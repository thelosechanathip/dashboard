<?php

namespace App\Http\Controllers\IT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use Carbon\Carbon;
use GuzzleHttp\Client;

class SystemInfoController extends Controller
{
    // Config Telegram  Start
        private $telegramBotToken = '7311914937:AAE0NsaVaxBPVsYD-IYcgK8soNGP3VYT8n0'; // แทนที่ด้วย Bot Token
        private $telegramChatIds = [ // เพิ่มหลาย Chat ID หรือ Group ID
            // '7090380759', // { Chanathip Khraengraeng }
            '-4576242553', // { แจ้งเตือน Error Computer Client }
        ];
    // Config Telegram  End

    // ฟังก์ชันสำหรับส่งข้อความ Telegram Start
        private function sendTelegramMessage($messageText) {
            $client = new Client();

            foreach ($this->telegramChatIds as $chatId) {
                try {
                    $response = $client->post("https://api.telegram.org/bot{$this->telegramBotToken}/sendMessage", [
                        'form_params' => [
                            'chat_id' => $chatId,
                            'text' => $messageText,
                        ],
                    ]);

                    $statusCode = $response->getStatusCode();
                    $body = $response->getBody()->getContents();

                    if ($statusCode == 200) {
                        \Log::info("Message sent successfully to Chat ID: {$chatId}");
                    } else {
                        \Log::error("Failed to send message to Chat ID: {$chatId}. Status Code: {$statusCode}");
                    }
                } catch (\Exception $e) {
                    \Log::error("Error while sending message to Chat ID: {$chatId}. Error: " . $e->getMessage());
                }
            }
        }
    // ฟังก์ชันสำหรับส่งข้อความ Telegram End

    public function send_error(Request $request) {
        // ดึงข้อมูลทั้งหมดจาก Cache
        $system_info_api = Cache::get('system_info', []);
        $latestDataByIP = []; // เก็บข้อมูลตัวล่าสุดของแต่ละ IP Address
    
        // ย้อนลูปข้อมูลเพื่อให้ข้อมูลล่าสุดอยู่บนสุด
        foreach (array_reverse($system_info_api) as $sia) {
            $ipAddress = $sia['ip_address'];
            // ตรวจสอบว่ามี IP นี้แล้วหรือยัง ถ้ามีแล้วจะข้าม
            if (!isset($latestDataByIP[$ipAddress])) {
                $latestDataByIP[$ipAddress] = $sia;
            }
        }
    
        if (count($latestDataByIP) > 0) {
            foreach ($latestDataByIP as $sia) {
                $cpu_percent_value = floatval(str_replace('%', '', $sia['cpu_percent'] ?? '0'));
                $memory_percent_value = floatval(str_replace('%', '', $sia['memory_percent'] ?? '0'));
                $currentTimestamp = now()->locale('th')->translatedFormat('l ที่ d F Y เวลา H:i:s'); // วันเวลาไทย
                $test_date = now()->format('Y-m-d H:i:s');
    
                // ตรวจสอบ CPU > 90%
                if ($cpu_percent_value > 90) {
                    $messageText = "แจ้งเตือน CPU > 90%!\r\n" .
                                   "ทดสอบวันที่ : {$test_date}\r\n" .
                                   "วันที่-เวลา ที่แจ้งเตือน : {$currentTimestamp}\r\n" .
                                   "IP Address : {$sia['ip_address']}\r\n" .
                                   "Host name : {$sia['hostname']}\r\n" .
                                   "สาเหตุ : CPU เกิดการใช้งานมากกว่า 90% กรุณาตรวจสอบเครื่องดังกล่าวด้วยขอบคุณครับ!\r\n";
                    $this->sendTelegramMessage($messageText);
                }
    
                // ตรวจสอบ RAM > 80%
                if ($memory_percent_value > 80) {
                    $messageText = "แจ้งเตือน RAM > 80%!\r\n" .
                                   "ทดสอบวันที่ : {$test_date}\r\n" .
                                   "วันที่-เวลา ที่แจ้งเตือน : {$currentTimestamp}\r\n" .
                                   "IP Address : {$sia['ip_address']}\r\n" .
                                   "Host name : {$sia['hostname']}\r\n" .
                                   "สาเหตุ : RAM เกิดการใช้งานมากกว่า 80% กรุณาตรวจสอบเครื่องดังกล่าวด้วยขอบคุณครับ!\r\n";
                    $this->sendTelegramMessage($messageText);
                }
            }
        }
    }

    public function receiveSystemInfo(Request $request) {
        // รับข้อมูล JSON จาก Python
        $data = $request->json()->all();

        if (!$data || !isset($data['hostname'])) {
            return response()->json(['error' => 'Invalid data or missing hostname'], 400);
        }

        // ดึงข้อมูลทั้งหมดจาก Cache ที่มีอยู่ (จะคืนค่าเป็น array หากยังไม่มีข้อมูลใน cache)
        $allSystemInfo = Cache::get('system_info', []);

        // อัปเดตข้อมูลของแต่ละเครื่องแยกกันโดยใช้ hostname
        $data['timestamp'] = now();  // เพิ่ม timestamp ลงในข้อมูล
        $allSystemInfo[$data['hostname']] = $data;

        // เก็บข้อมูลใหม่ลง Cache พร้อมตั้งเวลาให้อยู่ได้นานขึ้นตามที่ต้องการ (เช่น 5 นาที)
        Cache::put('system_info', $allSystemInfo, now()->addMinutes(5));

        return response()->json(['status' => 'success', 'message' => 'Successfully!']);
    }

