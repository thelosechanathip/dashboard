<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class PalliativeCareController extends Controller
{
    private function queryEclaimReceivedMoney() {
        $rcmdb_repeclaim = DB::connection('mysql')->select(
            "
                SELECT * ,SUBSTRING(FileName ,19,6)AS dd FROM rcmdb.repeclaim WHERE PallativeCare>0 ORDER BY Rep DESC
            "
        );

        return (array) $rcmdb_repeclaim;
    }

    private function SePPS($hpi) {
        if (strpos($hpi, 'PPS = 10 %') || strpos($hpi, '10%') || strpos($hpi, '10 %')) $rss="PPS=10%";
        else if (strpos($hpi, 'PPS = 20 %') || strpos($hpi, '20%') || strpos($hpi, '20 %')) $rss="PPS=20%";
        else if (strpos($hpi, 'PPS = 30 %') || strpos($hpi, '30%') || strpos($hpi, '30 %')) $rss="PPS=30%";
        else if (strpos($hpi, 'PPS = 40 %') || strpos($hpi, '40%') || strpos($hpi, '40 %')) $rss="PPS=40%";
        else if (strpos($hpi, 'PPS = 50 %') || strpos($hpi, '50%') || strpos($hpi, '50 %')) $rss="PPS=50%";
        else if (strpos($hpi, 'PPS = 60 %') || strpos($hpi, '60%') || strpos($hpi, '60 %')) $rss="PPS=60%";
        else if (strpos($hpi, 'PPS = 70 %') || strpos($hpi, '70%') || strpos($hpi, '70 %')) $rss="PPS=70%";
        else if (strpos($hpi, 'PPS = 80 %') || strpos($hpi, '80%') || strpos($hpi, '80 %')) $rss="PPS=80%";
        else if (strpos($hpi, 'PPS = 90 %') || strpos($hpi, '90%') || strpos($hpi, '90 %')) $rss="PPS=90%";
        else $rss="PPS= -";
        return $rss;
    }

    private function SePS($hpi) {
        if (strpos($hpi, 'PS = 1/10') || strpos($hpi, '1/10')) $rss="PS=1/10";
        else if (strpos($hpi, 'PS = 2/10') || strpos($hpi, '2/10')) $rss="PS=2/10";
        else if (strpos($hpi, 'PS = 3/10') || strpos($hpi, '3/10')) $rss="PS=3/10";
        else if (strpos($hpi, 'PS = 4/10') || strpos($hpi, '4/10')) $rss="PS=4/10";
        else if (strpos($hpi, 'PS = 5/10') || strpos($hpi, '5/10')) $rss="PS=5/10";
        else if (strpos($hpi, 'PS = 6/10') || strpos($hpi, '6/10')) $rss="PS=6/10";
        else if (strpos($hpi, 'PS = 7/10') || strpos($hpi, '7/10')) $rss="PS=7/10";
        else if (strpos($hpi, 'PS = 8/10') || strpos($hpi, '8/10')) $rss="PS=8/10";
        else if (strpos($hpi, 'PS = 9/10') || strpos($hpi, '9/10')) $rss="PS=9/10";
        else $rss="PS= -";
        return $rss;
    }

    private function SeBed($hpi) {
        if (strpos($hpi, 'เตียง1') || strpos($hpi, 'เตียง 1') || strpos($hpi, 'เตียง=1') || strpos($hpi, 'เตียง = 1') || strpos($hpi, 'เตียง= 1') || strpos($hpi, 'เตียง =1')) $rss="เตียง 1";
        else if (strpos($hpi, 'เตียง2') || strpos($hpi, 'เตียง 2') || strpos($hpi, 'เตียง=2') || strpos($hpi, 'เตียง = 2') || strpos($hpi, 'เตียง= 2') || strpos($hpi, 'เตียง =2')) $rss="เตียง 2";
        else if (strpos($hpi, 'เตียง3') || strpos($hpi, 'เตียง 3') || strpos($hpi, 'เตียง=3') || strpos($hpi, 'เตียง = 3') || strpos($hpi, 'เตียง= 3') || strpos($hpi, 'เตียง =3')) $rss="เตียง 3";
        else if (strpos($hpi, 'เตียง4') || strpos($hpi, 'เตียง 4') || strpos($hpi, 'เตียง=4') || strpos($hpi, 'เตียง = 4') || strpos($hpi, 'เตียง= 4') || strpos($hpi, 'เตียง =4')) $rss="เตียง 4";
        else $rss="เตียง= -";
        return $rss;
    }

    private function SeBi($hpi) {
        for($i=100;$i>=0;$i--){
            if (strpos(strtolower($hpi), 'bi'.$i) || strpos(strtolower($hpi), 'bi '.$i) || strpos(strtolower($hpi), 'bi  '.$i) || strpos(strtolower($hpi), 'bi='.$i) || strpos(strtolower($hpi), 'bi = '.$i) || strpos(strtolower($hpi), 'bi= '.$i) || strpos(strtolower($hpi), 'bi ='.$i))
            {
                $ress="BI = ".$i;

                 break;
            }
            else $ress="BI = -";
        }

        return $ress;
    }

    private function DateThai($strDate) {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

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
        if($request->min_date == 0 || $request->max_date == 0) {
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

        if($min_date == 0 || $max_date == 0) {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => 'กรุณาเลือกวันที่รับบริการ',
                'icon' => 'error'
            ]);
        }

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
            $service_unit = "AND vs.hospsub NOT IN('11098', '05532', '05533', '05534', '05535', '05536', '05537', '05538', '05539', '05540', '05541', '13976')";
        } else {
            $service_unit = "AND vs.hospsub = '{$request->service_unit}'";
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
                    ptt.name AS 'pttype_name',
                    vs.hn,
                    pt_all.cid,
                    pt_all.fullname,
                    pt_all.birthday,
                    pt_all.age,
                    pt_all.fulladdress,
                    zrn.rpst_id,
                    zrn.rpst_name,
                    vs.pdx,
                    CASE
                        WHEN vs.pdx = 'Z515'
                            OR vs.dx0 = 'Z515'
                            OR vs.dx1 = 'Z515'
                            OR vs.dx2 = 'Z515'
                            OR vs.dx3 = 'Z515'
                            OR vs.dx4 = 'Z515'
                            OR vs.dx5 = 'Z515'
                        THEN 'Z515'
                        ELSE NULL
                    END AS Z515,
                    CASE
                        WHEN vs.pdx = 'Z718'
                            OR vs.dx0 = 'Z718'
                            OR vs.dx1 = 'Z718'
                            OR vs.dx2 = 'Z718'
                            OR vs.dx3 = 'Z718'
                            OR vs.dx4 = 'Z718'
                            OR vs.dx5 = 'Z718'
                        THEN 'Z718'
                        ELSE NULL
                    END AS Z718,
                    (
                        SELECT COUNT(*)
                        FROM ovst_community_service a1
                        INNER JOIN vn_stat vn ON vn.vn = a1.vn
                        WHERE vn.hn = vs.hn
                        AND a1.ovst_community_service_type_id BETWEEN 1 AND 103
                    ) AS dayc,
                    (
                        SELECT COUNT(*)
                        FROM ovst_community_service a1
                        INNER JOIN vn_stat vn ON vn.vn = a1.vn
                        INNER JOIN ovstdiag di ON di.vn = vn.vn
                        WHERE di.icd10 = 'Z718'
                        AND vn.hn = vs.hn
                        AND a1.ovst_community_service_type_id BETWEEN 1 AND 103
                    ) AS dayc1,
                    pt_all.death,
                    DATEDIFF(NOW(), (
                        SELECT MAX(a1.entry_datetime)
                        FROM ovst_community_service a1
                        INNER JOIN vn_stat vn ON vn.vn = a1.vn
                        WHERE vn.hn = vs.hn
                        AND a1.ovst_community_service_type_id BETWEEN 1 AND 103
                    )) AS daym
                    ,(SELECT COUNT(r.REP) FROM eclaimdb.m_registerdata r LEFT JOIN eclaimdb.m_ppcom p ON p.ECLAIM_NO=r.ECLAIM_NO WHERE NOT ISNULL(p.ECLAIM_NO) AND p.GR_ITEMNAME='3 Palliative Care' AND r.HN=vs.hn) AS ec
                    ,(
                        SELECT SUM(s.PallativeCare)
                        FROM rcmdb.repeclaim s
                        WHERE s.HN = vs.hn
                        AND s.PallativeCare > 0
                    ) AS money
                FROM(
                    SELECT
                        *
                    FROM vn_stat vs
                    WHERE vs.vstdate BETWEEN '{$min_date}' AND '{$max_date}'
                ) AS vs
                INNER JOIN (
                    SELECT
                        pt.hn,
                        pt.cid,
                        CONCAT(pt.pname, pt.fname, ' ', pt.lname) AS fullname,
                        pt.birthday,
                        (YEAR(CURRENT_DATE()) - YEAR(pt.birthday)) AS age,
                        CONCAT(pt.addrpart, ' หมู่ ', pt.moopart, ' ', ta.full_name) AS fulladdress,
                        pt.hcode,
                        pt.death
                    FROM patient pt
                    LEFT OUTER JOIN thaiaddress ta ON CONCAT(pt.chwpart, pt.amppart, pt.tmbpart) = ta.addressid
                ) AS pt_all ON vs.hn = pt_all.hn
                INNER JOIN pttype ptt ON vs.pttype = ptt.pttype
                LEFT OUTER JOIN ovst_community_service AS oc ON oc.vn = vs.vn AND oc.ovst_community_service_type_id BETWEEN 1 AND 103
                LEFT OUTER JOIN zbm_rpst_name zrn ON vs.hospsub = zrn.rpst_id
                WHERE
                    (vs.pdx = 'Z515' OR vs.dx0 = 'Z515' OR vs.dx1 = 'Z515' OR vs.dx2 = 'Z515' OR vs.dx3 = 'Z515' OR vs.dx4 = 'Z515' OR vs.dx5 = 'Z515')
                    {$service_unit}
                    {$death_type}
                GROUP BY vs.hn
                ORDER BY vs.hn DESC;
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
                    $bgColor = "text-dark";
                    $deathMessage = 'คนไข้เสียชีวิตแล้ว';
                } else {
                    $class = 'table-light';
                    $bgColor = "";
                    $deathMessage = 'คนไข้ยังมีชีวิตอยู่';
                    if($pcfln->daym < 30) {
                        $class = 'table-light';
                        $deathMessage = '<span class="">เยี่ยม ' . $pcfln->daym . ' วันที่แล้ว</span>';
                    } else if($pcfln->daym < 60) {
                        $class = 'table-primary';
                        $deathMessage = '<span class="">เยี่ยม 1 เดือนที่แล้ว</span>';
                    } else if($pcfln->daym < 90) {
                        $class = 'table-primary';
                        $deathMessage = '<span class="">เยี่ยม 2 เดือนที่แล้ว</span>';
                    } else if($pcfln->daym < 120) {
                        $class = 'table-success';
                        $deathMessage = '<span class="">เยี่ยม 3 เดือนที่แล้ว</span>';
                    } else if($pcfln->daym < 210) {
                        $class = 'table-success';
                        $deathMessage = '<span class="">เยี่ยม 6 เดือนที่แล้ว</span>';
                    } else if($pcfln->daym < 420) {
                        $class = 'table-warning';
                        $deathMessage = '<span class="">เยี่ยม 1 ปีที่แล้ว</span>';
                    } else {
                        $class = '';
                        $deathMessage = '<span class="">เยี่ยมมากกว่า 1 ปี</span>';
                    }
                }

                $vstdate = $this->DateThai($pcfln->vstdate);
                $birthday = $this->DateThai($pcfln->birthday);

                $output .= '<tr class="' . $class . '">
                <td>' . $vstdate . '</td>
                <td>' . $pcfln->pttype_name . '</td>
                <td>' . $pcfln->hn . '</td>
                <td>' . $pcfln->fullname . '</td>
                <td>' . $pcfln->cid . '</td>
                <td>' . $birthday . '</td>
                <td>' . $pcfln->age . '</td>
                <td>' . $pcfln->fulladdress . '</td>
                <td>' . $pcfln->rpst_name . '</td>
                <td>' . $pcfln->pdx . '</td>
                <td>
                    <button type="button" id="' . $pcfln->hn . '" class="btn btn-warning home-visiting-information-z718" data-bs-toggle="modal" data-bs-target="#home_visiting_information_z718">
                        ' . $pcfln->dayc1 . '
                    </button>
                </td>
                <td>
                    <button type="button" id="' . $pcfln->hn . '" class="btn btn-warning home-visiting-information" data-bs-toggle="modal" data-bs-target="#home_visiting_information">
                        ' . $pcfln->dayc . '
                    </button>
                </td>
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

    public function getHomeVisitingInformation(Request $request) {
        $hn = $request->id;

        $ovst_community_service = DB::connection('mysql')->select(
            "
                SELECT DATE(entry_datetime) AS vstdate,dt.name AS dtname,os.cc,os.hpi,GROUP_CONCAT(DISTINCT ot.ovst_community_service_type_name) AS csname,os.temperature,os.pulse,os.rr,CONCAT( LEFT(os.bps,3), '/',LEFT(os.bpd,2))as bp
                FROM ovst_community_service oc
                INNER JOIN opdscreen os ON os.vn=oc.vn
                INNER JOIN ovst_community_service_type ot ON ot.ovst_community_service_type_id=oc.ovst_community_service_type_id
                INNER JOIN (SELECT cs.vn FROM ovst_community_service cs INNER JOIN vn_stat vn ON vn.vn=cs.vn AND cs.ovst_community_service_type_id BETWEEN 1 AND 103 AND vn.hn='{$hn}') tb ON tb.vn=oc.vn
                LEFT JOIN doctor dt ON dt.code= oc.doctor
                WHERE os.hn='{$hn}' GROUP BY oc.vn ORDER BY oc.vn DESC
            "
        );

        $patient = DB::connection('mysql')->select(
            "
                SELECT pt.hn,pt.cid,CONCAT(pt.pname,pt.fname,' ',pt.lname) AS fullname,CONCAT(pt.addrpart,' หมู่ ',pt.moopart,' ',th.full_name) AS fulladdress,zn.rpst_name
                FROM patient pt
                LEFT JOIN thaiaddress th ON th.addressid = CONCAT(pt.chwpart,pt.amppart,pt.tmbpart)
                LEFT JOIN zbm_rpst zr ON zr.chwpart=pt.chwpart AND zr.amppart=pt.amppart AND zr.tmbpart=pt.tmbpart AND zr.moopart=pt.moopart
                LEFT JOIN zbm_rpst_name zn ON zn.rpst_id=zr.rpst_id
                WHERE pt.hn='{$hn}'
                GROUP BY pt.hn
            "
        );

        $output = '';

        if(count($ovst_community_service) > 0 && count($patient) > 0) {
            $output .= '
                <div class="row border">
                    <div class="col-2 border-end">
                        <p class="mt-2">ผู้ป่วย</p>
                    </div>
                    <div class="col-10"> ';
            foreach($patient AS $p) {
            $output .= '
                        <div class="mt-2">
                            <p> HN : ' . $p->hn . '</p>
                            <p> ชื่อ-สกุล : ' . $p->fullname . '</p>
                            <p> เลขบัตรประชาจำตัวประชาชน : ' . $p->cid . '</p>
                        </div>
            ';
            }
            $output .= '
                    </div>
                </div>
                <div class="mt-2 row border">
                    <div class="col-2 border-end">
                        <p class="mt-2">ที่อยู่</p>
                    </div>
                    <div class="col-10"> ';
            foreach($patient AS $p) {
                if($p->rpst_name) {
                    $rpst_name = $p->rpst_name;
                } else {
                    $rpst_name = "ไม่มีชื่อสถานบริการ";
                }
            $output .= '
                        <div class="mt-2">
                            <p>' . $p->fulladdress . '</p>
                            <p> สถานบริการ : ' . $rpst_name . '</p>
                        </div>
            ';
            }
            $output .= '
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-center align-items-center fw-bold">
                    <p><i class="bi bi-house-fill me-2"></i>การลงบันทึกเยี่ยมของโรงพยาบาล<i class="bi bi-house-fill ms-2"></i></p>
                </div>
                <div class="mt-2 row"> ';
            foreach($ovst_community_service AS $ocs) {

            $SePPS = $this->SePPS($ocs->hpi);
            $SePS = $this->SePS($ocs->hpi);
            $SeBed = $this->SeBed($ocs->hpi);
            $SeBi = $this->SeBi($ocs->hpi);
            $DateThai = $this->DateThai($ocs->vstdate);

            $output .= '
                    <div class="col-4 border p-3">
                        <div class="">
                            วันที่ออกเยี่ยม : ' . $DateThai . '
                        </div>
                        <div class="">
                            เจ้าหน้าที่ : ' . $ocs->dtname . '
                        </div>
                        <div class="mt-2 row">
                            <div class="border-end col-5">
                                <div>' . $SePPS . '</div>
                                <div>' . $SeBed . '</div>
                                <div>' . $SeBi . '</div>
                                <div> BP = ' . $ocs->bp . ' mmHg</div>
                            </div>
                            <div class="col-7">
                                <div>' . $SePS . '</div>
                                <div> PR = ' . $ocs->pulse . ' /min</div>
                                <div>' . $ocs->rr . ' /min</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 border p-3">
                        <div><span class="text-danger">อาการสำคัญ : </span>' . $ocs->cc . '</div>
                        <div><span class="text-danger">อาการปัจจุบัน : </span>' . $ocs->hpi . '</div>
                        <div><li>' . $ocs->csname . '</li></div>
                    </div>
            ';
            }
            $output .='
                </div>
            ';

            echo $output;
        } else {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'messsage' => 'ไม่มี HN ส่งมา',
                'icon' => 'error'
            ]);
        }
    }

    public function getHomeVisitingInformationZ718(Request $request) {
        $hn = $request->id;

        $ovst_community_service = DB::connection('mysql')->select(
            "
                SELECT DATE(entry_datetime) AS vstdate,dt.name AS dtname,os.cc,os.hpi,GROUP_CONCAT(DISTINCT ot.ovst_community_service_type_name) AS csname,di.icd10
                ,if(ov.pdx ='Z515' OR ov.dx0 ='Z515' OR ov.dx1 ='Z515' OR ov.dx1 ='Z515' OR ov.dx2 ='Z515' OR ov.dx3 ='Z515' OR ov.dx4 ='Z515' OR ov.dx5 ='Z515','Z515',NULL) AS Z
                ,if(ov.pdx ='Z718' OR ov.dx0 ='Z718' OR ov.dx1 ='Z718' OR ov.dx1 ='Z718' OR ov.dx2 ='Z718' OR ov.dx3 ='Z718' OR ov.dx4 ='Z718' OR ov.dx5 ='Z718','Z718',NULL) AS Z718
                FROM ovst_community_service oc
                INNER JOIN opdscreen os ON os.vn=oc.vn
                INNER JOIN ovst_community_service_type ot ON ot.ovst_community_service_type_id=oc.ovst_community_service_type_id
                INNER JOIN (SELECT cs.vn FROM ovst_community_service cs INNER JOIN vn_stat vn ON vn.vn=cs.vn AND cs.ovst_community_service_type_id BETWEEN 1 AND 103 AND vn.hn='{$hn}') tb ON tb.vn=oc.vn
                LEFT JOIN doctor dt ON dt.code= oc.doctor
                LEFT JOIN ovstdiag di ON oc.vn = di.vn
                LEFT JOIN vn_stat ov ON ov.vn = oc.vn
                WHERE (ov.pdx ='Z515' OR ov.dx0 ='Z515' OR ov.dx1 ='Z515' OR ov.dx2 ='Z515' OR ov.dx3 ='Z515' OR ov.dx4 ='Z515' OR ov.dx5 ='Z515')
                AND (ov.pdx ='Z718' OR ov.dx0 ='Z718' OR ov.dx1 ='Z718' OR ov.dx2 ='Z718' OR ov.dx3 ='Z718' OR ov.dx4 ='Z718' OR ov.dx5 ='Z718')
                AND os.hn='{$hn}' GROUP BY oc.vn ORDER BY oc.vn DESC
            "
        );

        $patient = DB::connection('mysql')->select(
            "
                SELECT pt.hn,pt.cid,CONCAT(pt.pname,pt.fname,' ',pt.lname) AS fullname,CONCAT(pt.addrpart,' หมู่ ',pt.moopart,' ',th.full_name) AS fulladdress,zn.rpst_name
                FROM patient pt
                LEFT JOIN thaiaddress th ON th.addressid = CONCAT(pt.chwpart,pt.amppart,pt.tmbpart)
                LEFT JOIN zbm_rpst zr ON zr.chwpart=pt.chwpart AND zr.amppart=pt.amppart AND zr.tmbpart=pt.tmbpart AND zr.moopart=pt.moopart
                LEFT JOIN zbm_rpst_name zn ON zn.rpst_id=zr.rpst_id
                WHERE pt.hn='{$hn}'
                GROUP BY pt.hn
            "
        );

        $output = '';

        if(count($ovst_community_service) > 0 && count($patient) > 0) {
            $output .= '
                <div class="row border">
                    <div class="col-2 border-end">
                        <p class="mt-2">ผู้ป่วย</p>
                    </div>
                    <div class="col-10"> ';
            foreach($patient AS $p) {
            $output .= '
                        <div class="mt-2">
                            <p> HN : ' . $p->hn . '</p>
                            <p> ชื่อ-สกุล : ' . $p->fullname . '</p>
                            <p> เลขบัตรประชาจำตัวประชาชน : ' . $p->cid . '</p>
                        </div>
            ';
            }
            $output .= '
                    </div>
                </div>
                <div class="mt-2 row border">
                    <div class="col-2 border-end">
                        <p class="mt-2">ที่อยู่</p>
                    </div>
                    <div class="col-10"> ';
            foreach($patient AS $p) {
                if($p->rpst_name) {
                    $rpst_name = $p->rpst_name;
                } else {
                    $rpst_name = "ไม่มีชื่อสถานบริการ";
                }
            $output .= '
                        <div class="mt-2">
                            <p>' . $p->fulladdress . '</p>
                            <p> สถานบริการ : ' . $rpst_name . '</p>
                        </div>
            ';
            }
            $output .= '
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-center align-items-center fw-bold">
                    <p><i class="bi bi-house-fill me-2"></i>การลงบันทึกเยี่ยมของโรงพยาบาล<i class="bi bi-house-fill ms-2"></i></p>
                </div>
                <div class="mt-2 row"> ';
            foreach($ovst_community_service AS $ocs) {

            $SePPS = $this->SePPS($ocs->hpi);
            $SePS = $this->SePS($ocs->hpi);
            $SeBed = $this->SeBed($ocs->hpi);
            $SeBi = $this->SeBi($ocs->hpi);
            $DateThai = $this->DateThai($ocs->vstdate);

            $output .= '
                    <div class="col-4 border p-3">
                        <div class="">
                            วันที่ออกเยี่ยม : ' . $DateThai . '
                        </div>
                        <div class="">
                            เจ้าหน้าที่ : ' . $ocs->dtname . '
                        </div>
                        <div class="mt-2 row">
                            <div class="border-end col-5">
                                <div>' . $SePPS . '</div>
                                <div>' . $SeBed . '</div>
                            </div>
                            <div class="col-7">
                                <div>' . $SePS . '</div>
                                <div>' . $SeBi . '</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 border p-3">
                        <div><span class="text-danger">อาการสำคัญ : </span>' . $ocs->cc . '</div>
                        <div><span class="text-danger">อาการปัจจุบัน : </span>' . $ocs->hpi . '</div>
                        <div><li>' . $ocs->csname . '</li></div>
                    </div>
            ';
            }
            $output .='
                </div>
            ';

            echo $output;
        } else {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'messsage' => 'ไม่มี HN ส่งมา',
                'icon' => 'error'
            ]);
        }
    }

    public function getEclaimReceivedMoney() {
        $rcmdb_repeclaim = $this->queryEclaimReceivedMoney();

        $output = '';

        if (count($rcmdb_repeclaim) > 0) {
            $output .= '<table id="table-eclaim-received-money" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
            <thead>
                <tr>
                    <th>HN</th>
                    <th>เลขบัตรประชาชน</th>
                    <th>ชื่อ - สกุล</th>
                    <th>จำนวนเงิน</th>
                    <th>วันที่ได้รับเงิน</th>
                    <th>REP</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($rcmdb_repeclaim as $rr) {
                $output .= '<tr>
                <td>' . $rr->HN . '</td>
                <td>' . $rr->PID . '</td>
                <td>' . $rr->PtName . '</td>
                <td>' . $rr->PallativeCare . '</td>
                <td>' . $rr->dd . '</td>
                <td>' . $rr->Rep . '</td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการ E-Claim</h1>';
        }
    }

    public function getNumberOfNewPatients() {
        $result_1 = "MONTH(v.vstdate) = MONTH(CURRENT_DATE())";
        $result_2 = "LAST_DAY(CURRENT_DATE() - INTERVAL 1 MONTH)";

        $number_of_new_patients = DB::connection('mysql')->select(
            "
                SELECT DISTINCT
                    o.hn AS 'hn', pp.name AS pttype_name,
                    (YEAR(NOW()) - YEAR(pt.birthday)) AS age,
                    v.pdx, o.vstdate AS day1,
                    CONCAT(pt.pname, '', pt.fname, ' ', pt.lname) AS fullname,
                    pt.informaddr AS fulladdress
                FROM ovstdiag o
                LEFT OUTER JOIN vn_stat v ON v.vn = o.vn
                LEFT JOIN patient pt ON pt.hn = o.hn
                LEFT JOIN vn_stat vn ON vn.vn = o.vn
                LEFT JOIN pttype pp ON pp.pttype = vn.pttype
                LEFT JOIN ipt i ON i.vn = v.vn
                WHERE o.icd10 IN ('Z515')
                AND {$result_1}
                AND o.hn NOT IN (
                    SELECT DISTINCT o.hn
                    FROM ovstdiag o
                    LEFT OUTER JOIN vn_stat v ON v.vn = o.vn
                    WHERE o.icd10 IN ('Z515')
                    AND v.vstdate <= {$result_2}
                )
                GROUP BY o.hn
                ORDER BY o.vn DESC
            "
        );

        $output = '';

        if (count($number_of_new_patients) > 0) {
            $output .= '<table id="table-eclaim-received-money" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>hn</th>
                    <th>ชื่อ - สกุล</th>
                    <th>pdx</th>
                    <th>สิทธิ์</th>
                    <th>อายุ</th>
                    <th>วันที่</th>
                    <th>ที่อยู่</th>
                </tr>
            </thead>
            <tbody>';
            $i = 1;
            foreach ($number_of_new_patients as $nonp) {
                $output .= '<tr>
                <td>' . $i . '</td>
                <td>' . $nonp->hn . '</td>
                <td>' . $nonp->fullname . '</td>
                <td>' . $nonp->pdx . '</td>
                <td>' . $nonp->pttype_name . '</td>
                <td>' . $nonp->age . '</td>
                <td>' . $nonp->day1 . '</td>
                <td>' . $nonp->fulladdress . '</td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการคนไข้รายใหม่</h1>';
        }
    }
}
