<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use DateTime;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;
use App\Models\Dashboard_Setting\AncQualityModel;

use App\Models\Log\AccessibilityLogModel;
use App\Models\Log\SidebarSub1MenuLogModel;
use App\Models\Log\AncQualityLogModel;

class AncQualityController extends Controller
{
    // Function ในการเรียกใช้งาน Username ที่เข้ามาใช้งาน SomeMethod Start
        private function someMethod(Request $request) {
            // ดึง session ทั้งหมดมาเก็บไว้ในตัวแปร data
            $data = $request->session()->all();
            
            // ดึง Username จาก User ที่ได้ Login เข้ามา และเก็บเป็น session ไปไว้ในตัวแปร username
            $username = $request->session()->get('loginname');
            
            // ใช้งาน $username ต่อไปตามที่คุณต้องการ
            return $username;
        }
    // Function ในการเรียกใช้งาน Username ที่เข้ามาใช้งาน SomeMethod End

    // Check Year Start
        private function changeYear($date_old) {
            $year_old = (int)substr($date_old, 0, 4); // ดึงค่าเฉพาะปีจากวันที่

            if ($year_old > 2500) {
                $calendar = 'พ.ศ.';
                $new_year = $year_old - 543;
            } else {
                $new_year = $year_old;
            }

            $date_new = substr_replace($date_old, $new_year, 0, 4);

            return $date_new;
        }
    // Check Year End

    // Check isThaiDateFormat Start
        private function isThaiDateFormat($value) {
            $result = preg_match('/^(\d{1,2})\s+([ก-๙]+)\s+(\d{4})$/u', $value);
            // echo "isThaiDateFormat Check for '$value': " . ($result ? 'Match' : 'No Match') . "\n";
            return $result;
        }
    // Check isThaiDateFormat End

    // ConvertThaiDate Start
        private function convertThaiDate($date) {
            // echo "Input Date: $date\n";  // แสดงวันที่ที่รับเข้ามา
            if (preg_match('/^(\d{1,2})\s+([ก-๙]+)\s+(\d{4})$/u', $date, $matches)) {
                // echo "Pattern Matched\n";
                $day = $matches[1];
                $month = $matches[2];
                $year = $matches[3];
        
                // แปลงปี พ.ศ. เป็น ค.ศ.
                if ((int)$year > 2400) {
                    $year -= 543;
                }

                if ((int)$day <= 9) {
                    $day = "0" . $day;
                }
        
                // แปลงชื่อเดือนภาษาไทยเป็นตัวเลข
                $thaiMonths = [
                    'มกราคม' => '01', 'กุมภาพันธ์' => '02', 'มีนาคม' => '03',
                    'เมษายน' => '04', 'พฤษภาคม' => '05', 'มิถุนายน' => '06',
                    'กรกฎาคม' => '07', 'สิงหาคม' => '08', 'กันยายน' => '09',
                    'ตุลาคม' => '10', 'พฤศจิกายน' => '11', 'ธันวาคม' => '12'
                ];
        
                if (isset($thaiMonths[$month])) {
                    $month = $thaiMonths[$month];
                } else {
                    // echo "Month Not Found in Thai Months Array\n";
                    return $date;  // คืนค่าเดิมหากไม่พบเดือนที่ถูกต้อง
                }
        
                // แปลงวันที่เป็น Y-m-d
                $convertedDate = "$year-$month-$day";
                // echo "Converted Date: $convertedDate\n";  // แสดงผลวันที่ที่แปลงแล้ว
                return $convertedDate;
            }
        
            // echo "Pattern Not Matched\n";
            return "Null";  // คืนค่าเดิมหากไม่ตรงกับรูปแบบที่ต้องการ
        }
    // ConvertThaiDate End

