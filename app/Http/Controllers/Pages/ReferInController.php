<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// ดึง Database เข้ามายัง Controller Start
use Illuminate\Support\Facades\DB;
// ดึง Database เข้ามายัง Controller End

class ReferInController extends Controller
{
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

    private function getYear($year_old, $year_new) {
        // Query table : referin และ COUNT ค่าออกมาแสดง Start
        $ovst_count = DB::table('referin')
            ->select(
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_old}-10-01' AND '{$year_old}-10-31' THEN 1 END) AS october"),
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_old}-11-01' AND '{$year_old}-11-30' THEN 1 END) AS november"),
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_old}-12-01' AND '{$year_old}-12-31' THEN 1 END) AS december"),
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_new}-01-01' AND '{$year_new}-01-31' THEN 1 END) AS january"),
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_new}-02-01' AND '{$year_new}-02-31' THEN 1 END) AS february"),
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_new}-03-01' AND '{$year_new}-03-31' THEN 1 END) AS march"),
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_new}-04-01' AND '{$year_new}-04-30' THEN 1 END) AS april"),
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_new}-05-01' AND '{$year_new}-05-31' THEN 1 END) AS may"),
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_new}-06-01' AND '{$year_new}-06-30' THEN 1 END) AS june"),
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_new}-07-01' AND '{$year_new}-07-31' THEN 1 END) AS july"),
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_new}-08-01' AND '{$year_new}-08-31' THEN 1 END) AS august"),
                DB::raw("COUNT(CASE WHEN refer_date BETWEEN '{$year_new}-09-01' AND '{$year_new}-09-30' THEN 1 END) AS september")
            )
            ->first();
        // Query table : referin และ COUNT ค่าออกมาแสดง End

        // ส่งค่าออกไปพร้อมกับตัวแปรที่เก็บ Array Sart
        return (array) $ovst_count;
        // ส่งค่าออกไปพร้อมกับตัวแปรที่เก็บ Array End
    }

    private function getChartYear($response) {
        $chartDataYear = [
            'labels' => ['ตุลาคม', 'พฤศจิกายน', 'ธันวาคม', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน'],
            'datasets' => [
                [
                    'label' => 'จำนวน Refer In',
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

    public function index(Request $request) {
        $data = $request->session()->all();
        $year = date('Y');

        return view('pages.referin', compact('data', 'year'));
    }

    public function getReferInData(Request $request) {
        $year = $request->input('year');

        $years = $this->check_year($year);

        $response_year = $this->getYear($years['year_old'], $years['year_new']);

        $chartDataYear = $this->getChartYear($response_year);

        return response()->json([
            'chartDataYear' => $chartDataYear
        ]);
    }

    public function getReferInDailyData(Request $request) {
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

            $daily_count = DB::table('referin')
                ->select(DB::raw('DATE(refer_date) as date'), DB::raw('COUNT(*) as count'))
                ->whereBetween('refer_date', [$start_date, $end_date])
                ->groupBy(DB::raw('DATE(refer_date)'))
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
                        'label' => 'จำนวน Refer In รายวัน',
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

    public function getReferInSelectData(Request $request) {
        try {
            $minDate = $request->min_date;
            $maxDate = $request->max_date;

            if ($minDate != $maxDate) {
                $daily_count = DB::table('referin')
                    ->select(DB::raw('DATE(refer_date) as date'), DB::raw('COUNT(*) as count'))
                    ->whereBetween('refer_date', [$minDate, $maxDate])
                    ->groupBy(DB::raw('DATE(refer_date)'))
                    ->orderBy('date')
                    ->get();
            } else {
                $daily_count = DB::table('referin')
                    ->select(DB::raw('DATE(refer_date) as date'), DB::raw('COUNT(*) as count'))
                    ->whereDate('refer_date', $minDate)
                    ->groupBy(DB::raw('DATE(refer_date)'))
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
                            'label' => 'จำนวน Refer In',
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

}
