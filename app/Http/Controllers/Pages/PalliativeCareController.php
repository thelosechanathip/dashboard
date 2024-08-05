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
        $min_date = $request->min_date;
        $max_date = $request->max_date;

        if($request->service_unit == 0) {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => 'กรุณาเลือกหน่วยบริการ',
                'icon' => 'error'
            ]);
        } else if($request->service_unit == 99999) {
            $service_unit = "";
        } else if($request->service_unit == 11111) {
            $service_unit = "AND pt_all.rpst_id NOT IN('11098', '05532', '05533', '05534', '05535', '05536', '05537', '05538', '05539', '05540', '05541', '13976')";
        } else {
            $service_unit = "AND pt_all.rpst_id = $request->service_unit";
        }

        if($request->death_type == 0) {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => 'กรุณาเลือกสถานะ',
                'icon' => 'error'
            ]);
        } else if($request->death_type == 99999) {
            $death_type = "";
        } else {
            $death_type = "AND pt_all.death = '{$request->death_type}'";
        }

        $palliativeCareFetchListName = DB::connection('mysql')->select(
            "
                SELECT
                    vs.vstdate,
                    ptt.name as pttype_name,
                    vs.hn,
                    pt_all.cid,
                    pt_all.fullname,
                    pt_all.birthday,
                    pt_all.age,
                    pt_all.fulladdress,
                    pt_all.rpst_id,
                    pt_all.rpst_name,
                    vs.pdx,
                    CASE
                        WHEN vs.pdx = 'Z515' OR vs.dx0 = 'Z515' OR vs.dx1 = 'Z515' OR vs.dx2 = 'Z515' OR vs.dx3 = 'Z515' OR vs.dx4 = 'Z515' OR vs.dx5 = 'Z515'
                        THEN 'Z515'
                        ELSE NULL
                    END AS Z515,
                    CASE
                        WHEN vs.pdx = 'Z718' OR vs.dx0 = 'Z718' OR vs.dx1 = 'Z718' OR vs.dx2 = 'Z718' OR vs.dx3 = 'Z718' OR vs.dx4 = 'Z718' OR vs.dx5 = 'Z718'
                        THEN 'Z718'
                        ELSE NULL
                    END AS Z718,
                    (SELECT COUNT(*)
                        FROM ovst_community_service a1
                        INNER JOIN vn_stat vn ON vn.vn = a1.vn
                        WHERE vn.hn = vs.hn
                        AND a1.ovst_community_service_type_id BETWEEN 1 AND 103) AS dayc,
                    (SELECT COUNT(*)
                        FROM ovst_community_service a1
                        INNER JOIN vn_stat vn ON vn.vn = a1.vn
                        INNER JOIN ovstdiag di ON di.vn = vn.vn
                        WHERE di.icd10 = 'Z718'
                        AND vn.hn = vs.hn
                        AND a1.ovst_community_service_type_id BETWEEN 1 AND 103) AS dayc1,
                    pt_all.death,
                    DATEDIFF(NOW(), (SELECT MAX(a1.entry_datetime)
                        FROM ovst_community_service a1
                        INNER JOIN vn_stat vn ON vn.vn = a1.vn
                        WHERE vn.hn = vs.hn
                        AND a1.ovst_community_service_type_id BETWEEN 1 AND 103)) AS daym,
                    (SELECT SUM(s.PallativeCare)
                        FROM rcmdb.repeclaim s
                        WHERE s.HN = vs.hn
                        AND s.PallativeCare > 0) AS money
                FROM (
                    SELECT
                        vs.vstdate,
                        vs.hn,
                        vs.vn,
                        vs.pdx,
                        vs.dx0,
                        vs.dx1,
                        vs.dx2,
                        vs.dx3,
                        vs.dx4,
                        vs.dx5,
                        vs.pttype
                    FROM vn_stat vs
                    WHERE vs.vstdate BETWEEN '{$min_date}' AND '{$max_date}'
                ) AS vs
                INNER JOIN (
                    SELECT pt.hn, pt.cid, CONCAT(pt.pname, pt.fname, ' ', pt.lname) AS fullname, pt.birthday,
                        (YEAR(CURRENT_DATE()) - YEAR(pt.birthday)) AS age,
                        CONCAT(pt.addrpart, ' หมู่ ', pt.moopart, ' ', ta.full_name) AS fulladdress,
                        pt.hcode, pt.death, zr.rpst_id, zrn.rpst_name
                    FROM patient pt
                    INNER JOIN thaiaddress ta ON CONCAT(pt.chwpart, pt.amppart, pt.tmbpart) = ta.addressid
                    INNER JOIN zbm_rpst zr ON CONCAT(pt.chwpart, pt.amppart, pt.tmbpart, pt.moopart) = CONCAT(zr.chwpart, zr.amppart, zr.tmbpart, zr.moopart)
                    INNER JOIN zbm_rpst_name zrn ON zr.rpst_id = zrn.rpst_id
                ) as pt_all ON vs.hn = pt_all.hn
                INNER JOIN pttype as ptt ON vs.pttype = ptt.pttype
                LEFT JOIN ovst_community_service as oc ON oc.vn = vs.vn AND oc.ovst_community_service_type_id BETWEEN 1 AND 103
                WHERE (vs.pdx = 'Z515' OR vs.dx0 = 'Z515' OR vs.dx1 = 'Z515' OR vs.dx2 = 'Z515' OR vs.dx3 = 'Z515' OR vs.dx4 = 'Z515' OR vs.dx5 = 'Z515')
                {$service_unit}
                {$death_type}
                GROUP BY vs.hn
                ORDER BY vs.vn DESC
            "
        );

        $output = '';

        if (count($palliativeCareFetchListName) > 0) {
            $output .= '<table id="table-fetch-list-name" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
            <thead>
                <tr>
                    <th>วันที่รับบริการ</th>
                    <th>สิทธิ์</th>
                    <th>HN</th>
                    <th>ชื่อ - สกุล</th>
                    <th>เลขบัตรประชาชน</th>
                    <th>วันเกิด</th>
                    <th>อายุ</th>
                    <th>ที่อยู่</th>
                    <th>รพสต</th>
                    <th>รหัส PDX</th>
                    <th>เยี่ยมบ้าน<br>Z718</th>
                    <th>เยี่ยมบ้าน<br>รพ.(ครั้ง)</th>
                    <th>ชดเชย</th>
                    <th>หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($palliativeCareFetchListName as $pcfln) {
                if ($pcfln->death == 'Y') {
                    $class = 'table-danger';
                    $bgColor = "";
                    $deathMessage = 'คนไข้เสียชีวิตแล้ว';
                } else {
                    $class = 'table-light';
                    $bgColor = "";
                    $deathMessage = 'คนไข้ยังมีชีวิตอยู่';
                    if($pcfln->daym < 30) {
                        $class = 'table-success';
                        $deathMessage = '<span class="">เยี่ยม ' . $pcfln->daym . ' วันที่แล้ว</span>';
                    } else if($pcfln->daym < 60) {
                        $class = 'table-primary';
                        $deathMessage = '<span class="">เยี่ยม 1 เดือนที่แล้ว</span>';
                    } else if($pcfln->daym < 90) {
                        $class = 'table-primary';
                        $deathMessage = '<span class="">เยี่ยม 2 เดือนที่แล้ว</span>';
                    } else if($pcfln->daym < 120) {
                        $class = 'table-warning';
                        $deathMessage = '<span class="">เยี่ยม 3 เดือนที่แล้ว</span>';
                    } else if($pcfln->daym < 210) {
                        $class = 'table-warning';
                        $deathMessage = '<span class="">เยี่ยม 6 เดือนที่แล้ว</span>';
                    } else if($pcfln->daym < 420) {
                        $class = 'table-danger';
                        $deathMessage = '<span class="">เยี่ยม 1 ปีที่แล้ว</span>';
                    } else {
                        $class = '';
                        $deathMessage = '<span class="">เยี่ยมมากกว่า 1 ปี</span>';
                    }
                }

                $output .= '<tr class="' . $class . '">
                <td>' . $pcfln->vstdate . '</td>
                <td>' . $pcfln->pttype_name . '</td>
                <td>' . $pcfln->hn . '</td>
                <td>' . $pcfln->fullname . '</td>
                <td>' . $pcfln->cid . '</td>
                <td>' . $pcfln->birthday . '</td>
                <td>' . $pcfln->age . '</td>
                <td>' . $pcfln->fulladdress . '</td>
                <td>' . $pcfln->rpst_name . '</td>
                <td>' . $pcfln->pdx . '</td>
                <td>' . $pcfln->dayc . '</td>
                <td>' . $pcfln->dayc1 . '</td>
                <td>' . $pcfln->money . '</td>
                <td class="' . $bgColor . '">' . $deathMessage . '</td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลคนไข้ Palliative Care ในรายการที่เลือก</h1>';
        }
    }
}
