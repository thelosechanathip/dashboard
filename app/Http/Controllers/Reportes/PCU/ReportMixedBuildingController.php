<?php

namespace App\Http\Controllers\Reportes\PCU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;
use App\Models\Dashboard_Setting\FiscalYearModel;

use App\Models\Log\AccessibilityLogModel;
use App\Models\Log\ReportMixedBuildingLogModel;
use App\Models\Log\SidebarSub1MenuLogModel;

class ReportMixedBuildingController extends Controller
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

    // หน้าแรกของระบบรายงาน Mixed Building Start
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
            $report_mixed_building_log_data = [
                'function' => "The user comes to the page report mixed building.",
                'username' => $data['loginname'],
                'command_sql' => "",
                'query_time' => "",
                'operation' => 'OPEN'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            ReportMixedBuildingLogModel::create($report_mixed_building_log_data);

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
                    return view('reportes.pcu.report_mixed_building', compact('data', 'fiscal_year'));
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
                        return view('reportes.pcu.report_mixed_building', compact('data', 'fiscal_year'));
                    } else {
                        $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบรายงาน Mixed Building หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบรายงาน Mixed Building ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }  
    // หน้าแรกของระบบรายงาน Mixed Building End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ Mixed Building จากปีงบประมาณ ที่ถูกส่งเข้ามา Start
        public function getReportMixedBuildingFetchYear(Request $request) {
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
            $query = DB::table('ipt as i')
                ->join('patient as pt', 'i.hn', '=', 'pt.hn')
                ->join('an_stat as ans', 'i.vn', '=', 'ans.vn')
                ->join('pttype as ptt', 'i.pttype', '=', 'ptt.pttype')
                ->select([
                    'i.regdate',
                    'i.an',
                    'i.hn',
                    'pt.pname',
                    'pt.fname',
                    'pt.lname',
                    DB::raw('YEAR(CURRENT_DATE) - YEAR(pt.birthday) AS age'),
                    'pt.cid',
                    'ptt.name as pttype_name',
                    'ans.pdx as diag_main',
                    DB::raw("
                        CASE
                            WHEN CONCAT(
                                COALESCE(ans.dx0, ''), ',', COALESCE(ans.dx1, ''), ',', COALESCE(ans.dx2, ''), ',',
                                COALESCE(ans.dx3, ''), ',', COALESCE(ans.dx4, ''), ',', COALESCE(ans.dx5, '')
                            ) = '' THEN ''
                            ELSE TRIM(TRAILING ',' FROM CONCAT(
                                COALESCE(ans.dx0, ''), ',',
                                COALESCE(ans.dx1, ''), ',',
                                COALESCE(ans.dx2, ''), ',',
                                COALESCE(ans.dx3, ''), ',',
                                COALESCE(ans.dx4, ''), ',',
                                COALESCE(ans.dx5, '')
                            ))
                        END AS diag_sub
                    "),
                    DB::raw("
                        (
                            SELECT SUM(s.Compensated)
                            FROM rcmdb.repeclaim s
                            WHERE s.AN = i.an
                            AND s.Compensated > 0
                        ) AS money
                    ")
                ])
                ->whereBetween('i.regdate', ["{$year_change['year_old']}-10-01", "{$year_change['year_new']}-09-30"])
                ->where('i.ward', '07') // { 07 = ตึกรวมของ }
                ->where('i.admdoctor', '02') // { 07 = พญ.ศุภมาศ อุ่นสากล }
            ;

            $reportMixedBuildingFetch = $query->get();

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
            $report_mixed_building_log_data = [
                'function' => 'getreportMixedBuildingFetchYear',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReportMixedBuildingLogModel
            ReportMixedBuildingLogModel::create($report_mixed_building_log_data);
        
            $output = '';
        
            if ($reportMixedBuildingFetch->isNotEmpty()) {
                // สร้างตาราง
                $output = '<div class="table-responsive">';
                $output .= '<table id="table-fetch-report-mixed-building" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: auto;">วันที่มารับบริการ</th>
                            <th style="width: auto;">หมายเลข AN</th>
                            <th style="width: auto;">HN</th>
                            <th style="width: auto;">คำนำหน้า</th>
                            <th style="width: auto;">ชื่อ</th>
                            <th style="width: auto;">นามสกุล</th>
                            <th style="width: auto;">อายุ</th>
                            <th style="width: auto;">เลขบัตรประจำตัวประชาชน</th>
                            <th style="width: auto;">สิทธิ์การรักษา</th>
                            <th style="width: auto;">Diag หลัก</th>
                            <th style="width: auto;">Diag รอง</th>
                            <th style="width: auto;">ค่าตอบแทนชดเชย</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                foreach ($reportMixedBuildingFetch as $rzmbf) {
                    // สร้างแถวของตาราง
                    $regdate = $this->DateThai($rzmbf->regdate);

                    if($rzmbf->money != '' || $rzmbf->money != NULL) {
                        $money = $rzmbf->money . ' บาท';
                    } else {
                        $money = '';
                    }
                
                    $output .= '<tr>
                        <td>' . $regdate . '</td>
                        <td>' . $rzmbf->an . '</td>
                        <td>' . $rzmbf->hn . '</td>
                        <td>' . $rzmbf->pname . '</td>
                        <td>' . $rzmbf->fname . '</td>
                        <td>' . $rzmbf->lname . '</td>
                        <td>' . $rzmbf->age . '</td>
                        <td>' . $rzmbf->cid . '</td>
                        <td>' . $rzmbf->pttype_name . '</td>
                        <td>' . $rzmbf->diag_main . '</td>
                        <td>' . $rzmbf->diag_sub . '</td>
                        <td>' . $money . '</td>
                    </tr>';
                }
            
                $output .= '</tbody></table>';
                $output .= '</div>';
            
                echo $output;
            } else {
                echo '<div class="alert alert-warning text-center my-5">
                    <h5>ไม่มีข้อมูลรายการ Mixed Buildingในรายการที่เลือก</h5>
                </div>';
            }            
            
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ Mixed Building จากปีงบประมาณ ที่ถูกส่งเข้ามา End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ Mixed Building จากวัน-เดือน-ปี ที่ถูกส่งเข้ามา Start
        public function getReportMixedBuildingFetchSelectDate(Request $request) {
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
            $query = DB::table('ipt as i')
                ->join('patient as pt', 'i.hn', '=', 'pt.hn')
                ->join('an_stat as ans', 'i.vn', '=', 'ans.vn')
                ->join('pttype as ptt', 'i.pttype', '=', 'ptt.pttype')
                ->select([
                    'i.regdate',
                    'i.an',
                    'i.hn',
                    'pt.pname',
                    'pt.fname',
                    'pt.lname',
                    DB::raw('YEAR(CURRENT_DATE) - YEAR(pt.birthday) AS age'),
                    'pt.cid',
                    'ptt.name as pttype_name',
                    'ans.pdx as diag_main',
                    DB::raw("
                        CASE
                            WHEN CONCAT(
                                COALESCE(ans.dx0, ''), ',', COALESCE(ans.dx1, ''), ',', COALESCE(ans.dx2, ''), ',',
                                COALESCE(ans.dx3, ''), ',', COALESCE(ans.dx4, ''), ',', COALESCE(ans.dx5, '')
                            ) = '' THEN ''
                            ELSE TRIM(TRAILING ',' FROM CONCAT(
                                COALESCE(ans.dx0, ''), ',',
                                COALESCE(ans.dx1, ''), ',',
                                COALESCE(ans.dx2, ''), ',',
                                COALESCE(ans.dx3, ''), ',',
                                COALESCE(ans.dx4, ''), ',',
                                COALESCE(ans.dx5, '')
                            ))
                        END AS diag_sub
                    "),
                    DB::raw("
                        (
                            SELECT SUM(s.Compensated)
                            FROM rcmdb.repeclaim s
                            WHERE s.AN = i.an
                            AND s.Compensated > 0
                        ) AS money
                    ")
                ])
                ->whereBetween('i.regdate', [$min_date, $max_date])
                ->where('i.ward', '07') // { 07 = ตึกรวมของ }
                ->where('i.admdoctor', '02') // { 07 = พญ.ศุภมาศ อุ่นสากล }
            ;

            $reportMixedBuildingFetch = $query->get();

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
            $report_mixed_building_log_data = [
                'function' => 'getreportMixedBuildingFetch',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReportMixedBuildingLogModel
            ReportMixedBuildingLogModel::create($report_mixed_building_log_data);
        
            $output = '';
        
            if ($reportMixedBuildingFetch->isNotEmpty()) {
                // สร้างตาราง
                $output = '<div class="table-responsive">';
                $output .= '<table id="table-fetch-report-mixed-building" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: auto;">วันที่มารับบริการ</th>
                            <th style="width: auto;">หมายเลข AN</th>
                            <th style="width: auto;">HN</th>
                            <th style="width: auto;">คำนำหน้า</th>
                            <th style="width: auto;">ชื่อ</th>
                            <th style="width: auto;">นามสกุล</th>
                            <th style="width: auto;">อายุ</th>
                            <th style="width: auto;">เลขบัตรประจำตัวประชาชน</th>
                            <th style="width: auto;">สิทธิ์การรักษา</th>
                            <th style="width: auto;">Diag หลัก</th>
                            <th style="width: auto;">Diag รอง</th>
                            <th style="width: auto;">ค่าตอบแทนชดเชย</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                foreach ($reportMixedBuildingFetch as $rzmbf) {
                    // สร้างแถวของตาราง
                    $regdate = $this->DateThai($rzmbf->regdate);

                    if($rzmbf->money != '' || $rzmbf->money != NULL) {
                        $money = $rzmbf->money . ' บาท';
                    } else {
                        $money = '';
                    }
                
                    $output .= '<tr>
                        <td>' . $regdate . '</td>
                        <td>' . $rzmbf->an . '</td>
                        <td>' . $rzmbf->hn . '</td>
                        <td>' . $rzmbf->pname . '</td>
                        <td>' . $rzmbf->fname . '</td>
                        <td>' . $rzmbf->lname . '</td>
                        <td>' . $rzmbf->age . '</td>
                        <td>' . $rzmbf->cid . '</td>
                        <td>' . $rzmbf->pttype_name . '</td>
                        <td>' . $rzmbf->diag_main . '</td>
                        <td>' . $rzmbf->diag_sub . '</td>
                        <td>' . $money . '</td>
                    </tr>';
                }
            
                $output .= '</tbody></table>';
                $output .= '</div>';
            
                echo $output;
            } else {
                echo '<div class="alert alert-warning text-center my-5">
                    <h5>ไม่มีข้อมูลรายการ Mixed Buildingในรายการที่เลือก</h5>
                </div>';
            }     
            
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ Mixed Building จากวัน-เดือน-ปี ที่ถูกส่งเข้ามา End
}
