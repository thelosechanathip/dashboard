<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class PalliativeCareController extends Controller
{
    private function getChartCountDeath($summarize_count_death) {
        $count_death = [];
        $death_name = [];
        foreach ($summarize_count_death as $data) {
            $count_death[] = $data->kk;
            $death_name[] = $data->pdx;
        }

        $chart_count_death = [
            'labels' => $death_name,
            'datasets' => [
                [
                    'label' => 'จำนวนผู้เสียชีวิตใน Palliative Care แยกตาม Diag',
                    'data' => $count_death,
                    'backgroundColor' => 'rgba(54, 162, 235, 1)',
                    'borderColor' => 'rgba(54, 162, 235, 3)',
                    'borderWidth' => 1
                ]
            ],
            'options' => [
                'plugins' => [
                    'datalabels' => [
                        'anchor' => 'end',
                        'align' => 'top',
                        'color' => 'black',
                        'font' => [
                            'weight' => 'bold'
                        ],
                        'formatter' => 'function(value, context) { return value; }'
                    ]
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ];
        return $chart_count_death;
    }

    public function index(Request $request) {
        $data = $request->session()->all();

        $zbm_rpst_name = DB::connection('mysql')->select(
            "
                SELECT
                    rpst_id,
                    rpst_name
                FROM zbm_rpst_name
                WHERE
                    rpst_id IN('11098', '05532', '05533', '05534', '05535', '05536', '05537', '05538', '05539', '05540', '05541', '13976', '00000')
            "
        );

        return view('pages.palliativeCare', compact('data', 'zbm_rpst_name'));
    }

    public function getPalliativeCareSelectData(Request $request) {
        if($request->all() === null) {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => 'กรุณากรอกวันที่ ที่ต้องการดูข้อมูลด้วยครับ',
                'icon' => 'error'
            ]);
        } else {
            $summarize_count_death = DB::connection('mysql')->select(
                "
                    SELECT
                        COUNT(DISTINCT ov.hn) as kk,
                        ov.pdx
                    FROM vn_stat ov
                    LEFT JOIN ovst_community_service oc ON oc.vn=ov.vn AND oc.ovst_community_service_type_id BETWEEN 1 AND 103
                    LEFT JOIN patient pt ON pt.hn=ov.hn
                    LEFT JOIN thaiaddress th ON th.addressid = CONCAT(pt.chwpart,pt.amppart,pt.tmbpart)
                    LEFT JOIN zbm_rpst zr ON zr.chwpart=pt.chwpart AND zr.amppart=pt.amppart AND zr.tmbpart=pt.tmbpart AND zr.moopart=pt.moopart
                    LEFT JOIN zbm_rpst_name zn ON zn.rpst_id=zr.rpst_id
                    WHERE (ov.pdx ='Z515' OR ov.dx0 ='Z515' OR ov.dx1 ='Z515' OR ov.dx2 ='Z515' OR ov.dx3 ='Z515' OR ov.dx4 ='Z515' OR ov.dx5 ='Z515')
                    AND ov.vstdate BETWEEN ? AND ?
                    AND pt.death ='Y'
                    GROUP BY ov.pdx
                ",
                [$request->min_date, $request->max_date]
            );

            if($summarize_count_death > 0) {
                $chart_count_death = $this->getChartCountDeath($summarize_count_death);

                return response()->json([
                    'status' => 200,
                    'chart_count_death' => $chart_count_death
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'ไม่มีข้อมูลถูกส่งไป',
                    'icon' => 'error'
                ]);
            }
        }
    }

    public function getPalliativeCareFetchListName(Request $request) {
        // $min_date = $request->min_date;
        // $max_date = $request->max_date;

        // if ($request->service_unit == '99999') {
        //     $service_unit = "";
        // } else if ($request->service_unit == '00000') {
        //     $service_unit = "NOT IN('11098', '05532', '05533', '05534', '05535', '05536', '05537', '05538', '05539', '05540', '05541', '13976', '00000')";
        // } else {
        //     $service_unit = "= '{$request->service_unit}'";
        // }

        // if ($request->death_type == '99999') {
        //     $death_type = "";
        // } else {
        //     $death_type = "= '{$request->death_type}'";
        // }

        $min_date = $request->min_date;
        $max_date = $request->max_date;

        $palliativeCareFetchListName = DB::connection('mysql')->select(
            "
                SELECT
                    hn,
                    vn,
                    vstdate
                FROM ovst
                WHERE vstdate BETWEEN ? AND ?
            ",
            [$min_date, $max_date]
        );

        // $palliativeCareFetchListName = DB::connection('mysql')->select(
        //     "
        //         SELECT
        //             MAX(ov.vstdate) AS vstdate,
        //             ANY_VALUE(pp.name) AS name,
        //             ov.hn,
        //             pt.cid,
        //             CONCAT(pt.pname, pt.fname, ' ', pt.lname) AS ptname,
        //             pt.birthday,
        //             (YEAR(NOW()) - YEAR(pt.birthday)) AS age,
        //             CONCAT(pt.addrpart, ' หมู่ ', pt.moopart, ' ', th.full_name) AS addr,
        //             ANY_VALUE(zn.rpst_name) AS rpst_name,
        //             ANY_VALUE(zn.rpst_id) AS rpst_id,
        //             (SELECT vn.pdx FROM vn_stat vn WHERE vn.vn = ov.vn) AS C,
        //             IF(ov.pdx = 'Z515' OR ov.dx0 = 'Z515' OR ov.dx1 = 'Z515' OR ov.dx2 = 'Z515' OR ov.dx3 = 'Z515' OR ov.dx4 = 'Z515' OR ov.dx5 = 'Z515', 'Z515', NULL) AS Z,
        //             IF(ov.pdx = 'Z718' OR ov.dx0 = 'Z718' OR ov.dx1 = 'Z718' OR ov.dx2 = 'Z718' OR ov.dx3 = 'Z718' OR ov.dx4 = 'Z718' OR ov.dx5 = 'Z718', 'Z718', NULL) AS Z718,
        //             IF(ISNULL(pt.death) OR pt.death = '', 'N', pt.death) AS death,
        //             (
        //                 SELECT COUNT(*)
        //                 FROM ovst_community_service a1
        //                 INNER JOIN vn_stat vn ON vn.vn = a1.vn
        //                 WHERE vn.hn = ov.hn
        //                 AND a1.ovst_community_service_type_id BETWEEN 1 AND 103
        //             ) AS dayc,
        //             (
        //                 SELECT COUNT(*)
        //                 FROM ovst_community_service a1
        //                 INNER JOIN vn_stat vn ON vn.vn = a1.vn
        //                 INNER JOIN ovstdiag di ON di.vn = vn.vn
        //                 WHERE di.icd10 = 'Z718'
        //                 AND vn.hn = ov.hn
        //                 AND a1.ovst_community_service_type_id BETWEEN 1 AND 103
        //             ) AS dayc1,
        //             palliative.up.date AS dd1,
        //             DATEDIFF(NOW(), (
        //                 SELECT MAX(a1.entry_datetime)
        //                 FROM ovst_community_service a1
        //                 INNER JOIN vn_stat vn ON vn.vn = a1.vn
        //                 WHERE vn.hn = ov.hn
        //                 AND a1.ovst_community_service_type_id BETWEEN 1 AND 103
        //             )) AS daym,
        //             (
        //                 SELECT SUM(s.PallativeCare)
        //                 FROM rcmdb.repeclaim s
        //                 WHERE s.HN = ov.hn
        //                 AND s.PallativeCare > 0
        //             ) AS money
        //         FROM vn_stat ov
        //         LEFT JOIN pttype pp ON pp.pttype = ov.pttype
        //         LEFT JOIN ovst_community_service oc ON oc.vn = ov.vn AND oc.ovst_community_service_type_id BETWEEN 1 AND 103
        //         LEFT JOIN patient pt ON pt.hn = ov.hn
        //         LEFT JOIN palliative.uploads up ON up.cid = pt.cid
        //         LEFT JOIN thaiaddress th ON th.addressid = CONCAT(pt.chwpart, pt.amppart, pt.tmbpart)
        //         LEFT JOIN zbm_rpst zr ON zr.chwpart = pt.chwpart AND zr.amppart = pt.amppart AND zr.tmbpart = pt.tmbpart AND zr.moopart = pt.moopart
        //         LEFT JOIN zbm_rpst_name zn ON zn.rpst_id = zr.rpst_id
        //         WHERE pt.death {$death_type}
        //         AND (ov.pdx = 'Z515' OR ov.dx0 = 'Z515' OR ov.dx1 = 'Z515' OR ov.dx2 = 'Z515' OR ov.dx3 = 'Z515' OR ov.dx4 = 'Z515' OR ov.dx5 = 'Z515')
        //         AND ov.vstdate BETWEEN {$min_date} AND {$max_date}
        //         AND zr.rpst_id {$service_unit}
        //         GROUP BY ov.hn
        //         ORDER BY ov.vstdate DESC;
        //     "
        // );

        // // ตรวจสอบผลลัพธ์ของ query
        // if (empty($palliativeCareFetchListName)) {
        //     Log::info('No data found for the given criteria.');
        // } else {
        //     Log::info('Data retrieved successfully.');
        // }

        $output = '';

        if (count($palliativeCareFetchListName) > 0) {
            $output .= '<table id="table-fetch-list-name" class="table table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead>
              <tr>
                <th>VN</th>
                <th>HN</th>
                <th>วันที่รับบริการ</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($palliativeCareFetchListName as $pcfln) {
                $output .= '<tr>
                <td>' . $pcfln->vn . '</td>
                <td>' . $pcfln->hn . '</td>
                <td>' . $pcfln->vstdate . '</td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">ไม่มีคนไข้ Palliative Care</h1>';
        }
    }


}