    public function showSystemInfo(Request $request) {
        // ดึงข้อมูลทั้งหมดจาก Cache
        $system_info_api = Cache::get('system_info', []);
        $latestDataByIP = []; // เก็บข้อมูลตัวล่าสุดของแต่ละ IP Address
    
        // ย้อนลูปข้อมูลเพื่อให้ข้อมูลล่าสุดอยู่บนสุด
        foreach (array_reverse($system_info_api) as $sia) {
            $ipAddress = $sia['ip_address'];
            // ตรวจสอบว่ามี IP นี้แล้วหรือยัง ถ้ามีแล้วจะข้าม
            if (!isset($latestDataByIP[$ipAddress])) {
                $latestDataByIP[$ipAddress] = $sia;
            }
        }
    
        $output = '';
        if (count($latestDataByIP) > 0) {
            $output .= '<table class="table table-hover table-striped table-bordered table-sm text-center align-middle" id="system_information_table">
            <thead class="table-dark">
                <tr>
                    <th style="width: auto;">ลำดับ</th>
                    <th style="width: auto;">Status</th>
                    <th style="width: auto;">ระบบปฏิบัติการ</th>
                    <th style="width: auto;">OS_Version</th>
                    <th style="width: auto;">OS_Release</th>
                    <th style="width: auto;">OS_Architecture</th>
                    <th style="width: auto;">Hostname</th>
                    <th style="width: auto;">IP Address</th>
                    <th style="width: auto;">CPU Usage</th>
                    <th style="width: auto;">Total Memory</th>
                    <th style="width: auto;">Used Memory</th>
                    <th style="width: auto;">Memory Usage</th>
                    <th style="width: auto;">Device(s)</th>
                    <th style="width: auto;">Total Size(s)</th>
                    <th style="width: auto;">Used Space(s)</th>
                    <th style="width: auto;">Free Space(s)</th>
                    <th style="width: auto;">Usage (%)</th>
                </tr>
            </thead>
            <tbody>';
    
            $id = 0;
            $current_time = now();
    
            foreach ($latestDataByIP as $sia) {
                $deviceList = [];
                $mountpointList = [];
                $totalList = [];
                $usedList = [];
                $freeList = [];
                $usageList = [];
    
                // รวบรวมข้อมูลไดรฟ์ทั้งหมดเป็นลิสต์
                foreach ($sia['disk_info'] as $disk) {
                    $deviceList[] = $disk['device'] ?? '';
                    $mountpointList[] = $disk['mountpoint'] ?? '';
                    $totalList[] = $disk['total_gb'] ?? '';
                    $usedList[] = $disk['used_gb'] ?? '';
                    $freeList[] = $disk['free_gb'] ?? '';
                    $usageList[] = $disk['percent_used'] ?? '';
                }
    
                // การกำหนดสีของ CPU และ Memory
                $cpu_percent_value = floatval(str_replace('%', '', $sia['cpu_percent']));
                $memory_percent_value = floatval(str_replace('%', '', $sia['memory_percent']));
    
                $color_cpu = ($cpu_percent_value > 90) ? 'bg-danger text-light' : 'bg-success text-light';
                $color_memory = ($memory_percent_value > 80) ? 'bg-danger text-light' : 'bg-success text-light';
    
                // ตรวจสอบสถานะการออนไลน์ของเครื่องโดยดูเวลาการอัปเดตล่าสุด
                $last_update_time = isset($sia['timestamp']) ? Carbon::parse($sia['timestamp']) : null;
    
                // หากไม่มี timestamp หรือเวลาห่างเกิน 5 นาที ถือว่า Offline
                if ($last_update_time && $current_time->diffInMinutes($last_update_time) <= 5) {
                    $status = 'Online';
                    $color_status = 'bg-success text-light';
                } else {
                    $status = 'Offline';
                    $color_status = 'bg-danger text-light';
                }
    
                // รวมข้อมูลไดรฟ์ในเซลล์เดียวโดยแยกด้วย `<br>`
                $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td class="' . $color_status . '">' . $status . '</td>
                    <td>' . ($sia['os_name'] ?? '') . '</td>
                    <td>' . ($sia['os_version'] ?? '') . '</td>
                    <td>' . ($sia['os_release'] ?? '') . '</td>
                    <td>' . ($sia['os_architecture'] ?? '') . '</td>
                    <td>' . ($sia['hostname'] ?? '') . '</td>
                    <td>' . ($sia['ip_address'] ?? '') . '</td>
                    <td class="' . $color_cpu . '">' . ($sia['cpu_percent'] ?? '') . '</td>
                    <td>' . ($sia['memory_total_gb'] ?? '') . '</td>
                    <td>' . ($sia['memory_used_gb'] ?? '') . '</td>
                    <td class="' . $color_memory . '">' . ($sia['memory_percent'] ?? '') . '</td>
                    <td>' . implode('<br>', $deviceList) . '</td>
                    <td>' . implode('<br>', $totalList) . '</td>
                    <td>' . implode('<br>', $usedList) . '</td>
                    <td>' . implode('<br>', $freeList) . '</td>
                    <td>' . implode('<br>', $usageList) . '</td>
                </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">ไม่มี System Info API ถูกส่งมา! (สถานะ: Offline)</h1>';
        }
    }    

    // Index System Info Start
        public function index(Request $request) {
            // ดึงข้อมูล session ทั้งหมด
            $data = $request->session()->all();

            if (isset($data['groupname']) && $data['groupname'] == 'ผู้ดูแลระบบ') {
                // ส่งข้อมูลทั้งหมดไปยัง view
                return view('it.system_info', [
                    'data' => $data
                ]);
            } else {
                $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบนี้!');
                return redirect()->route('dashboard');
            }
        }
    // Index System Info End

}
