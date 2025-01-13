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

class PCEClaimWithdrawalController extends Controller
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

    // หน้าแรกของ E Claim Withdrawal(รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย) Start
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
                    // ส่งค่าคืนกลับไปยังหน้า E Claim Withdrawal(รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย) พร้อมกับ Data Start
                    return view('program.sub_page.pc_e_claim_withdrawal', compact('data', 'sidebar_sub1_menu_id'));
                    // ส่งค่าคืนกลับไปยังหน้า E Claim Withdrawal(รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย) พร้อมกับ Data End
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
                        // ส่งค่าคืนกลับไปยังหน้า E Claim Withdrawal(รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย) พร้อมกับ Data Start
                        return view('program.sub_page.pc_e_claim_withdrawal', compact('data', 'sidebar_sub1_menu_id'));
                        // ส่งค่าคืนกลับไปยังหน้า E Claim Withdrawal(รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย) พร้อมกับ Data End
                    } else {
                        $request->session()->put('error', 'ไม่มีสิทธิ์เข้าใช้งานระบบ E Claim Withdrawal(รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย) หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        // $request->session()->put('error', 'ณ ตอนนี้ทีม IT ขออนุญาตปิดปรับปรุงระบบ Pallliative Care ขออภัยในความไม่สะดวก!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบ E Claim Withdrawal(รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย) ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }
    // หน้าแรกของ E Claim Withdrawal(รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย) End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย จาก Request ที่ถูกส่งเข้ามา Start
        public function getEClaimWithdrawalFetchListName(Request $request) {
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
            $query = DB::table('vn_stat as vn')
                ->selectRaw('
                    op.vn,
                    op.vstdate,
                    os.vsttime,
                    pt.hn,
                    CONCAT(pt.pname, pt.fname, " ", pt.lname) AS fullname,
                    CONCAT_WS(", ", 
                        CASE WHEN vn.pdx != "" THEN vn.pdx ELSE NULL END, 
                        CASE WHEN vn.dx0 != "" THEN vn.dx0 ELSE NULL END, 
                        CASE WHEN vn.dx1 != "" THEN vn.dx1 ELSE NULL END, 
                        CASE WHEN vn.dx2 != "" THEN vn.dx2 ELSE NULL END, 
                        CASE WHEN vn.dx3 != "" THEN vn.dx3 ELSE NULL END, 
                        CASE WHEN vn.dx4 != "" THEN vn.dx4 ELSE NULL END, 
                        CASE WHEN vn.dx5 != "" THEN vn.dx5 ELSE NULL END
                    ) AS pdx,
                    os.cc,
                    CASE 
                        WHEN op.icode IN ("1000196","1610222","1580024","1650002","1590016","1550025","1580001") 
                            THEN CONCAT(dr.name, " ", dr.strength)
                        WHEN op.icode IN ("3003603", "3003604") 
                            THEN nd.name
                        WHEN op.icode IN ("3001558", "3001549", "3001550", "3001548", "3001721", "3001722") 
                            THEN GROUP_CONCAT(nd.name SEPARATOR ", ")
                        ELSE ""
                    END AS x1,
                    CASE 
                        WHEN op.icode IN ("1000196","1610222","1580024","1650002","1590016","1550025","1580001") 
                            THEN CONCAT(ROUND(op.unitprice, 2), " x ", op.qty, " ", dr.units, " = ", ROUND(dr.unitprice * op.qty, 2))
                        WHEN op.icode IN ("3003603", "3003604") 
                            THEN CONCAT(op.qty, " x ", ROUND(op.unitprice, 0), " = ", ROUND(op.sum_price, 0))
                        WHEN op.icode IN ("3003056", "3003409", "3003533", "3003631") 
                            THEN CONCAT(op.qty, " x ", ROUND(op.unitprice, 0), " = ", ROUND(op.sum_price, 0))
                        ELSE ""
                    END AS x2,
                    CASE 
                        WHEN op.icode IN ("1000196","1610222","1580024","1650002","1590016","1550025","1580001") 
                            THEN CONCAT(u.name1, " ", u.name2, " ", u.name3)
                        ELSE NULL
                    END AS x3
                ')
                ->join('patient as pt', 'pt.hn', '=', 'vn.hn')
                ->join('opitemrece as op', 'op.vn', '=', 'vn.vn')
                ->join('opdscreen as os', 'os.vn', '=', 'vn.vn')
                ->leftJoin('drugitems as dr', 'dr.icode', '=', 'op.icode')
                ->leftJoin('nondrugitems as nd', 'nd.icode', '=', 'op.icode')
                ->leftJoin('s_drugitems as s', 's.icode', '=', 'op.icode')
                ->leftJoin('drugusage as d', 'd.drugusage', '=', 'op.drugusage')
                ->leftJoin('sp_use as u', 'u.sp_use', '=', 'op.sp_use')
                ->whereBetween('op.vstdate', [$min_date, $max_date])
                ->whereIn('op.icode', [
                    '1000196', '1610222', '1580024', '1650002', '1590016', 
                    '1550025', '1580001', '3001558', '3001549', '3001550', 
                    '3001548', '3001721', '3001722'
                ])
                ->where(function ($query) {
                    $query->where('vn.pdx', 'Z515')
                        ->orWhere('vn.dx0', 'Z515')
                        ->orWhere('vn.dx1', 'Z515')
                        ->orWhere('vn.dx2', 'Z515')
                        ->orWhere('vn.dx3', 'Z515')
                        ->orWhere('vn.dx4', 'Z515')
                        ->orWhere('vn.dx5', 'Z515');
                })
            ;

            $query->groupBy('vn.vn')
                ->orderByDesc('vn.vn')
                ->orderBy('vn.hn');

            $eClaimWithdrawalFetchListName = $query->get();

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
                'function' => 'geteClaimWithdrawalFetchListName',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($palliative_care_log_data);
        
            $output = '';
        
            if ($eClaimWithdrawalFetchListName->isNotEmpty()) {
                // สร้างตาราง
                $output = '<div class="table-responsive">';
                $output .= '<table id="table-fetch-list-name" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: auto;">ข้อมูลการรับบริการ</th>
                            <th style="width: auto;">รายการเวชภัณฑ์/เวชภัณฑ์มิใช่ยา</th>
                            <th style="width: auto;">จำนวน มูลค่า</th>
                            <th style="width: auto;">วิธีการใช้ยา</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                foreach ($eClaimWithdrawalFetchListName as $ewfln) {
                    // จัดรูปแบบวันที่
                    $vstdate = $this->DateThai($ewfln->vstdate);
            
                    // จัดการ x1 ให้ขึ้นบรรทัดใหม่เมื่อเจอ ,
                    $formattedX1 = str_replace(',', '<br>', $ewfln->x1);
                    $formattedX2 = str_replace(',', '<br>', $ewfln->x2);
                    $formattedX3 = str_replace(',', '<br>', $ewfln->x3);
            
                    // สร้างแถวของตาราง
                    $output .= '<tr>
                        <td>
                            <strong>วันที่เข้ารับบริการ:</strong> ' . $vstdate . ' ' . $ewfln->vsttime . '<br>
                            <strong>HN:</strong> ' . $ewfln->hn . '<br>
                            <strong>ชื่อ-สกุล:</strong> ' . $ewfln->fullname . '<br>
                            <strong>การวินิจฉัย:</strong> ' . $ewfln->pdx . '<br>
                            <strong>อาการสำคัญ:</strong> ' . $ewfln->cc . '
                        </td>
                        <td>' . nl2br($formattedX1) . '</td>
                        <td>' . nl2br($formattedX2) . '</td>
                        <td>' . nl2br($formattedX3) . '</td>
                    </tr>';
                }
            
                $output .= '</tbody></table>';
                $output .= '</div>';
            
                echo $output;
            } else {
                echo '<div class="alert alert-warning text-center my-5">
                    <h5>ไม่มีข้อมูลรายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้ายในรายการที่เลือก</h5>
                </div>';
            }            
            
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย จาก Request ที่ถูกส่งเข้ามา End
}
