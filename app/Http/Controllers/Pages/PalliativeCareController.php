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

        $palliativeCareFetchListName = DB::table('vn_stat as vs')
        ->select(
            DB::raw('MAX(vs.vstdate) as vstdate'),
            'ptt.name as pttype_name',
            'vs.hn',
            'pt_all.cid',
            'pt_all.fullname',
            'pt_all.birthday',
            'pt_all.age',
            'pt_all.fulladdress',
            'pt_all.rpst_id',
            'pt_all.rpst_name',
            'vs.pdx',
            DB::raw("CASE
                        WHEN vs.pdx = 'Z515' OR vs.dx0 = 'Z515' OR vs.dx1 = 'Z515' OR vs.dx2 = 'Z515' OR vs.dx3 = 'Z515' OR vs.dx4 = 'Z515' OR vs.dx5 = 'Z515'
                        THEN 'Z515'
                        ELSE NULL
                    END AS Z515"),
            DB::raw("CASE
                        WHEN vs.pdx = 'Z718' OR vs.dx0 = 'Z718' OR vs.dx1 = 'Z718' OR vs.dx2 = 'Z718' OR vs.dx3 = 'Z718' OR vs.dx4 = 'Z718' OR vs.dx5 = 'Z718'
                        THEN 'Z718'
                        ELSE NULL
                    END AS Z718"),
            DB::raw("(SELECT COUNT(*)
                      FROM ovst_community_service a1
                      INNER JOIN vn_stat vn ON vn.vn = a1.vn
                      WHERE vn.hn = vs.hn
                      AND a1.ovst_community_service_type_id BETWEEN 1 AND 103) AS dayc"),
            DB::raw("(SELECT COUNT(*)
                      FROM ovst_community_service a1
                      INNER JOIN vn_stat vn ON vn.vn = a1.vn
                      INNER JOIN ovstdiag di ON di.vn = vn.vn
                      WHERE di.icd10 = 'Z718'
                      AND vn.hn = vs.hn
                      AND a1.ovst_community_service_type_id BETWEEN 1 AND 103) AS dayc1"),
            'pt_all.death',
            DB::raw("DATEDIFF(NOW(), (SELECT MAX(a1.entry_datetime)
                      FROM ovst_community_service a1
                      INNER JOIN vn_stat vn ON vn.vn = a1.vn
                      WHERE vn.hn = vs.hn
                      AND a1.ovst_community_service_type_id BETWEEN 1 AND 103)) AS daym"),
            DB::raw("(SELECT SUM(s.PallativeCare)
                      FROM rcmdb.repeclaim s
                      WHERE s.HN = vs.hn
                      AND s.PallativeCare > 0) AS money")
        )
        ->join(DB::raw("(SELECT pt.hn, pt.cid, CONCAT(pt.pname, pt.fname, ' ', pt.lname) AS fullname, pt.birthday,
                            (YEAR(CURRENT_DATE()) - YEAR(pt.birthday)) AS age,
                            CONCAT(pt.addrpart, ' หมู่ ', pt.moopart, ' ', ta.full_name) AS fulladdress,
                            pt.hcode, pt.death, zr.rpst_id, zrn.rpst_name
                        FROM patient pt
                        INNER JOIN thaiaddress ta ON CONCAT(pt.chwpart, pt.amppart, pt.tmbpart) = ta.addressid
                        INNER JOIN zbm_rpst zr ON ta.addressid = CONCAT(zr.chwpart, zr.amppart, zr.tmbpart)
                        INNER JOIN zbm_rpst_name zrn ON zr.rpst_id = zrn.rpst_id) as pt_all"),
            'vs.hn', '=', 'pt_all.hn')
        ->join('pttype as ptt', 'vs.pttype', '=', 'ptt.pttype')
        ->leftJoin('ovst_community_service as oc', function($join) {
            $join->on('oc.vn', '=', 'vs.vn')
                 ->whereBetween('oc.ovst_community_service_type_id', [1, 103]);
        })
        ->where(function($query) {
            $query->where('vs.pdx', 'Z515')
                  ->orWhere('vs.dx0', 'Z515')
                  ->orWhere('vs.dx1', 'Z515')
                  ->orWhere('vs.dx2', 'Z515')
                  ->orWhere('vs.dx3', 'Z515')
                  ->orWhere('vs.dx4', 'Z515')
                  ->orWhere('vs.dx5', 'Z515');
        })
        ->where('pt_all.rpst_id', '05532')
        ->whereBetween('vs.vstdate', ['2023-07-01', '2024-07-31'])
        ->groupBy('vs.hn')
        ->orderBy('vs.hn', 'DESC')
        ->get();

        $output = '';

        if ($palliativeCareFetchListName->isNotEmpty()) {
            $output .= '<table id="table-fetch-list-name" class="table table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead>
                <tr>
                    <th>วันที่รับบริการ</th>
                    <th>HN</th>
                    <th>ประเภทผู้ป่วย</th>
                    <th>ชื่อผู้ป่วย</th>
                    <th>เลขบัตรประชาชน</th>
                    <th>วันเกิด</th>
                    <th>อายุ</th>
                    <th>ที่อยู่</th>
                    <th>ชื่อเขต</th>
                    <th>สถานะเขต</th>
                    <th>วันตาย</th>
                    <th>ค่ายา</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($palliativeCareFetchListName as $pcfln) {
                $output .= '<tr>
                <td>' . $pcfln->vstdate . '</td>
                <td>' . $pcfln->hn . '</td>
                <td>' . $pcfln->pttype_name . '</td>
                <td>' . $pcfln->ptname . '</td>
                <td>' . $pcfln->cid . '</td>
                <td>' . $pcfln->birthday . '</td>
                <td>' . $pcfln->age . '</td>
                <td>' . $pcfln->addr . '</td>
                <td>' . $pcfln->rpst_name . '</td>
                <td>' . $pcfln->rpst_id . '</td>
                <td>' . $pcfln->dd1 . '</td>
                <td>' . $pcfln->money . '</td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">ไม่มีคนไข้ Palliative Care</h1>';
        }
    }
}
