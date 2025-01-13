<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// เรียกใช้งาน Database
use Illuminate\Support\Facades\DB;

// use App\Models\Dashboard_Setting\ModuleModel;
use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;
use App\Models\Dashboard_Setting\FiscalYearModel;
use App\Models\Dashboard_Setting\AdvanceCarePlanModel;

use App\Models\Log\PalliativeCareLogModel;
use App\Models\Log\ModuleLogModel;
use App\Models\Log\AccessibilityLogModel;
use App\Models\Log\SidebarSub1MenuLogModel;

class PalliativeCareController extends Controller
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

    // แปลง วัน-เดือน-ปี เป็นของประเทศไทย isThaiYear  Start
        private function isThaiYear($request_1, $request_2) {
            if($request_1 != 0 && $request_2 != 0) {
                $date_parts_1 = explode('-', $request_1);
                $date_parts_2 = explode('-', $request_2);

                $year_1 = $date_parts_1[0];
                $year_2 = $date_parts_2[0];

                if($year_1 >= 2400 && $year_1 <= 2600 || $year_2 >= 2400 && $year_2 <= 2600) {
                    $year_1 = $year_1 - 543;
                    $year_2 = $year_2 - 543;
                    $date_1 = $year_1 . '-' . $date_parts_1[1] . '-' . $date_parts_1[2];
                    $date_2 = $year_2 . '-' . $date_parts_2[1] . '-' . $date_parts_2[2];
                    $date_all = array(
                        'date_1' => $date_1,
                        'date_2' => $date_2
                    );
                    return $date_all;
                } else {
                    $date_all = array(
                        'date_1' => $request_1,
                        'date_2' => $request_2
                    );
                    return $date_all;
                }
            } else {
                return false;
            }
        }
    // แปลง วัน-เดือน-ปี เป็นของประเทศไทย isThaiYear  End

    // ดึงข้อมูล คนไข้ Palliative Care รายใหม่จาก จาก Request ที่ถูกส่งเข้ามา QueryNumberOfNewPatients Start
        private function queryNumberOfNewPatients($request_1, $request_2, Request $request) {
            // ตรวจสอบว่ามีการส่ง Request มาหรือไม่ ถ้าไม่ก็ให้ส่ง False กลับไป
            if (empty($request_1) || empty($request_2)) {
                return false;
            }
        
            $startTime = microtime(true);
        
            // Query ข้อมูลจาก Table
            $query = DB::table('ovstdiag as o')
                ->distinct()
                ->select(
                    'o.hn as hn',
                    'pp.name as pttype_name',
                    DB::raw('(YEAR(NOW()) - YEAR(pt.birthday)) as age'),
                    'v.pdx',
                    'o.vstdate as day1',
                    DB::raw("CONCAT(pt.pname, '', pt.fname, ' ', pt.lname) as fullname"),
                    'pt.informaddr as fulladdress'
                )
                ->leftJoin('vn_stat as v', 'v.vn', '=', 'o.vn')
                ->leftJoin('patient as pt', 'pt.hn', '=', 'o.hn')
                ->leftJoin('vn_stat as vn', 'vn.vn', '=', 'o.vn')
                ->leftJoin('pttype as pp', 'pp.pttype', '=', 'vn.pttype')
                ->leftJoin('ipt as i', 'i.vn', '=', 'v.vn')
                ->whereIn('o.icd10', ['Z515'])
                ->whereRaw($request_1) // ควร validate ค่า $request_1 ก่อน
                ->whereNotIn('o.hn', function($query) use ($request_2) {
                    $query->select(DB::raw('DISTINCT o.hn'))
                        ->from('ovstdiag as o')
                        ->leftJoin('vn_stat as v', 'v.vn', '=', 'o.vn')
                        ->whereIn('o.icd10', ['Z515'])
                        ->where('v.vstdate', '<=', DB::raw($request_2)); // ควร validate $request_2 ด้วย
                })
                ->groupBy('o.hn')
                ->orderBy('o.vn', 'desc');
        
            // ดึงข้อมูลจาก Query (ดึงหลายแถว)
            $number_of_new_patients_query = $query->get();
        
            // ดึง SQL query พร้อม bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
        
            // สร้างข้อมูลสำหรับบันทึกใน log
            $palliative_care_log_data = [
                'function' => 'queryNumberOfNewPatients',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($palliative_care_log_data);
        
            // ส่งค่า Query คืนกลับไป
            return $number_of_new_patients_query;
        }
    // ดึงข้อมูล คนไข้ Palliative Care รายใหม่จาก จาก Request ที่ถูกส่งเข้ามา QueryNumberOfNewPatients End

    // ดึงข้อมูล คนไข้ Palliative Care รายเก่าจาก จาก Request ที่ถูกส่งเข้ามา QueryNumberOfOldPatients Start
        private function queryNumberOfOldPatients($firstDayOfMonth, $lastDayOfMonth, Request $request) {
            // ตรวจสอบว่ามีการส่ง Request มาหรือไม่ ถ้าไม่ก็ให้ส่ง False กลับไป
            if(empty($firstDayOfMonth) || empty($lastDayOfMonth)) {
                return false;
            }

            $startTime = microtime(true);
        
            // Query ข้อมูลจาก Table และแปลงคำสั่ง SQL เป็น Laravel Query Builder
            $query = DB::table('ovstdiag as o')
                ->distinct()
                ->select(
                    'o.hn',
                    DB::raw("CONCAT(pt.pname, pt.fname, ' ', pt.lname) as fullname"),
                    'pt.informaddr as fulladdress'
                )
                ->leftJoin('vn_stat as v', 'v.vn', '=', 'o.vn')
                ->leftJoin('patient as pt', 'pt.hn', '=', 'o.hn')
                ->leftJoin('vn_stat as vn', 'vn.vn', '=', 'o.vn')
                ->leftJoin('pttype as pp', 'pp.pttype', '=', 'vn.pttype')
                ->leftJoin('ipt as i', 'i.vn', '=', 'v.vn')
                ->whereIn('o.icd10', ['Z515'])
                ->whereBetween('v.vstdate', [$firstDayOfMonth, $lastDayOfMonth])
                ->whereIn('o.hn', function($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                    $query->select(DB::raw('DISTINCT o.hn'))
                        ->from('ovstdiag as o')
                        ->leftJoin('vn_stat as v', 'v.vn', '=', 'o.vn')
                        ->whereIn('o.icd10', ['Z515'])
                        ->whereBetween('v.vstdate', [$firstDayOfMonth, $lastDayOfMonth]);
                })
                ->groupBy('o.hn')
                ->orderBy('o.vn', 'desc');

            // ดึงข้อมูลจาก Query (ดึงหลายแถว)
            $number_of_old_patients_query = $query->get();
        
            // ดึง SQL query พร้อม bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
        
            // สร้างข้อมูลสำหรับบันทึกใน log
            $palliative_care_log_data = [
                'function' => 'queryNumberOfOldPatients',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($palliative_care_log_data);
        
            // ส่งค่า Query คืนกลับไปในรูปแบบของ Collection
            return $number_of_old_patients_query;
        }
    // ดึงข้อมูล คนไข้ Palliative Care รายเก่าจาก จาก Request ที่ถูกส่งเข้ามา QueryNumberOfOldPatients End

    // ดึงข้อมูล คนไข้ Palliative Care ที่มีอาการปวด( Pain ) จาก Request ที่ถูกส่งเข้ามา Start
        private function queryPalliativeCarePatientsPain($firstDayOfMonth, $lastDayOfMonth, Request $request) {
            // ตรวจสอบว่ามีการส่ง Request มาหรือไม่ ถ้าไม่ก็ให้ส่ง False กลับไปยัง Function ที่เรียกใช้งาน Function นี้ Start
            if($firstDayOfMonth == 0 && $lastDayOfMonth == 0) {
                return false;
            }
            // ตรวจสอบว่ามีการส่ง Request มาหรือไม่ ถ้าไม่ก็ให้ส่ง False กลับไปยัง Function ที่เรียกใช้งาน Function นี้ End

            $startTime = microtime(true);

            // Query ข้อมูลจาก Table และนำ Request ที่ถูกส่งเข้ามาไปแทนค่าในตัวแปร ({$firstDayOfMonth, $lastDayOfMonth}) ของคำสั่ง Query บน Mysql Start
            $query = DB::table('opitemrece as op')
                ->distinct()
                ->select(
                    'op.hn',
                    DB::raw("CONCAT(pt.pname, '', pt.fname, ' ', pt.lname) as fullname"),
                    'pt.informaddr as fulladdress'
                )
                ->leftJoin('drugitems as nd', 'nd.icode', '=', 'op.icode')
                ->leftJoin('an_stat as an', 'an.an', '=', 'op.an')
                ->leftJoin('vn_stat as vn', 'vn.vn', '=', 'op.vn')
                ->leftJoin('patient as pt', 'pt.hn', '=', 'op.hn')
                ->whereIn('op.icode', [1580001, 1590005, 1000156, 1000406, 1000412, 1000413, 1000430, 1550025])
                ->whereBetween('op.vstdate', [$firstDayOfMonth, $lastDayOfMonth]);
            // Query ข้อมูลจาก Table และนำ Request ที่ถูกส่งเข้ามาไปแทนค่าในตัวแปร ({$firstDayOfMonth, $request_2}) ของคำสั่ง Query บน Mysql End

            // ดึงข้อมูลจาก Query (ดึงหลายแถว)
            $palliative_care_patients_pain = $query->get();
        
            // ดึง SQL query พร้อม bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
        
            // สร้างข้อมูลสำหรับบันทึกใน log
            $palliative_care_log_data = [
                'function' => 'queryPalliativeCarePatientsPain',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($palliative_care_log_data);

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ ส่งกลับไปในรูปแบบของ Array Start
            return $palliative_care_patients_pain;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ ส่งกลับไปในรูปแบบของ Array End
        }
    // ดึงข้อมูล คนไข้ Palliative Care ที่มีอาการปวด( Pain ) จาก Request ที่ถูกส่งเข้ามา End

    // ดึงข้อมูล ทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้ว Start
        private function queryEclaimReceivedMoney(Request $request) {
            $startTime = microtime(true);

            // Query ข้อมูลจาก Table Start
            $query = DB::table('rcmdb.repeclaim')
                ->select('*', DB::raw('SUBSTRING(FileName, 19, 6) AS dd'))
                ->where('PallativeCare', '>', 0)
                ->orderBy('Rep', 'DESC')
            ;
            // Query ข้อมูลจาก Table End

            // ดึงข้อมูลจาก Query (ดึงหลายแถว)
            $rcmdb_repeclaim = $query->get();
        
            // ดึง SQL query พร้อม bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
        
            // สร้างข้อมูลสำหรับบันทึกใน log
            $palliative_care_log_data = [
                'function' => 'queryEclaimReceivedMoney',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($palliative_care_log_data);

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ ส่งกลับไปในรูปแบบของ Array Start
            return $rcmdb_repeclaim;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ ส่งกลับไปในรูปแบบของ Array End
        }
    // ดึงข้อมูล ทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้ว End

    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ PPS ออกมาใช้งาน Start
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

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return $rss;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ PPS ออกมาใช้งาน End

    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ PS ออกมาใช้งาน Start
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

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return $rss;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ PS ออกมาใช้งาน End

    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ เตียง ออกมาใช้งาน Start
        private function SeBed($hpi) {
            if (strpos($hpi, 'เตียง1') || strpos($hpi, 'เตียง 1') || strpos($hpi, 'เตียง=1') || strpos($hpi, 'เตียง = 1') || strpos($hpi, 'เตียง= 1') || strpos($hpi, 'เตียง =1')) $rss="เตียง 1";
            else if (strpos($hpi, 'เตียง2') || strpos($hpi, 'เตียง 2') || strpos($hpi, 'เตียง=2') || strpos($hpi, 'เตียง = 2') || strpos($hpi, 'เตียง= 2') || strpos($hpi, 'เตียง =2')) $rss="เตียง 2";
            else if (strpos($hpi, 'เตียง3') || strpos($hpi, 'เตียง 3') || strpos($hpi, 'เตียง=3') || strpos($hpi, 'เตียง = 3') || strpos($hpi, 'เตียง= 3') || strpos($hpi, 'เตียง =3')) $rss="เตียง 3";
            else if (strpos($hpi, 'เตียง4') || strpos($hpi, 'เตียง 4') || strpos($hpi, 'เตียง=4') || strpos($hpi, 'เตียง = 4') || strpos($hpi, 'เตียง= 4') || strpos($hpi, 'เตียง =4')) $rss="เตียง 4";
            else $rss="เตียง= -";

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return $rss;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ เตียง ออกมาใช้งาน End

    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ BI ออกมาใช้งาน Start
        private function SeBi($hpi) {
            for($i=100;$i>=0;$i--){
                if (strpos(strtolower($hpi), 'bi'.$i) || strpos(strtolower($hpi), 'bi '.$i) || strpos(strtolower($hpi), 'bi  '.$i) || strpos(strtolower($hpi), 'bi='.$i) || strpos(strtolower($hpi), 'bi = '.$i) || strpos(strtolower($hpi), 'bi= '.$i) || strpos(strtolower($hpi), 'bi ='.$i))
                {
                    $ress="BI = ".$i;

                    break;
                }
                else $ress="BI = -";
            }

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return $ress;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // แยกรายการของ Colunm hpi เพื่อดึงค่าของ BI ออกมาใช้งาน End

    // แปลงวันที่จาก ค.ศ. ให้เป็นวันที่ของไทย Start
        private function DateThai($strDate) {
            // ดึงค่าปีออกมาแล้วบวกด้วย 543 เพื่อหาค่า พ.ศ. แล้วนำไปเก็บที่ตัวแปร
            $strYear = date("Y",strtotime($strDate))+543;
            // ดึงค่าเดือนออกมาแล้วนำไปเก็บที่ตัวแปร
            $strMonth= date("n",strtotime($strDate));
            // ดึงค่าวันออกมาแล้วนำไปเก็บที่ตัวแปร
            $strDay= date("j",strtotime($strDate));
            // ดึงค่าเดือนออกมาในรูปแบบภาษาไทย แล้วนำไปเก็บที่ตัวแปร
            $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            // เทียบข้อมูลตัวเลขของเดือนและเปลี่ยนไปเป็นเดือนในรูปแบบภาษาไทย แล้วนำไปเก็บที่ตัวแปร
            $strMonthThai=$strMonthCut[$strMonth];

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return "$strDay $strMonthThai $strYear";
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // แปลงวันที่จาก ค.ศ. ให้เป็นวันที่ของไทย End

    // จำนวนผู้เสียชีวิตใน Palliative Care แยกตาม Diag Start
        private function getChartCountDeath($summarize_count_death) {
            // สร้าง Array เปล่า Start
            $count_death = [];
            $death_name = [];
            // สร้าง Array เปล่า End

            // นำ Request ที่ส่งเข้ามาไป Loop Start
            foreach ($summarize_count_death as $data) {
                // ดึงข้อมูลจาก Request ที่ส่งเข้ามา Loop ตาม Column ที่ถูกส่งมา Start
                $count_death[] = $data->kk;
                $death_name[] = $data->pdx;
                // ดึงข้อมูลจาก Request ที่ส่งเข้ามา Loop ตาม Column ที่ถูกส่งมา End
            }
            // นำ Request ที่ส่งเข้ามาไป Loop End

            // สร้างเนื่อหาภายใน Chart Start
            $chart_count_death = [
                // หัวข้อของข้อมูล
                'labels' => $death_name,
                // ตัวขข้อมูลและสีของข้อมูลหรือ Style ต่างๆ
                'datasets' => [
                    [
                        'label' => 'จำนวนผู้เสียชีวิตใน Palliative Care แยกตาม Diag',
                        'data' => $count_death,
                        'backgroundColor' => 'rgba(54, 162, 235, 1)',
                        'borderColor' => 'rgba(54, 162, 235, 3)',
                        'borderWidth' => 1
                    ]
                ],
                // Option เสริมของ Chart JS
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
            // สร้างเนื่อหาภายใน Chart End

            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ Start
            return $chart_count_death;
            // ส่งค่า Query คืนกลับไปให้ Function ที่เรียกใช้งาน Function  นี้ End
        }
    // จำนวนผู้เสียชีวิตใน Palliative Care แยกตาม Diag End

    // หน้าแรกของ Palliative Care Start
        public function index(Request $request) {
            // ดึงข้อมูล Session ที่มีการ Login เข้ามาภายในระบบ
            $data = $request->session()->all();

            $fiscal_year = FiscalYearModel::orderBy('id', 'desc')->get();

            $startTime_1 = microtime(true);

            $sidebar_sub1_menu_id = $request->id;

            $query_1 = SidebarSub1MenuModel::where('id', $sidebar_sub1_menu_id);

            $SidebarSub1MenuId = $query_1->first();
        
            // ดึง SQL query_1 พร้อม bindings
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $sidebar_sub1_menu_log_data = [
                'function' => "Where sidebar_sub1_menu_name = {$SidebarSub1MenuId->sidebar_sub1_menu_name}",
                'username' => $data['loginname'],
                'command_sql' => $fullSql_1,
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            SidebarSub1MenuLogModel::create($sidebar_sub1_menu_log_data);

            $startTime_2 = microtime(true);

            // Query สถานบริการ Start
            $query_2 = DB::table('zbm_rpst_name')
                ->select('rpst_id', 'rpst_name')
                ->whereIn('rpst_id', ['11098', '05532', '05533', '05534', '05535', '05536', '05537', '05538', '05539', '05540', '05541', '13976', '00000']);
            // Query สถานบริการ End

            // ดึงข้อมูลจาก Query (ดึงหลายแถว)
            $zbm_rpst_name = $query_2->get();
        
            // ดึง SQL query พร้อม bindings
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);
        
            // สร้างข้อมูลสำหรับบันทึกใน log
            $palliative_care_log_data = [
                'function' => 'Come to the Palliative Care page AND SELECT DATA',
                'username' => $data['loginname'],
                'command_sql' => $fullSql_2,
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($palliative_care_log_data);

            if($SidebarSub1MenuId->status_id === 1) {
                $startTime_3 = microtime(true);

                $query_3 = AccessibilityModel::where('accessibility_name', $data['groupname'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);

                // ดึงข้อมูลจาก Query (ดึงหลายแถว)
                $accessibility_groupname_model = $query_3->first();
            
                // ดึง SQL query พร้อม bindings
                $sql_3 = $query_3->toSql();
                $bindings_3 = $query_3->getBindings();
                $fullSql_3 = vsprintf(str_replace('?', "'%s'", $sql_3), $bindings_3);
            
                $endTime_3 = microtime(true);
                $executionTime_3 = $endTime_3 - $startTime_3;
                $formattedExecutionTime_3 = number_format($executionTime_3, 3);
            
                // ดึง username จาก method someMethod
                // $username = $this->someMethod($request);
            
                // สร้างข้อมูลสำหรับบันทึกใน log
                $accessibility_log_data = [
                    'function' => "Where accessibility_name = {$data['groupname']} AND sidebar_sub1_menu_id = {$SidebarSub1MenuId->id}",
                    'username' => $data['loginname'],
                    'command_sql' => $fullSql_3,
                    'query_time' => $formattedExecutionTime_3,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน AccessibilityLogModel
                AccessibilityLogModel::create($accessibility_log_data);
                
                if($accessibility_groupname_model !== null && $accessibility_groupname_model->status_id === 1) {
                    // ส่งค่าคืนกลับไปยังหน้า palliative care พร้อมกับ Data Start
                    return view('program.palliativeCare', compact('data', 'zbm_rpst_name', 'fiscal_year', 'sidebar_sub1_menu_id'));
                    // ส่งค่าคืนกลับไปยังหน้า palliative care พร้อมกับ Data End
                } else {
                    $startTime_4 = microtime(true);

                    $query_4 = AccessibilityModel::where('accessibility_name', $data['name'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);

                    // ดึงข้อมูลจาก Query (ดึงหลายแถว)
                    $accessibility_name_model = $query_4->first();
                
                    // ดึง SQL query พร้อม bindings
                    $sql_4 = $query_4->toSql();
                    $bindings_4 = $query_4->getBindings();
                    $fullSql_4 = vsprintf(str_replace('?', "'%s'", $sql_4), $bindings_4);
                
                    $endTime_4 = microtime(true);
                    $executionTime_4 = $endTime_4 - $startTime_4;
                    $formattedExecutionTime_4 = number_format($executionTime_4, 3);
                
                    // ดึง username จาก method someMethod
                    // $username = $this->someMethod($request);
                
                    // สร้างข้อมูลสำหรับบันทึกใน log
                    $accessibility_log_data = [
                        'function' => "Where accessibility_name = {$data['name']} AND sidebar_sub1_menu_id = {$SidebarSub1MenuId->id}",
                        'username' => $data['loginname'],
                        'command_sql' => $fullSql_4,
                        'query_time' => $formattedExecutionTime_4,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน AccessibilityLogModel
                    AccessibilityLogModel::create($accessibility_log_data);

                    if($accessibility_name_model !== null && $accessibility_name_model->status_id === 1) {
                        // ส่งค่าคืนกลับไปยังหน้า palliative care พร้อมกับ Data Start
                        return view('program.palliativeCare', compact('data', 'zbm_rpst_name', 'fiscal_year', 'sidebar_sub1_menu_id'));
                        // ส่งค่าคืนกลับไปยังหน้า palliative care พร้อมกับ Data End
                    } else {
                        $request->session()->put('error', 'ไม่มีสิทธิ์เข้าใช้งานระบบ Palliative Care หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        // $request->session()->put('error', 'ณ ตอนนี้ทีม IT ขออนุญาตปิดปรับปรุงระบบ Pallliative Care ขออภัยในความไม่สะดวก!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบ Palliative Care ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }
    // หน้าแรกของ Palliative Care End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลคนไข้ Palliative Care ที่เสียชีวิตตาม Diag จาก Request ที่ถูกส่งเข้ามา Start
        public function getPalliativeCareSelectData(Request $request) {
            if($request->min_date == 0 || $request->max_date == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณากรอกวันที่ ที่ต้องการดูข้อมูลด้วยครับ',
                    'icon' => 'error'
                ]);
            } else {
                // เริ่มนับเวลา
                $startTime = microtime(true);
        
                // สร้าง query
                $query = DB::table('vn_stat as vs')
                    ->select(DB::raw('COUNT(DISTINCT vs.hn) as kk'), 'vs.pdx')
                    ->leftJoin('ovst_community_service as oc', function($join) {
                        $join->on('oc.vn', '=', 'vs.vn')
                            ->whereBetween('oc.ovst_community_service_type_id', [1, 103]);
                    })
                    ->leftJoin('patient as pt', 'pt.hn', '=', 'vs.hn')
                    ->leftJoin('thaiaddress as th', 'th.addressid', '=', 'pt.addressid')  // ปรับการ JOIN address
                    ->leftJoin('zbm_rpst_name as zrn', 'vs.hospsub', '=', 'zrn.rpst_id')
                    ->leftJoin('opitemrece as opi', 'vs.vn', '=', 'opi.vn')
                    ->leftJoin('nondrugitems as ndi', 'opi.icode', '=', 'ndi.icode')
                    ->where(function($query) {
                        $query->whereIn('vs.pdx', ['Z515'])
                            ->orWhereIn('vs.dx0', ['Z515'])
                            ->orWhereIn('vs.dx1', ['Z515'])
                            ->orWhereIn('vs.dx2', ['Z515'])
                            ->orWhereIn('vs.dx3', ['Z515'])
                            ->orWhereIn('vs.dx4', ['Z515'])
                            ->orWhereIn('vs.dx5', ['Z515'])
                            ->orWhere('ndi.name', 'EVA001 ประเมินอาการผู้ป่วย Palliative ที่บ้านเพื่อปรับการรักษา');
                    })
                    ->whereBetween('vs.vstdate', [$request->min_date, $request->max_date])
                    ->where('pt.death', 'Y')
                    ->groupBy('vs.pdx')
                ;
        
                // ดึงข้อมูลจาก query
                $summarize_count_death = $query->get();

                // ดึง SQL query พร้อม bindings
                $sql = $query->toSql();
                $bindings = $query->getBindings();
                $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
            
                $endTime = microtime(true);
                $executionTime = $endTime - $startTime;
                $formattedExecutionTime = number_format($executionTime, 3);

                // ดึง username จาก method someMethod
                $username = $this->someMethod($request);

                // สร้างข้อมูลสำหรับบันทึกใน log
                $palliative_care_log_data = [
                    'function' => 'getPalliativeCareSelectData',
                    'username' => $username,
                    'command_sql' => $fullSql,
                    'query_time' => $formattedExecutionTime,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน PalliativeCareLogModel
                PalliativeCareLogModel::create($palliative_care_log_data);
        
                // ตรวจสอบว่ามีข้อมูลหรือไม่
                if($summarize_count_death->isNotEmpty()) {
                    // เรียกฟังก์ชันเพื่อทำ chart
                    $chart_count_death = $this->getChartCountDeath($summarize_count_death);
        
                    return response()->json([
                        'status' => 200,
                        'chart_count_death' => $chart_count_death
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'title' => 'Error',
                        'message' => 'ไม่มีจำนวนผู้เสียชีวิตตาม วัน เดือน ปี ที่ท่านเลือก!',
                        'icon' => 'error'
                    ]);
                }
            }
        }
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลคนไข้ Palliative Care ที่เสียชีวิตตาม Diag จาก Request ที่ถูกส่งเข้ามา End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายชื่อคนไข้ Palliative Care จาก Request ที่ถูกส่งเข้ามา Start
        public function getPalliativeCareFetchListName(Request $request) {
            $min_date = $request->min_date;
            $max_date = $request->max_date;
        
            // ตรวจสอบวันที่
            if ($min_date == 0 || $max_date == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกวันที่รับบริการ',
                    'icon' => 'error'
                ]);
            }

            $startTime = microtime(true);
        
            // Query ข้อมูลจากฐานข้อมูล
            $query = DB::table('vn_stat as vs')
                ->select(
                    'vs.vstdate',
                    'vs.vn',
                    'ptt.name as pttype_name',
                    'vs.hn',
                    'pt.cid',
                    DB::raw("CONCAT(pt.pname, pt.fname, ' ', pt.lname) AS fullname"),
                    'pt.birthday',
                    DB::raw('(YEAR(NOW()) - YEAR(pt.birthday)) AS age'),
                    DB::raw("CONCAT(pt.addrpart, ' หมู่ ', pt.moopart, ' ', th.full_name) AS fulladdress"),
                    'zn.rpst_name',
                    'zn.rpst_id',
                    'vs.pdx',
                    DB::raw("
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
                        END AS Z515
                    "),
                    DB::raw("
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
                        END AS Z718
                    "),
                    DB::raw("
                        (
                            SELECT COUNT(*)
                            FROM ovst_community_service a1
                            INNER JOIN vn_stat vn ON vn.vn = a1.vn
                            WHERE vn.hn = vs.hn
                            AND a1.ovst_community_service_type_id BETWEEN 1 AND 103
                        ) AS dayc
                    "),
                    DB::raw("
                        (
                            SELECT COUNT(*)
                            FROM ovst_community_service a1
                            INNER JOIN vn_stat vn ON vn.vn = a1.vn
                            INNER JOIN ovstdiag di ON di.vn = vn.vn
                            WHERE di.icd10 = 'Z718'
                            AND vn.hn = vs.hn
                            AND a1.ovst_community_service_type_id BETWEEN 1 AND 103
                        ) AS dayc1
                    "),
                    'pt.death',
                    'pt.deathday',
                    DB::raw("
                        DATEDIFF(NOW(), (
                            SELECT MAX(a1.entry_datetime)
                            FROM ovst_community_service a1
                            INNER JOIN vn_stat vn ON vn.vn = a1.vn
                            WHERE vn.hn = vs.hn
                            AND a1.ovst_community_service_type_id BETWEEN 1 AND 103
                        )) AS daym
                    "),
                    DB::raw("
                        (
                            SELECT COUNT(r.REP)
                            FROM eclaimdb.m_registerdata r
                            LEFT JOIN eclaimdb.m_ppcom p ON p.ECLAIM_NO = r.ECLAIM_NO
                            WHERE NOT ISNULL(p.ECLAIM_NO) AND p.GR_ITEMNAME = '3 Palliative Care'
                            AND r.HN = vs.hn
                        ) AS ec
                    "),
                    DB::raw("
                        (
                            SELECT SUM(s.PallativeCare)
                            FROM rcmdb.repeclaim s
                            WHERE s.HN = vs.hn
                            AND s.PallativeCare > 0
                        ) AS money
                    ")
                )
                ->join('pttype as ptt', 'vs.pttype', '=', 'ptt.pttype')
                ->leftJoin('ovst_community_service as oc', function($join) {
                    $join->on('oc.vn', '=', 'vs.vn')
                        ->whereBetween('oc.ovst_community_service_type_id', [1, 103]);
                })
                ->leftJoin('patient as pt', 'pt.hn', '=', 'vs.hn')
                ->leftJoin('thaiaddress as th', DB::raw("th.addressid"), '=', DB::raw("CONCAT(pt.chwpart, pt.amppart, pt.tmbpart)"))
                ->leftJoin('zbm_rpst as zr', function ($join) {
                    $join->on('zr.chwpart', '=', 'pt.chwpart')
                        ->on('zr.amppart', '=', 'pt.amppart')
                        ->on('zr.tmbpart', '=', 'pt.tmbpart')
                        ->on('zr.moopart', '=', 'pt.moopart');
                })
                ->leftJoin('zbm_rpst_name as zn', 'zn.rpst_id', '=', 'zr.rpst_id')
                ->leftJoin('opitemrece as opi', 'vs.vn', '=', 'opi.vn')
                ->leftJoin('nondrugitems as ndi', 'opi.icode', '=', 'ndi.icode')
                ->where(function($query) {
                    $query->where('vs.pdx', 'Z515')
                        ->orWhere('vs.dx0', 'Z515')
                        ->orWhere('vs.dx1', 'Z515')
                        ->orWhere('vs.dx2', 'Z515')
                        ->orWhere('vs.dx3', 'Z515')
                        ->orWhere('vs.dx4', 'Z515')
                        ->orWhere('vs.dx5', 'Z515')
                        ->orWhere('ndi.name', 'EVA001 ประเมินอาการผู้ป่วย Palliative ที่บ้านเพื่อปรับการรักษา');
                })
                ->whereBetween('vs.vstdate', [$min_date, $max_date])
            ;

            // ตรวจสอบว่า $service_unit และ $death_type ไม่เป็นค่าว่างก่อนใช้ whereRaw

            $data_notIn = [
                '11098', '05532', '05533', '05534', '05535', '05536', '05537', '05538', '05539', '05540', '05541', '13976'
            ];

            if ($request->service_unit == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกหน่วยบริการ',
                    'icon' => 'error'
                ]);
            } elseif ($request->service_unit == 99999) {
                $service_unit = "";
            } elseif ($request->service_unit == 11111) {
                $query->whereNotIn('vs.hospsub', $data_notIn);
            } else {
                $query->where('vs.hospsub', $request->service_unit);
            }

            if ($request->death_type == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกสถานะ',
                    'icon' => 'error'
                ]);
            } elseif ($request->death_type == 99999) {
                $death_type = "";
            } else {
                $query->where('pt.death', $request->death_type);
            }

            $query->groupBy('vs.vn')
                ->orderBy('vs.hn', 'DESC');

            $palliativeCareFetchListName = $query->get();

            // ดึง SQL query พร้อม bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);
        
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $formattedExecutionTime = number_format($executionTime, 3);

            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $palliative_care_log_data = [
                'function' => 'getPalliativeCareFetchListName',
                'username' => $username,
                'command_sql' => $fullSql,
                'query_time' => $formattedExecutionTime,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($palliative_care_log_data);
            
                // Debug ข้อมูล
            // dd($palliativeCareFetchListName);
        
            $output = '';
        
            if ($palliativeCareFetchListName->isNotEmpty()) {
                // สร้างตาราง
                $output .= '<table id="table-fetch-list-name" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th style="width: auto;">วันที่รับบริการ</th>
                        <th style="width: auto;">สิทธิ์</th>
                        <th style="width: auto;">HN</th>
                        <th style="width: auto;">VN</th>
                        <th style="width: auto;">ชื่อ - สกุล</th>
                        <th style="width: auto;">เลขบัตรประชาชน</th>
                        <th style="width: auto;">วันเกิด</th>
                        <th style="width: auto;">อายุ</th>
                        <th style="width: auto;">ที่อยู่</th>
                        <th style="width: auto;">รพสต</th>
                        <th style="width: auto;">รหัส PDX</th>
                        <th style="width: auto;">เพิ่มACP</th>
                        <th style="width: auto;">ACP Detail</th>
                        <th style="width: auto;">เยี่ยมบ้าน<br>Z718</th>
                        <th style="width: auto;">เยี่ยมบ้าน<br>รพ.(ครั้ง)</th>
                        <th style="width: auto;">ชดเชย</th>
                        <th style="width: auto;">หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>';
                // ลูปข้อมูลเพื่อนำไปแสดงในตาราง
                foreach ($palliativeCareFetchListName as $pcfln) {
                    // เช็คสถานะการเสียชีวิต
                    if ($pcfln->death == 'Y') {
                        if($pcfln->deathday == '') {
                            $class = 'table-danger';
                            $bgColor = "text-dark";
                            $deathMessage = 'คนไข้เสียชีวิตแล้ว : ไม่มีวันเสียชีวิตในระบบ';
                        } else {
                            $class = 'table-danger';
                            $bgColor = "text-dark";
                            $deathday = $this->DateThai($pcfln->deathday);
                            $deathMessage = 'คนไข้เสียชีวิตแล้ว : ' . $deathday . ' ';
                        }
                    } else {
                        $class = 'table-light';
                        $bgColor = "";
                        $deathMessage = 'คนไข้ยังมีชีวิตอยู่';
                        if ($pcfln->daym < 30) {
                            $class = 'table-light';
                            $deathMessage = '<span class="">เยี่ยม ' . $pcfln->daym . ' วันที่แล้ว</span>';
                        } elseif ($pcfln->daym < 60) {
                            $class = 'table-primary';
                            $deathMessage = '<span class="">เยี่ยม 1 เดือนที่แล้ว</span>';
                        } elseif ($pcfln->daym < 90) {
                            $class = 'table-primary';
                            $deathMessage = '<span class="">เยี่ยม 2 เดือนที่แล้ว</span>';
                        } elseif ($pcfln->daym < 120) {
                            $class = 'table-success';
                            $deathMessage = '<span class="">เยี่ยม 3 เดือนที่แล้ว</span>';
                        } elseif ($pcfln->daym < 210) {
                            $class = 'table-success';
                            $deathMessage = '<span class="">เยี่ยม 6 เดือนที่แล้ว</span>';
                        } elseif ($pcfln->daym < 420) {
                            $class = 'table-warning';
                            $deathMessage = '<span class="">เยี่ยม 1 ปีที่แล้ว</span>';
                        } else {
                            $class = '';
                            $deathMessage = '<span class="">เยี่ยมมากกว่า 1 ปี</span>';
                        }
                    }
                
                    // สร้างแถวของตาราง
                    $vstdate = $this->DateThai($pcfln->vstdate);
                    $birthday = $this->DateThai($pcfln->birthday);
                
                    $acp_model = AdvanceCarePlanModel::where('acp_vn', $pcfln->vn)->first(); // ใช้ first() เพื่อดึงข้อมูลเดียว
                
                    $output .= '<tr class="' . $class . '">
                        <td>' . $vstdate . '</td>
                        <td>' . $pcfln->pttype_name . '</td>
                        <td>' . $pcfln->hn . '</td>
                        <td>' . $pcfln->vn . '</td>
                        <td>' . $pcfln->fullname . '</td>
                        <td>' . $pcfln->cid . '</td>
                        <td>' . $birthday . '</td>
                        <td>' . $pcfln->age . '</td>
                        <td>' . $pcfln->fulladdress . '</td>
                        <td>' . $pcfln->rpst_name . '</td>
                        <td>' . $pcfln->pdx . '</td>
                        <td>
                            <button type="button" 
                                id="' . $pcfln->vn . '" 
                                class="btn btn-success advance_care_plan_add zoom-card" 
                                data-bs-toggle="modal" 
                                data-bs-target="#advance_care_plan_modal"
                                data-fullname="' . $pcfln->fullname . '" 
                                data-hn="' . $pcfln->hn . '"
                                data-cid="' . $pcfln->cid . '"
                            >
                                +
                            </button>
                        </td>
                        <td>';
                
                    // เช็คว่ามีข้อมูลใน acp_model หรือไม่
                    if ($acp_model) {
                        $output .= '<button type="button" 
                            id="' . $acp_model->acp_vn . '" 
                            class="btn btn-secondary advance_care_plan_detail zoom-card" 
                            data-bs-toggle="modal" 
                            data-bs-target="#advance_care_plan_detail_modal"
                            data-vn="' . $acp_model->acp_vn . '"
                        >
                            ' . $acp_model->acp_vn . '
                        </button>';
                    } else {
                        $output .= '-'; // ถ้าไม่มีข้อมูลให้แสดงค่าว่าง
                    }
                
                    $output .= '</td>
                        <td>
                            <button type="button" id="' . $pcfln->hn . '" class="btn btn-warning home-visiting-information-z718 zoom-card" data-bs-toggle="modal" data-bs-target="#home_visiting_information_z718">
                                ' . $pcfln->dayc1 . '
                            </button>
                        </td>
                        <td>
                            <button type="button" id="' . $pcfln->hn . '" class="btn btn-warning home-visiting-information zoom-card" data-bs-toggle="modal" data-bs-target="#home_visiting_information">
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
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลรายชื่อคนไข้ Palliative Care จาก Request ที่ถูกส่งเข้ามา End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลการเยี่ยมบ้าน รพ.(ครั้ง) จาก Request ที่ถูกส่งเข้ามา Start
        public function getHomeVisitingInformation(Request $request) {
            $hn = $request->id;

            $startTime_1 = microtime(true);

            $query_1 = DB::table('ovst_community_service as oc')
                ->select(
                    DB::raw('DATE(oc.entry_datetime) AS vstdate'),
                    'dt.name as dtname',
                    'os.cc',
                    'os.hpi',
                    DB::raw('GROUP_CONCAT(DISTINCT ot.ovst_community_service_type_name) AS csname'),
                    'os.temperature',
                    'os.pulse',
                    'os.rr',
                    DB::raw("CONCAT(LEFT(os.bps, 3), '/', LEFT(os.bpd, 2)) as bp")
                )
                ->join('opdscreen as os', 'os.vn', '=', 'oc.vn')
                ->join('ovst_community_service_type as ot', 'ot.ovst_community_service_type_id', '=', 'oc.ovst_community_service_type_id')
                ->join(DB::raw("(SELECT cs.vn FROM ovst_community_service cs INNER JOIN vn_stat vn ON vn.vn = cs.vn AND cs.ovst_community_service_type_id BETWEEN 1 AND 103 AND vn.hn = '{$hn}') as tb"), 'tb.vn', '=', 'oc.vn')
                ->leftJoin('doctor as dt', 'dt.code', '=', 'oc.doctor')
                ->where('os.hn', $hn)
                ->groupBy('oc.vn')
                ->orderBy('oc.vn', 'DESC')
            ;

            $ovst_community_service = $query_1->get();

            // ดึง SQL query_1 พร้อม bindings
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);

            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $ovst_community_service_log_data = [
                'function' => 'getHomeVisitingInformation => Query : ovst_community_service',
                'username' => $username,
                'command_sql' => $fullSql_1,
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($ovst_community_service_log_data);

            $startTime_2 = microtime(true);

            $query_2 = DB::table('patient as pt')
                ->select(
                    'pt.hn',
                    'pt.cid',
                    DB::raw("CONCAT(pt.pname, pt.fname, ' ', pt.lname) AS fullname"),
                    DB::raw("CONCAT(pt.addrpart, ' หมู่ ', pt.moopart, ' ', th.full_name) AS fulladdress"),
                    'zn.rpst_name'
                )
                ->leftJoin('thaiaddress as th', DB::raw("CONCAT(pt.chwpart, pt.amppart, pt.tmbpart)"), '=', 'th.addressid')
                ->leftJoin('zbm_rpst as zr', function($join) {
                    $join->on('zr.chwpart', '=', 'pt.chwpart')
                         ->on('zr.amppart', '=', 'pt.amppart')
                         ->on('zr.tmbpart', '=', 'pt.tmbpart')
                         ->on('zr.moopart', '=', 'pt.moopart');
                })
                ->leftJoin('zbm_rpst_name as zn', 'zn.rpst_id', '=', 'zr.rpst_id')
                ->where('pt.hn', $hn)
                ->groupBy('pt.hn')
            ;

            $patient = $query_2->get();

            // ดึง SQL query_2 พร้อม bindings
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);

            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $patient_log_data = [
                'function' => 'getHomeVisitingInformation => Query : patient',
                'username' => $username,
                'command_sql' => $fullSql_2,
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($patient_log_data);

            $output = '';

            if($ovst_community_service->isNotEmpty() && $patient->isNotEmpty()) {
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
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลการเยี่ยมบ้าน รพ.(ครั้ง) จาก Request ที่ถูกส่งเข้ามา End

    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลการเยี่ยมบ้าน Z718 จาก Request ที่ถูกส่งเข้ามา Start
        public function getHomeVisitingInformationZ718(Request $request) {
            $hn = $request->id;

            $startTime_1 = microtime(true);

            $query_1 = DB::table('ovst_community_service as oc')
                ->select(
                    DB::raw('DATE(oc.entry_datetime) AS vstdate'),
                    'dt.name as dtname',
                    'os.cc',
                    'os.hpi',
                    DB::raw('GROUP_CONCAT(DISTINCT ot.ovst_community_service_type_name) AS csname'),
                    'di.icd10',
                    DB::raw("
                        IF(ov.pdx = 'Z515' OR ov.dx0 = 'Z515' OR ov.dx1 = 'Z515' OR ov.dx2 = 'Z515'
                        OR ov.dx3 = 'Z515' OR ov.dx4 = 'Z515' OR ov.dx5 = 'Z515', 'Z515', NULL) AS Z515
                    "),
                    DB::raw("
                        IF(ov.pdx = 'Z718' OR ov.dx0 = 'Z718' OR ov.dx1 = 'Z718' OR ov.dx2 = 'Z718'
                        OR ov.dx3 = 'Z718' OR ov.dx4 = 'Z718' OR ov.dx5 = 'Z718', 'Z718', NULL) AS Z718
                    ")
                )
                ->join('opdscreen as os', 'os.vn', '=', 'oc.vn')
                ->join('ovst_community_service_type as ot', 'ot.ovst_community_service_type_id', '=', 'oc.ovst_community_service_type_id')
                ->join(DB::raw("(SELECT cs.vn FROM ovst_community_service cs INNER JOIN vn_stat vn ON vn.vn = cs.vn AND cs.ovst_community_service_type_id BETWEEN 1 AND 103 AND vn.hn = '{$hn}') as tb"), 'tb.vn', '=', 'oc.vn')
                ->leftJoin('doctor as dt', 'dt.code', '=', 'oc.doctor')
                ->leftJoin('ovstdiag as di', 'oc.vn', '=', 'di.vn')
                ->leftJoin('vn_stat as ov', 'ov.vn', '=', 'oc.vn')
                ->where(function ($query) {
                    $query->where('ov.pdx', 'Z515')
                        ->orWhere('ov.dx0', 'Z515')
                        ->orWhere('ov.dx1', 'Z515')
                        ->orWhere('ov.dx2', 'Z515')
                        ->orWhere('ov.dx3', 'Z515')
                        ->orWhere('ov.dx4', 'Z515')
                        ->orWhere('ov.dx5', 'Z515');
                })
                ->where(function ($query) {
                    $query->where('ov.pdx', 'Z718')
                        ->orWhere('ov.dx0', 'Z718')
                        ->orWhere('ov.dx1', 'Z718')
                        ->orWhere('ov.dx2', 'Z718')
                        ->orWhere('ov.dx3', 'Z718')
                        ->orWhere('ov.dx4', 'Z718')
                        ->orWhere('ov.dx5', 'Z718');
                })
                ->where('os.hn', $hn)
                ->groupBy('oc.vn')
                ->orderBy('oc.vn', 'DESC')
            ;

            $ovst_community_service = $query_1->get();

            // ดึง SQL query_1 พร้อม bindings
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);

            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $ovst_community_service_log_data = [
                'function' => 'getHomeVisitingInformationZ718 => Query : ovst_community_service',
                'username' => $username,
                'command_sql' => $fullSql_1,
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($ovst_community_service_log_data);

            $startTime_2 = microtime(true);
            
            $query_2 = DB::table('patient as pt')
                ->select(
                    'pt.hn',
                    'pt.cid',
                    DB::raw("CONCAT(pt.pname, pt.fname, ' ', pt.lname) AS fullname"),
                    DB::raw("CONCAT(pt.addrpart, ' หมู่ ', pt.moopart, ' ', th.full_name) AS fulladdress"),
                    'zn.rpst_name'
                )
                ->leftJoin('thaiaddress as th', DB::raw("CONCAT(pt.chwpart, pt.amppart, pt.tmbpart)"), '=', 'th.addressid')
                ->leftJoin('zbm_rpst as zr', function($join) {
                    $join->on('zr.chwpart', '=', 'pt.chwpart')
                         ->on('zr.amppart', '=', 'pt.amppart')
                         ->on('zr.tmbpart', '=', 'pt.tmbpart')
                         ->on('zr.moopart', '=', 'pt.moopart');
                })
                ->leftJoin('zbm_rpst_name as zn', 'zn.rpst_id', '=', 'zr.rpst_id')
                ->where('pt.hn', $hn)
                ->groupBy('pt.hn')
            ;

            $patient = $query_2->get();

            // ดึง SQL query_2 พร้อม bindings
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);

            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $patient_log_data = [
                'function' => 'getHomeVisitingInformationZ718 => Query : patient',
                'username' => $username,
                'command_sql' => $fullSql_2,
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($patient_log_data);

            $output = '';

            if($ovst_community_service->isNotEmpty() && $patient->isNotEmpty()) {
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
    // Funtion สำหรับจัดการเกี่ยวกับข้อมูลการเยี่ยมบ้าน Z718 จาก Request ที่ถูกส่งเข้ามา End

    // Function สำหรับจัดการ ทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้ว Start
        public function getEclaimReceivedMoney(Request $request) {
            $rcmdb_repeclaim = $this->queryEclaimReceivedMoney($request);

            $output = '';

            if (count($rcmdb_repeclaim) > 0) {
                $output .= '<table id="table-eclaim-received-money" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
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
    // Function สำหรับจัดการ ทะเบียนผู้ป่วยส่งเบิก E-Claim ที่ได้รับเงินแล้ว End

    // Function สำหรับจัดการ Palliative Care คนไข้รายใหม่ตามเดือนและปีปัจจุบัน Start
        public function getNumberOfNewPatients(Request $request) {
            $request_1 = "MONTH(v.vstdate) = MONTH(CURRENT_DATE())";
            $request_2 = "LAST_DAY(CURRENT_DATE() - INTERVAL 1 MONTH)";

            $number_of_new_patients = $this->queryNumberOfNewPatients($request_1, $request_2, $request);

            $output = '';

            if (count($number_of_new_patients) != false) {
                $output .= '
                <table id="table-number-of-new-patients" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
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
                $i = 0;
                foreach ($number_of_new_patients as $nonp) {
                    $changeDate = $this->DateThai($nonp->day1);
                    $output .= '<tr>
                    <td>' . ++$i . '</td>
                    <td>' . $nonp->hn . '</td>
                    <td>' . $nonp->fullname . '</td>
                    <td>' . $nonp->pdx . '</td>
                    <td>' . $nonp->pttype_name . '</td>
                    <td>' . $nonp->age . '</td>
                    <td>' . $changeDate . '</td>
                    <td>' . $nonp->fulladdress . '</td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการคนไข้รายใหม่</h1>';
            }
        }
    // Function สำหรับจัดการ Palliative Care คนไข้รายใหม่ตามเดือนและปีปัจจุบัน End

    // Function สำหรับจัดการ Palliative Care คนไข้รายใหม่ตาม ปีงบประมาณ ของ Request ที่ส่งเข้ามา Start
        public function getNumberOfNewPatientsSelectFiscalYears(Request $request) {
            $years = $request->nonpsfy_years;

            if($years == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกปีงบประมาณก่อนครับ',
                    'icon' => 'error'
                ]);
            }

            $years = $years - 543;

            $firstDayOfMonth = date('Y-m-01', mktime(0, 0, 0, 10, 1, $years - 1));
            $lastDayOfMonth = date('Y-m-t', mktime(0, 0, 0, 9, 1, $years));

            $request_1 = "v.vstdate BETWEEN '{$firstDayOfMonth}' AND '{$lastDayOfMonth}'";
            $request_2 = "'{$firstDayOfMonth}'";

            $number_of_new_patients = $this->queryNumberOfNewPatients($request_1, $request_2, $request);

            $output = '';

            if (count($number_of_new_patients) != false) {
                $output .= '
                <table id="table-number-of-new-patients-select-fiscal-years" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
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
                $i = 0;
                foreach ($number_of_new_patients as $nonp) {
                    $changeDate = $this->DateThai($nonp->day1);
                    $output .= '<tr>
                    <td>' . ++$i . '</td>
                    <td>' . $nonp->hn . '</td>
                    <td>' . $nonp->fullname . '</td>
                    <td>' . $nonp->pdx . '</td>
                    <td>' . $nonp->pttype_name . '</td>
                    <td>' . $nonp->age . '</td>
                    <td>' . $changeDate . '</td>
                    <td>' . $nonp->fulladdress . '</td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการคนไข้รายใหม่</h1>';
            }
        }
    // Function สำหรับจัดการ Palliative Care คนไข้รายใหม่ตาม ปีงบประมาณ ของ Request ที่ส่งเข้ามา End

    // Function สำหรับจัดการ Palliative Care คนไข้รายใหม่ตาม กำหนดเอง ของ Request ที่ส่งเข้ามา Start
        public function getPatientDateRangeSelect(Request $request) {
            $date_1 = $request->pdrs_1;
            $date_2 = $request->pdrs_2;

            if($date_1 == 0 || $date_2 == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกเดือนที่ต้องการก่อนครับ',
                    'icon' => 'error'
                ]);
            }

            $date_all = $this->isThaiYear($date_1, $date_2);

            if($date_all == false) {
                return response()->json([
                    'message' => 'ไม่มีข้อมูลถูกส่งไป'
                ]);
            } else {
                $date_1 = $date_all['date_1'];
                $date_2 = $date_all['date_2'];
            }

            $request_1 = "v.vstdate BETWEEN '{$date_1}' AND '{$date_2}'";
            $request_2 = "'{$date_1}'";

            $number_of_new_patients = $this->queryNumberOfNewPatients($request_1, $request_2, $request);

            $output = '';

            if (count($number_of_new_patients) != false) {
                $output .= '
                <table id="table-patient-date-range-select" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
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
                $i = 0;
                foreach ($number_of_new_patients as $nonp) {
                    $changeDate = $this->DateThai($nonp->day1);
                    $output .= '<tr>
                    <td>' . ++$i . '</td>
                    <td>' . $nonp->hn . '</td>
                    <td>' . $nonp->fullname . '</td>
                    <td>' . $nonp->pdx . '</td>
                    <td>' . $nonp->pttype_name . '</td>
                    <td>' . $nonp->age . '</td>
                    <td>' . $changeDate . '</td>
                    <td>' . $nonp->fulladdress . '</td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการคนไข้รายใหม่</h1>';
            }
        }
    // Function สำหรับจัดการ Palliative Care คนไข้รายใหม่ตาม กำหนดเอง ของ Request ที่ส่งเข้ามา End

    // Function สำหรับจัดการ Palliative Care คนไข้รายเก่าตามเดือนและปีปัจจุบัน Start
        public function getNumberOfOldPatients(Request $request) {
            $currentYear = date('Y');
            $currentMonth = date('m');

            $firstDayOfMonth = date('Y-m-01', mktime(0, 0, 0, $currentMonth, 1, $currentYear));
            $lastDayOfMonth = date('Y-m-t', mktime(0, 0, 0, $currentMonth, 1, $currentYear));

            $number_of_old_patients = $this->queryNumberOfOldPatients($firstDayOfMonth, $lastDayOfMonth, $request);

            $output = '';

            if (count($number_of_old_patients) != false) {
                $output .= '
                <table id="table-number-of-old-patients" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>ลำดับ</th>
                        <th>hn</th>
                        <th>ชื่อ - สกุล</th>
                        <th>ที่อยู่</th>
                    </tr>
                </thead>
                <tbody>';
                $i = 0;
                foreach ($number_of_old_patients as $noop) {
                    $output .= '<tr>
                    <td>' . ++$i . '</td>
                    <td>' . $noop->hn . '</td>
                    <td>' . $noop->fullname . '</td>
                    <td>' . $noop->fulladdress . '</td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการคนไข้รายเก่า</h1>';
            }
        }
    // Function สำหรับจัดการ Palliative Care คนไข้รายเก่าตามเดือนและปีปัจจุบัน End

    // Function สำหรับจัดการ Palliative Care คนไข้รายเก่าตาม เดือน-ปี ของ Request ที่ส่งเข้ามา Start
        public function getNumberOfOldPatientsSelectFiscalYears(Request $request) {
            $years = $request->noopsfy_years;

            if($years == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกปีงบประมาณก่อนครับ',
                    'icon' => 'error'
                ]);
            }

            $years = $years - 543;

            $firstDayOfMonth = date('Y-m-01', mktime(0, 0, 0, 10, 1, $years - 1));
            $lastDayOfMonth = date('Y-m-t', mktime(0, 0, 0, 9, 1, $years));

            $number_of_old_patients = $this->queryNumberOfOldPatients($firstDayOfMonth, $lastDayOfMonth, $request);

            $output = '';

            if (count($number_of_old_patients) != false) {
                $output .= '
                <table id="table-number-of-old-patients-select-fiscal-years" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>ลำดับ</th>
                        <th>hn</th>
                        <th>ชื่อ - สกุล</th>
                        <th>ที่อยู่</th>
                    </tr>
                </thead>
                <tbody>';
                $i = 0;
                foreach ($number_of_old_patients as $noop) {
                    $output .= '<tr>
                    <td>' . ++$i . '</td>
                    <td>' . $noop->hn . '</td>
                    <td>' . $noop->fullname . '</td>
                    <td>' . $noop->fulladdress . '</td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการคนไข้รายเก่า</h1>';
            }
        }
    // Function สำหรับจัดการ Palliative Care คนไข้รายเก่าตาม เดือน-ปี ของ Request ที่ส่งเข้ามา End

    // Function สำหรับจัดการ Palliative Care คนไข้รายเก่าตาม กำหนดเอง ของ Request ที่ส่งเข้ามา Start
        public function getPatientDateRangeSelectOld(Request $request) {
            $date_1 = $request->pdrso_1;
            $date_2 = $request->pdrso_2;

            if($date_1 == 0 || $date_2 == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกเดือนที่ต้องการก่อนครับ',
                    'icon' => 'error'
                ]);
            }

            $date_all = $this->isThaiYear($date_1, $date_2);

            if($date_all == false) {
                return response()->json([
                    'message' => 'ไม่มีข้อมูลถูกส่งไป'
                ]);
            } else {
                $date_1 = $date_all['date_1'];
                $date_2 = $date_all['date_2'];
            }

            $number_of_old_patients = $this->queryNumberOfOldPatients($date_1, $date_2, $request);

            $output = '';

            if (count($number_of_old_patients) != false) {
                $output .= '
                <table id="table-patient-date-range-select-old" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>ลำดับ</th>
                        <th>hn</th>
                        <th>ชื่อ - สกุล</th>
                        <th>ที่อยู่</th>
                    </tr>
                </thead>
                <tbody>';
                $i = 0;
                foreach ($number_of_old_patients as $noop) {
                    $output .= '<tr>
                    <td>' . ++$i . '</td>
                    <td>' . $noop->hn . '</td>
                    <td>' . $noop->fullname . '</td>
                    <td>' . $noop->fulladdress . '</td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการคนไข้รายเก่า</h1>';
            }
        }
    // Function สำหรับจัดการ Palliative Care คนไข้รายเก่าตาม กำหนดเอง ของ Request ที่ส่งเข้ามา End

    // Function สำหรับจัดการ Palliative Care ที่มีอาการปวด( Pain ) Start
        public function getPalliativeCarePatientsPain(Request $request) {
            $currentYear = date('Y');
            $currentMonth = date('m');

            $firstDayOfMonth = date('Y-m-01', mktime(0, 0, 0, $currentMonth, 1, $currentYear));
            $lastDayOfMonth = date('Y-m-t', mktime(0, 0, 0, $currentMonth, 1, $currentYear));

            $palliative_care_patients_pain = $this->queryPalliativeCarePatientsPain($firstDayOfMonth, $lastDayOfMonth, $request);

            $output = '';

            if (count($palliative_care_patients_pain) != false) {
                $output .= '
                <table id="table-number-of-old-patients" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>ลำดับ</th>
                        <th>hn</th>
                        <th>ชื่อ - สกุล</th>
                        <th>ที่อยู่</th>
                    </tr>
                </thead>
                <tbody>';
                $i = 0;
                foreach ($palliative_care_patients_pain as $pcpp) {
                    $output .= '<tr>
                    <td>' . ++$i . '</td>
                    <td>' . $pcpp->hn . '</td>
                    <td>' . $pcpp->fullname . '</td>
                    <td>' . $pcpp->fulladdress . '</td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการคนไข้ที่มีอาการปวด( Pain )</h1>';
            }
        }
    // Function สำหรับจัดการ Palliative Care ที่มีอาการปวด( Pain ) End

    // Function สำหรับจัดการ Palliative Care ที่มีอาการปวด( Pain ) เดือน-ปี ของ Request ที่ส่งเข้ามา Start
        public function getPalliativeCarePatientsWithPainFiscalYears(Request $request) {
            $years = $request->pcpwpf_years;

            if($years == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกปีงบประมาณก่อนครับ',
                    'icon' => 'error'
                ]);
            }

            $years = $years - 543;

            $firstDayOfMonth = date('Y-m-01', mktime(0, 0, 0, 10, 1, $years - 1));
            $lastDayOfMonth = date('Y-m-t', mktime(0, 0, 0, 9, 1, $years));

            $palliative_care_patients_pain = $this->queryPalliativeCarePatientsPain($firstDayOfMonth, $lastDayOfMonth, $request);

            $output = '';

            if (count($palliative_care_patients_pain) != false) {
                $output .= '
                <table id="table-palliative-care-patients-with-pain-select" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>ลำดับ</th>
                        <th>hn</th>
                        <th>ชื่อ - สกุล</th>
                        <th>ที่อยู่</th>
                    </tr>
                </thead>
                <tbody>';
                $i = 0;
                foreach ($palliative_care_patients_pain as $pcpp) {
                    $output .= '<tr>
                    <td>' . ++$i . '</td>
                    <td>' . $pcpp->hn . '</td>
                    <td>' . $pcpp->fullname . '</td>
                    <td>' . $pcpp->fulladdress . '</td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการคนไข้ที่มีอาการปวด( Pain )</h1>';
            }
        }
    // Function สำหรับจัดการ Palliative Care ที่มีอาการปวด( Pain ) เดือน-ปี ของ Request ที่ส่งเข้ามา End

    // Function สำหรับจัดการ Palliative Care ที่มีอาการปวด( Pain ) กำหนดเอง ของ Request ที่ส่งเข้ามา Start
        public function getPalliativeCarePatientsWithPainDateRangeSelect(Request $request) {
            $date_1 = $request->pcpwpdrs_1;
            $date_2 = $request->pcpwpdrs_2;

            if($date_1 == 0 || $date_2 == 0) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณาเลือกเดือนที่ต้องการก่อนครับ',
                    'icon' => 'error'
                ]);
            }

            $date_all = $this->isThaiYear($date_1, $date_2);

            if($date_all == false) {
                return response()->json([
                    'message' => 'ไม่มีข้อมูลถูกส่งไป'
                ]);
            } else {
                $date_1 = $date_all['date_1'];
                $date_2 = $date_all['date_2'];
            }

            $palliative_care_patients_pain = $this->queryPalliativeCarePatientsPain($date_1, $date_2, $request);

            $output = '';

            if (count($palliative_care_patients_pain) != false) {
                $output .= '
                <table id="table-palliative-care-patients-with-pain-select" class="table table-hover table-bordered table-rounded align-middle dt-responsive nowrap" style="width: 100%">
                <thead class="table-dark">
                    <tr>
                        <th>ลำดับ</th>
                        <th>hn</th>
                        <th>ชื่อ - สกุล</th>
                        <th>ที่อยู่</th>
                    </tr>
                </thead>
                <tbody>';
                $i = 0;
                foreach ($palliative_care_patients_pain as $pcpp) {
                    $output .= '<tr>
                    <td>' . ++$i . '</td>
                    <td>' . $pcpp->hn . '</td>
                    <td>' . $pcpp->fullname . '</td>
                    <td>' . $pcpp->fulladdress . '</td>
                </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการคนไข้ที่มีอาการปวด( Pain )</h1>';
            }
        }
    // Function สำหรับจัดการ Palliative Care ที่มีอาการปวด( Pain ) กำหนดเอง ของ Request ที่ส่งเข้ามา End
}
