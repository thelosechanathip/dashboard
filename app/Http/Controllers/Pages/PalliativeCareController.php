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
            ]
        ];
        return $chart_count_death;
    }

    public function index(Request $request) {
        $data = $request->session()->all();

        return view('pages.palliativeCare', compact('data'));
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
}
