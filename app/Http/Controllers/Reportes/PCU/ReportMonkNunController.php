<?php

namespace App\Http\Controllers\Reportes\PCU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;
use App\Models\Dashboard_Setting\FiscalYearModel;

use App\Models\Log\AccessibilityLogModel;
use App\Models\Log\ReportMonkNunLogModel;
use App\Models\Log\SidebarSub1MenuLogModel;

class ReportMonkNunController extends Controller
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

    // นำปีมาแก้ไขเพื่อนำไปใช้ในปีงบประมาณ Check_year Start
        private function check_year($year) {
            if($year) {
                return [
                    'year_old' => $year - 1,
                    'year_new' => $year
                ];
            } else {
                return false;
            }
        }
    // นำปีมาแก้ไขเพื่อนำไปใช้ในปีงบประมาณ Check_year End

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

    // หน้าแรกของระบบรายงาน Monk & Nun Start
        public function index(Request $request) {
            // Retrieve session data
            $data = $request->session()->all();

            $fiscal_year = FiscalYearModel::orderBy('id', 'desc')->get();

            $startTime = microtime(true);

            $sidebar_sub1_menu_id = $request->id;

            $query = SidebarSub1MenuModel::where('id', $sidebar_sub1_menu_id);

            $SidebarSub1MenuId = $query->first();

            // ดึง SQL query พร้อม bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $sidebar_sub1_menu_log_data = [
                'function' => "Where sidebar_sub1_menu_name = {$SidebarSub1MenuId->sidebar_sub1_menu_name}", // ใช้ double quotes และการแทนที่ตัวแปรใน string
                'username' => $data['loginname'],
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            SidebarSub1MenuLogModel::create($sidebar_sub1_menu_log_data);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $report_monk_nun_log_data = [
                'function' => "The user comes to the page report monk and nun.",
                'username' => $data['loginname'],
                'command_sql' => "",
                'query_time' => "",
                'operation' => 'OPEN'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            ReportMonkNunLogModel::create($report_monk_nun_log_data);

            if($SidebarSub1MenuId->status_id === 1) {
                $startTime_1 = microtime(true);

                $query_1 = AccessibilityModel::where('accessibility_name', $data['groupname'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);
                $accessibility_groupname_model = $query_1->first();

                // ดึง SQL query_1 พร้อม bindings
                $sql_1 = $query_1->toSql();
                $bindings_1 = $query_1->getBindings();
                $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
            
                $endTime_1 = microtime(true);
                $executionTime_1 = $endTime_1 - $startTime_1;
                $formattedExecutionTime_1 = number_format($executionTime_1, 3);

                // สร้างข้อมูลสำหรับบันทึกใน log
                $accessibility_log_data = [
                    'function' => "Where accessibility_name = {$data['groupname']} AND sidebar_sub1_menu_id = {$SidebarSub1MenuId->id}",
                    'username' => $data['loginname'],
                    'command_sql' => $fullSql_1,
                    'query_time' => $formattedExecutionTime_1,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน AccessibilityLogModel
                AccessibilityLogModel::create($accessibility_log_data);

                if($accessibility_groupname_model !== null && $accessibility_groupname_model->status_id === 1) {
                    return view('reportes.pcu.report_monk_nun', compact('data', 'fiscal_year'));
                } else {
                    $startTime_2 = microtime(true);

                    $query_2 = AccessibilityModel::where('accessibility_name', $data['name'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);
                    $accessibility_name_model = $query_2->first();

                    // ดึง SQL query_2 พร้อม bindings
                    $sql_2 = $query_2->toSql();
                    $bindings_2 = $query_2->getBindings();
                    $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
                
                    $endTime_2 = microtime(true);
                    $executionTime_2 = $endTime_2 - $startTime_2;
                    $formattedExecutionTime_2 = number_format($executionTime_2, 3);

                    // สร้างข้อมูลสำหรับบันทึกใน log
                    $accessibility_log_data = [
                        'function' => "Where accessibility_name = {$data['name']} AND sidebar_sub1_menu_id = {$SidebarSub1MenuId->id}",
                        'username' => $data['loginname'],
                        'command_sql' => $fullSql_2,
                        'query_time' => $formattedExecutionTime_2,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน AccessibilityLogModel
                    AccessibilityLogModel::create($accessibility_log_data);

                    if($accessibility_name_model !== null && $accessibility_name_model->status_id === 1) {
                        return view('reportes.pcu.report_monk_nun', compact('data', 'fiscal_year'));
                    } else {
                        $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบรายงาน Monk & Nun หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบรายงาน Monk & Nun ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }  
    // หน้าแรกของระบบรายงาน Monk & Nun End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ Monk & Nun จากปีงบประมาณ ที่ถูกส่งเข้ามา Start
        public function getReportMonkNunFetchYear(Request $request) {
            $year = $request->yearSelect;
        
            // ตรวจสอบวันที่
            if ($year == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกวันที่รับบริการ',
                    'icon' => 'error'
                ]);
            }

            $year_change = $this->check_year($year);

            $startTime = microtime(true);
        
            // Query ข้อมูลจากฐานข้อมูล
            $query = DB::table('ovst as o')
                ->select(
                    'o.vstdate',
                    'o.hn',
                    'pt.pname',
                    'pt.fname',
                    'pt.lname',
                    DB::raw('YEAR(CURDATE()) - YEAR(pt.birthday) AS age'),
                    'pt.addrpart',
                    'pt.moopart',
                    'ta3.NAME as sub_district',
                    'ta2.NAME as district',
                    'ta1.NAME as province',
                    'pt.cid',
                    'ptt.NAME as pttype_name'
                )
                ->join('patient as pt', 'o.hn', '=', 'pt.hn')
                ->join('thaiaddress as ta1', function ($join) {
                    $join->on('ta1.chwpart', '=', 'pt.chwpart')
                        ->where('ta1.amppart', '=', '00')
                        ->where('ta1.tmbpart', '=', '00');
                })
                ->join('thaiaddress as ta2', function ($join) {
                    $join->on('ta2.chwpart', '=', 'pt.chwpart')
                        ->on('ta2.amppart', '=', 'pt.amppart')
                        ->where('ta2.tmbpart', '=', '00');
                })
                ->join('thaiaddress as ta3', function ($join) {
                    $join->on('ta3.chwpart', '=', 'pt.chwpart')
                        ->on('ta3.amppart', '=', 'pt.amppart')
                        ->on('ta3.tmbpart', '=', 'pt.tmbpart');
                })
                ->leftJoin('pttype as ptt', 'pt.pttype', '=', 'ptt.pttype')
                ->whereIn('pt.pname', ['พระ', 'แม่ชี'])
                ->whereBetween('o.vstdate', ["{$year_change['year_old']}-10-01", "{$year_change['year_new']}-09-30"])
                ->groupBy('o.hn')
                ->orderBy('o.vstdate')
            ;

            $reportMonkNunFetch = $query->get();

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
            $report_monk_nun_log_data = [
                'function' => 'getreportMonkNunFetchYear',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReportMonkNunLogModel
            ReportMonkNunLogModel::create($report_monk_nun_log_data);
        
            $output = '';
        
            if ($reportMonkNunFetch->isNotEmpty()) {
                // สร้างตาราง
                $output = '<div class="table-responsive">';
                $output .= '<table id="table-fetch-report-monk-nun" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: auto;">วันที่มารับบริการ</th>
                            <th style="width: auto;">HN</th>
                            <th style="width: auto;">คำนำหน้า</th>
                            <th style="width: auto;">ชื่อ</th>
                            <th style="width: auto;">นามสกุล</th>
                            <th style="width: auto;">อายุ</th>
                            <th style="width: auto;">บ้านเลขที่</th>
                            <th style="width: auto;">หมู่</th>
                            <th style="width: auto;">ตำบล</th>
                            <th style="width: auto;">อำเภอ</th>
                            <th style="width: auto;">จังหวัด</th>
                            <th style="width: auto;">เลขบัตรประจำตัวประชาชน</th>
                            <th style="width: auto;">สิทธิ์การรักษา</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                foreach ($reportMonkNunFetch as $rzmnf) {
                    // สร้างแถวของตาราง
                    $vstdate = $this->DateThai($rzmnf->vstdate);
                
                    $output .= '<tr>
                        <td>' . $vstdate . '</td>
                        <td>' . $rzmnf->hn . '</td>
                        <td>' . $rzmnf->pname . '</td>
                        <td>' . $rzmnf->fname . '</td>
                        <td>' . $rzmnf->lname . '</td>
                        <td>' . $rzmnf->age . '</td>
                        <td>' . $rzmnf->addrpart . '</td>
                        <td>' . $rzmnf->moopart . '</td>
                        <td>' . $rzmnf->sub_district . '</td>
                        <td>' . $rzmnf->district . '</td>
                        <td>' . $rzmnf->province . '</td>
                        <td>' . $rzmnf->cid . '</td>
                        <td>' . $rzmnf->pttype_name . '</td>
                    </tr>';
                }
            
                $output .= '</tbody></table>';
                $output .= '</div>';
            
                echo $output;
            } else {
                echo '<div class="alert alert-warning text-center my-5">
                    <h5>ไม่มีข้อมูลรายการ Monk & Nun ในรายการที่เลือก</h5>
                </div>';
            }            
            
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ Monk & Nun จากปีงบประมาณ ที่ถูกส่งเข้ามา End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ Monk & Nun จากวัน-เดือน-ปี ที่ถูกส่งเข้ามา Start
        public function getReportMonkNunFetchSelectDate(Request $request) {
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
            $query = DB::table('ovst as o')
                ->select(
                    'o.vstdate',
                    'o.hn',
                    'pt.pname',
                    'pt.fname',
                    'pt.lname',
                    DB::raw('YEAR(CURDATE()) - YEAR(pt.birthday) AS age'),
                    'pt.addrpart',
                    'pt.moopart',
                    'ta3.NAME as sub_district',
                    'ta2.NAME as district',
                    'ta1.NAME as province',
                    'pt.cid',
                    'ptt.NAME as pttype_name'
                )
                ->join('patient as pt', 'o.hn', '=', 'pt.hn')
                ->join('thaiaddress as ta1', function ($join) {
                    $join->on('ta1.chwpart', '=', 'pt.chwpart')
                        ->where('ta1.amppart', '=', '00')
                        ->where('ta1.tmbpart', '=', '00');
                })
                ->join('thaiaddress as ta2', function ($join) {
                    $join->on('ta2.chwpart', '=', 'pt.chwpart')
                        ->on('ta2.amppart', '=', 'pt.amppart')
                        ->where('ta2.tmbpart', '=', '00');
                })
                ->join('thaiaddress as ta3', function ($join) {
                    $join->on('ta3.chwpart', '=', 'pt.chwpart')
                        ->on('ta3.amppart', '=', 'pt.amppart')
                        ->on('ta3.tmbpart', '=', 'pt.tmbpart');
                })
                ->leftJoin('pttype as ptt', 'pt.pttype', '=', 'ptt.pttype')
                ->whereIn('pt.pname', ['พระ', 'แม่ชี'])
                ->whereBetween('o.vstdate', [$min_date, $max_date])
                ->groupBy('o.hn')
                ->orderBy('o.vstdate')
            ;

            $reportMonkNunFetch = $query->get();

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
            $report_monk_nun_log_data = [
                'function' => 'getreportMonkNunFetch',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReportMonkNunLogModel
            ReportMonkNunLogModel::create($report_monk_nun_log_data);
        
            $output = '';
        
            if ($reportMonkNunFetch->isNotEmpty()) {
                // สร้างตาราง
                $output = '<div class="table-responsive">';
                $output .= '<table id="table-fetch-report-monk-nun" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: auto;">วันที่มารับบริการ</th>
                            <th style="width: auto;">HN</th>
                            <th style="width: auto;">คำนำหน้า</th>
                            <th style="width: auto;">ชื่อ</th>
                            <th style="width: auto;">นามสกุล</th>
                            <th style="width: auto;">อายุ</th>
                            <th style="width: auto;">บ้านเลขที่</th>
                            <th style="width: auto;">หมู่</th>
                            <th style="width: auto;">ตำบล</th>
                            <th style="width: auto;">อำเภอ</th>
                            <th style="width: auto;">จังหวัด</th>
                            <th style="width: auto;">เลขบัตรประจำตัวประชาชน</th>
                            <th style="width: auto;">สิทธิ์การรักษา</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                foreach ($reportMonkNunFetch as $rzmnf) {
                    // สร้างแถวของตาราง
                    $vstdate = $this->DateThai($rzmnf->vstdate);
                
                    $output .= '<tr>
                        <td>' . $vstdate . '</td>
                        <td>' . $rzmnf->hn . '</td>
                        <td>' . $rzmnf->pname . '</td>
                        <td>' . $rzmnf->fname . '</td>
                        <td>' . $rzmnf->lname . '</td>
                        <td>' . $rzmnf->age . '</td>
                        <td>' . $rzmnf->addrpart . '</td>
                        <td>' . $rzmnf->moopart . '</td>
                        <td>' . $rzmnf->sub_district . '</td>
                        <td>' . $rzmnf->district . '</td>
                        <td>' . $rzmnf->province . '</td>
                        <td>' . $rzmnf->cid . '</td>
                        <td>' . $rzmnf->pttype_name . '</td>
                    </tr>';
                }
            
                $output .= '</tbody></table>';
                $output .= '</div>';
            
                echo $output;
            } else {
                echo '<div class="alert alert-warning text-center my-5">
                    <h5>ไม่มีข้อมูลรายการ Monk & Nun ในรายการที่เลือก</h5>
                </div>';
            }             
            
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ Monk & Nun จากวัน-เดือน-ปี ที่ถูกส่งเข้ามา End
}
