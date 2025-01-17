<?php

namespace App\Http\Controllers\Reportes\PCU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;
use App\Models\Dashboard_Setting\FiscalYearModel;

use App\Models\Log\AccessibilityLogModel;
use App\Models\Log\ReportPatientsUtilizingIcd10CodesLogModel;
use App\Models\Log\SidebarSub1MenuLogModel;


class ReportPatientsUtilizingIcd10CodesController extends Controller
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

    // Message Success Start
        private function messageSuccess($message) {
            return response()->json([
                'status' => 200,
                'title' => 'Success',
                'message' => $message,
                'icon' => 'success'
            ]);
        }
    // Message Success End

    // Message Error Start
        private function messageError($message) {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => $message,
                'icon' => 'error'
            ]);
        }
    // Message Error End

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

    // หน้าแรกของระบบรายงาน ICD 10 Start
        public function index(Request $request) {
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

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
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            SidebarSub1MenuLogModel::create($sidebar_sub1_menu_log_data);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $report_patients_utilizing_icd10_codes_log_data = [
                'function' => "The user comes to the page report patients utilizing icd10 codes.",
                'username' => $username,
                'command_sql' => "",
                'query_time' => "",
                'operation' => 'OPEN'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            ReportPatientsUtilizingIcd10CodesLogModel::create($report_patients_utilizing_icd10_codes_log_data);

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
                    'username' => $username,
                    'command_sql' => $fullSql_1,
                    'query_time' => $formattedExecutionTime_1,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน AccessibilityLogModel
                AccessibilityLogModel::create($accessibility_log_data);

                if($accessibility_groupname_model !== null && $accessibility_groupname_model->status_id === 1 && $data['groupname'] == 'ผู้ดูแลระบบ') {
                    return view('reportes.pcu.report_patients_utilizing_icd10_codes', compact('data', 'fiscal_year'));
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
                        'username' => $username,
                        'command_sql' => $fullSql_2,
                        'query_time' => $formattedExecutionTime_2,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน AccessibilityLogModel
                    AccessibilityLogModel::create($accessibility_log_data);

                    if($accessibility_name_model !== null && $accessibility_name_model->status_id === 1 && $data['groupname'] == 'ผู้ดูแลระบบ') {
                        return view('reportes.pcu.report_patients_utilizing_icd10_codes', compact('data', 'fiscal_year'));
                    } else {
                        $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบรายงาน ICD 10 หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบรายงาน ICD 10 ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }  
    // หน้าแรกของระบบรายงาน ICD 10 End

    // Query รายการ ICD10 Start 
        public function query_icd10(Request $request) {
            $searchTerm = $request->input('searchTerm');
            $username = $this->someMethod($request); // Ensure this method exists and works as expected
            $startTime_icd10 = microtime(true);
        
            // Initialize the query
            $query_icd10 = DB::table('icd101')
                ->select('code as id', 'name as text')  // Directly use 'id' and 'text' for Select2
                ->where(function($query) use ($searchTerm) {
                    $query->where('code', 'like', $searchTerm . '%')
                        ->orWhere('name', 'like', $searchTerm . '%');
                })
                ->orderBy('code');
        
            // Capture the SQL and bindings before executing the query
            $sql_icd10 = $query_icd10->toSql();
            $bindings_icd10 = $query_icd10->getBindings();
            $fullSql_icd10 = vsprintf(str_replace('?', "'%s'", $sql_icd10), $bindings_icd10);
        
            // Execute the query
            $icd10_fetch = $query_icd10->get();
        
            $endTime_icd10 = microtime(true);
            $executionTime_icd10 = $endTime_icd10 - $startTime_icd10;
            $formattedExecutionTime_icd10 = number_format($executionTime_icd10, 3);
        
            // Log the operation
            ReportPatientsUtilizingIcd10CodesLogModel::create([
                'function' => 'getIcd10Fetch',
                'username' => $username,
                'command_sql' => $fullSql_icd10,
                'query_time' => $formattedExecutionTime_icd10,
                'operation' => 'SELECT'
            ]);
        
            return response()->json(['results' => $icd10_fetch]);
        }
    // Query รายการ ICD10 End 

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ ICD 10 จาก  Request ที่ถูกส่งเข้ามา Start
        public function getReportPatientsUtilizingIcd10CodesFetch(Request $request) {

            $startTime = microtime(true);

            // Query ข้อมูลจากฐานข้อมูล
            $query = DB::table('vn_stat as vs')
                ->select([
                    'vs.vstdate',
                    'vs.hn',
                    'pt.pname',
                    'pt.fname',
                    'pt.lname',
                    DB::raw('YEAR(CURRENT_DATE) - YEAR(pt.birthday) AS age'),
                    'pt.cid',
                    'pt.addrpart',
                    'pt.moopart',
                    'ta3.name as sub_district',
                    'ta2.name as district',
                    'ta1.name as province',
                    'ptt.name as pttype_name',
                    'vs.pdx as diag_main',
                    DB::raw("COALESCE(CONCAT_WS(',', vs.dx0, vs.dx1, vs.dx2, vs.dx3, vs.dx4, vs.dx5), '') as diag_sub"),
                    DB::raw("(SELECT SUM(s.Compensated) FROM rcmdb.repeclaim s WHERE s.VN = vs.vn AND s.Compensated > 0) as money"),
                    DB::raw('CASE WHEN COUNT(vs.hn) > 1 THEN CONCAT("มีข้อมูลซ้ำกันจำนวน ", COUNT(vs.hn), "Visit") ELSE "" END AS comment')
                ])
                ->leftjoin('patient as pt', 'vs.hn', '=', 'pt.hn')
                ->leftjoin('pttype as ptt', 'vs.pttype', '=', 'ptt.pttype')
                ->leftJoin('thaiaddress as ta1', function ($join) {
                    $join->on('ta1.chwpart', '=', 'pt.chwpart')
                        ->where('ta1.amppart', '00')
                        ->where('ta1.tmbpart', '00');
                })
                ->leftJoin('thaiaddress as ta2', function ($join) {
                    $join->on('ta2.chwpart', '=', 'pt.chwpart')
                        ->on('ta2.amppart', '=', 'pt.amppart')
                        ->where('ta2.tmbpart', '00');
                })
                ->leftJoin('thaiaddress as ta3', function ($join) {
                    $join->on('ta3.chwpart', '=', 'pt.chwpart')
                        ->on('ta3.amppart', '=', 'pt.amppart')
                        ->on('ta3.tmbpart', '=', 'pt.tmbpart');
                })
            ;

            if($request->yearSelect) {
                $year_change = $this->check_year($request->yearSelect);

                if($year_change == false) {
                    $error = $this->messageError("เกิดข้อผิดพลาดกรุณาติดต่อ IT ให้หาทางแก้ไขโดยด่วน!");
                    return $error;
                }   else {
                    if($request->has(['yearIcd10Min', 'yearIcd10Max'])) {
                        if($request->has('yearIcd10NotIn')) {
                            $icd10 = [$request->yearIcd10Min, $request->yearIcd10Max];
                            $query->where(function ($query) use ($icd10) {
                                $query->whereBetween('vs.pdx', $icd10)
                                    ->orWhereBetween('vs.dx0', $icd10)
                                    ->orWhereBetween('vs.dx1', $icd10)
                                    ->orWhereBetween('vs.dx2', $icd10)
                                    ->orWhereBetween('vs.dx3', $icd10)
                                    ->orWhereBetween('vs.dx4', $icd10)
                                    ->orWhereBetween('vs.dx5', $icd10);
                                })
                            ;

                            $yearIcd10NotIns = $request->input('yearIcd10NotIn');
    
                            // Check if the input is a string and convert it to an array
                            if (is_string($yearIcd10NotIns)) {
                                $yearIcd10NotIns = [$yearIcd10NotIns];  // Convert to array
                            }

                            foreach ($yearIcd10NotIns as $code) {
                                $icd10Not[] = $code;
                            }

                            $query->where(function ($query) use ($icd10Not) {
                                $query->whereNotIn('vs.pdx', $icd10Not)
                                    ->whereNotIn('vs.dx0', $icd10Not)
                                    ->whereNotIn('vs.dx1', $icd10Not)
                                    ->whereNotIn('vs.dx2', $icd10Not)
                                    ->whereNotIn('vs.dx3', $icd10Not)
                                    ->whereNotIn('vs.dx4', $icd10Not)
                                    ->whereNotIn('vs.dx5', $icd10Not);
                                })
                            ;
                            
                            $query->whereBetween('vs.vstdate', ["{$year_change['year_old']}-10-01", "{$year_change['year_new']}-09-30"]);
                        } else {
                            $icd10 = [$request->yearIcd10Min, $request->yearIcd10Max];
                            $query->where(function ($query) use ($icd10) {
                                $query->whereBetween('vs.pdx', $icd10)
                                    ->orWhereBetween('vs.dx0', $icd10)
                                    ->orWhereBetween('vs.dx1', $icd10)
                                    ->orWhereBetween('vs.dx2', $icd10)
                                    ->orWhereBetween('vs.dx3', $icd10)
                                    ->orWhereBetween('vs.dx4', $icd10)
                                    ->orWhereBetween('vs.dx5', $icd10);
                                })
                            ;
                            $query->whereBetween('vs.vstdate', ["{$year_change['year_old']}-10-01", "{$year_change['year_new']}-09-30"]);
                        }
                    }   else if ($request->has('yearIcd10In')) {
                        if($request->has('yearIcd10NotIn')) {
                            $yearIcd10Ins = $request->input('yearIcd10In');
    
                            // Check if the input is a string and convert it to an array
                            if (is_string($yearIcd10Ins)) {
                                $yearIcd10Ins = [$yearIcd10Ins];  // Convert to array
                            }

                            foreach ($yearIcd10Ins as $code) {
                                $icd10[] = $code;
                            }

                            $query->where(function ($query) use ($icd10) {
                                $query->whereIn('vs.pdx', $icd10)
                                    ->orWhereIn('vs.dx0', $icd10)
                                    ->orWhereIn('vs.dx1', $icd10)
                                    ->orWhereIn('vs.dx2', $icd10)
                                    ->orWhereIn('vs.dx3', $icd10)
                                    ->orWhereIn('vs.dx4', $icd10)
                                    ->orWhereIn('vs.dx5', $icd10);
                                })
                            ;

                            $yearIcd10NotIns = $request->input('yearIcd10NotIn');
    
                            // Check if the input is a string and convert it to an array
                            if (is_string($yearIcd10NotIns)) {
                                $yearIcd10NotIns = [$yearIcd10NotIns];  // Convert to array
                            }

                            foreach ($yearIcd10NotIns as $code) {
                                $icd10Not[] = $code;
                            }

                            $query->where(function ($query) use ($icd10Not) {
                                $query->whereNotIn('vs.pdx', $icd10Not)
                                    ->whereNotIn('vs.dx0', $icd10Not)
                                    ->whereNotIn('vs.dx1', $icd10Not)
                                    ->whereNotIn('vs.dx2', $icd10Not)
                                    ->whereNotIn('vs.dx3', $icd10Not)
                                    ->whereNotIn('vs.dx4', $icd10Not)
                                    ->whereNotIn('vs.dx5', $icd10Not);
                                })
                            ;
                            
                            $query->whereBetween('vs.vstdate', ["{$year_change['year_old']}-10-01", "{$year_change['year_new']}-09-30"]);
                        } else {
                            $yearIcd10Ins = $request->input('yearIcd10In');
    
                            // Check if the input is a string and convert it to an array
                            if (is_string($yearIcd10Ins)) {
                                $yearIcd10Ins = [$yearIcd10Ins];  // Convert to array
                            }

                            foreach ($yearIcd10Ins as $code) {
                                $icd10[] = $code;
                            }

                            $query->where(function ($query) use ($icd10) {
                                $query->whereIn('vs.pdx', $icd10)
                                    ->orWhereIn('vs.dx0', $icd10)
                                    ->orWhereIn('vs.dx1', $icd10)
                                    ->orWhereIn('vs.dx2', $icd10)
                                    ->orWhereIn('vs.dx3', $icd10)
                                    ->orWhereIn('vs.dx4', $icd10)
                                    ->orWhereIn('vs.dx5', $icd10);
                                })
                            ;
                            
                            $query->whereBetween('vs.vstdate', ["{$year_change['year_old']}-10-01", "{$year_change['year_new']}-09-30"]);
                        }
                    } else {
                        $error = $this->messageError("กรุณาเลือก ICD10 ที่ต้องการค้นหา!");
                        return $error;
                    }
                }
            } else if($request->min_date || $request->max_date) {
                if($request->min_date != Null && $request->max_date != Null) {
                    if($request->has(['dateSelectIcd10Min', 'dateSelectIcd10Max'])) {
                        if($request->has('dateSelectIcd10NotIn')) {
                            $icd10 = [$request->dateSelectIcd10Min, $request->dateSelectIcd10Max];
                            $query->where(function ($query) use ($icd10) {
                                $query->whereBetween('vs.pdx', $icd10)
                                    ->orWhereBetween('vs.dx0', $icd10)
                                    ->orWhereBetween('vs.dx1', $icd10)
                                    ->orWhereBetween('vs.dx2', $icd10)
                                    ->orWhereBetween('vs.dx3', $icd10)
                                    ->orWhereBetween('vs.dx4', $icd10)
                                    ->orWhereBetween('vs.dx5', $icd10);
                                })
                            ;

                            $dateSelectIcd10NotIns = $request->input('dateSelectIcd10NotIn');
    
                            // Check if the input is a string and convert it to an array
                            if (is_string($dateSelectIcd10NotIns)) {
                                $dateSelectIcd10NotIns = [$dateSelectIcd10NotIns];  // Convert to array
                            }

                            foreach ($dateSelectIcd10NotIns as $code) {
                                $icd10Not[] = $code;
                            }

                            $query->where(function ($query) use ($icd10Not) {
                                $query->whereNotIn('vs.pdx', $icd10Not)
                                    ->whereNotIn('vs.dx0', $icd10Not)
                                    ->whereNotIn('vs.dx1', $icd10Not)
                                    ->whereNotIn('vs.dx2', $icd10Not)
                                    ->whereNotIn('vs.dx3', $icd10Not)
                                    ->whereNotIn('vs.dx4', $icd10Not)
                                    ->whereNotIn('vs.dx5', $icd10Not);
                                })
                            ;

                            $query->whereBetween('vs.vstdate', [$request->min_date, $request->max_date]);
                        } else {
                            $icd10 = [$request->dateSelectIcd10Min, $request->dateSelectIcd10Max];
                            $query->where(function ($query) use ($icd10) {
                                $query->whereBetween('vs.pdx', $icd10)
                                    ->orWhereBetween('vs.dx0', $icd10)
                                    ->orWhereBetween('vs.dx1', $icd10)
                                    ->orWhereBetween('vs.dx2', $icd10)
                                    ->orWhereBetween('vs.dx3', $icd10)
                                    ->orWhereBetween('vs.dx4', $icd10)
                                    ->orWhereBetween('vs.dx5', $icd10);
                                })
                            ;
                            $query->whereBetween('vs.vstdate', [$request->min_date, $request->max_date]);
                        }
                    } else if ($request->has('dateSelectIcd10In')) {
                        if($request->has('dateSelectIcd10NotIn')) {
                            $dateSelectIcd10Ins = $request->input('dateSelectIcd10In');
    
                            // Check if the input is a string and convert it to an array
                            if (is_string($dateSelectIcd10Ins)) {
                                $dateSelectIcd10Ins = [$dateSelectIcd10Ins];  // Convert to array
                            }

                            foreach ($dateSelectIcd10Ins as $code) {
                                $icd10[] = $code;
                            }

                            $query->where(function ($query) use ($icd10) {
                                $query->whereIn('vs.pdx', $icd10)
                                    ->orWhereIn('vs.dx0', $icd10)
                                    ->orWhereIn('vs.dx1', $icd10)
                                    ->orWhereIn('vs.dx2', $icd10)
                                    ->orWhereIn('vs.dx3', $icd10)
                                    ->orWhereIn('vs.dx4', $icd10)
                                    ->orWhereIn('vs.dx5', $icd10);
                                })
                            ;

                            $dateSelectIcd10NotIns = $request->input('dateSelectIcd10NotIn');
    
                            // Check if the input is a string and convert it to an array
                            if (is_string($dateSelectIcd10NotIns)) {
                                $dateSelectIcd10NotIns = [$dateSelectIcd10NotIns];  // Convert to array
                            }

                            foreach ($dateSelectIcd10NotIns as $code) {
                                $icd10Not[] = $code;
                            }

                            $query->where(function ($query) use ($icd10Not) {
                                $query->whereNotIn('vs.pdx', $icd10Not)
                                    ->whereNotIn('vs.dx0', $icd10Not)
                                    ->whereNotIn('vs.dx1', $icd10Not)
                                    ->whereNotIn('vs.dx2', $icd10Not)
                                    ->whereNotIn('vs.dx3', $icd10Not)
                                    ->whereNotIn('vs.dx4', $icd10Not)
                                    ->whereNotIn('vs.dx5', $icd10Not);
                                })
                            ;
                            
                            $query->whereBetween('vs.vstdate', [$request->min_date, $request->max_date]);
                        } else {
                            $dateSelectIcd10Ins = $request->input('dateSelectIcd10In');
    
                            // Check if the input is a string and convert it to an array
                            if (is_string($dateSelectIcd10Ins)) {
                                $dateSelectIcd10Ins = [$dateSelectIcd10Ins];  // Convert to array
                            }

                            foreach ($dateSelectIcd10Ins as $code) {
                                $icd10[] = $code;
                            }

                            $query->where(function ($query) use ($icd10) {
                                $query->whereIn('vs.pdx', $icd10)
                                    ->orWhereIn('vs.dx0', $icd10)
                                    ->orWhereIn('vs.dx1', $icd10)
                                    ->orWhereIn('vs.dx2', $icd10)
                                    ->orWhereIn('vs.dx3', $icd10)
                                    ->orWhereIn('vs.dx4', $icd10)
                                    ->orWhereIn('vs.dx5', $icd10);
                                })
                            ;
                            
                            $query->whereBetween('vs.vstdate', [$request->min_date, $request->max_date]);
                        }
                    } else {
                        $error = $this->messageError("กรุณาเลือก ICD10 ที่ต้องการค้นหา!");
                        return $error;
                    }
                } else {
                    $error = $this->messageError("กรุณาเลือกวันที่ต้องการหาข้อมูล!");
                    return $error;
                }
            } else {
                $error = $this->messageError("กรุณาเลือกปีงบประมาณหรือวันที่ต้องการหาข้อมูล!");
                return $error;
            }

            $query->groupBy('vs.hn')
                ->orderBy('vs.vstdate')
            ;

            $reportPatientsUtilizingIcd10CodesFetch = $query->get();

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
            $report_patients_utilizing_icd10_codes_log_data = [
                'function' => 'getReportPatientsUtilizingIcd10CodesFetch',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReportPatientsUtilizingIcd10CodesLogModel
            ReportPatientsUtilizingIcd10CodesLogModel::create($report_patients_utilizing_icd10_codes_log_data);
        
            $output = '';
        
            if ($reportPatientsUtilizingIcd10CodesFetch->isNotEmpty()) {
                // สร้างตาราง
                $output = '<div class="table-responsive">';
                $output .= '<table id="table-fetch-report-patients-utilizing-icd10-codes" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: auto;">วันที่มารับบริการ</th>
                            <th style="width: auto;">HN</th>
                            <th style="width: auto;">คำนำหน้า</th>
                            <th style="width: auto;">ชื่อ</th>
                            <th style="width: auto;">นามสกุล</th>
                            <th style="width: auto;">อายุ</th>
                            <th style="width: auto;">เลขบัตรประจำตัวประชาชน</th>
                            <th style="width: auto;">บ้านเลขที่</th>
                            <th style="width: auto;">หมู่</th>
                            <th style="width: auto;">ตำบล</th>
                            <th style="width: auto;">อำเภอ</th>
                            <th style="width: auto;">จังหวัด</th>
                            <th style="width: auto;">สิทธิ์การรักษา</th>
                            <th style="width: auto;">Diag หลัก</th>
                            <th style="width: auto;">Diag รอง</th>
                            <th style="width: auto;">ค่าตอบแทนชดเชย</th>
                            <th style="width: auto;">หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                foreach ($reportPatientsUtilizingIcd10CodesFetch as $rpuicf) {
                    // สร้างแถวของตาราง
                    $vstdate = $this->DateThai($rpuicf->vstdate);
                
                    if($rpuicf->money != '' || $rpuicf->money != NULL) {
                        $money = $rpuicf->money . ' บาท';
                    } else {
                        $money = '';
                    }
                
                    $output .= '<tr>
                        <td>' . $vstdate . '</td>
                        <td>' . $rpuicf->hn . '</td>
                        <td>' . $rpuicf->pname . '</td>
                        <td>' . $rpuicf->fname . '</td>
                        <td>' . $rpuicf->lname . '</td>
                        <td>' . $rpuicf->age . '</td>
                        <td>' . $rpuicf->cid . '</td>
                        <td>' . $rpuicf->addrpart . '</td>
                        <td>' . $rpuicf->moopart . '</td>
                        <td>' . $rpuicf->sub_district . '</td>
                        <td>' . $rpuicf->district . '</td>
                        <td>' . $rpuicf->province . '</td>
                        <td>' . $rpuicf->pttype_name . '</td>
                        <td>' . $rpuicf->diag_main . '</td>
                        <td>' . $rpuicf->diag_sub . '</td>
                        <td>' . $money . '</td>
                        <td>' . $rpuicf->comment . '</td>
                    </tr>';
                }
            
                $output .= '</tbody></table>';
                $output .= '</div>';
            
                echo $output;
            } else {
                echo '<div class="alert alert-warning text-center my-5">
                    <h5>ไม่มีข้อมูลรายการ ICD 10 ในรายการที่เลือก</h5>
                </div>';
            }            
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ ICD 10 จาก  Request ที่ถูกส่งเข้ามา End
}
