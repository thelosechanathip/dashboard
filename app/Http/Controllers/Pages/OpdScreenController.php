<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\ModuleModel;
use App\Models\Dashboard_Setting\AccessibilityModel;

use App\Models\Log\OpdScreenLogModel;
use App\Models\Log\ModuleLogModel;
use App\Models\Log\AccessibilityLogModel;

class OpdScreenController extends Controller
{
    // Function ในการเรียกใช้งาน Username ที่เข้ามาใช้งาน SomeMethod Start
        private function someMethod(Request $request) {
            $data = $request->session()->all();
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

            $query = DB::table('opdscreen')
                ->select(
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_old}-10-01' AND '{$year_old}-10-31' THEN 1 END) AS october"),
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_old}-11-01' AND '{$year_old}-11-30' THEN 1 END) AS november"),
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_old}-12-01' AND '{$year_old}-12-31' THEN 1 END) AS december"),
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_new}-01-01' AND '{$year_new}-01-31' THEN 1 END) AS january"),
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_new}-02-01' AND '{$year_new}-02-31' THEN 1 END) AS february"),
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_new}-03-01' AND '{$year_new}-03-31' THEN 1 END) AS march"),
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_new}-04-01' AND '{$year_new}-04-30' THEN 1 END) AS april"),
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_new}-05-01' AND '{$year_new}-05-31' THEN 1 END) AS may"),
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_new}-06-01' AND '{$year_new}-06-30' THEN 1 END) AS june"),
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_new}-07-01' AND '{$year_new}-07-31' THEN 1 END) AS july"),
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_new}-08-01' AND '{$year_new}-08-31' THEN 1 END) AS august"),
                    DB::raw("COUNT(CASE WHEN vstdate BETWEEN '{$year_new}-09-01' AND '{$year_new}-09-30' THEN 1 END) AS september")
                )
                ->where('screen_dep', '027')
                ->whereNotNull('cc')
                ->where('cc', '!=', '')
            ;

            // ดึงข้อมูลจาก Query
            $opdscreen_count = $query->first();
        
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
            $opdscreen_log_data = [
                'function' => 'getYear',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน OpdScreenLogModel
            OpdScreenLogModel::create($opdscreen_log_data);

            return (array) $opdscreen_count;
        }
    // นำปีงบประมาณที่ได้มาจัดหาเดือนที่ถูกต้อง GetYear End

    // นำเดือนมาสร้าง Chart GetChartYear Start
        private function getChartYear($response) {
            $chartDataYear = [
                'labels' => ['ตุลาคม', 'พฤศจิกายน', 'ธันวาคม', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน'],
                'datasets' => [
                    [
                        'label' => 'จำนวนผู้เข้ามารับบริการ',
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
                // return true;
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

    // หน้าแรกของ Opdscreen Index Start
        public function index(Request $request) {
            $data = $request->session()->all();
            $year = date('Y');

            $opdscreen_log_data = [
                'function' => 'Come to the Opdscreen page',
                'username' => $data['loginname'],
                'command_sql' => '',
                'query_time' => '',
                'operation' => 'OPEN'
            ];
        
            // บันทึกข้อมูลลงใน OpdScreenLogModel
            OpdScreenLogModel::create($opdscreen_log_data);

            $startTime_1 = microtime(true);

            $query_1 = ModuleModel::where('module_name', 'Opdscreen');

            $opdscreenId = $query_1->first();

            // ดึง SQL query_1 พร้อม bindings
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $module_log_data = [
                'function' => 'Where module_name = Opdscreen',
                'username' => $data['loginname'],
                'command_sql' => $fullSql_1,
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            ModuleLogModel::create($module_log_data);

            if($opdscreenId->status_id === 1) {
                $startTime_2 = microtime(true);

                $query_2 = AccessibilityModel::where('accessibility_name', $data['groupname'])->where('module_id', $opdscreenId->id);
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
                    return view('pages.opdscreen', compact('data', 'year'));
                } else {
                    $startTime_3 = microtime(true);

                    $query_3 = AccessibilityModel::where('accessibility_name', $data['name'])->where('module_id', $opdscreenId->id);
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
                        return view('pages.opdscreen', compact('data', 'year'));
                    } else {
                        // $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบ Opdscreen หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        $request->session()->put('error', 'ขณะนี้ระบบ ผู้ป่วยนอก ยังไม่ได้เปิดให้ใช้งาน!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบ Opdscreen ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }
    // หน้าแรกของ Opdscreen Index End

    // GetOpdScreenData Start
        public function getOpdScreenData(Request $request) {
            $year = $request->input('year');

            $years = $this->check_year($year);

            $response_year = $this->getYear($years['year_old'], $years['year_new'], $request);

            $chartDataYear = $this->getChartYear($response_year);

            return response()->json([
                'chartDataYear' => $chartDataYear
            ]);
        }
    // GetOpdScreenData End

    // GetOpdScreenDailyData Start
        public function getOpdScreenDailyData(Request $request) {
            try {
                $year = $request->input('year');
                $years = $this->check_year($year);

                $month = $request->input('month');
                $month_int = $this->getMonthNumber($month);

                if($month_int == 10 || $month_int == 11 || $month_int == 12) {
                    $start_date = $years['year_old'] . '-' . $month_int . '-01';
                } else {
                    $start_date = $years['year_new'] . '-' . $month_int . '-01';
                }

                $end_date = date("Y-m-t", strtotime($start_date));

                $startTime = microtime(true);

                $daily_count = DB::table('opdscreen')
                    ->select(DB::raw('DATE(vstdate) as date'), DB::raw('COUNT(*) as count'))
                    ->whereBetween('vstdate', [$start_date, $end_date])
                    ->where('screen_dep', '027')
                    ->whereNotNull('cc')
                    ->where('cc', '!=', '')
                    ->groupBy(DB::raw('DATE(vstdate)'))
                    ->orderBy('date');

                $opdscreen_count = $daily_count->get(); // ดึงข้อมูลออกมา

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
                $opdscreen_log_data = [
                    'function' => 'getOpdScreenDailyData',
                    'username' => $username,
                    'command_sql' => $fullSql, // SQL query ที่มีการแทนค่าจริง
                    'query_time' => $formattedExecutionTime,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน OpdScreenLogModel
                OpdScreenLogModel::create($opdscreen_log_data);

                $dates = [];
                $counts = [];
                foreach ($opdscreen_count as $data) {
                    $dates[] = $data->date;
                    $counts[] = $data->count;
                }

                $chartDataDaily = [
                    'labels' => $dates,
                    'datasets' => [
                        [
                            'label' => 'จำนวนผู้เข้ามารับบริการรายวัน',
                            'data' => $counts,
                            'backgroundColor' => 'rgba(54, 162, 235, 1)',
                            'borderColor' => 'rgba(54, 162, 235, 2)',
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
    // GetOpdScreenDailyData End

    // GetOpdScreenSelectData Start
        public function getOpdScreenSelectData(Request $request) {
            try {
                $minDate = $request->min_date;
                $maxDate = $request->max_date;

                if ($minDate != $maxDate) {
                    $startTime = microtime(true);

                    $daily_count_query = DB::table('opdscreen')
                        ->select(DB::raw('DATE(vstdate) as date'), DB::raw('COUNT(*) as count'))
                        ->whereBetween('vstdate', [$minDate, $maxDate])
                        ->where('screen_dep', '027')
                        ->whereNotNull('cc')
                        ->where('cc', '!=', '')
                        ->groupBy(DB::raw('DATE(vstdate)'))
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
                    $opdscreen_log_data = [
                        'function' => 'getOpdScreenSelectData',
                        'username' => $username,
                        'command_sql' => $fullSql, // SQL query ที่มีการแทนค่าจริง
                        'query_time' => $formattedExecutionTime,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน OpdScreenLogModel
                    OpdScreenLogModel::create($opdscreen_log_data);
                } else {
                    $startTime = microtime(true);

                    $daily_count = DB::table('opdscreen')
                        ->select(DB::raw('DATE(vstdate) as date'), DB::raw('COUNT(*) as count'))
                        ->whereDate('vstdate', $minDate)
                        ->where('screen_dep', '027')
                        ->whereNotNull('cc')
                        ->where('cc', '!=', '')
                        ->groupBy(DB::raw('DATE(vstdate)'))
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
                    $opdscreen_log_data = [
                        'function' => 'getOpdScreenSelectData',
                        'username' => $username,
                        'command_sql' => $fullSql, // SQL query ที่มีการแทนค่าจริง
                        'query_time' => $formattedExecutionTime,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน OpdScreenLogModel
                    OpdScreenLogModel::create($opdscreen_log_data);
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
                        'rgba(255, 99, 132, 2)', 'rgba(54, 162, 235, 2)', 'rgba(255, 206, 86, 2)',
                        'rgba(75, 192, 192, 2)', 'rgba(153, 102, 255, 2)', 'rgba(255, 159, 64, 2)'
                    ];

                    for ($i = 0; $i < count($dates); $i++) {
                        $backgroundColor[] = $colors[$i % count($colors)];
                        $borderColor[] = $borderColors[$i % count($borderColors)];
                    }

                    $chartDataDaily = [
                        'labels' => $dates,
                        'datasets' => [
                            [
                                'label' => 'จำนวนผู้เข้ามารับบริการ',
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
    // GetOpdScreenSelectData End

}