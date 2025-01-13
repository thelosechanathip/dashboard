<?php

namespace App\Http\Controllers\Alert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use GuzzleHttp\Client;

class PttypeErrorController extends Controller
{
    // Config Telegram  Start
        private $telegramBotToken = '7311914937:AAE0NsaVaxBPVsYD-IYcgK8soNGP3VYT8n0'; // แทนที่ด้วย Bot Token
        private $telegramChatIds = [ // เพิ่มหลาย Chat ID หรือ Group ID
            '-4693841902', // { แจ้งเตือน ตรวจสอบสิทธิ์ }
        ];
    // Config Telegram  End

    // Function Send Text To Telegram Start
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
    // Function Send Text To Telegram End

    // Check Pttype Start
        public function CheckPttype() {
            $query_check_pttype = DB::table('vn_stat as vn')
                ->select(
                    'ov.staff',
                    'pat.cid',
                    'hd.name as hospdep',
                    DB::raw("CONCAT(hp.hosptype, '', hp.name) as hosname"),
                    DB::raw("CONCAT(pat.pname, pat.fname, ' ', pat.lname) as fullname"),
                    'vn.vstdate',
                    'ov.vsttime',
                    'vn.hn',
                    'vn.vn',
                    'vn.pttype',
                    'vn.hospmain',
                    'ou.name as name_staff',
                    'pt.name as typename'
                )
                ->leftJoin('pttype as pt', 'pt.pttype', '=', 'vn.pttype')
                ->leftJoin('patient as pat', 'pat.hn', '=', 'vn.hn')
                ->leftJoin('hospcode as hp', 'hp.hospcode', '=', 'vn.hospmain')
                ->join('ovst as ov', 'ov.vn', '=', 'vn.vn')
                ->leftJoin('opduser as ou', 'ou.loginname', '=', 'ov.staff')
                ->leftJoin('hospital_department as hd', 'hd.id', '=', 'ou.hospital_department_id')
                ->whereDate('vn.vstdate', '=', now())
                ->whereIn('pt.hipdata_code', ['UCS', 'WEL'])
                ->whereNotIn('vn.pttype', [
                    '00', 
                    '13', 
                    '29', 
                    '40', '41', '42', '43', '44', '45', '46', '47', '49', 
                    '52', '56', '57', '58', '59', 
                    '76', '78', '97', '98', '99', 
                    'PP', 'P1'
                ])
                ->whereNotIn('vn.hospmain', ['11098'])
                ->get()
            ;

            if ($query_check_pttype->isNotEmpty()) {
                foreach ($query_check_pttype AS $qcp) {
                    $messageErrorText = "แจ้งเตือน ตรวจสอบสิทธิ์ \r\n" . 
                        "HN : {$qcp->hn} \r\n" .
                        "วัน | เวลาที่มารับบริการ : {$qcp->vstdate} | {$qcp->vsttime} \r\n" . 
                        "คำนำหน้า - ชื่อ - สกุล : {$qcp->fullname} \r\n" . 
                        "เลขสิทธิ์ : {$qcp->pttype} \r\n" . 
                        "สิทธิ์ : {$qcp->typename} \r\n" . 
                        "ผู้ส่งตรวจ : {$qcp->name_staff} \r\n" . 
                        "หมายเหตุ : กรุณาตรวจสอบความถูกต้องในระบบ HoSXP หากมีข้อผิดพลาดติดต่อทีมงาน IT ขอบคุณครับ \r\n"
                    ;

                    $this->sendTelegramMessage($messageErrorText);
                }
            } else {

            }
        }
    // Check Pttype End
}
