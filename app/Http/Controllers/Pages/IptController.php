<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\ModuleModel;
use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\FiscalYearModel;

use App\Models\Log\IptLogModel;
use App\Models\Log\ModuleLogModel;
use App\Models\Log\AccessibilityLogModel;

use Carbon\Carbon;

class IptController extends Controller
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

    // นำปีงบประมาณที่ได้มาจัดหาเดือนที่ถูกต้อง GetYear Start
        private function getYear($year_old, $year_new, $request) {
            $startTime = microtime(true);
        
            // สร้าง Query
            $query = DB::table('ipt')
                ->select(
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_old}-10-01' AND '{$year_old}-10-31' THEN 1 END) AS october"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_old}-11-01' AND '{$year_old}-11-30' THEN 1 END) AS november"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_old}-12-01' AND '{$year_old}-12-31' THEN 1 END) AS december"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-01-01' AND '{$year_new}-01-31' THEN 1 END) AS january"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-02-01' AND '{$year_new}-02-28' THEN 1 END) AS february"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-03-01' AND '{$year_new}-03-31' THEN 1 END) AS march"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-04-01' AND '{$year_new}-04-30' THEN 1 END) AS april"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-05-01' AND '{$year_new}-05-31' THEN 1 END) AS may"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-06-01' AND '{$year_new}-06-30' THEN 1 END) AS june"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-07-01' AND '{$year_new}-07-31' THEN 1 END) AS july"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-08-01' AND '{$year_new}-08-31' THEN 1 END) AS august"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-09-01' AND '{$year_new}-09-30' THEN 1 END) AS september")
                );
        
            // ดึงข้อมูลจาก Query
            $ovst_count = $query->first();
        
            // ดึง SQL query พร้อม bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);
        
            // // ดึง username จาก method someMethod
            $username = $this->someMethod($request); 
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $ipt_log_data = [
                'function' => 'getYear',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน IptLogModel
            IptLogModel::create($ipt_log_data);
        
            // ส่งข้อมูลกลับ
            return (array) $ovst_count;  // คืนค่าข้อมูลที่ดึงมา
        }
    // นำปีงบประมาณที่ได้มาจัดหาเดือนที่ถูกต้อง GetYear End

    // Query Count ตึก Male, Female, Loungta, LR Start
        private function getCountAdmitMFLL(Request $request) {
            $startTime = microtime(true);
        
            // สร้าง Query
            $query = DB::table('ipt')
                ->whereNull('dchdate')
                ->whereIn('ward', ['01', '02', '03', '04'])
            ;
        
            // ดึงข้อมูลจาก Query
            $ipt01020304_result  = $query->count();
        
            // ดึง SQL query พร้อม bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);
        
            // // ดึง username จาก method someMethod
            $username = $this->someMethod($request); 
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $ipt_log_data = [
                'function' => 'getYear',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน IptLogModel
            IptLogModel::create($ipt_log_data);
        
            // ส่งข้อมูลกลับ
            return $ipt01020304_result ;  // คืนค่าข้อมูลที่ดึงมา
        }
    // Query Count ตึก Male, Female, Loungta, LR End

    // นำเดือนมาสร้าง Chart GetChartYear Start
        private function getChartYear($response) {
            $chartDataYear = [
                'labels' => ['ตุลาคม', 'พฤศจิกายน', 'ธันวาคม', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน'],
                'datasets' => [
                    [
                        'label' => 'จำนวน Admit ประจำเดือน',
                        'data' => [
                            $response['october'],
                            $response['november'],
                            $response['december'],
                            $response['january'],
                            $response['february'],
                            $response['march'],
                            $response['april'],
                            $response['may'],
                            $response['june'],
                            $response['july'],
                            $response['august'],
                            $response['september']
                        ],
                        'backgroundColor' => [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        'borderColor' => [
                            'rgba(255, 99, 132, 3)',
                            'rgba(54, 162, 235, 3)',
                            'rgba(255, 206, 86, 3)',
                            'rgba(75, 192, 192, 3)',
                            'rgba(153, 102, 255, 3)',
                            'rgba(255, 159, 64, 3)',
                            'rgba(75, 192, 192, 3)',
                            'rgba(153, 102, 255, 3)',
                            'rgba(255, 159, 64, 3)',
                            'rgba(255, 99, 132, 3)',
                            'rgba(54, 162, 235, 3)',
                            'rgba(255, 206, 86, 3)'
                        ],
                        'borderWidth' => 1
                    ]
                ]
            ];
            return $chartDataYear;
        }
    // นำเดือนมาสร้าง Chart GetChartYear End

    // แปลงเดือนที่เป็น Text ไปเป็น Int GetMonthNumber Start
        private function getMonthNumber($month) {
            $months = [
                'ตุลาคม' => '10',
                'พฤศจิกายน' => '11',
                'ธันวาคม' => '12',
                'มกราคม' => '01',
                'กุมภาพันธ์' => '02',
                'มีนาคม' => '03',
                'เมษายน' => '04',
                'พฤษภาคม' => '05',
                'มิถุนายน' => '06',
                'กรกฎาคม' => '07',
                'สิงหาคม' => '08',
                'กันยายน' => '09',
            ];

            if(!$month) {
                return false;
            } else {
                $month = $months[$month];
                return $month;
            }
        }
    // แปลงเดือนที่เป็น Text ไปเป็น Int GetMonthNumber End

    // แปลงเดือนที่เป็น Int ไปเป็น Text GetMonthName Start
        private function getMonthName($month) {
            $months = [
                '01' => 'มกราคม',
                '02' => 'กุมภาพันธ์',
                '03' => 'มีนาคม',
                '04' => 'เมษายน',
                '05' => 'พฤษภาคม',
                '06' => 'มิถุนายน',
                '07' => 'กรกฎาคม',
                '08' => 'สิงหาคม',
                '09' => 'กันยายน',
                '10' => 'ตุลาคม',
                '11' => 'พฤศจิกายน',
                '12' => 'ธันวาคม',
            ];

            return $months[$month] ?? $month;
        }
    // แปลงเดือนที่เป็น Int ไปเป็น Text GetMonthName End

    // หน้าแรกของ IPT Index Start
        public function index(Request $request) {
            $data = $request->session()->all();

            $fiscal_year = FiscalYearModel::orderBy('id', 'desc')->get();
            
            $month = date('m');

            if($month != 10 && $month != 11 && $month != 12) {
                $year = date('Y');
            } else {
                $year = date('Y') + 1;
            }

            $startTime = microtime(true);

            $query = DB::table('ward')->where('ward', '!=', '00');

            $wards = $query->get();

            // ดึง SQL query พร้อม bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $ward_log_data = [
                'function' => 'Query Ward',
                'username' => $data['loginname'],
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน IptLogModel
            IptLogModel::create($ward_log_data);

            $ipt_log_data = [
                'function' => 'Come to the IPT page',
                'username' => $data['loginname'],
                'command_sql' => '',
                'query_time' => '',
                'operation' => 'OPEN'
            ];
        
            // บันทึกข้อมูลลงใน IptLogModel
            IptLogModel::create($ipt_log_data);

            $startTime_1 = microtime(true);

            $query_1 = ModuleModel::where('module_name', 'Admit');

            $admitId = $query_1->first();

            // ดึง SQL query_1 พร้อม bindings
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $module_log_data = [
                'function' => 'Where module_name = Admit',
                'username' => $data['loginname'],
                'command_sql' => $fullSql_1,
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            ModuleLogModel::create($module_log_data);

            if($admitId->status_id === 1) {
                $startTime_2 = microtime(true);

                $query_2 = AccessibilityModel::where('accessibility_name', $data['groupname'])->where('module_id', $admitId->id);
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
                    'function' => 'Where accessibility_name = {groupname} AND {module_id}',
                    'username' => $data['loginname'],
                    'command_sql' => $fullSql_2,
                    'query_time' => $formattedExecutionTime_2,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน AccessibilityLogModel
                AccessibilityLogModel::create($accessibility_log_data);

                if($accessibility_groupname_model !== null && $accessibility_groupname_model->status_id === 1) {
                    return view('pages.ipt', compact(
                        'data', 
                        'year',
                        'wards',
                        'fiscal_year'
                    ));
                } else {
                    $startTime_3 = microtime(true);

                    $query_3 = AccessibilityModel::where('accessibility_name', $data['name'])->where('module_id', $admitId->id);
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
                        'function' => 'Where accessibility_name = {name} AND {module_id}',
                        'username' => $data['loginname'],
                        'command_sql' => $fullSql_3,
                        'query_time' => $formattedExecutionTime_3,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน AccessibilityLogModel
                    AccessibilityLogModel::create($accessibility_log_data);

                    if($accessibility_name_model !== null && $accessibility_name_model->status_id === 1) {
                        return view('pages.ipt', compact(
                            'data', 
                            'year',
                            'wards',
                            'fiscal_year'
                        ));
                    } else {
                        $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบ Admit หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        // $request->session()->put('error', 'เนื่องจากมีการปิดปรับปรุงระบบขออภัยในความไม่สะดวก!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบ Admit ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }
    // หน้าแรกของ IPT Index End

    // GetIptData Start
        public function getIptData(Request $request) {
            $year = $request->input('year');

            $years = $this->check_year($year);

            $response_year = $this->getYear($years['year_old'], $years['year_new'], $request);

            $response_result_admit_mfll = $this->getCountAdmitMFLL($request);

            $chartDataYear = $this->getChartYear($response_year);

            return response()->json([
                'chartDataYear' => $chartDataYear,
                'response_result_admit_mfll' => $response_result_admit_mfll
            ]);
        }
    // GetIptData End

    // GetIptDailyData Start
        public function getIptDailyData(Request $request) {
            try {
                $year = $request->input('year');
                $years = $this->check_year($year);
        
                $month = $request->input('month');
                $month_int = $this->getMonthNumber($month);
        
                // กำหนดวันที่เริ่มต้นตามเงื่อนไขเดือน
                if ($month_int == 10 || $month_int == 11 || $month_int == 12) {
                    $start_date = $years['year_old'] . '-' . $month_int . '-01';
                } else {
                    $start_date = $years['year_new'] . '-' . $month_int . '-01';
                }
        
                $end_date = date("Y-m-t", strtotime($start_date)); // คำนวณวันสิ้นเดือน
        
                $startTime = microtime(true);
        
                // Query เพื่อดึงข้อมูล
                $daily_count = DB::table('ipt')
                    ->select(DB::raw('DATE(regdate) as date'), DB::raw('COUNT(*) as count'))
                    ->whereBetween('regdate', [$start_date, $end_date])
                    ->groupBy(DB::raw('DATE(regdate)'))
                    ->orderBy('date');
        
                $ovst_count = $daily_count->get(); // ดึงข้อมูลออกมา
        
                // ดึง SQL query พร้อม bindings
                $sql = $daily_count->toSql();
                $bindings = $daily_count->getBindings();
                $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
                $endTime = microtime(true);
                $executionTime = $endTime - $startTime;
                $formattedExecutionTime = number_format($executionTime, 3);
        
                // ดึง username จาก method someMethod
                $username = $this->someMethod($request);
                
                // สร้างข้อมูลสำหรับบันทึกใน log
                $ipt_log_data = [
                    'function' => 'getIptDailyData',
                    'username' => $username,
                    'command_sql' => $fullSql, // SQL query ที่มีการแทนค่าจริง
                    'query_time' => $formattedExecutionTime,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน IptLogModel
                IptLogModel::create($ipt_log_data);
        
                // สร้างข้อมูลสำหรับกราฟ
                $dates = [];
                $counts = [];
                foreach ($ovst_count as $data) {
                    $dates[] = $data->date;
                    $counts[] = $data->count;
                }
        
                $chartDataDaily = [
                    'labels' => $dates,
                    'datasets' => [
                        [
                            'label' => 'จำนวน Admit รายวัน',
                            'data' => $counts,
                            'backgroundColor' => 'rgba(54, 162, 235, 1)',
                            'borderColor' => 'rgba(54, 162, 235, 1)',
                            'borderWidth' => 1
                        ]
                    ]
                ];
        
                return response()->json(['chartDataDaily' => $chartDataDaily]);
        
            } catch (\Exception $e) {
                // บันทึกข้อผิดพลาดลงใน log
                \Log::error($e->getMessage());
                return response()->json(['error' => 'Server Error'], 500);
            }
        }
    // GetIptDailyData End

    // GetIptNameDoctorData Start
        public function getIptNameDoctorData(Request $request) {
            try {
                $date = $request->input('date');

                // Validate the date input
                if (!$date || !strtotime($date)) {
                    return response()->json(['error' => 'Invalid date format'], 400);
                }

                $startTime = microtime(true);

                // ใช้ Query Builder แทน DB::select()
                $daily_count_query = DB::table('ipt as i')
                    ->leftJoin('doctor as dt', 'i.admdoctor', '=', 'dt.code')
                    ->select('dt.name as doctor_name', DB::raw('COUNT(i.admdoctor) AS count_doctor_ipt'))
                    ->whereDate('regdate', $date)
                    ->groupBy('i.admdoctor');

                // ดึงผลลัพธ์จาก query
                $daily_count = $daily_count_query->get();

                // ดึง SQL query พร้อม bindings
                $sql = $daily_count_query->toSql();
                $bindings = $daily_count_query->getBindings();
                $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

                $endTime = microtime(true);
                $executionTime = $endTime - $startTime;
                $formattedExecutionTime = number_format($executionTime, 3);

                // ดึง username จาก method someMethod
                $username = $this->someMethod($request);
                
                // สร้างข้อมูลสำหรับบันทึกใน log
                $ipt_log_data = [
                    'function' => 'getIptNameDoctorData',
                    'username' => $username,
                    'command_sql' => $fullSql, // SQL query ที่มีการแทนค่าจริง
                    'query_time' => $formattedExecutionTime,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน IptLogModel
                IptLogModel::create($ipt_log_data);

                $doctor_names = [];
                $count_doctor_iptes = [];
                foreach ($daily_count as $data) {
                    $doctor_names[] = $data->doctor_name;
                    $count_doctor_iptes[] = $data->count_doctor_ipt;
                }

                $chartNameDoctorData = [
                    'labels' => $doctor_names,
                    'datasets' => [
                        [
                            'label' => 'จำนวน Admit รายวัน',
                            'data' => $count_doctor_iptes,
                            'backgroundColor' => 'rgba(54, 162, 235, 1)',
                            'borderColor' => 'rgba(54, 162, 235, 3)',
                            'borderWidth' => 1
                        ]
                    ]
                ];

                return response()->json(['chartNameDoctorData' => $chartNameDoctorData]);
            } catch (\Exception $e) {
                // Log the error
                \Log::error($e->getMessage());
                return response()->json(['error' => 'Server Error'], 500);
            }
        }
    // GetIptNameDoctorData End

    // GetIptSelectData Start
        public function getIptSelectData(Request $request) {
            try {
                $minDate = $request->min_date;
                $maxDate = $request->max_date;

                if ($minDate != $maxDate) {
                    $startTime = microtime(true);

                    $daily_count_query = DB::table('ipt')
                        ->select(DB::raw('DATE(regdate) as date'), DB::raw('COUNT(*) as count'))
                        ->whereBetween('regdate', [$minDate, $maxDate])
                        ->groupBy(DB::raw('DATE(regdate)'))
                        ->orderBy('date');

                    $daily_count = $daily_count_query->get();
                    // ดึง SQL query พร้อม bindings
                    $sql = $daily_count_query->toSql();
                    $bindings = $daily_count_query->getBindings();
                    $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

                    $endTime = microtime(true);
                    $executionTime = $endTime - $startTime;
                    $formattedExecutionTime = number_format($executionTime, 3);

                    // ดึง username จาก method someMethod
                    $username = $this->someMethod($request);
                    
                    // สร้างข้อมูลสำหรับบันทึกใน log
                    $ipt_log_data = [
                        'function' => 'getIptSelectData',
                        'username' => $username,
                        'command_sql' => $fullSql, // SQL query ที่มีการแทนค่าจริง
                        'query_time' => $formattedExecutionTime,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน IptLogModel
                    IptLogModel::create($ipt_log_data);
                } else {
                    $startTime = microtime(true);

                    $daily_count_query = DB::table('ipt')
                        ->select(DB::raw('DATE(regdate) as date'), DB::raw('COUNT(*) as count'))
                        ->whereDate('regdate', $minDate)
                        ->groupBy(DB::raw('DATE(regdate)'))
                        ->orderBy('date');

                    $daily_count = $daily_count_query->get();
                    // ดึง SQL query พร้อม bindings
                    $sql = $daily_count_query->toSql();
                    $bindings = $daily_count_query->getBindings();
                    $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

                    $endTime = microtime(true);
                    $executionTime = $endTime - $startTime;
                    $formattedExecutionTime = number_format($executionTime, 3);

                    // ดึง username จาก method someMethod
                    $username = $this->someMethod($request);
                    
                    // สร้างข้อมูลสำหรับบันทึกใน log
                    $ipt_log_data = [
                        'function' => 'getIptSelectData',
                        'username' => $username,
                        'command_sql' => $fullSql, // SQL query ที่มีการแทนค่าจริง
                        'query_time' => $formattedExecutionTime,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน IptLogModel
                    IptLogModel::create($ipt_log_data);
                }

                if($daily_count == '') {
                    return response()->json([
                        'error' => 'ไม่มีข้อมูลใน Database'
                    ]);
                } else {
                    foreach ($daily_count as $data) {
                        $dates[] = $data->date;
                        $counts[] = $data->count;
                    }

                    $colors = [
                        'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'
                    ];
                    $borderColors = [
                        'rgba(255, 99, 132, 3)', 'rgba(54, 162, 235, 3)', 'rgba(255, 206, 86, 3)',
                        'rgba(75, 192, 192, 3)', 'rgba(153, 102, 255, 3)', 'rgba(255, 159, 64, 3)'
                    ];

                    for ($i = 0; $i < count($dates); $i++) {
                        $backgroundColor[] = $colors[$i % count($colors)];
                        $borderColor[] = $borderColors[$i % count($borderColors)];
                    }

                    $chartDataDaily = [
                        'labels' => $dates,
                        'datasets' => [
                            [
                                'label' => 'จำนวน Admit',
                                'data' => $counts,
                                'backgroundColor' => $backgroundColor,
                                'borderColor' => $borderColor,
                                'borderWidth' => 1
                            ]
                        ]
                    ];

                    return response()->json(['chartDataDaily' => $chartDataDaily]);
                }

            } catch(\Exception $e) {
                \Log::error($e->getMessage());
                return response()->json([
                    'status' => 500,
                    'error' => 'ไม่มีข้อมูลใน Database'
                ]);
            }
        }
    // GetIptSelectData End

    // GetResultCountYearsDoctor Start
        public function getResultCountYearsDoctor(Request $request) {
            $year = $request->years;
            $years = $this->check_year($year);

            $startTime = microtime(true);

            $daily_count_query = DB::connection('mysql')->table('ipt as i')
                ->leftJoin('doctor as dt', 'i.admdoctor', '=', 'dt.code')
                ->select('dt.name as doctor_name', DB::raw('COUNT(i.admdoctor) as count_doctor_ipt'))
                ->whereBetween('regdate', [$years['year_old'].'-10-01', $years['year_new'].'-09-30'])
                ->groupBy('i.admdoctor');

            $daily_count = $daily_count_query->get();

            // ดึง SQL query พร้อมกับ bindings
            $sql = $daily_count_query->toSql();
            $bindings = $daily_count_query->getBindings();

            // แทนที่เครื่องหมาย `?` ด้วยค่าจริงที่ถูก bind
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

            $endTime = microtime(true);

            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);

            $username = $this->someMethod($request);    

            $ipt_log_data = [
                'function' => 'getResultCountYearsDoctor',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
            IptLogModel::create($ipt_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: 20%;">รายชื่อ</th>
                            <th style="width: 75%;">จำนวนที่มีการ Admit</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->doctor_name . '</td>
                        <td>' . $dc->count_doctor_ipt . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลของแพทย์ประจำปีบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultCountYearsDoctor End

    // GetResultCountMonthDoctor Start
        public function getResultCountMonthDoctor(Request $request) {
            $year = $request->years;


            $month = $request->month;

            $month_int = $this->getMonthNumber($month);

            $startTime = microtime(true);

            // Query ที่ใช้การ concatenate string เพื่อเชื่อมตัวแปร $year
            $daily_count_query = DB::table('ipt as i')
                ->leftJoin('doctor as dt', 'i.admdoctor', '=', 'dt.code')
                ->select('dt.name as doctor_name', DB::raw('COUNT(i.admdoctor) as count_doctor_ipt'))
                ->where('regdate', 'like', "$year-$month_int-%")
                ->groupBy('i.admdoctor');

            $daily_count = $daily_count_query->get();

            // ดึง SQL query พร้อมกับ bindings
            $sql = $daily_count_query->toSql();
            $bindings = $daily_count_query->getBindings();

            // แทนที่เครื่องหมาย `?` ด้วยค่าจริงที่ถูก bind
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

            $endTime = microtime(true);

            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);

            $username = $this->someMethod($request);    

            $ipt_log_data = [
                'function' => 'getResultCountMonthDoctor',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
            IptLogModel::create($ipt_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: 20%;">รายชื่อ</th>
                            <th style="width: 75%;">จำนวนที่มีการ Admit</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->doctor_name . '</td>
                        <td>' . $dc->count_doctor_ipt . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลของแพทย์ประจำปีบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultCountMonthDoctor End

    // GetResultCountDateDoctor Start
        public function getResultCountDateDoctor(Request $request) {
            $date = $request->date;

            $startTime = microtime(true);

            // Query ที่ใช้การ concatenate string เพื่อเชื่อมตัวแปร $year
            $daily_count_query = DB::table('ipt as i')
                ->leftJoin('doctor as dt', 'i.admdoctor', '=', 'dt.code')
                ->select('dt.name as doctor_name', DB::raw('COUNT(i.admdoctor) as count_doctor_ipt'))
                ->where('i.regdate', '=', "$date")
                ->groupBy('i.admdoctor');

            $daily_count = $daily_count_query->get();

            // ดึง SQL query พร้อมกับ bindings
            $sql = $daily_count_query->toSql();
            $bindings = $daily_count_query->getBindings();

            // แทนที่เครื่องหมาย `?` ด้วยค่าจริงที่ถูก bind
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

            $endTime = microtime(true);

            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);

            $username = $this->someMethod($request);    

            $ipt_log_data = [
                'function' => 'getResultCountDateDoctor',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
            IptLogModel::create($ipt_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: 20%;">รายชื่อ</th>
                            <th style="width: 75%;">จำนวนที่มีการ Admit</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->doctor_name . '</td>
                        <td>' . $dc->count_doctor_ipt . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลของแพทย์ประจำวันบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultCountDateDoctor End

    // CheckStatusWard Start
        public function checkStatusWard(Request $request) {
            $wardName = $request->wardName;

            $startTime = microtime(true);

            $query = ModuleModel::select('status_id')->where('module_name', '=', $wardName);

            $module_model = $query->first();

            // ดึง SQL query พร้อมกับ bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();

            // แทนที่เครื่องหมาย `?` ด้วยค่าจริงที่ถูก bind
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

            $endTime = microtime(true);

            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);

            $username = $this->someMethod($request);    

            $ipt_log_data = [
                'function' => 'checkStatusWard',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            IptLogModel::create($ipt_log_data);

            return response()->json($module_model);
        }
    // CheckStatusWard End

    // GetResultWard Start
        public function getResultWard(Request $request) {
            $ward = $request->wardId;

            $startTime = microtime(true);
        
            // นับจำนวนข้อมูลที่ตรงกับเงื่อนไข
            $query = DB::table('ipt')
                ->whereDate('regdate', Carbon::today()) // เปรียบเทียบ regdate กับวันที่ปัจจุบัน
                ->where('ward', $ward);

            $count_all = $query->count();

            // ดึง SQL query พร้อมกับ bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();

            // แทนที่เครื่องหมาย `?` ด้วยค่าจริงที่ถูก bind
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

            $endTime = microtime(true);

            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);

            $username = $this->someMethod($request);    

            $ipt_log_data = [
                'function' => 'getResultWard',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            IptLogModel::create($ipt_log_data);

            $startTime_2 = microtime(true);
        
            // นับจำนวนข้อมูลที่ตรงกับเงื่อนไข
            $query_2 = DB::table('ipt')
                ->whereNull('dchdate')
                ->where('ward', $ward)
            ;

            $count_current = $query_2->count();

            // ดึง SQL query_2 พร้อมกับ bindings
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();

            // แทนที่เครื่องหมาย `?` ด้วยค่าจริงที่ถูก bind
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);

            $endTime_2 = microtime(true);

            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);

            $username = $this->someMethod($request);    

            $ipt_log_data_2 = [
                'function' => 'getResultWard',
                'username' => $username,
                'command_sql' => $fullSql_2,
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];

            IptLogModel::create($ipt_log_data_2);
        
            return response()->json([
                'count_all' => $count_all,
                'count_current' => $count_current,

            ]); // ส่งค่าจำนวนข้อมูลกลับไป
        }
    // GetResultWard End
}