    // หน้าแรกของ ANC Quality Index Start
        public function index(Request $request) {
            // Retrieve session data
            $data = $request->session()->all();
            
            $startTime_1 = microtime(true);

            $sidebar_sub1_menu_id = $request->id;

            $query_1 = SidebarSub1MenuModel::where('id', $sidebar_sub1_menu_id);

            $SidebarSub1MenuId = $query_1->first();

            // ดึง SQL query_1 พร้อม bindings
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $sidebar_sub1_menu_log_data = [
                'function' => "Where sidebar_sub1_menu_name = {$SidebarSub1MenuId->sidebar_sub1_menu_name}", // ใช้ double quotes และการแทนที่ตัวแปรใน string
                'username' => $data['loginname'],
                'command_sql' => $fullSql_1,
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            SidebarSub1MenuLogModel::create($sidebar_sub1_menu_log_data);

            $startTime_2 = microtime(true);

            // Query สถานบริการ Start
            $query_2 = DB::table('zbm_rpst_name')
                ->select('rpst_id', 'rpst_name')
                ->whereIn('rpst_id', ['11098', '05532', '05533', '05534', '05535', '05536', '05537', '05538', '05539', '05540', '05541', '13976', '00000']);
            // Query สถานบริการ End

            // ดึงข้อมูลจาก Query (ดึงหลายแถว)
            $zbm_rpst_name = $query_2->get();
        
            // ดึง SQL query พร้อม bindings
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);
        
            // สร้างข้อมูลสำหรับบันทึกใน log
            $anc_quality_log_data = [
                'function' => 'Come to the ANC Quality page AND SELECT DATA',
                'username' => $data['loginname'],
                'command_sql' => $fullSql_2,
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน AncQualityLogModel
            AncQualityLogModel::create($anc_quality_log_data);

            if($SidebarSub1MenuId->status_id === 1) {
                $startTime_3 = microtime(true);

                $query_3 = AccessibilityModel::where('accessibility_name', $data['groupname'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);
                $accessibility_groupname_model = $query_3->first();

                // ดึง SQL query_3 พร้อม bindings
                $sql_3 = $query_3->toSql();
                $bindings_3 = $query_3->getBindings();
                $fullSql_3 = vsprintf(str_replace('?', "'%s'", $sql_3), $bindings_3);
            
                $endTime_3 = microtime(true);
                $executionTime_3 = $endTime_3 - $startTime_3;
                $formattedExecutionTime_3 = number_format($executionTime_3, 3);

                // สร้างข้อมูลสำหรับบันทึกใน log
                $accessibility_log_data = [
                    'function' => "Where accessibility_name = {$data['groupname']} AND sidebar_sub1_menu_id = {$SidebarSub1MenuId->id}",
                    'username' => $data['loginname'],
                    'command_sql' => $fullSql_3,
                    'query_time' => $formattedExecutionTime_3,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน AccessibilityLogModel
                AccessibilityLogModel::create($accessibility_log_data);

                if($accessibility_groupname_model !== null && $accessibility_groupname_model->status_id === 1) {
                    return view('program.anc_quality', compact('data', 'zbm_rpst_name'));
                } else {
                    $startTime_4 = microtime(true);

                    $query_4 = AccessibilityModel::where('accessibility_name', $data['name'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);
                    $accessibility_name_model = $query_4->first();

                    // ดึง SQL query_4 พร้อม bindings
                    $sql_4 = $query_4->toSql();
                    $bindings_4 = $query_4->getBindings();
                    $fullSql_4 = vsprintf(str_replace('?', "'%s'", $sql_4), $bindings_4);
                
                    $endTime_4 = microtime(true);
                    $executionTime_4 = $endTime_4 - $startTime_4;
                    $formattedExecutionTime_4 = number_format($executionTime_4, 3);

                    // สร้างข้อมูลสำหรับบันทึกใน log
                    $accessibility_log_data = [
                        'function' => "Where accessibility_name = {$data['name']} AND sidebar_sub1_menu_id = {$SidebarSub1MenuId->id}",
                        'username' => $data['loginname'],
                        'command_sql' => $fullSql_4,
                        'query_time' => $formattedExecutionTime_4,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน AccessibilityLogModel
                    AccessibilityLogModel::create($accessibility_log_data);

                    if($accessibility_name_model !== null && $accessibility_name_model->status_id === 1) {
                        return view('program.anc_quality', compact('data', 'zbm_rpst_name'));
                    } else {
                        $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบ ANC Quality หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบ ANC Quality ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }    
    // หน้าแรกของ ANC Quality Index Start

    // Get Result Start
        public function getResult(Request $request) {
            $input_date = $request->input('date');

            $date = $this->changeYear($input_date);

            // $input_date = '2024-11-05'; // ตัวอย่างวันที่
            $date_lmp = Carbon::createFromFormat('Y-m-d', $date)->subDays(281);
            $result_lmp = $date_lmp->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_12 = Carbon::createFromFormat('Y-m-d', $date)->subDays(199);
            $result_12 = $date_12->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_15 = Carbon::createFromFormat('Y-m-d', $date)->subDays(176);
            $result_15 = $date_15->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_18 = Carbon::createFromFormat('Y-m-d', $date)->subDays(156);
            $result_18 = $date_18->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_19 = Carbon::createFromFormat('Y-m-d', $date)->subDays(148);
            $result_19 = $date_19->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_20 = Carbon::createFromFormat('Y-m-d', $date)->subDays(141);
            $result_20 = $date_20->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_21 = Carbon::createFromFormat('Y-m-d', $date)->subDays(134);
            $result_21 = $date_21->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_26 = Carbon::createFromFormat('Y-m-d', $date)->subDays(99);
            $result_26 = $date_26->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_27 = Carbon::createFromFormat('Y-m-d', $date)->subDays(92);
            $result_27 = $date_27->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_30 = Carbon::createFromFormat('Y-m-d', $date)->subDays(71);
            $result_30 = $date_30->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_31 = Carbon::createFromFormat('Y-m-d', $date)->subDays(64);
            $result_31 = $date_31->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_34 = Carbon::createFromFormat('Y-m-d', $date)->subDays(43);
            $result_34 = $date_34->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_35 = Carbon::createFromFormat('Y-m-d', $date)->subDays(36);
            $result_35 = $date_35->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_36 = Carbon::createFromFormat('Y-m-d', $date)->subDays(29);
            $result_36 = $date_36->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_37 = Carbon::createFromFormat('Y-m-d', $date)->subDays(22);
            $result_37 = $date_37->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_38 = Carbon::createFromFormat('Y-m-d', $date)->subDays(15);
            $result_38 = $date_38->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_39 = Carbon::createFromFormat('Y-m-d', $date)->subDays(8);
            $result_39 = $date_39->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            $date_40 = Carbon::createFromFormat('Y-m-d', $date)->subDays(1);
            $result_40 = $date_40->locale('th')->isoFormat('D MMMM') . ' ' . ($date_lmp->year + 543);

            return response()->json([
                'result_lmp' => $result_lmp,
                'result_12' => $result_12,
                'result_15' => $result_15,
                'result_18' => $result_18,
                'result_19' => $result_19,
                'result_20' => $result_20,
                'result_21' => $result_21,
                'result_26' => $result_26,
                'result_27' => $result_27,
                'result_30' => $result_30,
                'result_31' => $result_31,
                'result_34' => $result_34,
                'result_35' => $result_35,
                'result_36' => $result_36,
                'result_37' => $result_37,
                'result_38' => $result_38,
                'result_39' => $result_39,
                'result_40' => $result_40
            ]);
        }
    // Get Result End

    // Export PDF Start
        public function exportPDF(Request $request){
            $opduser = $request->session()->all();
            
            // นำค่าจาก Input เข้ามา Start
                $data = [
                    'lmp' => $request->input('lmp'),
                    'edc' => $request->input('edc'),
                    'fullname' => $request->input('fullname'),
                    'shph' => $request->input('shph'),
                    'telephone' => $request->input('telephone'),
                    'week_12' => $request->input('week_12'),
                    'week_15' => $request->input('week_15'),
                    'week_18' => $request->input('week_18'),
                    'week_19' => $request->input('week_19'),
                    'week_20' => $request->input('week_20'),
                    'week_21' => $request->input('week_21'),
                    'week_26' => $request->input('week_26'),
                    'week_27' => $request->input('week_27'),
                    'week_30' => $request->input('week_30'),
                    'week_31' => $request->input('week_31'),
                    'week_34' => $request->input('week_34'),
                    'week_35' => $request->input('week_35'),
                    'week_36' => $request->input('week_36'),
                    'week_37' => $request->input('week_37'),
                    'week_38' => $request->input('week_38'),
                    'week_39' => $request->input('week_39'),
                    'week_40' => $request->input('week_40'),
                    'atvt_12' => $request->input('atvt_12'),
                    'atvt_15_18' => $request->input('atvt_15_18'),
                    'atvt_19_20' => $request->input('atvt_19_20'),
                    'atvt_21_26' => $request->input('atvt_21_26'),
                    'atvt_27_30' => $request->input('atvt_27_30'),
                    'atvt_31_34' => $request->input('atvt_31_34'),
                    'atvt_35_36' => $request->input('atvt_35_36'),
                    'atvt_37_38' => $request->input('atvt_37_38'),
                    'atvt_39_40' => $request->input('atvt_39_40'),
                    'tt_12' => $request->input('tt_12'),
                    'tt_15_18' => $request->input('tt_15_18'),
                    'tt_19_20' => $request->input('tt_19_20'),
                    'tt_21_26' => $request->input('tt_21_26'),
                    'tt_27_30' => $request->input('tt_27_30'),
                    'tt_31_34' => $request->input('tt_31_34'),
                    'tt_35_36' => $request->input('tt_35_36'),
                    'tt_37_38' => $request->input('tt_37_38'),
                    'tt_39_40' => $request->input('tt_39_40')
                ];
            // นำค่าจาก Input เข้ามา End
        
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
            $html = view('program.preview_pdf.anc_quality_pdf', $data)->render();
        
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A4-L', // กำหนดเป็น A4 แนวนอน
                'orientation' => 'L', // 'L' สำหรับ landscape (แนวนอน), 'P' สำหรับ portrait (แนวตั้ง)
                'fontDir' => array_merge($fontDirs, [
                    storage_path('fonts/'),
                ]),
                'fontdata' => $fontData + [
                    'sarabun_new' => [
                        'R' => 'THSarabun.ttf',
                        'I' => 'THSarabun Italic.ttf',
                        'B' => 'THSarabun Bold.ttf',
                    ],
                ],
                'default_font' => 'sarabun_new',
            ]);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $anc_quality_log_data = [
                'function' => "exportPDF : Export File ANC Quality", // ใช้ double quotes และการแทนที่ตัวแปรใน string
                'username' => $opduser['loginname'],
                'command_sql' => "Patient_name : {$data['fullname']}, Telephone_number : {$data['telephone']}, LMP : {$data['lmp']}, EDC : {$data['edc']}",
                'query_time' => "",
                'operation' => 'EXPORT'
            ];
        
            // บันทึกข้อมูลลงใน ANCQualityLogModel
            AncQualityLogModel::create($anc_quality_log_data);

            $data['recorder_name'] = $opduser['loginname'];

            foreach ($data as $key => $value) {
                // ตรวจสอบฟิลด์ที่ต้องการให้เป็นวันที่ 
                $check_date = $this->isThaiDateFormat($value);   
                if($check_date == 1) {
                    // แปลงวันที่ถ้าเป็นรูปแบบไทย
                    $data[$key] = $this->convertThaiDate($value);
                } else {
                    $data[$key] = $value;
                }           
            }            

            if(AncQualityModel::create($data)) {
                // สร้างข้อมูลสำหรับบันทึกใน log
                $anc_quality_log_data = [
                    'function' => "Insert Data : AncQualityModel", // ใช้ double quotes และการแทนที่ตัวแปรใน string
                    'username' => $opduser['loginname'],
                    'command_sql' => "Insert All Data",
                    'query_time' => "",
                    'operation' => 'INSERT'
                ];
            
                // บันทึกข้อมูลลงใน ANCQualityLogModel
                AncQualityLogModel::create($anc_quality_log_data);
                $mpdf->WriteHTML($html);
                return $mpdf->Output('ANC-Quality8.pdf', 'I'); // 'I' สำหรับแสดงผลใน browser
            } else {
                return "Error";
            }
        }
    // Export PDF End

}
