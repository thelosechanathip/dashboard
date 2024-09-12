<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Log\IptLogModel;

class IptController extends Controller
{
    private function someMethod(Request $request) {
        $data = $request->session()->all();
        $username = $request->session()->get('loginname');
        
        // ใช้งาน $username ต่อไปตามที่คุณต้องการ
        return $username;
    }

    // นำปีมาแก้ไขเพื่อนำไปใช้ในปีงบประมาณ Start
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
    // นำปีมาแก้ไขเพื่อนำไปใช้ในปีงบประมาณ End

    // นำปีงบประมาณที่ได้มาจัดหาเดือนที่ถูกต้อง Start
        private function getYear($year_old, $year_new) {
            // $startTime = microtime(true);

            // สร้าง Query ก่อนที่จะเรียกใช้ first()
            $query = DB::table('ipt')
                ->select(
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_old}-10-01' AND '{$year_old}-10-31' THEN 1 END) AS october"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_old}-11-01' AND '{$year_old}-11-30' THEN 1 END) AS november"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_old}-12-01' AND '{$year_old}-12-31' THEN 1 END) AS december"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-01-01' AND '{$year_new}-01-31' THEN 1 END) AS january"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-02-01' AND '{$year_new}-02-28' THEN 1 END) AS february"), // February มีได้สูงสุด 28 หรือ 29 วัน
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-03-01' AND '{$year_new}-03-31' THEN 1 END) AS march"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-04-01' AND '{$year_new}-04-30' THEN 1 END) AS april"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-05-01' AND '{$year_new}-05-31' THEN 1 END) AS may"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-06-01' AND '{$year_new}-06-30' THEN 1 END) AS june"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-07-01' AND '{$year_new}-07-31' THEN 1 END) AS july"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-08-01' AND '{$year_new}-08-31' THEN 1 END) AS august"),
                    DB::raw("COUNT(CASE WHEN regdate BETWEEN '{$year_new}-09-01' AND '{$year_new}-09-30' THEN 1 END) AS september")
                );

            $ovst_count = $query->first();

            // ดึง SQL ก่อนจะ execute query
            // $sql = $query->toSql();
            // $bindings = $query->getBindings();

            // ส่ง $request ไปให้ getUserLogin() เพื่อดึง username จาก session
            // $username = $this->getUserLogin($request);

            // Execute query
            // $ovst_count = $query->first();

            // แทนที่เครื่องหมาย `?` ด้วยค่าจริงที่ถูก bind
            // $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

            // $endTime = microtime(true);
            // $executionTime = $endTime - $startTime;
            // $formattedExecutionTime = number_format($executionTime, 3) . 's';

            // บันทึก log
            // $ipt_log_data = [
            //     'title' => 'getYear',
            //     'username' => $username,
            //     'command_sql' => $fullSql,
            //     'query_time' => $formattedExecutionTime,
            //     'operation' => 'SELECT'
            // ];
            return (array) $ovst_count;

            // if (IptLogModel::create($ipt_log_data)) {
            //     return (array) $ovst_count;
            // } else {
            //     echo "Error";
            // }
        }


    // นำปีงบประมาณที่ได้มาจัดหาเดือนที่ถูกต้อง End

    // นำเดือนมาสร้าง Chart Start
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
    // นำเดือนมาสร้าง Chart End

    // แปลงเดือนที่เป็น Text ไปเป็น Int Start
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
    // แปลงเดือนที่เป็น Text ไปเป็น Int End

    // แปลงเดือนที่เป็น Int ไปเป็น Text Start
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
    // แปลงเดือนที่เป็น Int ไปเป็น Text End

    // หน้าแรกของ IPT Start
        public function index(Request $request) {
            $data = $request->session()->all();
            $year = date('Y');

            return view('pages.ipt', compact('data', 'year'));
        }
    // หน้าแรกของ IPT End

    public function getIptData(Request $request) {
        $year = $request->input('year');

        $years = $this->check_year($year);

        $response_year = $this->getYear($years['year_old'], $years['year_new']);

        $chartDataYear = $this->getChartYear($response_year);

        return response()->json([
            'chartDataYear' => $chartDataYear
        ]);
    }

    public function getIptDailyData(Request $request) {
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

            $daily_count = DB::table('ipt')
                ->select(DB::raw('DATE(regdate) as date'), DB::raw('COUNT(*) as count'))
                ->whereBetween('regdate', [$start_date, $end_date])
                ->groupBy(DB::raw('DATE(regdate)'))
                ->orderBy('date')
                ->get();

            $dates = [];
            $counts = [];
            foreach ($daily_count as $data) {
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

    public function getIptNameDoctorData(Request $request) {
        try {
            $date = $request->input('date');

            // Validate the date input
            if (!$date || !strtotime($date)) {
                return response()->json(['error' => 'Invalid date format'], 400);
            }

            $daily_count = DB::connection('mysql')->select(
                "
                    SELECT
                        dt.name AS doctor_name,
                        COUNT(i.admdoctor) AS count_doctor_ipt
                    FROM ipt i
                    LEFT OUTER JOIN doctor dt ON i.admdoctor = dt.code
                    WHERE regdate = ?
                    GROUP BY i.admdoctor
                ",
                [$date]
            );

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

    public function getIptSelectData(Request $request) {
        try {
            $minDate = $request->min_date;
            $maxDate = $request->max_date;

            if ($minDate != $maxDate) {
                $daily_count = DB::table('ipt')
                    ->select(DB::raw('DATE(regdate) as date'), DB::raw('COUNT(*) as count'))
                    ->whereBetween('regdate', [$minDate, $maxDate])
                    // ->whereNull('dchdate')
                    ->groupBy(DB::raw('DATE(regdate)'))
                    ->orderBy('date')
                    ->get();
            } else {
                $daily_count = DB::table('ipt')
                    ->select(DB::raw('DATE(regdate) as date'), DB::raw('COUNT(*) as count'))
                    ->whereDate('regdate', $minDate)
                    // ->whereNull('dchdate')
                    ->groupBy(DB::raw('DATE(regdate)'))
                    ->orderBy('date')
                    ->get();
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

        if(IptLogModel::create($ipt_log_data)) {
            $output = '';
            if (count($daily_count) > 0) {
                $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_count_table">
                    <thead>
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
    }

    public function getResultCountMonthDoctor(Request $request) {
        $year = $request->years;
        $month = $request->month;

        $month_int = $this->getMonthNumber($month);

        // Query ที่ใช้การ concatenate string เพื่อเชื่อมตัวแปร $year
        $daily_count = DB::connection('mysql')->select(
            "
                SELECT
                    dt.name AS doctor_name,
                    COUNT(i.admdoctor) AS count_doctor_ipt
                FROM ipt i
                LEFT OUTER JOIN doctor dt ON i.admdoctor = dt.code
                WHERE regdate LIKE '$year-$month_int-%'
                GROUP BY i.admdoctor
            "
        );

        $output = '';
        if (count($daily_count) > 0) {
            $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_count_table">
                <thead>
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
            $output .= '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลของแพทย์ประจำเดือนบน Database!</h1>';
        }

        // ส่งข้อมูล HTML กลับ
        return response($output);
    }

    public function getResultCountDateDoctor(Request $request) {
        $date = $request->date;

        // Query ที่ใช้การ concatenate string เพื่อเชื่อมตัวแปร $year
        $daily_count = DB::connection('mysql')->select(
            "
                SELECT
                    dt.name AS doctor_name,
                    COUNT(i.admdoctor) AS count_doctor_ipt
                FROM ipt i
                LEFT OUTER JOIN doctor dt ON i.admdoctor = dt.code
                WHERE regdate = ' $date '
                GROUP BY i.admdoctor
            "
        );

        $output = '';
        if (count($daily_count) > 0) {
            $output .= '<table class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%" id="result_count_table">
                <thead>
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


}
