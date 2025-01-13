<?php

namespace App\Http\Controllers\Reportes\PCU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel; // Export => Extension( Excel )

use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;
use App\Models\Dashboard_Setting\FiscalYearModel;

use App\Models\Log\AccessibilityLogModel;
use App\Models\Log\ReportCXR4100341004LogModel;
use App\Models\Log\SidebarSub1MenuLogModel;

class ReportCXR4100341004Controller extends Controller
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

    // หน้าแรกของระบบรายงาน CXR 41003 & 41004 Start
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
            $report_cxr_41003_41004_log_data = [
                'function' => "The user comes to the page report cxr 41003 & 41004.",
                'username' => $data['loginname'],
                'command_sql' => "",
                'query_time' => "",
                'operation' => 'OPEN'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            ReportCXR4100341004LogModel::create($report_cxr_41003_41004_log_data);

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
                    return view('reportes.pcu.report_cxr_41003_41004', compact('data', 'fiscal_year'));
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
                        return view('reportes.pcu.report_cxr_41003_41004', compact('data', 'fiscal_year'));
                    } else {
                        $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบรายงาน CXR 41003 & 41004 หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบรายงาน CXR 41003 & 41004 ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }  
    // หน้าแรกของระบบรายงาน CXR 41003 & 41004 End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ CXR 41003 & 41004 จากปีงบประมาณ ที่ถูกส่งเข้ามา Start
        public function getReportCXR4100341004FetchYear(Request $request) {
            $year = $request->yearSelect;

            if (!$year || !is_numeric($year)) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกวันที่รับบริการ',
                    'icon' => 'error'
                ]);
            }
        
            $year_change = $this->check_year($year);
            $startDate = $year_change['year_old'] . '-10-01';
            $endDate = $year_change['year_new'] . '-09-30';

            $startTime = microtime(true);
        
            $query = "
                SELECT 
                    pt.hn,
                    pt.cid,
                    pt.pname,
                    pt.fname,
                    pt.lname,
                    pt.birthday,
                    YEAR(CURRENT_DATE) - YEAR(pt.birthday) AS age,
                    pt.addrpart,
                    pt.moopart,
                    ta1.name AS sub_district,
                    ta2.name AS district,
                    ta3.name AS province,
                    pt.clinic,
                    ptt.name AS pttype_name,
                    t1.order_date_time,
                    t2.hba1c
                FROM (
                    SELECT 
                        vn, 
                        hn, 
                        xray_list, 
                        MAX(order_date_time) AS order_date_time
                    FROM xray_head 
                    WHERE order_date_time BETWEEN ? AND ? 
                    AND xray_list IN(?, ?)
                    GROUP BY hn
                    ORDER BY hn
                ) AS t1
                LEFT OUTER JOIN (
                    SELECT 
                        hn,
                        MAX(vstdate) AS vstdate,
                        hba1c
                    FROM opdscreen 
                    WHERE vstdate BETWEEN ? AND ? 
                    AND hba1c IS NOT NULL
                    GROUP BY hn 
                ) AS t2 ON t1.hn = t2.hn
                INNER JOIN patient pt ON t1.hn = pt.hn
                INNER JOIN thaiaddress ta1 ON ta1.chwpart = pt.chwpart AND ta1.amppart = '00' AND ta1.tmbpart = '00'
                INNER JOIN thaiaddress ta2 ON ta2.chwpart = pt.chwpart AND ta2.amppart = pt.amppart AND ta2.tmbpart = '00'
                INNER JOIN thaiaddress ta3 ON ta3.chwpart = pt.chwpart AND ta3.amppart = pt.amppart AND ta3.tmbpart = pt.tmbpart
                INNER JOIN pttype ptt ON pt.pttype = ptt.pttype
                GROUP BY t1.hn
                ORDER BY t1.hn
            ";
        
            $bindings = [
                $startDate, 
                $endDate, 
                'CXR 41003', 
                'C.X.R. [Portable] 41004', 
                $startDate, 
                $endDate
            ];
        
            $reportCXR4100341004Fetch = DB::select($query, $bindings);
        
            // ดึง SQL query พร้อม bindings
            $sql = $query;
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
        
            // สร้างข้อมูลสำหรับบันทึกใน log
            $report_cxr_41003_41004_log_data = [
                'function' => 'getReportCXR4100341004FetchYear',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReportCXR4100341004LogModel
            ReportCXR4100341004LogModel::create($report_cxr_41003_41004_log_data);

            $file = $request->file('file');
        
            if (!$request->hasFile('file')) {
                $output = '';
        
                if (count($reportCXR4100341004Fetch) > 0) {
                    // สร้างตาราง
                    $output = '<div class="table-responsive">';
                    $output .= '<table id="table-fetch-report-cxr-41003-41004" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: auto;">HN</th>
                                <th style="width: auto;">CID</th>
                                <th style="width: auto;">คำนำหน้า</th>
                                <th style="width: auto;">ชื่อ</th>
                                <th style="width: auto;">นามสกุล</th>
                                <th style="width: auto;">วันเกิด</th>
                                <th style="width: auto;">อายุ</th>
                                <th style="width: auto;">บ้านเลขที่</th>
                                <th style="width: auto;">หมู่</th>
                                <th style="width: auto;">ตำบล</th>
                                <th style="width: auto;">อำเภอ</th>
                                <th style="width: auto;">จังหวัด</th>
                                <th style="width: auto;">โรคประจำตัว</th>
                                <th style="width: auto;">สิทธิ์การรักษา</th>
                                <th style="width: auto;">วัน-เวลาที่ Xray</th>
                                <th style="width: auto;">HBA1C</th>
                            </tr>
                        </thead>
                        <tbody>';
                    
                    // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                    foreach ($reportCXR4100341004Fetch as $rcxr4100341004f) {
                        // สร้างแถวของตาราง
                        $order_date_time = $this->DateThai($rcxr4100341004f->order_date_time);
                        $birthday = $this->DateThai($rcxr4100341004f->birthday);
                    
                        $output .= '<tr>
                            <td>' . $rcxr4100341004f->hn . '</td>
                            <td>' . $rcxr4100341004f->cid . '</td>
                            <td>' . $rcxr4100341004f->pname . '</td>
                            <td>' . $rcxr4100341004f->fname . '</td>
                            <td>' . $rcxr4100341004f->lname . '</td>
                            <td>' . $birthday . '</td>
                            <td>' . $rcxr4100341004f->age . '</td>
                            <td>' . $rcxr4100341004f->addrpart . '</td>
                            <td>' . $rcxr4100341004f->moopart . '</td>
                            <td>' . $rcxr4100341004f->sub_district . '</td>
                            <td>' . $rcxr4100341004f->district . '</td>
                            <td>' . $rcxr4100341004f->province . '</td>
                            <td>' . $rcxr4100341004f->clinic . '</td>
                            <td>' . $rcxr4100341004f->pttype_name . '</td>
                            <td>' . $order_date_time . '</td>
                            <td>' . $rcxr4100341004f->hba1c . '</td>
                        </tr>';
                    }
                
                    $output .= '</tbody></table>';
                    $output .= '</div>';
                
                    return response()->json($output);
                } else {
                    echo '<div class="alert alert-warning text-center my-5">
                        <h5>ไม่มีข้อมูลรายการ CXR 41003 & 41004ในรายการที่เลือก</h5>
                    </div>';
                }    
            } else {
                $file = $request->file('file');
    
                // อ่านข้อมูล cid จากไฟล์ Excel
                $file_excel = Excel::toArray([], $file);
            
                $excel_cids = [];
                if (!empty($file_excel) && isset($file_excel[0])) {
                    $header = $file_excel[0][0]; // แถวแรกเป็น Header
                    $excel_cids = [];
                
                    // หา index ของคอลัมน์ 'CID' ใน Header
                    $cidIndex = array_search('CID', array_map('trim', $header));
                
                    // ตรวจสอบว่าพบคอลัมน์ CID หรือไม่
                    if ($cidIndex !== false) {
                        foreach ($file_excel[0] as $key => $row) {
                            if ($key == 0) continue; // ข้าม Header แถวแรก
                            
                            // ใช้ index ที่หาได้เพื่อดึงข้อมูลคอลัมน์ CID
                            if (!empty($row[$cidIndex])) {
                                $excel_cids[] = $row[$cidIndex];
                            }
                        }
                    }
                }

                // ตัดข้อมูลที่ซ้ำกันระหว่าง Database กับ Excel
                $filtered_data = array_filter($reportCXR4100341004Fetch, function ($row) use ($excel_cids) {
                    return !in_array(strval($row->cid), $excel_cids);
                });                

                $output = '';

                $output = '<div class="table-responsive">';
                $output .= '<table id="table-fetch-report-cxr-41003-41004" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: auto;">HN</th>
                            <th style="width: auto;">CID</th>
                            <th style="width: auto;">คำนำหน้า</th>
                            <th style="width: auto;">ชื่อ</th>
                            <th style="width: auto;">นามสกุล</th>
                            <th style="width: auto;">วันเกิด</th>
                            <th style="width: auto;">อายุ</th>
                            <th style="width: auto;">บ้านเลขที่</th>
                            <th style="width: auto;">หมู่</th>
                            <th style="width: auto;">ตำบล</th>
                            <th style="width: auto;">อำเภอ</th>
                            <th style="width: auto;">จังหวัด</th>
                            <th style="width: auto;">โรคประจำตัว</th>
                            <th style="width: auto;">สิทธิ์การรักษา</th>
                            <th style="width: auto;">วัน-เวลาที่ Xray</th>
                            <th style="width: auto;">HBA1C</th>
                        </tr>
                    </thead>
                <tbody>';
                // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                foreach ($filtered_data as $row) {
                    // สร้างแถวของตาราง
                    $order_date_time = $this->DateThai($row->order_date_time);
                    $birthday = $this->DateThai($row->birthday);
                
                    $output .= '<tr>
                        <td>' . $row->hn . '</td>
                        <td>' . $row->cid . '</td>
                        <td>' . $row->pname . '</td>
                        <td>' . $row->fname . '</td>
                        <td>' . $row->lname . '</td>
                        <td>' . $birthday . '</td>
                        <td>' . $row->age . '</td>
                        <td>' . $row->addrpart . '</td>
                        <td>' . $row->moopart . '</td>
                        <td>' . $row->sub_district . '</td>
                        <td>' . $row->district . '</td>
                        <td>' . $row->province . '</td>
                        <td>' . $row->clinic . '</td>
                        <td>' . $row->pttype_name . '</td>
                        <td>' . $order_date_time . '</td>
                        <td>' . $row->hba1c . '</td>
                    </tr>';
                }
            
                $output .= '</tbody></table>';
                $output .= '</div>';
            
                return response()->json($output);
            }        
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ CXR 41003 & 41004 จากปีงบประมาณ ที่ถูกส่งเข้ามา End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ CXR 41003 & 41004 จากวัน-เดือน-ปี ที่ถูกส่งเข้ามา Start
        public function getReportCXR4100341004FetchSelectDate(Request $request) {
            $min_date = $request->min_date;
            $max_date = $request->max_date;

            $min_date_hba1c = $request->min_date_hba1c;
            $max_date_hba1c = $request->max_date_hba1c;
        
            // ตรวจสอบวันที่
            if ($min_date == 0 || $max_date == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกวันที่รับบริการ',
                    'icon' => 'error'
                ]);
            }

            if ($min_date_hba1c == 0 || $max_date_hba1c == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกวันที่ต้องการดึงค่า HBA1C',
                    'icon' => 'error'
                ]);
            }
        
            $startTime = microtime(true);
        
            $query = "
                SELECT 
                    pt.hn,
                    pt.cid,
                    pt.pname,
                    pt.fname,
                    pt.lname,
                    pt.birthday,
                    YEAR(CURRENT_DATE) - YEAR(pt.birthday) AS age,
                    pt.addrpart,
                    pt.moopart,
                    ta1.name AS sub_district,
                    ta2.name AS district,
                    ta3.name AS province,
                    pt.clinic,
                    ptt.name AS pttype_name,
                    t1.order_date_time,
                    t2.hba1c
                FROM (
                    SELECT 
                        vn, 
                        hn, 
                        xray_list, 
                        MAX(order_date_time) AS order_date_time
                    FROM xray_head 
                    WHERE order_date_time BETWEEN ? AND ? 
                    AND xray_list IN(?, ?)
                    GROUP BY hn
                    ORDER BY hn
                ) AS t1
                LEFT OUTER JOIN (
                    SELECT 
                        hn,
                        MAX(vstdate) AS vstdate,
                        hba1c
                    FROM opdscreen 
                    WHERE vstdate BETWEEN ? AND ? 
                    AND hba1c IS NOT NULL
                    GROUP BY hn 
                ) AS t2 ON t1.hn = t2.hn
                INNER JOIN patient pt ON t1.hn = pt.hn
                INNER JOIN thaiaddress ta1 ON ta1.chwpart = pt.chwpart AND ta1.amppart = '00' AND ta1.tmbpart = '00'
                INNER JOIN thaiaddress ta2 ON ta2.chwpart = pt.chwpart AND ta2.amppart = pt.amppart AND ta2.tmbpart = '00'
                INNER JOIN thaiaddress ta3 ON ta3.chwpart = pt.chwpart AND ta3.amppart = pt.amppart AND ta3.tmbpart = pt.tmbpart
                INNER JOIN pttype ptt ON pt.pttype = ptt.pttype
                GROUP BY t1.hn
                ORDER BY t1.hn
            ";
        
            $bindings = [
                $min_date, 
                $max_date,
                'CXR 41003', 
                'C.X.R. [Portable] 41004', 
                $min_date_hba1c, 
                $max_date_hba1c
            ];
        
            $reportCXR4100341004Fetch = DB::select($query, $bindings);
        
            // ดึง SQL query พร้อม bindings
            $sql = $query;
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);

            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $report_cxr_41003_41004_log_data = [
                'function' => 'getReportCXR4100341004FetchSelectDate',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReportCXR4100341004LogModel
            ReportCXR4100341004LogModel::create($report_cxr_41003_41004_log_data);

            $file = $request->file('file');

            if (!$request->hasFile('file')) {
                $output = '';
        
                if (count($reportCXR4100341004Fetch) > 0) {
                    // สร้างตาราง
                    $output = '<div class="table-responsive">';
                    $output .= '<table id="table-fetch-report-cxr-41003-41004" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: auto;">HN</th>
                                <th style="width: auto;">CID</th>
                                <th style="width: auto;">คำนำหน้า</th>
                                <th style="width: auto;">ชื่อ</th>
                                <th style="width: auto;">นามสกุล</th>
                                <th style="width: auto;">วันเกิด</th>
                                <th style="width: auto;">อายุ</th>
                                <th style="width: auto;">บ้านเลขที่</th>
                                <th style="width: auto;">หมู่</th>
                                <th style="width: auto;">ตำบล</th>
                                <th style="width: auto;">อำเภอ</th>
                                <th style="width: auto;">จังหวัด</th>
                                <th style="width: auto;">โรคประจำตัว</th>
                                <th style="width: auto;">สิทธิ์การรักษา</th>
                                <th style="width: auto;">วัน-เวลาที่ Xray</th>
                                <th style="width: auto;">HBA1C</th>
                            </tr>
                        </thead>
                        <tbody>';
                    
                    // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                    foreach ($reportCXR4100341004Fetch as $rcxr4100341004f) {
                        // สร้างแถวของตาราง
                        $order_date_time = $this->DateThai($rcxr4100341004f->order_date_time);
                        $birthday = $this->DateThai($rcxr4100341004f->birthday);
                    
                        $output .= '<tr>
                            <td>' . $rcxr4100341004f->hn . '</td>
                            <td>' . $rcxr4100341004f->cid . '</td>
                            <td>' . $rcxr4100341004f->pname . '</td>
                            <td>' . $rcxr4100341004f->fname . '</td>
                            <td>' . $rcxr4100341004f->lname . '</td>
                            <td>' . $birthday . '</td>
                            <td>' . $rcxr4100341004f->age . '</td>
                            <td>' . $rcxr4100341004f->addrpart . '</td>
                            <td>' . $rcxr4100341004f->moopart . '</td>
                            <td>' . $rcxr4100341004f->sub_district . '</td>
                            <td>' . $rcxr4100341004f->district . '</td>
                            <td>' . $rcxr4100341004f->province . '</td>
                            <td>' . $rcxr4100341004f->clinic . '</td>
                            <td>' . $rcxr4100341004f->pttype_name . '</td>
                            <td>' . $order_date_time . '</td>
                            <td>' . $rcxr4100341004f->hba1c . '</td>
                        </tr>';
                    }
                
                    $output .= '</tbody></table>';
                    $output .= '</div>';
                
                    return response()->json($output);
                } else {
                    echo '<div class="alert alert-warning text-center my-5">
                        <h5>ไม่มีข้อมูลรายการ CXR 41003 & 41004ในรายการที่เลือก</h5>
                    </div>';
                }    
            } else {
                $file = $request->file('file');
    
                // อ่านข้อมูล cid จากไฟล์ Excel
                $file_excel = Excel::toArray([], $file);
            
                $excel_cids = [];
                if (!empty($file_excel) && isset($file_excel[0])) {
                    $header = $file_excel[0][0]; // แถวแรกเป็น Header
                    $excel_cids = [];
                
                    // หา index ของคอลัมน์ 'CID' ใน Header
                    $cidIndex = array_search('CID', array_map('trim', $header));
                
                    // ตรวจสอบว่าพบคอลัมน์ CID หรือไม่
                    if ($cidIndex !== false) {
                        foreach ($file_excel[0] as $key => $row) {
                            if ($key == 0) continue; // ข้าม Header แถวแรก
                            
                            // ใช้ index ที่หาได้เพื่อดึงข้อมูลคอลัมน์ CID
                            if (!empty($row[$cidIndex])) {
                                $excel_cids[] = $row[$cidIndex];
                            }
                        }
                    }
                }

                // ตัดข้อมูลที่ซ้ำกันระหว่าง Database กับ Excel
                $filtered_data = array_filter($reportCXR4100341004Fetch, function ($row) use ($excel_cids) {
                    return !in_array(strval($row->cid), $excel_cids);
                });                

                $output = '';

                $output = '<div class="table-responsive">';
                $output .= '<table id="table-fetch-report-cxr-41003-41004" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: auto;">HN</th>
                            <th style="width: auto;">CID</th>
                            <th style="width: auto;">คำนำหน้า</th>
                            <th style="width: auto;">ชื่อ</th>
                            <th style="width: auto;">นามสกุล</th>
                            <th style="width: auto;">วันเกิด</th>
                            <th style="width: auto;">อายุ</th>
                            <th style="width: auto;">บ้านเลขที่</th>
                            <th style="width: auto;">หมู่</th>
                            <th style="width: auto;">ตำบล</th>
                            <th style="width: auto;">อำเภอ</th>
                            <th style="width: auto;">จังหวัด</th>
                            <th style="width: auto;">โรคประจำตัว</th>
                            <th style="width: auto;">สิทธิ์การรักษา</th>
                            <th style="width: auto;">วัน-เวลาที่ Xray</th>
                            <th style="width: auto;">HBA1C</th>
                        </tr>
                    </thead>
                <tbody>';
                // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                foreach ($filtered_data as $row) {
                    // สร้างแถวของตาราง
                    $order_date_time = $this->DateThai($row->order_date_time);
                    $birthday = $this->DateThai($row->birthday);
                
                    $output .= '<tr>
                        <td>' . $row->hn . '</td>
                        <td>' . $row->cid . '</td>
                        <td>' . $row->pname . '</td>
                        <td>' . $row->fname . '</td>
                        <td>' . $row->lname . '</td>
                        <td>' . $birthday . '</td>
                        <td>' . $row->age . '</td>
                        <td>' . $row->addrpart . '</td>
                        <td>' . $row->moopart . '</td>
                        <td>' . $row->sub_district . '</td>
                        <td>' . $row->district . '</td>
                        <td>' . $row->province . '</td>
                        <td>' . $row->clinic . '</td>
                        <td>' . $row->pttype_name . '</td>
                        <td>' . $order_date_time . '</td>
                        <td>' . $row->hba1c . '</td>
                    </tr>';
                }
            
                $output .= '</tbody></table>';
                $output .= '</div>';
            
                return response()->json($output);
            }
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ CXR 41003 & 41004 จากวัน-เดือน-ปี ที่ถูกส่งเข้ามา End
}
