<?php

namespace App\Http\Controllers\Program\Sub_page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// เรียกใช้งาน Database
use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;
use App\Models\Dashboard_Setting\AdvanceCarePlanModel;
use App\Models\Dashboard_Setting\FiscalYearModel;

use App\Models\Log\PalliativeCareLogModel;
use App\Models\Log\ModuleLogModel;
use App\Models\Log\AccessibilityLogModel;
use App\Models\Log\SidebarSub1MenuLogModel;

class PCDementiaController extends Controller
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

    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ PPS ออกมาใช้งาน Start
        private function SePPS($hpi) {
            if (strpos($hpi, 'PPS = 10 %') || strpos($hpi, '10%') || strpos($hpi, '10 %')) $rss="PPS=10%";
            else if (strpos($hpi, 'PPS = 20 %') || strpos($hpi, '20%') || strpos($hpi, '20 %')) $rss="PPS=20%";
            else if (strpos($hpi, 'PPS = 30 %') || strpos($hpi, '30%') || strpos($hpi, '30 %')) $rss="PPS=30%";
            else if (strpos($hpi, 'PPS = 40 %') || strpos($hpi, '40%') || strpos($hpi, '40 %')) $rss="PPS=40%";
            else if (strpos($hpi, 'PPS = 50 %') || strpos($hpi, '50%') || strpos($hpi, '50 %')) $rss="PPS=50%";
            else if (strpos($hpi, 'PPS = 60 %') || strpos($hpi, '60%') || strpos($hpi, '60 %')) $rss="PPS=60%";
            else if (strpos($hpi, 'PPS = 70 %') || strpos($hpi, '70%') || strpos($hpi, '70 %')) $rss="PPS=70%";
            else if (strpos($hpi, 'PPS = 80 %') || strpos($hpi, '80%') || strpos($hpi, '80 %')) $rss="PPS=80%";
            else if (strpos($hpi, 'PPS = 90 %') || strpos($hpi, '90%') || strpos($hpi, '90 %')) $rss="PPS=90%";
            else $rss="PPS= -";

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return $rss;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ PPS ออกมาใช้งาน End

    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ PS ออกมาใช้งาน Start
        private function SePS($hpi) {
            if (strpos($hpi, 'PS = 1/10') || strpos($hpi, '1/10')) $rss="PS=1/10";
            else if (strpos($hpi, 'PS = 2/10') || strpos($hpi, '2/10')) $rss="PS=2/10";
            else if (strpos($hpi, 'PS = 3/10') || strpos($hpi, '3/10')) $rss="PS=3/10";
            else if (strpos($hpi, 'PS = 4/10') || strpos($hpi, '4/10')) $rss="PS=4/10";
            else if (strpos($hpi, 'PS = 5/10') || strpos($hpi, '5/10')) $rss="PS=5/10";
            else if (strpos($hpi, 'PS = 6/10') || strpos($hpi, '6/10')) $rss="PS=6/10";
            else if (strpos($hpi, 'PS = 7/10') || strpos($hpi, '7/10')) $rss="PS=7/10";
            else if (strpos($hpi, 'PS = 8/10') || strpos($hpi, '8/10')) $rss="PS=8/10";
            else if (strpos($hpi, 'PS = 9/10') || strpos($hpi, '9/10')) $rss="PS=9/10";
            else $rss="PS= -";

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return $rss;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ PS ออกมาใช้งาน End

    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ เตียง ออกมาใช้งาน Start
        private function SeBed($hpi) {
            if (strpos($hpi, 'เตียง1') || strpos($hpi, 'เตียง 1') || strpos($hpi, 'เตียง=1') || strpos($hpi, 'เตียง = 1') || strpos($hpi, 'เตียง= 1') || strpos($hpi, 'เตียง =1')) $rss="เตียง 1";
            else if (strpos($hpi, 'เตียง2') || strpos($hpi, 'เตียง 2') || strpos($hpi, 'เตียง=2') || strpos($hpi, 'เตียง = 2') || strpos($hpi, 'เตียง= 2') || strpos($hpi, 'เตียง =2')) $rss="เตียง 2";
            else if (strpos($hpi, 'เตียง3') || strpos($hpi, 'เตียง 3') || strpos($hpi, 'เตียง=3') || strpos($hpi, 'เตียง = 3') || strpos($hpi, 'เตียง= 3') || strpos($hpi, 'เตียง =3')) $rss="เตียง 3";
            else if (strpos($hpi, 'เตียง4') || strpos($hpi, 'เตียง 4') || strpos($hpi, 'เตียง=4') || strpos($hpi, 'เตียง = 4') || strpos($hpi, 'เตียง= 4') || strpos($hpi, 'เตียง =4')) $rss="เตียง 4";
            else $rss="เตียง= -";

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return $rss;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ เตียง ออกมาใช้งาน End

    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ BI ออกมาใช้งาน Start
        private function SeBi($hpi) {
            for($i=100;$i>=0;$i--){
                if (strpos(strtolower($hpi), 'bi'.$i) || strpos(strtolower($hpi), 'bi '.$i) || strpos(strtolower($hpi), 'bi  '.$i) || strpos(strtolower($hpi), 'bi='.$i) || strpos(strtolower($hpi), 'bi = '.$i) || strpos(strtolower($hpi), 'bi= '.$i) || strpos(strtolower($hpi), 'bi ='.$i))
                {
                    $ress="BI = ".$i;

                    break;
                }
                else $ress="BI = -";
            }

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return $ress;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ BI ออกมาใช้งาน End

    // แปลง วัน-เดือน-ปี เป็นของประเทศไทย isThaiYear  Start
        private function isThaiYear($request_1, $request_2) {
            if($request_1 != 0 && $request_2 != 0) {
                $date_parts_1 = explode('-', $request_1);
                $date_parts_2 = explode('-', $request_2);

                $year_1 = $date_parts_1[0];
                $year_2 = $date_parts_2[0];

                if($year_1 >= 2400 && $year_1 <= 2600 || $year_2 >= 2400 && $year_2 <= 2600) {
                    $year_1 = $year_1 - 543;
                    $year_2 = $year_2 - 543;
                    $date_1 = $year_1 . '-' . $date_parts_1[1] . '-' . $date_parts_1[2];
                    $date_2 = $year_2 . '-' . $date_parts_2[1] . '-' . $date_parts_2[2];
                    $date_all = array(
                        'date_1' => $date_1,
                        'date_2' => $date_2
                    );
                    return $date_all;
                } else {
                    $date_all = array(
                        'date_1' => $request_1,
                        'date_2' => $request_2
                    );
                    return $date_all;
                }
            } else {
                return false;
            }
        }
    // แปลง วัน-เดือน-ปี เป็นของประเทศไทย isThaiYear  End

    // แปลงวันที่จาก ค.ศ. ให้เป็นวันที่ของไทย Start
        private function DateThai($strDate) {
            // ดึงค่าปีออกมาแล้วบวกด้วย 543 เพื่อหาค่า พ.ศ. แล้วนำไปเก็บที่ตัวแปร
            $strYear = date("Y",strtotime($strDate))+543;
            // ดึงค่าเดือนออกมาแล้วนำไปเก็บที่ตัวแปร
            $strMonth= date("n",strtotime($strDate));
            // ดึงค่าวันออกมาแล้วนำไปเก็บที่ตัวแปร
            $strDay= date("j",strtotime($strDate));
            // ดึงค่าเดือนออกมาในรูปแบบภาษาไทย แล้วนำไปเก็บที่ตัวแปร
            $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            // เทียบข้อมูลตัวเลขของเดือนและเปลี่ยนไปเป็นเดือนในรูปแบบภาษาไทย แล้วนำไปเก็บที่ตัวแปร
            $strMonthThai=$strMonthCut[$strMonth];

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return "$strDay $strMonthThai $strYear";
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // แปลงวันที่จาก ค.ศ. ให้เป็นวันที่ของไทย End

    // จำนวนคนไข้ภาวะสมองเสื่อมแยกตาม รพสต. แสดงแบบ Chart Start
        private function getChartCountDementiaShph($dementia_count_shph) {
            // สร้าง Array เปล่า Start
            $count_dementia = [];
            $shph_name = [];
            // สร้าง Array เปล่า End

            // นำ Request ที่ส่งเข้ามาไป Loop Start
            foreach ($dementia_count_shph as $data) {
                // ดึงข้อมูลจาก Request ที่ส่งเข้ามา Loop ตาม Column ที่ถูกส่งมา Start
                $count_dementia[] = $data->cc;

                if($data->rpst_name == '') {
                    $shph_name[] = 'ไม่มีสถานพยาบาลที่ชัดเจน';
                } else {
                    $shph_name[] = $data->rpst_name;
                }
                // ดึงข้อมูลจาก Request ที่ส่งเข้ามา Loop ตาม Column ที่ถูกส่งมา End
            }
            // นำ Request ที่ส่งเข้ามาไป Loop End

            // สร้างเนื่อหาภายใน Chart Start
            $chart_count_dementia_shph = [
                // หัวข้อของข้อมูล
                'labels' => $shph_name,
                // ตัวขข้อมูลและสีของข้อมูลหรือ Style ต่างๆ
                'datasets' => [
                    [
                        'label' => 'จำนวนคนไข้ภาวะสมองเสื่อมแยกตาม รพสต. ',
                        'data' => $count_dementia,
                        'backgroundColor' => 'rgba(54, 162, 235, 1)',
                        'borderColor' => 'rgba(54, 162, 235, 3)',
                        'borderWidth' => 1
                    ]
                ],
                // Option เสริมของ Chart JS
                'options' => [
                    'plugins' => [
                        'datalabels' => [
                            'anchor' => 'end',
                            'align' => 'top',
                            'color' => 'black',
                            'font' => [
                                'weight' => 'bold'
                            ],
                            'formatter' => 'function(value, context) { return value; }'
                        ]
                    ],
                    'scales' => [
                        'y' => [
                            'beginAtZero' => true
                        ]
                    ]
                ]
            ];
            // สร้างเนื่อหาภายใน Chart End

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return $chart_count_dementia_shph;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // จำนวนคนไข้ภาวะสมองเสื่อมแยกตาม รพสต. แสดงแบบ Chart End

    // หน้าแรกของ Dementia(คนไข้ภาวรสมองเสื่อม) Start
        public function index(Request $request) {
            // ดึงข้อมูล Session ที่มีการ Login เข้ามาภายในระบบ
            $data = $request->session()->all();

            $fiscal_year = FiscalYearModel::orderBy('id', 'desc')->get();

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
                'function' => "Where sidebar_sub1_menu_name = {$SidebarSub1MenuId->sidebar_sub1_menu_name}",
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
            $palliative_care_log_data = [
                'function' => 'Come to the Dementia page AND SELECT DATA',
                'username' => $data['loginname'],
                'command_sql' => $fullSql_2,
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($palliative_care_log_data);

            if($SidebarSub1MenuId->status_id === 1) {
                $startTime_3 = microtime(true);

                $query_3 = AccessibilityModel::where('accessibility_name', $data['groupname'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);

                // ดึงข้อมูลจาก Query (ดึงหลายแถว)
                $accessibility_groupname_model = $query_3->first();
            
                // ดึง SQL query พร้อม bindings
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
                    // ส่งค่าคืนกลับไปยังหน้า Dementia(คนไข้ภาวรสมองเสื่อม) พร้อมกับ Data Start
                    return view('program.sub_page.pc_dementia', compact('data', 'zbm_rpst_name', 'fiscal_year', 'sidebar_sub1_menu_id'));
                    // ส่งค่าคืนกลับไปยังหน้า Dementia(คนไข้ภาวรสมองเสื่อม) พร้อมกับ Data End
                } else {
                    $startTime_4 = microtime(true);

                    $query_4 = AccessibilityModel::where('accessibility_name', $data['name'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);

                    // ดึงข้อมูลจาก Query (ดึงหลายแถว)
                    $accessibility_name_model = $query_4->first();
                
                    // ดึง SQL query พร้อม bindings
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
                        // ส่งค่าคืนกลับไปยังหน้า Dementia(คนไข้ภาวรสมองเสื่อม) พร้อมกับ Data Start
                        return view('program.sub_page.pc_dementia', compact('data', 'zbm_rpst_name', 'fiscal_year', 'sidebar_sub1_menu_id'));
                        // ส่งค่าคืนกลับไปยังหน้า Dementia(คนไข้ภาวรสมองเสื่อม) พร้อมกับ Data End
                    } else {
                        $request->session()->put('error', 'ไม่มีสิทธิ์เข้าใช้งานระบบ Dementia(คนไข้ภาวรสมองเสื่อม) หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        // $request->session()->put('error', 'ณ ตอนนี้ทีม IT ขออนุญาตปิดปรับปรุงระบบ Pallliative Care ขออภัยในความไม่สะดวก!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบ Dementia(คนไข้ภาวรสมองเสื่อม) ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }
    // หน้าแรกของ Dementia(คนไข้ภาวรสมองเสื่อม) End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลคนไข้ภาวะสมองเสื่อมแยกตาม รพสต. จาก Request ที่ถูกส่งเข้ามา Start
        public function getDementiaSelectData(Request $request) {
            if($request->min_date == 0 || $request->max_date == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณากรอกวันที่ ที่ต้องการดูข้อมูลด้วยครับ',
                    'icon' => 'error'
                ]);
            } else {
                // เริ่มนับเวลา
                $startTime = microtime(true);
        
                // สร้าง query
                $query = DB::table('vn_stat as ov')
                    ->selectRaw('COUNT(DISTINCT ov.hn) as cc, zn.rpst_name')
                    ->leftJoin('ovst_community_service as oc', function ($join) {
                        $join->on('oc.vn', '=', 'ov.vn')
                            ->whereBetween('oc.ovst_community_service_type_id', [1, 103]);
                    })
                    ->leftJoin('patient as pt', 'pt.hn', '=', 'ov.hn')
                    ->leftJoin('thaiaddress as th', DB::raw("th.addressid"), '=', DB::raw("CONCAT(pt.chwpart, pt.amppart, pt.tmbpart)"))
                    ->leftJoin('zbm_rpst as zr', function ($join) {
                        $join->on('zr.chwpart', '=', 'pt.chwpart')
                            ->on('zr.amppart', '=', 'pt.amppart')
                            ->on('zr.tmbpart', '=', 'pt.tmbpart')
                            ->on('zr.moopart', '=', 'pt.moopart');
                    })
                    ->leftJoin('zbm_rpst_name as zn', 'zn.rpst_id', '=', 'zr.rpst_id')
                    ->where('ov.pdx', 'LIKE', 'F03')
                    ->whereBetween('ov.vstdate', [$request->min_date, $request->max_date])
                    ->groupBy('zn.rpst_id')
                    ->orderByDesc('ov.vstdate')
                ;
        
                // ดึงข้อมูลจาก query
                $dementia_count_shph = $query->get();

                // ดึง SQL query พร้อม bindings
                $sql = $query->toSql();
                $bindings = $query->getBindings();
                $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
            
                $endTime = microtime(true);
                $executionTime = $endTime - $startTime;
                $formattedExecutionTime = number_format($executionTime, 3);

                // ดึง username จาก method someMethod
                $username = $this->someMethod($request);

                // สร้างข้อมูลสำหรับบันทึกใน log
                $palliative_care_log_data = [
                    'function' => 'getDementiaSelectData',
                    'username' => $username,
                    'command_sql' => $fullSql,
                    'query_time' => $formattedExecutionTime,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน PalliativeCareLogModel
                PalliativeCareLogModel::create($palliative_care_log_data);
        
                // ตรวจสอบว่ามีข้อมูลหรือไม่
                if($dementia_count_shph->isNotEmpty()) {
                    // เรียกฟังก์ชันเพื่อทำ chart
                    $chart_count_dementia_shph = $this->getChartCountDementiaShph($dementia_count_shph);
        
                    return response()->json([
                        'status' => 200,
                        'chart_count_dementia_shph' => $chart_count_dementia_shph
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'title' => 'Error',
                        'message' => 'ไม่มีจำนวนคนไข้ภาวะสมองเสื่อมแยกตาม รพสต. ที่ท่านเลือก!',
                        'icon' => 'error'
                    ]);
                }
            }
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลคนไข้ภาวะสมองเสื่อมแยกตาม รพสต. จาก Request ที่ถูกส่งเข้ามา End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายชื่อคนไข้ภาวะสมองเสื่อม จาก Request ที่ถูกส่งเข้ามา Start
        public function getDementiaFetchListName(Request $request) {
            $min_date = $request->min_date;
            $max_date = $request->max_date;
        
            // ตรวจสอบวันที่
            if ($min_date == 0 || $max_date == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกวันที่รับบริการ',
                    'icon' => 'error'
                ]);
            }

            $startTime = microtime(true);
        
            // Query ข้อมูลจากฐานข้อมูล
            $query = DB::table('vn_stat as ov')
                ->selectRaw("
                    MAX(ov.vstdate) AS vstdate,
                    pp.name AS pttype_name,
                    ov.hn,
                    ov.vn,
                    pt.cid,
                    CONCAT(pt.pname, pt.fname, ' ', pt.lname) AS fullname,
                    pt.birthday,
                    (YEAR(NOW()) - YEAR(pt.birthday)) AS age,
                    CONCAT(pt.addrpart, ' หมู่ ', pt.moopart, ' ', th.full_name) AS fulladdress,
                    zn.rpst_name,
                    zn.rpst_id,
                    (SELECT vn.pdx FROM vn_stat vn WHERE vn.vn = ov.vn) AS pdx,
                    IF(ov.pdx = 'Z515' OR ov.dx0 = 'Z515' OR ov.dx1 = 'Z515' OR ov.dx2 = 'Z515' OR ov.dx3 = 'Z515' OR ov.dx4 = 'Z515' OR ov.dx5 = 'Z515', 'Z515', NULL) AS Z515,
                    IF(ov.pdx = 'Z718' OR ov.dx0 = 'Z718' OR ov.dx1 = 'Z718' OR ov.dx2 = 'Z718' OR ov.dx3 = 'Z718' OR ov.dx4 = 'Z718' OR ov.dx5 = 'Z718', 'Z718', NULL) AS Z718,
                    COALESCE(pt.death, 'N') AS death,
                    pt.deathday,
                    (SELECT COUNT(*) FROM ovst_community_service a1 
                        INNER JOIN vn_stat vn ON vn.vn = a1.vn 
                        WHERE vn.hn = ov.hn 
                        AND a1.ovst_community_service_type_id BETWEEN 1 AND 103) AS dayc,
                    DATEDIFF(NOW(), 
                        (SELECT MAX(a1.entry_datetime) FROM ovst_community_service a1 
                            INNER JOIN vn_stat vn ON vn.vn = a1.vn 
                            WHERE vn.hn = ov.hn 
                            AND a1.ovst_community_service_type_id BETWEEN 1 AND 103)) AS daym
                ")
                ->leftJoin('pttype as pp', 'pp.pttype', '=', 'ov.pttype')
                ->leftJoin('ovst_community_service as oc', function ($join) {
                    $join->on('oc.vn', '=', 'ov.vn')
                        ->whereBetween('oc.ovst_community_service_type_id', [1, 103]);
                })
                ->leftJoin('patient as pt', 'pt.hn', '=', 'ov.hn')
                ->leftJoin('thaiaddress as th', DB::raw("th.addressid"), '=', DB::raw("CONCAT(pt.chwpart, pt.amppart, pt.tmbpart)"))
                ->leftJoin('zbm_rpst as zr', function ($join) {
                    $join->on('zr.chwpart', '=', 'pt.chwpart')
                        ->on('zr.amppart', '=', 'pt.amppart')
                        ->on('zr.tmbpart', '=', 'pt.tmbpart')
                        ->on('zr.moopart', '=', 'pt.moopart');
                })
                ->leftJoin('zbm_rpst_name as zn', 'zn.rpst_id', '=', 'zr.rpst_id')
                ->where('ov.pdx', 'LIKE', 'F03')
                ->whereBetween('ov.vstdate', [$min_date, $max_date])
            ;

            // ตรวจสอบว่า $service_unit และ $death_type ไม่เป็นค่าว่างก่อนใช้ whereRaw
            $data_notIn = [
                '11098', '05532', '05533', '05534', '05535', '05536', '05537', '05538', '05539', '05540', '05541', '13976'
            ];

            if ($request->service_unit == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกหน่วยบริการ',
                    'icon' => 'error'
                ]);
            } elseif ($request->service_unit == 99999) {
                $service_unit = "";
            } elseif ($request->service_unit == 11111) {
                $query->whereNotIn('zn.rpst_id', $data_notIn);
            } else {
                $query->where('zn.rpst_id', $request->service_unit);
            }

            if ($request->death_type == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกสถานะ',
                    'icon' => 'error'
                ]);
            } elseif ($request->death_type == 99999) {
                $death_type = "";
            } else {
                $query->where('pt.death', $request->death_type);
            }

            $query->groupBy('ov.hn')
                ->orderBy('ov.vstdate');

            $dementiaFetchListName = $query->get();

            // ดึง SQL query พร้อม bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);

            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $palliative_care_log_data = [
                'function' => 'getDementiaFetchListName',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($palliative_care_log_data);
        
            $output = '';
        
            if ($dementiaFetchListName->isNotEmpty()) {
                // สร้างตาราง
                $output .= '<table id="table-fetch-list-name" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th style="width: auto;">วันที่รับบริการ</th>
                        <th style="width: auto;">สิทธิ์</th>
                        <th style="width: auto;">HN</th>
                        <th style="width: auto;">ชื่อ - สกุล</th>
                        <th style="width: auto;">เลขบัตรประชาชน</th>
                        <th style="width: auto;">วันเกิด</th>
                        <th style="width: auto;">อายุ</th>
                        <th style="width: auto;">ที่อยู่</th>
                        <th style="width: auto;">รพสต</th>
                        <th style="width: auto;">รหัส Dementia</th>
                        <th style="width: auto;">รหัส Z515</th>
                        <th style="width: auto;">รหัส Z718</th>
                        <th style="width: auto;">เพิ่มACP</th>
                        <th style="width: auto;">ACP Detail</th>
                        <th style="width: auto;">เยี่ยมบ้าน<br>รพ.(ครั้ง)</th>
                        <th style="width: auto;">หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>';
                // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                foreach ($dementiaFetchListName as $pcfln) {
                    // เช็คสถานะการเสียชีวิต
                    if ($pcfln->death == 'Y') {
                        if($pcfln->deathday == '') {
                            $class = 'table-danger';
                            $bgColor = "text-dark";
                            $deathMessage = 'คนไข้เสียชีวิตแล้ว : ไม่มีวันเสียชีวิตในระบบ';
                        } else {
                            $class = 'table-danger';
                            $bgColor = "text-dark";
                            $deathday = $this->DateThai($pcfln->deathday);
                            $deathMessage = 'คนไข้เสียชีวิตแล้ว : ' . $deathday . ' ';
                        }
                    } else {
                        $class = 'table-light';
                        $bgColor = "";
                        $deathMessage = 'คนไข้ยังมีชีวิตอยู่';
                        if ($pcfln->daym == 0) {
                            $class = 'table-light';
                            $deathMessage = '<span class="">ยังไม่มีการเยี่ยมบ้าน</span>';
                        } elseif($pcfln->daym < 30) {
                            $class = 'table-light';
                            $deathMessage = '<span class="">เยี่ยม ' . $pcfln->daym . ' วันที่แล้ว</span>';
                        } elseif ($pcfln->daym < 60) {
                            $class = 'table-primary';
                            $deathMessage = '<span class="">เยี่ยม 1 เดือนที่แล้ว</span>';
                        } elseif ($pcfln->daym < 90) {
                            $class = 'table-primary';
                            $deathMessage = '<span class="">เยี่ยม 2 เดือนที่แล้ว</span>';
                        } elseif ($pcfln->daym < 120) {
                            $class = 'table-success';
                            $deathMessage = '<span class="">เยี่ยม 3 เดือนที่แล้ว</span>';
                        } elseif ($pcfln->daym < 210) {
                            $class = 'table-success';
                            $deathMessage = '<span class="">เยี่ยม 6 เดือนที่แล้ว</span>';
                        } elseif ($pcfln->daym < 420) {
                            $class = 'table-warning';
                            $deathMessage = '<span class="">เยี่ยม 1 ปีที่แล้ว</span>';
                        } else {
                            $class = '';
                            $deathMessage = '<span class="">เยี่ยมมากกว่า 1 ปี</span>';
                        }
                    }
                
                    // สร้างแถวของตาราง
                    $vstdate = $this->DateThai($pcfln->vstdate);
                    $birthday = $this->DateThai($pcfln->birthday);

                    $acp_model = AdvanceCarePlanModel::where('acp_vn', $pcfln->vn)->first(); // ใช้ first() เพื่อดึงข้อมูลเดียว
                
                    $output .= '<tr class="' . $class . '">
                        <td>' . $vstdate . '</td>
                        <td>' . $pcfln->pttype_name . '</td>
                        <td>' . $pcfln->hn . '</td>
                        <td>' . $pcfln->fullname . '</td>
                        <td>' . $pcfln->cid . '</td>
                        <td>' . $birthday . '</td>
                        <td>' . $pcfln->age . '</td>
                        <td>' . $pcfln->fulladdress . '</td>
                        <td>' . $pcfln->rpst_name . '</td>
                        <td>' . $pcfln->pdx . '</td>
                        <td>' . $pcfln->Z515 . '</td>
                        <td>' . $pcfln->Z718 . '</td>
                        <td>
                            <button type="button" 
                                id="' . $pcfln->vn . '" 
                                class="btn btn-success advance_care_plan_add zoom-card" 
                                data-bs-toggle="modal" 
                                data-bs-target="#advance_care_plan_modal"
                                data-fullname="' . $pcfln->fullname . '" 
                                data-hn="' . $pcfln->hn . '"
                                data-cid="' . $pcfln->cid . '"
                            >
                                +
                            </button>
                        </td>
                        <td>';
                
                    // เช็คว่ามีข้อมูลใน acp_model หรือไม่
                    if ($acp_model) {
                        $output .= '<button type="button" 
                            id="' . $acp_model->acp_vn . '" 
                            class="btn btn-secondary advance_care_plan_detail zoom-card" 
                            data-bs-toggle="modal" 
                            data-bs-target="#advance_care_plan_detail_modal"
                            data-vn="' . $acp_model->acp_vn . '"
                        >
                            ' . $acp_model->acp_vn . '
                        </button>';
                    } else {
                        $output .= '-'; // ถ้าไม่มีข้อมูลให้แสดงค่าว่าง
                    }
                    
                    $output .= '<td>
                            <button type="button" id="' . $pcfln->hn . '" class="btn btn-warning dementia-home-visiting-information zoom-card" data-bs-toggle="modal" data-bs-target="#dementia_home_visiting_information">
                                ' . $pcfln->dayc . '
                            </button>
                        </td>
                        <td class="' . $bgColor . '">' . $deathMessage . '</td>
                    </tr>';
                }                
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลคนไข้ภาวะสมองเสื่อมในรายการที่เลือก</h1>';
            }
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายชื่อคนไข้ภาวะสมองเสื่อม จาก Request ที่ถูกส่งเข้ามา End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลการเยี่ยมบ้าน Z718 จาก Request ที่ถูกส่งเข้ามา Start
        public function getDementiaHomeVisitingInformationZ718(Request $request) {
            $hn = $request->id;

            $startTime_1 = microtime(true);

            // สร้าง Subquery สำหรับ ovst_community_service
            $subQuery = DB::table('ovst_community_service as cs')
                ->join('vn_stat as vn', 'vn.vn', '=', 'cs.vn')
                ->whereBetween('cs.ovst_community_service_type_id', [1, 103])
                ->where('vn.hn', $hn)
                ->select('cs.vn');

            $query_1 = DB::table('ovst_community_service as oc')
                ->select([
                    DB::raw('DATE(oc.entry_datetime) AS vstdate'),
                    'dt.name as dtname',
                    'os.cc',
                    'os.hpi',
                    DB::raw('GROUP_CONCAT(DISTINCT ot.ovst_community_service_type_name) AS csname'),
                    'di.icd10',
                    DB::raw("CASE 
                                WHEN ov.pdx = 'Z515' OR ov.dx0 = 'Z515' OR ov.dx1 = 'Z515' 
                                    OR ov.dx2 = 'Z515' OR ov.dx3 = 'Z515' OR ov.dx4 = 'Z515' OR ov.dx5 = 'Z515' 
                                THEN 'Z515' 
                                ELSE NULL 
                            END AS Z"),
                    DB::raw("CASE 
                                WHEN ov.pdx = 'Z718' OR ov.dx0 = 'Z718' OR ov.dx1 = 'Z718' 
                                    OR ov.dx2 = 'Z718' OR ov.dx3 = 'Z718' OR ov.dx4 = 'Z718' OR ov.dx5 = 'Z718' 
                                THEN 'Z718' 
                                ELSE NULL 
                            END AS Z718"),
                ])
                ->join('opdscreen as os', 'os.vn', '=', 'oc.vn')
                ->join('ovst_community_service_type as ot', 'ot.ovst_community_service_type_id', '=', 'oc.ovst_community_service_type_id')
                ->joinSub($subQuery, 'tb', function ($join) {
                    $join->on('tb.vn', '=', 'oc.vn');
                })
                ->leftJoin('doctor as dt', 'dt.code', '=', 'oc.doctor')
                ->leftJoin('ovstdiag as di', 'di.vn', '=', 'oc.vn')
                ->leftJoin('vn_stat as ov', 'ov.vn', '=', 'oc.vn')
                ->where(function ($query) {
                    $query->where('ov.pdx', '=', 'Z515')
                        ->orWhere('ov.dx0', '=', 'Z515')
                        ->orWhere('ov.dx1', '=', 'Z515')
                        ->orWhere('ov.dx2', '=', 'Z515')
                        ->orWhere('ov.dx3', '=', 'Z515')
                        ->orWhere('ov.dx4', '=', 'Z515')
                        ->orWhere('ov.dx5', '=', 'Z515');
                })
                ->where(function ($query) {
                    $query->where('ov.pdx', '=', 'Z718')
                        ->orWhere('ov.dx0', '=', 'Z718')
                        ->orWhere('ov.dx1', '=', 'Z718')
                        ->orWhere('ov.dx2', '=', 'Z718')
                        ->orWhere('ov.dx3', '=', 'Z718')
                        ->orWhere('ov.dx4', '=', 'Z718')
                        ->orWhere('ov.dx5', '=', 'Z718');
                })
                ->where('os.hn', $hn)
                ->groupBy('oc.vn')
                ->orderByDesc('oc.vn')
            ;

            $ovst_community_service = $query_1->get();

            // ดึง SQL query_1 พร้อม bindings
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);

            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $ovst_community_service_log_data = [
                'function' => 'getDementiaHomeVisitingInformationZ718 => Query : ovst_community_service',
                'username' => $username,
                'command_sql' => $fullSql_1,
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($ovst_community_service_log_data);

            $startTime_2 = microtime(true);
            
            $query_2 = DB::table('patient as pt')
                ->select([
                    'pt.hn',
                    'pt.cid',
                    DB::raw("CONCAT(pt.pname, pt.fname, ' ', pt.lname) AS fullname"),
                    DB::raw("CONCAT(pt.addrpart, ' หมู่ ', pt.moopart, ' ', th.full_name) AS fulladdress"),
                    'zn.rpst_name'
                ])
                ->leftJoin('thaiaddress as th', DB::raw("th.addressid"), '=', DB::raw("CONCAT(pt.chwpart, pt.amppart, pt.tmbpart)"))
                ->leftJoin('zbm_rpst as zr', function ($join) {
                    $join->on('zr.chwpart', '=', 'pt.chwpart')
                        ->on('zr.amppart', '=', 'pt.amppart')
                        ->on('zr.tmbpart', '=', 'pt.tmbpart')
                        ->on('zr.moopart', '=', 'pt.moopart');
                })
                ->leftJoin('zbm_rpst_name as zn', 'zn.rpst_id', '=', 'zr.rpst_id')
                ->where('pt.hn', $hn)
                ->groupBy('pt.hn')
            ;

            $patient = $query_2->get();

            // ดึง SQL query_2 พร้อม bindings
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);

            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $patient_log_data = [
                'function' => 'getDementiaHomeVisitingInformationZ718 => Query : patient',
                'username' => $username,
                'command_sql' => $fullSql_2,
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($patient_log_data);

            $output = '';

            if($patient->isNotEmpty()) {
                $output .= '
                    <div class="row border">
                        <div class="col-2 border-end">
                            <p class="mt-2">ผู้ป่วย</p>
                        </div>
                        <div class="col-10"> ';
                foreach($patient AS $p) {
                $output .= '
                            <div class="mt-2">
                                <p> HN : ' . $p->hn . '</p>
                                <p> ชื่อ-สกุล : ' . $p->fullname . '</p>
                                <p> เลขบัตรประชาจำตัวประชาชน : ' . $p->cid . '</p>
                            </div>
                ';
                }
                $output .= '
                        </div>
                    </div>
                    <div class="mt-2 row border">
                        <div class="col-2 border-end">
                            <p class="mt-2">ที่อยู่</p>
                        </div>
                        <div class="col-10"> ';
                foreach($patient AS $p) {
                    if($p->rpst_name) {
                        $rpst_name = $p->rpst_name;
                    } else {
                        $rpst_name = "ไม่มีชื่อสถานบริการ";
                    }
                $output .= '
                            <div class="mt-2">
                                <p>' . $p->fulladdress . '</p>
                                <p> สถานบริการ : ' . $rpst_name . '</p>
                            </div>
                ';
                }
                $output .= '
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-center align-items-center fw-bold">
                        <p><i class="bi bi-house-fill me-2"></i>การลงบันทึกเยี่ยมของโรงพยาบาล<i class="bi bi-house-fill ms-2"></i></p>
                    </div>
                    <div class="mt-2 row"> ';
                foreach($ovst_community_service AS $ocs) {

                $SePPS = $this->SePPS($ocs->hpi);
                $SePS = $this->SePS($ocs->hpi);
                $SeBed = $this->SeBed($ocs->hpi);
                $SeBi = $this->SeBi($ocs->hpi);
                $DateThai = $this->DateThai($ocs->vstdate);

                $output .= '
                        <div class="col-4 border p-3">
                            <div class="">
                                วันที่ออกเยี่ยม : ' . $DateThai . '
                            </div>
                            <div class="">
                                เจ้าหน้าที่ : ' . $ocs->dtname . '
                            </div>
                            <div class="mt-2 row">
                                <div class="border-end col-5">
                                    <div>' . $SePPS . '</div>
                                    <div>' . $SeBed . '</div>
                                </div>
                                <div class="col-7">
                                    <div>' . $SePS . '</div>
                                    <div>' . $SeBi . '</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8 border p-3">
                            <div><span class="text-danger">อาการสำคัญ : </span>' . $ocs->cc . '</div>
                            <div><span class="text-danger">อาการปัจจุบัน : </span>' . $ocs->hpi . '</div>
                            <div><li>' . $ocs->csname . '</li></div>
                        </div>
                ';
                }
                $output .='
                    </div>
                ';

                echo $output;
            } else {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'messsage' => 'ไม่มีข้อมูล',
                    'icon' => 'error'
                ]);
            }
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลการเยี่ยมบ้าน Z718 จาก Request ที่ถูกส่งเข้ามา End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลการเยี่ยมบ้าน รพ.(ครั้ง) จาก Request ที่ถูกส่งเข้ามา Start
        public function getDementiaHomeVisitingInformation(Request $request) {
            $hn = $request->id;

            $startTime_1 = microtime(true);

            $subQuery_1 = DB::table('ovst_community_service as cs')
                ->join('vn_stat as vn', 'vn.vn', '=', 'cs.vn')
                ->whereBetween('cs.ovst_community_service_type_id', [1, 103])
                ->where('vn.hn', $hn)
                ->select('cs.vn');

            $query_1 = DB::table('ovst_community_service as oc')
                ->select([
                    DB::raw('DATE(oc.entry_datetime) AS vstdate'),
                    'dt.name as dtname',
                    'os.cc',
                    'os.hpi',
                    DB::raw('GROUP_CONCAT(DISTINCT ot.ovst_community_service_type_name) AS csname'),
                    'os.temperature',
                    'os.pulse',
                    'os.rr',
                    DB::raw("CONCAT(LEFT(os.bps, 3), '/', LEFT(os.bpd, 2)) AS bp"),
                ])
                ->join('opdscreen as os', 'os.vn', '=', 'oc.vn')
                ->join('ovst_community_service_type as ot', 'ot.ovst_community_service_type_id', '=', 'oc.ovst_community_service_type_id')
                ->joinSub($subQuery_1, 'tb', function ($join) {
                    $join->on('tb.vn', '=', 'oc.vn');
                })
                ->leftJoin('doctor as dt', 'dt.code', '=', 'oc.doctor')
                ->where('os.hn', $hn)
                ->groupBy('oc.vn')
                ->orderByDesc('oc.vn')
            ;

            $ovst_community_service = $query_1->get();

            // ดึง SQL query_1 พร้อม bindings
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);

            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $ovst_community_service_log_data = [
                'function' => 'getDementiaHomeVisitingInformation => Query : ovst_community_service',
                'username' => $username,
                'command_sql' => $fullSql_1,
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($ovst_community_service_log_data);

            $startTime_2 = microtime(true);

            $query_2 = DB::table('patient as pt')
                ->select(
                    'pt.hn',
                    'pt.cid',
                    DB::raw("CONCAT(pt.pname, pt.fname, ' ', pt.lname) AS fullname"),
                    DB::raw("CONCAT(pt.addrpart, ' หมู่ ', pt.moopart, ' ', th.full_name) AS fulladdress"),
                    'zn.rpst_name'
                )
                ->leftJoin('thaiaddress as th', DB::raw("CONCAT(pt.chwpart, pt.amppart, pt.tmbpart)"), '=', 'th.addressid')
                ->leftJoin('zbm_rpst as zr', function($join) {
                    $join->on('zr.chwpart', '=', 'pt.chwpart')
                        ->on('zr.amppart', '=', 'pt.amppart')
                        ->on('zr.tmbpart', '=', 'pt.tmbpart')
                        ->on('zr.moopart', '=', 'pt.moopart');
                })
                ->leftJoin('zbm_rpst_name as zn', 'zn.rpst_id', '=', 'zr.rpst_id')
                ->where('pt.hn', $hn)
                ->groupBy('pt.hn')
            ;

            $patient = $query_2->get();

            // ดึง SQL query_2 พร้อม bindings
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);

            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $patient_log_data = [
                'function' => 'getDementiaHomeVisitingInformation => Query : patient',
                'username' => $username,
                'command_sql' => $fullSql_2,
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($patient_log_data);

            $output = '';

            if($patient->isNotEmpty()) {
                $output .= '
                    <div class="row border">
                        <div class="col-2 border-end">
                            <p class="mt-2">ผู้ป่วย</p>
                        </div>
                        <div class="col-10"> ';
                foreach($patient AS $p) {
                $output .= '
                            <div class="mt-2">
                                <p> HN : ' . $p->hn . '</p>
                                <p> ชื่อ-สกุล : ' . $p->fullname . '</p>
                                <p> เลขบัตรประชาจำตัวประชาชน : ' . $p->cid . '</p>
                            </div>
                ';
                }
                $output .= '
                        </div>
                    </div>
                    <div class="mt-2 row border">
                        <div class="col-2 border-end">
                            <p class="mt-2">ที่อยู่</p>
                        </div>
                        <div class="col-10"> ';
                foreach($patient AS $p) {
                    if($p->rpst_name) {
                        $rpst_name = $p->rpst_name;
                    } else {
                        $rpst_name = "ไม่มีชื่อสถานบริการ";
                    }
                $output .= '
                            <div class="mt-2">
                                <p>' . $p->fulladdress . '</p>
                                <p> สถานบริการ : ' . $rpst_name . '</p>
                            </div>
                ';
                }
                $output .= '
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-center align-items-center fw-bold">
                        <p><i class="bi bi-house-fill me-2"></i>การลงบันทึกเยี่ยมของโรงพยาบาล<i class="bi bi-house-fill ms-2"></i></p>
                    </div>
                    <div class="mt-2 row"> ';
                foreach($ovst_community_service AS $ocs) {

                $SePPS = $this->SePPS($ocs->hpi);
                $SePS = $this->SePS($ocs->hpi);
                $SeBed = $this->SeBed($ocs->hpi);
                $SeBi = $this->SeBi($ocs->hpi);
                $DateThai = $this->DateThai($ocs->vstdate);

                $output .= '
                        <div class="col-4 border p-3">
                            <div class="">
                                วันที่ออกเยี่ยม : ' . $DateThai . '
                            </div>
                            <div class="">
                                เจ้าหน้าที่ : ' . $ocs->dtname . '
                            </div>
                            <div class="mt-2 row">
                                <div class="border-end col-5">
                                    <div>' . $SePPS . '</div>
                                    <div>' . $SeBed . '</div>
                                    <div>' . $SeBi . '</div>
                                    <div> BP = ' . $ocs->bp . ' mmHg</div>
                                </div>
                                <div class="col-7">
                                    <div>' . $SePS . '</div>
                                    <div> PR = ' . $ocs->pulse . ' /min</div>
                                    <div>' . $ocs->rr . ' /min</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8 border p-3">
                            <div><span class="text-danger">อาการสำคัญ : </span>' . $ocs->cc . '</div>
                            <div><span class="text-danger">อาการปัจจุบัน : </span>' . $ocs->hpi . '</div>
                            <div><li>' . $ocs->csname . '</li></div>
                        </div>
                ';
                }
                $output .='
                    </div>
                ';

                echo $output;
            } else {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'messsage' => 'ไม่มี HN ส่งมา',
                    'icon' => 'error'
                ]);
            }
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลการเยี่ยมบ้าน รพ.(ครั้ง) จาก Request ที่ถูกส่งเข้ามา End
}
