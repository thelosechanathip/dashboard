<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\ModuleModel;
use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\FiscalYearModel;

use App\Models\Log\HealthMedServiceLogModel;
use App\Models\Log\ModuleLogModel;
use App\Models\Log\AccessibilityLogModel;

use Carbon\Carbon;

class HealthMedServiceController extends Controller
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

            $query = DB::table('health_med_service as hms')
                ->select(
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_old}-10-01' AND '{$year_old}-10-31' THEN 1 END) AS october"),
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_old}-11-01' AND '{$year_old}-11-30' THEN 1 END) AS november"),
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_old}-12-01' AND '{$year_old}-12-31' THEN 1 END) AS december"),
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_new}-01-01' AND '{$year_new}-01-31' THEN 1 END) AS january"),
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_new}-02-01' AND '{$year_new}-02-31' THEN 1 END) AS february"),
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_new}-03-01' AND '{$year_new}-03-31' THEN 1 END) AS march"),
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_new}-04-01' AND '{$year_new}-04-30' THEN 1 END) AS april"),
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_new}-05-01' AND '{$year_new}-05-31' THEN 1 END) AS may"),
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_new}-06-01' AND '{$year_new}-06-30' THEN 1 END) AS june"),
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_new}-07-01' AND '{$year_new}-07-31' THEN 1 END) AS july"),
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_new}-08-01' AND '{$year_new}-08-31' THEN 1 END) AS august"),
                    DB::raw("COUNT(CASE WHEN hms.service_date BETWEEN '{$year_new}-09-01' AND '{$year_new}-09-30' THEN 1 END) AS september")
                )
                // ->join('health_med_service_diagnosis as hmsd', 'hms.health_med_service_id', '=', 'hmsd.health_med_service_id')
                // ->join('icd10_health_med as ihm', 'hmsd.icd10', '=', 'ihm.icd10')
                // ->join('patient as pt', 'hms.hn', '=', 'pt.hn')
            ;
            
            // ดึงข้อมูลจาก Query
            $health_med_service_count = $query->first();
        
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
            $health_med_service_log_data = [
                'function' => 'getYear',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน HealthMedServiceLogModel
            HealthMedServiceLogModel::create($health_med_service_log_data);

            return (array) $health_med_service_count;
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

    // หน้าแรกของ Health Med Service Index Start
        public function index(Request $request) {
            $data = $request->session()->all();

            $fiscal_year = FiscalYearModel::orderBy('id', 'desc')->get();
            
            $month = date('m');

            if($month != 10 && $month != 11 && $month != 12) {
                $year = date('Y');
            } else {
                $year = date('Y') + 1;
            }

            $health_med_service_data = [
                'opd_health_med_service' => [
                    'id' => '1',
                    'title' => 'OPD แพทย์แผนไทย',
                    'type' => 'OPD',
                    'key_word' => 'OPD Health Med Service Detail'
                ],
                'ipd_health_med_service' => [
                    'id' => '2',
                    'title' => 'IPD แพทย์แผนไทย',
                    'type' => 'IPD',
                    'key_word' => 'IPD Health Med Service Detail'
                ],
            ];            

            $health_med_service_log_data = [
                'function' => 'Come to the Health Med Service page',
                'username' => $data['loginname'],
                'command_sql' => '',
                'query_time' => '',
                'operation' => 'OPEN'
            ];
        
            // บันทึกข้อมูลลงใน HealthMedServiceLogModel
            HealthMedServiceLogModel::create($health_med_service_log_data);

            $startTime_1 = microtime(true);

            $query_1 = ModuleModel::where('module_name', 'Health Med Service');

            $healthMedServiceId = $query_1->first();
        
            // ดึง SQL query_1 พร้อม bindings
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $module_log_data = [
                'function' => 'Where module_name = Health Med Service',
                'username' => $data['loginname'],
                'command_sql' => $fullSql_1,
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            ModuleLogModel::create($module_log_data);

            if($healthMedServiceId->status_id === 1) {
                $startTime_2 = microtime(true);

                $query_2 = AccessibilityModel::where('accessibility_name', $data['groupname'])->where('module_id', $healthMedServiceId->id);
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

                if($accessibility_groupname_model !== null && $accessibility_groupname_model->status_id === 1 ) {
                    return view('pages.health_med_service', compact('data', 'year', 'health_med_service_data', 'fiscal_year'));
                } else {
                    $startTime_3 = microtime(true);

                    $query_3 = AccessibilityModel::where('accessibility_name', $data['name'])->where('module_id', $healthMedServiceId->id);
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

                    if($accessibility_name_model !== null && $accessibility_name_model->status_id === 1 ) {
                        return view('pages.health_med_service', compact('data', 'year', 'health_med_service_data', 'fiscal_year'));
                    } else {
                        $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบ แพทย์แผนไทย หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        // $request->session()->put('error', 'ขณะนี้ทางทีม IT มีการปรับปรุงระบบ ขออภัยในความไม่สะดวก!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบ แพทย์แผนไทย ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }
    // หน้าแรกของ Health Med Service Index Start

    // GetHealthMedServiceData Start
        public function getHealthMedServiceData(Request $request) {
            $year = $request->input('year');

            $years = $this->check_year($year);

            $response_year = $this->getYear($years['year_old'], $years['year_new'], $request);

            $chartDataYear = $this->getChartYear($response_year);

            return response()->json([
                'chartDataYear' => $chartDataYear
            ]);
        }
    // GetHealthMedServiceData End

    // GetHealthMedServiceDailyData Start
        public function getHealthMedServiceDailyData(Request $request) {
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

                $daily_count = DB::table('health_med_service')
                    ->select(DB::raw('DATE(service_date) as date'), DB::raw('COUNT(*) as count'))
                    ->whereBetween('service_date', [$start_date, $end_date])
                    ->groupBy(DB::raw('DATE(service_date)'))
                    ->orderBy('date')
                ;

                $health_med_service_count = $daily_count->get(); // ดึงข้อมูลออกมา

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
                $health_med_service_log_data = [
                    'function' => 'getHealthMedServiceDailyData',
                    'username' => $username,
                    'command_sql' => $fullSql, // SQL query ที่มีการแทนค่าจริง
                    'query_time' => $formattedExecutionTime,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน HealthMedServiceLogModel
                HealthMedServiceLogModel::create($health_med_service_log_data);

                $dates = [];
                $counts = [];
                foreach ($health_med_service_count as $data) {
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
                            'borderColor' => 'rgba(54, 162, 235, 3)',
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
    // GetHealthMedServiceDailyData End

    // GetHealthMedServiceSelectData Start
        public function getHealthMedServiceSelectData(Request $request) {
            try {
                $minDate = $request->min_date;
                $maxDate = $request->max_date;

                if ($minDate != $maxDate) {
                    $startTime = microtime(true);

                    $daily_count_query = DB::table('health_med_service')
                        ->select(DB::raw('DATE(service_date) as date'), DB::raw('COUNT(*) as count'))
                        ->whereBetween('service_date', [$minDate, $maxDate])
                        ->groupBy(DB::raw('DATE(service_date)'))
                        ->orderBy('date')
                    ;

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
                    $health_med_service_log_data = [
                        'function' => 'getHealthMedServiceSelectData',
                        'username' => $username,
                        'command_sql' => $fullSql, // SQL query ที่มีการแทนค่าจริง
                        'query_time' => $formattedExecutionTime,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน HealthMedServiceLogModel
                    HealthMedServiceLogModel::create($health_med_service_log_data);
                } else {
                    $startTime = microtime(true);

                    $daily_count_query = DB::table('health_med_service')
                        ->select(DB::raw('DATE(service_date) as date'), DB::raw('COUNT(*) as count'))
                        ->whereDate('service_date', $minDate)
                        ->groupBy(DB::raw('DATE(service_date)'))
                        ->orderBy('date')
                    ;
                    
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
                    $health_med_service_log_data = [
                        'function' => 'getHealthMedServiceSelectData',
                        'username' => $username,
                        'command_sql' => $fullSql, // SQL query ที่มีการแทนค่าจริง
                        'query_time' => $formattedExecutionTime,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน IptLogModel
                    HealthMedServiceLogModel::create($health_med_service_log_data);
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
    // GetHealthMedServiceSelectData End

    // CheckStatusHealthMedService Start
        public function checkStatusHealthMedService(Request $request) {
            $healthMedServiceName = $request->healthMedServiceName;

            $startTime = microtime(true);

            $query = ModuleModel::select('status_id')->where('module_name', '=', $healthMedServiceName);

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

            $health_med_service_log_data = [
                'function' => 'checkStatusWard',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            return response()->json($module_model);
        }
    // CheckStatusHealthMedService End

    // GetResultHealthMedService Start
        public function getResultHealthMedService(Request $request) {
            $healthMedServiceType = $request->healthMedServiceType;

            if($healthMedServiceType == 'OPD') {
                $startTime = microtime(true);

                $query = DB::table('health_med_service as hms')
                    ->whereDate('hms.service_date', Carbon::today())
                ; // ใช้ count โดยตรงแทนการใช้ select

                $count = $query->count('hms.vn');

                // ดึง SQL query พร้อมกับ bindings
                $sql = $query->toSql();
                $bindings = $query->getBindings();

                // แทนที่เครื่องหมาย `?` ด้วยค่าจริงที่ถูก bind
                $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

                $endTime = microtime(true);

                $executionTime = $endTime - $startTime;
                $formattedExecutionTime = number_format($executionTime, 3);

                $username = $this->someMethod($request);    

                $health_med_service_log_data = [
                    'function' => 'getResultHealthMedService',
                    'username' => $username,
                    'command_sql' => $fullSql,
                    'query_time' => $formattedExecutionTime,
                    'operation' => 'SELECT'
                ];

                HealthMedServiceLogModel::create($health_med_service_log_data);
        
                return response()->json([
                    'count' => $count, // ส่งค่า count กลับ
                    'healthMedServiceType' => $healthMedServiceType
                ]);
                
            } else if($healthMedServiceType == 'IPD') {
                $startTime = microtime(true);

                $query = DB::table('health_med_service as hms')
                    ->whereDate('hms.service_date', Carbon::today())
                ; // ใช้ count โดยตรงแทนการใช้ select

                $count = $query->count('hms.an');

                // ดึง SQL query พร้อมกับ bindings
                $sql = $query->toSql();
                $bindings = $query->getBindings();

                // แทนที่เครื่องหมาย `?` ด้วยค่าจริงที่ถูก bind
                $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

                $endTime = microtime(true);

                $executionTime = $endTime - $startTime;
                $formattedExecutionTime = number_format($executionTime, 3);

                $username = $this->someMethod($request);    

                $health_med_service_log_data = [
                    'function' => 'getResultHealthMedService',
                    'username' => $username,
                    'command_sql' => $fullSql,
                    'query_time' => $formattedExecutionTime,
                    'operation' => 'SELECT'
                ];

                HealthMedServiceLogModel::create($health_med_service_log_data);
        
                return response()->json([
                    'count' => $count, // ส่งค่า count กลับ
                    'healthMedServiceType' => $healthMedServiceType
                ]);
            }
        }
    // GetResultHealthMedService End

    // GetResultSexCountYears Start
        public function getResultSexCountYears(Request $request) {
            $year = $request->years;
            $years = $this->check_year($year);

            $startTime = microtime(true);

            $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
                ->select('s.name as sex', DB::raw('COUNT(*) as result'))
                ->leftJoin('patient as pt', 'hms.hn', '=', 'pt.hn')
                ->leftJoin('sex as s', 'pt.sex', '=', 's.code')
                // ->whereDate('hms.service_date', DB::raw('CURDATE()'))
                ->whereBetween('hms.service_date', [$years['year_old'].'-10-01', $years['year_new'].'-09-30'])
                ->groupBy('pt.sex');

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

            $health_med_service_log_data = [
                'function' => 'getResultSexCountYears',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_sex_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->sex . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลผู้มารับบริการแพทย์แผนไทยแยกเพศประจำปีบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultSexCountYears End

    // GetResultAgeCountYears Start
        public function getResultAgeCountYears(Request $request) {
            $year = $request->years;
            $years = $this->check_year($year);

            $startTime = microtime(true);

            $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
                ->select(DB::raw("
                    CASE 
                        WHEN vs.age_y IS NOT NULL AND vs.age_y = 30 THEN '0-30'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y BETWEEN 31 AND 40 THEN '31-40'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y BETWEEN 41 AND 50 THEN '41-50'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y BETWEEN 51 AND 60 THEN '51-60'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y >= 61 THEN '60 ปีขึ้นไป'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y = 30 THEN '0-30'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y BETWEEN 31 AND 40 THEN '31-40'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y BETWEEN 41 AND 50 THEN '41-50'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y BETWEEN 51 AND 60 THEN '51-60'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y >= 61 THEN '60 ปีขึ้นไป'
                        ELSE 'Other'
                    END AS age_group,
                    COUNT(*) as result
                "))
                ->leftJoin('patient as pt', 'hms.hn', '=', 'pt.hn')
                ->leftJoin('vn_stat as vs', 'hms.vn', '=', 'vs.vn')
                ->leftJoin('an_stat as ans', 'hms.an', '=', 'ans.an')
                // ->whereDate('hms.service_date', DB::raw('CURDATE()'))
                ->whereBetween('hms.service_date', [$years['year_old'].'-10-01', $years['year_new'].'-09-30'])
                ->groupBy('Age_Group');

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

            $health_med_service_log_data = [
                'function' => 'getResultAgeCountYears',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_age_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->age_group . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลผู้มารับบริการแพทย์แผนไทยช่วงอายุประจำปีบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultAgeCountYears End

    // GetResultPttypeCountYears Start
        public function getResultPttypeCountYears(Request $request) {
            $year = $request->years;
            $years = $this->check_year($year);

            $startTime = microtime(true);

            $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
                ->select(DB::raw("
                    CASE 
                        WHEN ptt1.name IS NOT NULL THEN ptt1.name
                        WHEN ptt2.name IS NOT NULL THEN ptt2.name
                        ELSE 'สิทธิ์ว่าง'
                    END AS pttype,
                    COUNT(*) as result
                "))
                ->leftJoin('ovst as o1', 'hms.an', '=', 'o1.an')
                ->leftJoin('ovst as o2', 'hms.vn', '=', 'o2.vn')
                ->leftJoin('pttype as ptt1', 'o1.pttype', '=', 'ptt1.pttype')
                ->leftJoin('pttype as ptt2', 'o2.pttype', '=', 'ptt2.pttype')
                ->whereBetween('hms.service_date', [$years['year_old'].'-10-01', $years['year_new'].'-09-30'])
                ->groupBy('o1.pttype', 'o2.pttype')
                ->orderBy('o1.pttype');

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

            $health_med_service_log_data = [
                'function' => 'getResultPttypeCountYears',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_pttype_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->pttype . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลผู้มารับบริการแพทย์แผนไทยช่วงอายุประจำปีบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultPttypeCountYears End

    // GetResultTreatmentSubtypeCountYears Start
        public function getResultTreatmentSubtypeCountYears(Request $request) {
            $year = $request->years;
            $years = $this->check_year($year);

            $startTime = microtime(true);

            $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
                ->select(DB::raw('hmts.health_med_treatment_subtype_name as treament_subtype_name'), DB::raw('COUNT(*) as result'))
                ->join('health_med_service_treatment as hmst', 'hms.health_med_service_id', '=', 'hmst.health_med_service_id')
                ->join('health_med_treatment_subtype as hmts', 'hmst.health_med_treatment_subtype_id', '=', 'hmts.health_med_treatment_subtype_id')
                ->whereBetween(DB::raw('hms.service_date'), [$years['year_old'].'-10-01', $years['year_new'].'-09-30'])
                ->groupBy(DB::raw('hmst.health_med_treatment_subtype_id'));

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

            $health_med_service_log_data = [
                'function' => 'getResultTreatmentSubtypeCountYears',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_treatment_subtype_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->treament_subtype_name . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลหัตถการแพทย์แผนไทยประจำปีบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultTreatmentSubtypeCountYears End

    // GetResultICD10CountYears Start
        public function getResultICD10CountYears(Request $request) {
            $year = $request->years;
            $years = $this->check_year($year);

            $startTime = microtime(true);

            $daily_count_query = DB::table('health_med_service as hms')
                ->join('ovstdiag as od', 'hms.vn', '=', 'od.vn', 'left')
                ->select('od.icd10', DB::raw('COUNT(*) as result'))
                ->whereBetween('hms.service_date', [$years['year_old'].'-10-01', $years['year_new'].'-09-30'])
                ->where('od.icd10', 'LIKE', 'U%')
                ->groupBy('od.icd10')
                ->orderBy('result', 'desc');

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

            $health_med_service_log_data = [
                'function' => 'getResultICD10CountYears',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_icd10_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->icd10 . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลรายการ ICD10 แพทย์แผนไทยประจำปีบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultICD10CountYears End

    // GetResultSexCountMonth Start
        public function getResultSexCountMonth(Request $request) {
            $year = $request->years;

            $month = $request->month;

            $month_int = $this->getMonthNumber($month);

            $startTime = microtime(true);

            // Query ที่ใช้การ concatenate string เพื่อเชื่อมตัวแปร $year
            $daily_count_query = $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
            ->select('s.name as sex', DB::raw('COUNT(*) as result'))
            ->leftJoin('patient as pt', 'hms.hn', '=', 'pt.hn')
            ->leftJoin('sex as s', 'pt.sex', '=', 's.code')
            ->where('hms.service_date', 'like', "$year-$month_int-%")
            ->groupBy('pt.sex');

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

            $health_med_service_log_data = [
                'function' => 'getResultSexCountMonth',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_sex_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->sex . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลผู้มารับบริการแพทย์แผนไทยแยกเพศประจำเดือนบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultSexCountMonth End

    // GetResultAgeCountMonth Start
        public function getResultAgeCountMonth(Request $request) {
            $year = $request->years;

            $month = $request->month;

            $month_int = $this->getMonthNumber($month);

            $startTime = microtime(true);

            // Query ที่ใช้การ concatenate string เพื่อเชื่อมตัวแปร $year
            $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
                ->select(DB::raw("
                    CASE 
                        WHEN vs.age_y IS NOT NULL AND vs.age_y = 30 THEN '0-30'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y BETWEEN 31 AND 40 THEN '31-40'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y BETWEEN 41 AND 50 THEN '41-50'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y BETWEEN 51 AND 60 THEN '51-60'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y >= 61 THEN '60 ปีขึ้นไป'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y = 30 THEN '0-30'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y BETWEEN 31 AND 40 THEN '31-40'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y BETWEEN 41 AND 50 THEN '41-50'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y BETWEEN 51 AND 60 THEN '51-60'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y >= 61 THEN '60 ปีขึ้นไป'
                        ELSE 'Other'
                    END AS age_group,
                    COUNT(*) as result
                "))
                ->leftJoin('patient as pt', 'hms.hn', '=', 'pt.hn')
                ->leftJoin('vn_stat as vs', 'hms.vn', '=', 'vs.vn')
                ->leftJoin('an_stat as ans', 'hms.an', '=', 'ans.an')
                ->where('hms.service_date', 'like', "$year-$month_int-%")
                ->groupBy('Age_Group');

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

            $health_med_service_log_data = [
                'function' => 'getResultAgeCountMonth',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_age_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->age_group . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลผู้มารับบริการแพทย์แผนไทยช่วงอายุประจำเดือนบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultAgeCountMonth End

    // GetResultPttypeCountMonth Start
        public function getResultPttypeCountMonth(Request $request) {
            $year = $request->years;

            $month = $request->month;

            $month_int = $this->getMonthNumber($month);

            $startTime = microtime(true);

            $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
                ->select(DB::raw("
                    CASE 
                        WHEN ptt1.name IS NOT NULL THEN ptt1.name
                        WHEN ptt2.name IS NOT NULL THEN ptt2.name
                        ELSE 'สิทธิ์ว่าง'
                    END AS pttype,
                    COUNT(*) as result
                "))
                ->leftJoin('ovst as o1', 'hms.an', '=', 'o1.an')
                ->leftJoin('ovst as o2', 'hms.vn', '=', 'o2.vn')
                ->leftJoin('pttype as ptt1', 'o1.pttype', '=', 'ptt1.pttype')
                ->leftJoin('pttype as ptt2', 'o2.pttype', '=', 'ptt2.pttype')
                ->where('hms.service_date', 'like', "$year-$month_int-%")
                ->groupBy('o1.pttype', 'o2.pttype')
                ->orderBy('o1.pttype');

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

            $health_med_service_log_data = [
                'function' => 'getResultPttypeCountMonth',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_pttype_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->pttype . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลผู้มารับบริการแพทย์แผนไทยช่วงอายุประจำเดือนบน Database!</h1>';
            }
            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultPttypeCountMonth End

    // GetResultTreatmentSubtypeCountMonth Start
        public function getResultTreatmentSubtypeCountMonth(Request $request) {
            $year = $request->years;

            $month = $request->month;

            $month_int = $this->getMonthNumber($month);

            $startTime = microtime(true);

            $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
                ->select(DB::raw('hmts.health_med_treatment_subtype_name as treament_subtype_name'), DB::raw('COUNT(*) as result'))
                ->join('health_med_service_treatment as hmst', 'hms.health_med_service_id', '=', 'hmst.health_med_service_id')
                ->join('health_med_treatment_subtype as hmts', 'hmst.health_med_treatment_subtype_id', '=', 'hmts.health_med_treatment_subtype_id')
                ->where('hms.service_date', 'like', "$year-$month_int-%")
                ->groupBy(DB::raw('hmst.health_med_treatment_subtype_id'));

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

            $health_med_service_log_data = [
                'function' => 'getResultTreatmentSubtypeCountMonth',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_treatment_subtype_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->treament_subtype_name . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลหัตถการแพทย์แผนไทยประจำเดือนบน Database!</h1>';
            }
            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultTreatmentSubtypeCountMonth End

    // GetResultICD10CountMonth Start
        public function getResultICD10CountMonth(Request $request) {
            $year = $request->years;

            $month = $request->month;

            $month_int = $this->getMonthNumber($month);

            $startTime = microtime(true);

            $daily_count_query = DB::table('health_med_service as hms')
                ->join('ovstdiag as od', 'hms.vn', '=', 'od.vn', 'left')
                ->select('od.icd10', DB::raw('COUNT(*) as result'))
                ->where('hms.service_date', 'like', "$year-$month_int-%")
                ->where('od.icd10', 'LIKE', 'U%')
                ->groupBy('od.icd10')
                ->orderBy('result', 'desc');

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

            $health_med_service_log_data = [
                'function' => 'getResultICD10CountMonth',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_icd10_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->icd10 . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลรายการ ICD10 แพทย์แผนไทยประจำเดือนบน Database!</h1>';
            }
            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultICD10CountMonth End

    // GetResultSexCountDate Start
        public function getResultSexCountDate(Request $request) {
            $date = $request->date;

            $startTime = microtime(true);

            $daily_count_query = $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
            ->select('s.name as sex', DB::raw('COUNT(*) as result'))
            ->join('patient as pt', 'hms.hn', '=', 'pt.hn')
            ->join('sex as s', 'pt.sex', '=', 's.code')
            ->where('hms.service_date', '=', "$date")
            ->groupBy('pt.sex');

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

            $health_med_service_log_data = [
                'function' => 'getResultSexCountDate',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_sex_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->sex . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลผู้มารับบริการแพทย์แผนไทยแยกเพศประจำวันบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultSexCountDate End

    // GetResultAgeCountDate Start
        public function getResultAgeCountDate(Request $request) {
            $date = $request->date;

            $startTime = microtime(true);

            $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
                ->select(DB::raw("
                    CASE 
                        WHEN vs.age_y IS NOT NULL AND vs.age_y = 30 THEN '0-30'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y BETWEEN 31 AND 40 THEN '31-40'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y BETWEEN 41 AND 50 THEN '41-50'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y BETWEEN 51 AND 60 THEN '51-60'
                        WHEN vs.age_y IS NOT NULL AND vs.age_y >= 61 THEN '60 ปีขึ้นไป'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y = 30 THEN '0-30'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y BETWEEN 31 AND 40 THEN '31-40'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y BETWEEN 41 AND 50 THEN '41-50'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y BETWEEN 51 AND 60 THEN '51-60'
                        WHEN ans.age_y IS NOT NULL AND ans.age_y >= 61 THEN '60 ปีขึ้นไป'
                        ELSE 'Other'
                    END AS age_group,
                    COUNT(*) as result
                "))
                ->leftJoin('patient as pt', 'hms.hn', '=', 'pt.hn')
                ->leftJoin('vn_stat as vs', 'hms.vn', '=', 'vs.vn')
                ->leftJoin('an_stat as ans', 'hms.an', '=', 'ans.an')
                ->where('hms.service_date', '=', "$date")
                ->groupBy('Age_Group');

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

            $health_med_service_log_data = [
                'function' => 'getResultAgeCountDate',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_age_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->age_group . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลผู้มารับบริการแพทย์แผนไทยช่วงอายุประจำวันบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultAgeCountDate End

    // GetResultPttypeCountDate Start
        public function getResultPttypeCountDate(Request $request) {
            $date = $request->date;

            $startTime = microtime(true);

            $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
                ->select(DB::raw("
                    CASE 
                        WHEN ptt1.name IS NOT NULL THEN ptt1.name
                        WHEN ptt2.name IS NOT NULL THEN ptt2.name
                        ELSE 'สิทธิ์ว่าง'
                    END AS pttype,
                    COUNT(*) as result
                "))
                ->leftJoin('ovst as o1', 'hms.an', '=', 'o1.an')
                ->leftJoin('ovst as o2', 'hms.vn', '=', 'o2.vn')
                ->leftJoin('pttype as ptt1', 'o1.pttype', '=', 'ptt1.pttype')
                ->leftJoin('pttype as ptt2', 'o2.pttype', '=', 'ptt2.pttype')
                ->where('hms.service_date', '=', "$date")
                ->groupBy('o1.pttype', 'o2.pttype')
                ->orderBy('o1.pttype');

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

            $health_med_service_log_data = [
                'function' => 'getResultPttypeCountDate',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_pttype_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->pttype . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลผู้มารับบริการแพทย์แผนไทยช่วงอายุประจำวันบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultPttypeCountDate End

    // GetResultTreatmentSubtypeCountDate Start
        public function getResultTreatmentSubtypeCountDate(Request $request) {
            $date = $request->date;

            $startTime = microtime(true);

            $daily_count_query = DB::connection('mysql')->table('health_med_service as hms')
                ->select(DB::raw('hmts.health_med_treatment_subtype_name as treament_subtype_name'), DB::raw('COUNT(*) as result'))
                ->join('health_med_service_treatment as hmst', 'hms.health_med_service_id', '=', 'hmst.health_med_service_id')
                ->join('health_med_treatment_subtype as hmts', 'hmst.health_med_treatment_subtype_id', '=', 'hmts.health_med_treatment_subtype_id')
                ->where('hms.service_date', '=', "$date")
                ->groupBy(DB::raw('hmst.health_med_treatment_subtype_id'));

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

            $health_med_service_log_data = [
                'function' => 'getResultTreatmentSubtypeCountDate',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_treatment_subtype_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->treament_subtype_name . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลหัตถการแพทย์แผนไทยประจำวันบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultTreatmentSubtypeCountDate End

    // GetResultICD10CountDate Start
        public function getResultICD10CountDate(Request $request) {
            $date = $request->date;

            $startTime = microtime(true);

            $daily_count_query = DB::table('health_med_service as hms')
                ->join('ovstdiag as od', 'hms.vn', '=', 'od.vn', 'left')
                ->select('od.icd10', DB::raw('COUNT(*) as result'))
                ->where('hms.service_date', '=', $date)
                ->where('od.icd10', 'LIKE', 'U%')
                ->groupBy('od.icd10')
                ->orderBy('result', 'desc');

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

            $health_med_service_log_data = [
                'function' => 'getResultTreatmentSubtypeCountDate',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];

            HealthMedServiceLogModel::create($health_med_service_log_data);

            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_icd10_count_table">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: auto;">รายการ</th>
                            <th style="width: auto;">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>';
                $id = 0;
                foreach ($daily_count as $dc) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td class="text-start">' . $dc->icd10 . '</td>
                        <td>' . $dc->result . '</td>
                    </tr>';
                }
                $output .= '</tbody></table>';
            } else {
                $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลรายการ ICD10 แพทย์แผนไทยประจำวันบน Database!</h1>';
            }

            // ส่งข้อมูล HTML กลับ
            return response($output);
        }
    // GetResultICD10CountDate End
}
