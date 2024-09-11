<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Exports\AuthenCodeExport;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;

class AuthenCodeController extends Controller
{

    private function getChart($summarize_count) {
        $total_all = $summarize_count->total_all;
        $total_authen_success = $summarize_count->total_authen_success;
        $total_not_authen = $summarize_count->total_not_authen;

        $percentage_authen_success = ($total_authen_success * 100) / $total_all;
        $percentage_not_authen = ($total_not_authen * 100) / $total_all;

        $percentage_authen_success_label = number_format($percentage_authen_success, 2) . '%';
        $percentage_not_authen_label = number_format($percentage_not_authen, 2) . '%';

        $chart = [
            'labels' => [
                'จำนวนคนไข้ที่ขอเลข Authen Code เรียบร้อย (' . $percentage_authen_success_label . ')',
                'จำนวนคนไข้ที่ยังไม่ได้ขอเลข Authen Code (' . $percentage_not_authen_label . ')'
            ],
            'datasets' => [
                [
                    'data' => [
                        $percentage_authen_success,
                        $percentage_not_authen
                    ],
                    'backgroundColor' => [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    'hoverOffset' => 4
                ]
            ]
        ];
        return $chart;
    }

    private function query_authen_code() {
        $summarize_report = DB::connection('mysql')->select(
            "
                SELECT
                        o.hn,
                        pt.cid,
                        pt.pname,
                        CONCAT(pt.fname, ' ', pt.lname) AS fullname,
                        ptt.name AS pttype_name,
                        CASE
                            WHEN vp.auth_code
                                    THEN vp.auth_code
                            ELSE 'ยังไม่มีเลข Authen Code บนระบบ HoSXP'
                        END AS result
                FROM ovst o
                LEFT OUTER JOIN visit_pttype vp ON o.vn = vp.vn
                LEFT OUTER JOIN patient pt ON o.hn = pt.hn
                LEFT OUTER JOIN vn_stat vs ON o.vn = vs.vn
                LEFT OUTER JOIN pttype ptt ON vs.pttype = ptt.pttype
                WHERE o.vstdate = CURDATE()
                    AND pt.nationality = '99'
                    AND vp.auth_code IS NULL
                ORDER BY o.hn DESC
            "
        );
        return (array) $summarize_report;
    }

    public function index(Request $request) {
        // Retrieve session data
        $data = $request->session()->all();
        // Get the current year
        $year = date('Y');

        // Execute the query to get the summarized counts
        $summarize_count = DB::connection('mysql')->select(
            "
                SELECT
                    COUNT(t1.vn) AS ovst_all,
                    COUNT(t2.vn) AS ovst_authen_all,
                    COUNT(CASE WHEN t2.pttype_spp_name = 'ข้าราชการ/รัฐวิสาหกิจ' THEN 1 END) AS ofc_lgo_authen,
                    COUNT(CASE WHEN t2.pttype_spp_name = 'บัตรประกันสังคม' THEN 1 END) AS sss_authen,
                    COUNT(CASE WHEN t2.pttype_spp_name = 'UC (บัตรทอง ไม่มี ท.)' THEN 1 END) AS ucs_authen,
                    COUNT(CASE WHEN t2.pttype_spp_name = 'สปร. (บัตรทอง มี ท.)' THEN 1 END) AS wel_authen,
                    COUNT(CASE WHEN t2.pttype_spp_name = 'คนต่างด้าวที่ขึ้นทะเบียน' THEN 1 END) AS nrh_authen,
                    COUNT(CASE WHEN t2.pttype_spp_name = 'อื่นๆ (ต่างด้าวไม่ขึ้นทะเบียน / ชำระเงินเอง)' THEN 1 END) AS other_authen,
                    COUNT(t3.vn) AS ovst_not_authen_all,
                    COUNT(CASE WHEN t3.pttype_spp_name = 'ข้าราชการ/รัฐวิสาหกิจ' THEN 1 END) AS ofc_lgo_not_authen,
                    COUNT(CASE WHEN t3.pttype_spp_name = 'บัตรประกันสังคม' THEN 1 END) AS sss_not_authen,
                    COUNT(CASE WHEN t3.pttype_spp_name = 'UC (บัตรทอง ไม่มี ท.)' THEN 1 END) AS ucs_not_authen,
                    COUNT(CASE WHEN t3.pttype_spp_name = 'สปร. (บัตรทอง มี ท.)' THEN 1 END) AS wel_not_authen,
                    COUNT(CASE WHEN t3.pttype_spp_name = 'คนต่างด้าวที่ขึ้นทะเบียน' THEN 1 END) AS nrh_not_authen,
                    COUNT(CASE WHEN t3.pttype_spp_name = 'อื่นๆ (ต่างด้าวไม่ขึ้นทะเบียน / ชำระเงินเอง)' THEN 1 END) AS other_not_authen
                FROM (
                    SELECT
                        vn,
                        hn,
                        vstdate
                    FROM ovst
                    WHERE vstdate = CURRENT_DATE()
                ) AS t1
                LEFT JOIN (
                    SELECT
                        vp.vn,
                        ptts.pttype_spp_name
                    FROM visit_pttype vp
                    LEFT JOIN vn_stat vs ON vp.vn = vs.vn
                    LEFT JOIN pttype ptt ON vs.pttype = ptt.pttype
                    LEFT JOIN pttype_spp ptts ON ptt.pttype_spp_id = ptts.pttype_spp_id
                    WHERE vp.auth_code IS NOT NULL
                ) AS t2 ON t1.vn = t2.vn
                LEFT JOIN (
                    SELECT
                        vp.vn,
                        ptts.pttype_spp_name
                    FROM visit_pttype vp
                    LEFT JOIN vn_stat vs ON vp.vn = vs.vn
                    LEFT JOIN pttype ptt ON vs.pttype = ptt.pttype
                    LEFT JOIN pttype_spp ptts ON ptt.pttype_spp_id = ptts.pttype_spp_id
                    WHERE vp.auth_code IS NULL
                ) AS t3 ON t1.vn = t3.vn
            "
        );

        // Get the first (and only) result from the query
        $summarize_count = $summarize_count[0];

        // Return the view with the necessary data
        return view('reportes.authenCode', compact('data', 'year', 'summarize_count'));
    }

    public function getAuthenCodeCount() {
        $summarize_count = DB::connection('mysql')->select(
            "
                SELECT
                    COUNT(*) AS total_all,
                    COUNT(vp.auth_code IN (SELECT auth_code FROM visit_pttype WHERE auth_code IS NOT NULL)) AS total_authen_success,
                    COUNT(*) - COUNT(vp.auth_code IN (SELECT auth_code FROM visit_pttype WHERE auth_code IS NOT NULL)) AS total_not_authen
                FROM ovst o
                LEFT OUTER JOIN visit_pttype vp ON o.vn = vp.vn
                LEFT OUTER JOIN patient pt ON o.hn =pt.hn
                WHERE o.vstdate = CURRENT_DATE()
                AND pt.nationality = '99';
            "
        );

        $summarize_count = $summarize_count[0];

        $chart = $this->getChart($summarize_count);

        return response()->json([
            'chart' => $chart
        ]);
    }

    public function authenCodeFetchAll() {
        $summarize_report = $this->query_authen_code();

        $output = '';

        if(count($summarize_report) > 0) {
            $output .= '<table id="table-list-authen-code" class="table table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead>
              <tr>
                <th>HN</th>
                <th>เลขบัตรประจำตัวประชาชน</th>
                <th>คำนำหน้า</th>
                <th>ชื่อ - สกุล</th>
                <th>สิทธิ์การรักษา</th>
                <th>สาเหตุ</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($summarize_report as $sr) {
				$output .= '<tr>
                <td>' . $sr->hn . '</td>
                <td>' . $sr->cid . '</td>
                <td>' . $sr->pname . '</td>
                <td>' . $sr->fullname . '</td>
                <td>' . $sr->pttype_name . '</td>
                <td>' . $sr->result . '</td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">ไม่มีคนไข้ที่ยังไม่ได้ขอเลข Authen Code!</h1>';
        }
    }

    public function exportNotAuthenCode() {
        $summarize_report = $this->query_authen_code();
        if (count($summarize_report) > 0) {
            // ส่ง JSON กลับไปยัง AJAX
            return response()->json([
                'status' => 200,
                'title' => 'success',
                'message' => 'Download Success',
                'icon' => 'success',
                'download_url' => route('downloadAuthenCode')
            ]);
        } else {
            echo "<script>alert('ไม่มีคนไข้ที่ยังไม่ได้ขอเลข Authen Code')</script>";
            return redirect()->route('report_index_authen_code');
        }
    }

    // สร้างฟังก์ชันใหม่สำหรับดาวน์โหลดไฟล์
    public function downloadAuthenCode() {
        $summarize_report = $this->query_authen_code();
        return Excel::download(new AuthenCodeExport($summarize_report), 'authencode.xlsx');
    }
}
