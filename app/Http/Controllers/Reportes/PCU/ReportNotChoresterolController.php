<?php

namespace App\Http\Controllers\Reportes\PCU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;
use App\Models\Dashboard_Setting\FiscalYearModel;

use App\Models\Log\AccessibilityLogModel;
use App\Models\Log\ReportNotChoresterolLogModel;
use App\Models\Log\SidebarSub1MenuLogModel;

class ReportNotChoresterolController extends Controller
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

    // หน้าแรกของระบบรายงาน Not Choresterol Start
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
        
            // บันทึกข้อมูลลงใน SidebarSub1MenuLogModel
            SidebarSub1MenuLogModel::create($sidebar_sub1_menu_log_data);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $report_not_choresterol_log_data = [
                'function' => "The user comes to the page report not choresterol.",
                'username' => $username,
                'command_sql' => "",
                'query_time' => "",
                'operation' => 'OPEN'
            ];
        
            // บันทึกข้อมูลลงใน ReportNotChoresterolLogModel
            ReportNotChoresterolLogModel::create($report_not_choresterol_log_data);

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

                if($accessibility_groupname_model !== null && $accessibility_groupname_model->status_id === 1) {
                    return view('reportes.pcu.report_not_choresterol', compact('data', 'fiscal_year'));
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

                    if($accessibility_name_model !== null && $accessibility_name_model->status_id === 1) {
                        return view('reportes.pcu.report_not_choresterol', compact('data', 'fiscal_year'));
                    } else {
                        $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบรายงาน Not Choresterol หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบรายงาน Not Choresterol ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }  
    // หน้าแรกของระบบรายงาน Not Choresterol End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ Not Choresterol จาก  Request ที่ถูกส่งเข้ามา Start
        public function getReportNotChoresterolFetch(Request $request){
            // ตรวจสอบข้อมูลเบื้องต้น
            if ($request->min_date && $request->max_date && $request->not_year) {
                try {
                    // Validate the input
                    $request->validate([
                        'not_year' => 'required|numeric', // ตรวจสอบว่าเป็นตัวเลขและไม่เป็นค่าว่าง
                    ]);
        
                    // แปลง min_date เป็น Carbon Object
                    $minDate1 = Carbon::parse($request->min_date);
        
                    // ลบวันที่
                    $newDate = $minDate1->subDays(1);
                    $minDate2 = $newDate->format('Y-m-d');
        
                    // กำหนดค่าตัวแปรสำหรับ Query
                    $minDate = $request->min_date;
                    $maxDate = $request->max_date;
                    $notYear = $request->not_year;
        
                } catch (\Illuminate\Validation\ValidationException $e) {
                    // จัดการข้อผิดพลาดจาก Validation
                    $error = $this->messageError('กรอกได้แค่ตัวเลขเท่านั้น!');
                    return $error;
                }
            } else {
                // กรณีข้อมูลไม่ครบ
                $error = $this->messageError('กรุณากรอกข้อมูลให้ครบ ขอบคุณครับ/คะ');
                return $error;
            }

            $startTime = microtime(true);
        
            // Query ข้อมูลจากฐานข้อมูล
            $query = DB::table('ovst as o')
                ->select([
                    'o.vstdate',
                    'o.vn',
                    'o.hn',
                    'pt.pname',
                    'pt.fname',
                    'pt.lname',
                    DB::raw('TIMESTAMPDIFF(YEAR, pt.birthday, CURDATE()) AS age'),
                    'ptt.name AS pttype_name',
                ])
                ->join('patient as pt', 'o.hn', '=', 'pt.hn')
                ->join('pttype as ptt', 'pt.pttype', '=', 'ptt.pttype')
                ->whereBetween('o.vstdate', [$minDate, $maxDate])
                ->whereRaw('TIMESTAMPDIFF(YEAR, pt.birthday, CURDATE()) BETWEEN 45 AND 70')
                ->whereNull('o.an')
                ->whereNotExists(function ($query) use ($minDate, $minDate2, $notYear) {
                    $query->select(DB::raw(1))
                        ->from('lab_head as lh')
                        ->leftJoin('lab_order_service as los', 'lh.lab_order_number', '=', 'los.lab_order_number')
                        ->leftJoin('lab_order as lo', 'lh.lab_order_number', '=', 'lo.lab_order_number')
                        ->whereColumn('lh.hn', 'o.hn')
                        ->whereBetween('lh.order_date', [
                            DB::raw("DATE_SUB('$minDate', INTERVAL $notYear YEAR)"),
                            $minDate2,
                        ])
                        ->whereIn('los.lab_name', ['Cholesterol', 'HDL'])
                        ->whereIn('lo.lab_items_name_ref', ['Cholesterol', 'HDL-C']);
                })
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('pttype as ptt_sub')
                        ->whereColumn('ptt_sub.pttype', 'pt.pttype')
                        ->whereIn('ptt_sub.pttype', [21, 22, 10]);
                })
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('opitemrece as opi')
                        ->whereColumn('opi.vn', 'o.vn')
                        ->whereIn('opi.icode', [
                            '1460327', '1550040', '1550065', '1550090', '1550019', '1550012',
                            '1560087', '1570064', '1540006', '1540007',
                        ]);
                })
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('vn_stat as vs')
                        ->whereColumn('vs.vn', 'o.vn')
                        ->where(function ($query) {
                            $query->whereBetween('vs.pdx', ['E70', 'E79'])
                                ->orWhereIn('vs.pdx', ['Z136'])
                                ->orWhereBetween('vs.dx0', ['E70', 'E79'])
                                ->orWhereIn('vs.dx0', ['Z136'])
                                ->orWhereBetween('vs.dx1', ['E70', 'E79'])
                                ->orWhereIn('vs.dx1', ['Z136'])
                                ->orWhereBetween('vs.dx2', ['E70', 'E79'])
                                ->orWhereIn('vs.dx2', ['Z136'])
                                ->orWhereBetween('vs.dx3', ['E70', 'E79'])
                                ->orWhereIn('vs.dx3', ['Z136'])
                                ->orWhereBetween('vs.dx4', ['E70', 'E79'])
                                ->orWhereIn('vs.dx4', ['Z136'])
                                ->orWhereBetween('vs.dx5', ['E70', 'E79'])
                                ->orWhereIn('vs.dx5', ['Z136']);
                        });
                });
        
            $query->groupBy('o.hn')
                ->orderBy('o.vstdate');
        
            $reportPatientsNotChoresterolFetch = $query->get();
        
            // ดึง SQL query พร้อม bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            // บันทึกเวลาการทำงาน
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);
        
            // บันทึกข้อมูลลงใน log
            $username = $this->someMethod($request);
            $report_not_choresterol_log_data = [
                'function' => 'getReportNotChoresterol',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
            ReportNotChoresterolLogModel::create($report_not_choresterol_log_data);
        
            // สร้าง HTML Output
            $output = '';
            if ($reportPatientsNotChoresterolFetch->isNotEmpty()) {
                $output = '<div class="table-responsive">';
                $output .= '<table id="table-fetch-report-not-choresterol" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: auto;">วันที่มารับบริการ</th>
                            <th style="width: auto;">VN</th>
                            <th style="width: auto;">HN</th>
                            <th style="width: auto;">คำนำหน้า</th>
                            <th style="width: auto;">ชื่อ</th>
                            <th style="width: auto;">นามสกุล</th>
                            <th style="width: auto;">อายุ</th>
                            <th style="width: auto;">สิทธิ์การรักษา</th>
                        </tr>
                    </thead>
                    <tbody>';
        
                foreach ($reportPatientsNotChoresterolFetch as $rpncf) {
                    $vstdate = $this->DateThai($rpncf->vstdate);
                    $output .= '<tr>
                        <td>' . $vstdate . '</td>
                        <td>' . $rpncf->vn . '</td>
                        <td>' . $rpncf->hn . '</td>
                        <td>' . $rpncf->pname . '</td>
                        <td>' . $rpncf->fname . '</td>
                        <td>' . $rpncf->lname . '</td>
                        <td>' . $rpncf->age . '</td>
                        <td>' . $rpncf->pttype_name . '</td>
                    </tr>';
                }
        
                $output .= '</tbody></table>';
                $output .= '</div>';
                echo $output;
            } else {
                echo '<div class="alert alert-warning text-center my-5">
                    <h5>ไม่มีข้อมูลรายการ Not Choresterol ในรายการที่เลือก</h5>
                </div>';
            }
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการ Not Choresterol จาก  Request ที่ถูกส่งเข้ามา End
}
