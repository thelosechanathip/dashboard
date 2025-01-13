<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Exports\AuthenCodeExport;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;

// use App\Models\Dashboard_Setting\ModuleModel;
use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;

use App\Models\Log\AuthenCodeLogModel;
use App\Models\Log\ModuleLogModel;
use App\Models\Log\AccessibilityLogModel;
use App\Models\Log\SidebarSub1MenuLogModel;

class AuthenCodeController extends Controller
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

    private function getChart($summarize_count) {
        $total_all = $summarize_count->total_all;
        $total_authen_success = $summarize_count->total_authen_success;
        $total_not_authen = $summarize_count->total_not_authen;

        $percentage_authen_success = ($total_authen_success * 100) / $total_all;
        $percentage_not_authen = ($total_not_authen * 100) / $total_all;

        $percentage_authen_success_label = number_format($percentage_authen_success, 2) . '%';
        $percentage_not_authen_label = number_format($percentage_not_authen, 2) . '%';

        $chart = [
            'labels' => [
                'จำนวนคนไข้ที่ขอเลข Authen Code เรียบร้อย (' . $percentage_authen_success_label . ')',
                'จำนวนคนไข้ที่ยังไม่ได้ขอเลข Authen Code (' . $percentage_not_authen_label . ')'
            ],
            'datasets' => [
                [
                    'data' => [
                        $percentage_authen_success,
                        $percentage_not_authen
                    ],
                    'backgroundColor' => [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    'hoverOffset' => 4
                ]
            ]
        ];
        return $chart;
    }

    private function query_authen_code(Request $request) {
        $startTime = microtime(true);

        $query = "
            SELECT
                    o.vn,
                o.hn,
                pt.cid,
                pt.pname,
                CONCAT(pt.fname, ' ', pt.lname) AS fullname,
                ptt.name AS pttype_name,
                CASE
                    WHEN pt.cid IS NULL OR pt.cid = ''
                        THEN 'ไม่มีการขอเลข Authen Code เพราะไม่มีเลขบัตรประชาชน'

                    WHEN COUNT(DISTINCT o.vn) = 2 AND COUNT(DISTINCT CASE WHEN vp.auth_code IS NULL THEN o.vn END) = 2
                        THEN 'มีการเปิด 2 VISIT และยังไม่มีเลข Authen Code ทั้ง 2 VISIT'
                    
                    WHEN COUNT(DISTINCT CASE WHEN vp.auth_code IS NOT NULL THEN o.vn END) > 0 
                        AND COUNT(DISTINCT CASE WHEN vp.auth_code IS NULL THEN o.vn END) > 0
                        THEN 'มีการเปิด VISIT โดยที่ VISIT แรกมีการขอ Authen Code แล้วแต่ VISIT ที่ 2 ยังไม่ได้ขอ Authen Code'
                    
                    WHEN COUNT(DISTINCT o.vn) = 1 AND COUNT(DISTINCT CASE WHEN vp.auth_code IS NULL THEN o.vn END) = 1
                        THEN 'มีการเปิด 1 VISIT และยังไม่มีเลข Authen Code 1 VISIT'
                    
                    ELSE NULL
                END AS result
            FROM ovst o 
            INNER JOIN visit_pttype vp ON o.vn = vp.vn 
            INNER JOIN patient pt ON o.hn = pt.hn 
            INNER JOIN vn_stat vs ON o.vn = vs.vn
            INNER JOIN pttype ptt ON vs.pttype = ptt.pttype
            WHERE 
                o.vstdate = CURDATE()
                AND pt.nationality = '99'
                    AND vp.auth_code IS NULL
            -- 		AND o.hn = '000053049'
            GROUP BY o.vn, o.hn, pt.cid, pt.pname, pt.fname, pt.lname, ptt.name
            HAVING result IS NOT NULL
            ORDER BY o.hn DESC;
        ";

        $summarize_report = DB::connection('mysql')->select($query);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        $formattedExecutionTime = number_format($executionTime, 3);

        // ดึง username จาก method someMethod
        $username = $this->someMethod($request);
        
        // สร้างข้อมูลสำหรับบันทึกใน log
        $authen_code_log_data = [
            'function' => 'query_authen_code',
            'username' => $username,
            'command_sql' => $query, // SQL query ที่มีการแทนค่าจริง
            'query_time' => $formattedExecutionTime,
            'operation' => 'SELECT'
        ];
    
        // บันทึกข้อมูลลงใน AuthenCodeLogModel
        AuthenCodeLogModel::create($authen_code_log_data);

        return (array) $summarize_report;
    }

    public function index(Request $request) {
        // Retrieve session data
        $data = $request->session()->all();
        // Get the current year
        $year = date('Y');

        $startTime = microtime(true);
    
        // Execute the query to get the summarized counts
        $query = DB::table('ovst as t1')
            ->select(
                DB::raw('COUNT(t1.vn) AS ovst_all'),
                DB::raw('COUNT(t2.vn) AS ovst_authen_all'),
                DB::raw("COUNT(CASE WHEN t2.pttype_spp_name = 'ข้าราชการ/รัฐวิสาหกิจ' THEN 1 END) AS ofc_lgo_authen"),
                DB::raw("COUNT(CASE WHEN t2.pttype_spp_name = 'บัตรประกันสังคม' THEN 1 END) AS sss_authen"),
                DB::raw("COUNT(CASE WHEN t2.pttype_spp_name = 'UC (บัตรทอง ไม่มี ท.)' THEN 1 END) AS ucs_authen"),
                DB::raw("COUNT(CASE WHEN t2.pttype_spp_name = 'สปร. (บัตรทอง มี ท.)' THEN 1 END) AS wel_authen"),
                DB::raw("COUNT(CASE WHEN t2.pttype_spp_name = 'คนต่างด้าวที่ขึ้นทะเบียน' THEN 1 END) AS nrh_authen"),
                DB::raw("COUNT(CASE WHEN t2.pttype_spp_name = 'อื่นๆ (ต่างด้าวไม่ขึ้นทะเบียน / ชำระเงินเอง)' THEN 1 END) AS other_authen"),
                DB::raw('COUNT(t3.vn) AS ovst_not_authen_all'),
                DB::raw("COUNT(CASE WHEN t3.pttype_spp_name = 'ข้าราชการ/รัฐวิสาหกิจ' THEN 1 END) AS ofc_lgo_not_authen"),
                DB::raw("COUNT(CASE WHEN t3.pttype_spp_name = 'บัตรประกันสังคม' THEN 1 END) AS sss_not_authen"),
                DB::raw("COUNT(CASE WHEN t3.pttype_spp_name = 'UC (บัตรทอง ไม่มี ท.)' THEN 1 END) AS ucs_not_authen"),
                DB::raw("COUNT(CASE WHEN t3.pttype_spp_name = 'สปร. (บัตรทอง มี ท.)' THEN 1 END) AS wel_not_authen"),
                DB::raw("COUNT(CASE WHEN t3.pttype_spp_name = 'คนต่างด้าวที่ขึ้นทะเบียน' THEN 1 END) AS nrh_not_authen"),
                DB::raw("COUNT(CASE WHEN t3.pttype_spp_name = 'อื่นๆ (ต่างด้าวไม่ขึ้นทะเบียน / ชำระเงินเอง)' THEN 1 END) AS other_not_authen")
            )
            ->leftJoin(DB::raw('(
                SELECT
                    vp.vn,
                    ptts.pttype_spp_name
                FROM visit_pttype vp
                LEFT JOIN vn_stat vs ON vp.vn = vs.vn
                LEFT JOIN pttype ptt ON vs.pttype = ptt.pttype
                LEFT JOIN pttype_spp ptts ON ptt.pttype_spp_id = ptts.pttype_spp_id
                WHERE vp.auth_code IS NOT NULL
            ) as t2'), 't1.vn', '=', 't2.vn')
            ->leftJoin(DB::raw('(
                SELECT
                    vp.vn,
                    ptts.pttype_spp_name
                FROM visit_pttype vp
                LEFT JOIN vn_stat vs ON vp.vn = vs.vn
                LEFT JOIN pttype ptt ON vs.pttype = ptt.pttype
                LEFT JOIN pttype_spp ptts ON ptt.pttype_spp_id = ptts.pttype_spp_id
                WHERE vp.auth_code IS NULL
            ) as t3'), 't1.vn', '=', 't3.vn')
            ->whereDate('t1.vstdate', '=', DB::raw('CURRENT_DATE()'))
        ;

        $summarize_count = $query->first();

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
        $authen_code_log_data = [
            'function' => 'Come to the Authen Code page => Query summarize_count',
            'username' => $username,
            'command_sql' => $fullSql, // SQL query ที่มีการแทนค่าจริง
            'query_time' => $formattedExecutionTime,
            'operation' => 'SELECT'
        ];
    
        // บันทึกข้อมูลลงใน AuthenCodeLogModel
        AuthenCodeLogModel::create($authen_code_log_data);

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

        if($SidebarSub1MenuId->status_id === 1) {
            $startTime_2 = microtime(true);

            $query_2 = AccessibilityModel::where('accessibility_name', $data['groupname'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);
            $accessibility_groupname_model = $query_2->first();

            // ดึง SQL query_2 พร้อม bindings
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $accessibility_log_data = [
                'function' => "Where accessibility_name = {$data['groupname']} AND sidebar_sub1_menu_id = {$SidebarSub1MenuId->id}",
                'username' => $data['loginname'],
                'command_sql' => $fullSql_2,
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน AccessibilityLogModel
            AccessibilityLogModel::create($accessibility_log_data);

            if($accessibility_groupname_model !== null && $accessibility_groupname_model->status_id === 1) {
                return view('reportes.authenCode', compact('data', 'year', 'summarize_count'));
            } else {
                $startTime_3 = microtime(true);

                $query_3 = AccessibilityModel::where('accessibility_name', $data['name'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);
                $accessibility_name_model = $query_3->first();

                // ดึง SQL query_3 พร้อม bindings
                $sql_3 = $query_3->toSql();
                $bindings_3 = $query_3->getBindings();
                $fullSql_3 = vsprintf(str_replace('?', "'%s'", $sql_3), $bindings_3);
            
                $endTime_3 = microtime(true);
                $executionTime_3 = $endTime_3 - $startTime_3;
                $formattedExecutionTime_3 = number_format($executionTime_3, 3);

                // สร้างข้อมูลสำหรับบันทึกใน log
                $accessibility_log_data = [
                    'function' => "Where accessibility_name = {$data['name']} AND sidebar_sub1_menu_id = {$SidebarSub1MenuId->id}",
                    'username' => $data['loginname'],
                    'command_sql' => $fullSql_3,
                    'query_time' => $formattedExecutionTime_3,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน AccessibilityLogModel
                AccessibilityLogModel::create($accessibility_log_data);

                if($accessibility_name_model !== null && $accessibility_name_model->status_id === 1) {
                    return view('reportes.authenCode', compact('data', 'year', 'summarize_count'));
                } else {
                    $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบ Authen Code หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                    return redirect()->route('dashboard');
                }
            }
        } else {
            $request->session()->put('error', 'ขณะนี้ระบบ Authen Code ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
            return redirect()->route('dashboard');
        }
    }    

    public function getAuthenCodeCount(Request $request) {
        $startTime = microtime(true);

        $query = "SELECT COUNT(*) AS total_all, COUNT(vp.auth_code IN (SELECT auth_code FROM visit_pttype WHERE auth_code IS NOT NULL)) AS total_authen_success, COUNT(*) - COUNT(vp.auth_code IN (SELECT auth_code FROM visit_pttype WHERE auth_code IS NOT NULL)) AS total_not_authen FROM ovst o LEFT OUTER JOIN visit_pttype vp ON o.vn = vp.vn LEFT OUTER JOIN patient pt ON o.hn =pt.hn WHERE o.vstdate = CURRENT_DATE() AND pt.nationality = '99';";

        $summarize_count = DB::connection('mysql')->select($query);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        $formattedExecutionTime = number_format($executionTime, 3);

        // ดึง username จาก method someMethod
        $username = $this->someMethod($request);
        
        // สร้างข้อมูลสำหรับบันทึกใน log
        $authen_code_log_data = [
            'function' => 'getAuthenCodeCount',
            'username' => $username,
            'command_sql' => $query, // SQL query ที่มีการแทนค่าจริง
            'query_time' => $formattedExecutionTime,
            'operation' => 'SELECT'
        ];
    
        // บันทึกข้อมูลลงใน AuthenCodeLogModel
        AuthenCodeLogModel::create($authen_code_log_data);

        $summarize_count = $summarize_count[0];

        $chart = $this->getChart($summarize_count);

        return response()->json([
            'chart' => $chart
        ]);
    }

    public function authenCodeFetchAll(Request $request) {
        $summarize_report = $this->query_authen_code($request);

        $output = '';

        if(count($summarize_report) > 0) {
            $output .= '<table id="table-list-authen-code" class="table table-hover table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead class="table-dark">
              <tr>
                <th>HN</th>
                <th>เลขบัตรประจำตัวประชาชน</th>
                <th>คำนำหน้า</th>
                <th>ชื่อ - สกุล</th>
                <th>สิทธิ์การรักษา</th>
                <th>สาเหตุ</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($summarize_report as $sr) {
				$output .= '<tr>
                <td>' . $sr->hn . '</td>
                <td>' . $sr->cid . '</td>
                <td>' . $sr->pname . '</td>
                <td>' . $sr->fullname . '</td>
                <td>' . $sr->pttype_name . '</td>
                <td>' . $sr->result . '</td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">ไม่มีคนไข้ที่ยังไม่ได้ขอเลข Authen Code!</h1>';
        }
    }

    public function exportNotAuthenCode(Request $request) {
        $summarize_report = $this->query_authen_code($request);
        if (count($summarize_report) > 0) {
            // ส่ง JSON กลับไปยัง AJAX
            return response()->json([
                'status' => 200,
                'title' => 'success',
                'message' => 'Download Success',
                'icon' => 'success',
                'download_url' => route('downloadAuthenCode')
            ]);
        } else {
            echo "<script>alert('ไม่มีคนไข้ที่ยังไม่ได้ขอเลข Authen Code')</script>";
            return redirect()->route('report_index_authen_code');
        }
    }

    // สร้างฟังก์ชันใหม่สำหรับดาวน์โหลดไฟล์
    public function downloadAuthenCode(Request $request) {
        $summarize_report = $this->query_authen_code($request);
        return Excel::download(new AuthenCodeExport($summarize_report), 'authencode.xlsx');
    }
}
