<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\ModuleModel;
use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;
use App\Models\Dashboard_Setting\ReceivingChartsModel;

use App\Models\Log\ReceivingChartsLogModel;
use App\Models\Log\ModuleLogModel;
use App\Models\Log\AccessibilityLogModel;
use App\Models\Log\SidebarSub1MenuLogModel;

class ReceivingChartsController extends Controller
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

    private function query_dischange_data(Request $request, $date) {
        
        if(is_array($date)) {
            $min_date = $date['min_date'];
            $max_date = $date['max_date'];

            $startTime_1 = microtime(true);

            // สร้าง query ตามช่วงวันที่
            $query_1 = DB::table('ipt as i')
                ->join('patient as pt', 'i.hn', '=', 'pt.hn')
                ->join('doctor as dt', 'i.admdoctor', '=', 'dt.code')
                ->join('ward as w', 'i.ward', '=', 'w.ward')
                ->select(
                    'i.an as an',
                    'i.hn as hn',
                    DB::raw("CONCAT(pt.pname, pt.fname, ' ', pt.lname) as fullname"),
                    'w.name as ward',
                    'i.dchdate as dchdate',
                    'dt.name as doctor',
                    'i.receive_chart_date_time',
                    'i.receive_chart_staff'
                )
                ->whereBetween('i.dchdate', [$min_date, $max_date])
            ;  // รับข้อมูลทั้งหมด

            // ดึงผลลัพธ์ของ query_1
            $dischange_data_report_1 = $query_1->get();
        
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_dischange_data',
                'username' => $username,
                'command_sql' => $fullSql_1,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);

            return $dischange_data_report_1;  // คืนค่าผลลัพธ์จาก query
        } else {
            $startTime_2 = microtime(true);
    
            // สร้าง query ตามปกติ
            $query_2 = DB::table('ipt as i')
                ->join('patient as pt', 'i.hn', '=', 'pt.hn')
                ->join('doctor as dt', 'i.admdoctor', '=', 'dt.code')
                ->join('ward as w', 'i.ward', '=', 'w.ward')
                ->select(
                    'i.an as an',
                    'i.hn as hn',
                    DB::raw("CONCAT(pt.pname, pt.fname, ' ', pt.lname) as fullname"),
                    'w.name as ward',
                    'i.dchdate as dchdate',
                    'dt.name as doctor',
                    'i.receive_chart_date_time',
                    'i.receive_chart_staff'
                )
                ->where('i.dchdate', '=', $date)
            ;
        
            // ดึงผลลัพธ์ของ query_2
            $dischange_data_report_2 = $query_2->get();
        
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_dischange_data',
                'username' => $username,
                'command_sql' => $fullSql_2,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);
        
            return $dischange_data_report_2;
        }
    }

    private function setting_table_dischage_data($dischange_data_report, $receivingChartsModel) {
        $output = '';

        if(count($dischange_data_report) > 0) {
            $output .= '<table id="table-list-dischange-data" class="table table-hover table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead class="table-dark">
              <tr>
                <th style="width: auto;">ลำดับ</th>
                <th style="width: auto;">AN</th>
                <th style="width: auto;">HN</th>
                <th style="width: auto;">Name</th>
                <th style="width: auto;">Ward</th>
                <th style="width: auto;">วันที่ Dischange</th>
                <th style="width: auto;">แพทย์</th>
                <th style="width: auto;">วันที่รับ Chart จากตึก</th>
                <th style="width: auto;">เจ้าหน้าที่ ที่รับ Chart</th>
                <th style="width: auto;">ติ๊กเพื่อส่ง Chart</th>
              </tr>
            </thead>
            <tbody>';
            $id = 0;
			foreach ($dischange_data_report as $ddr) {
                // ค้นหา hn ใน database อื่น
                $existing_hns = $receivingChartsModel->pluck('an')->toArray();
            
                // ตรวจสอบว่าพบข้อมูลหรือไม่
                if (in_array($ddr->an, $existing_hns)) {

                } else {
                    // ถ้าไม่พบข้อมูล
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td>' . $ddr->an . '</td>
                        <td>' . $ddr->hn . '</td>
                        <td>' . $ddr->fullname . '</td>
                        <td>' . $ddr->ward . '</td>
                        <td>' . $ddr->dchdate . '</td>
                        <td>' . $ddr->doctor . '</td>
                        <td>' . $ddr->receive_chart_date_time . '</td>
                        <td>' . $ddr->receive_chart_staff . '</td>
                        <td class="text-center align-middle">
                            <div class="form-check d-flex justify-content-center align-items-center receiving-charts-add">
                                <input type="hidden" class="receiving_charts_an" value="' . $ddr->an . '">
                                <input type="hidden" class="receiving_charts_hn" value="' . $ddr->hn . '">
                                <input type="hidden" class="receiving_charts_fullname" value="' . $ddr->fullname . '">
                                <input type="hidden" class="receiving_charts_ward" value="' . $ddr->ward . '">
                                <input type="hidden" class="receiving_charts_dchdate" value="' . $ddr->dchdate . '">
                                <input type="hidden" class="receiving_charts_doctor" value="' . $ddr->doctor . '">
                                <input type="hidden" class="receiving_charts_receive_chart_date_time" value="' . $ddr->receive_chart_date_time . '">
                                <input type="hidden" class="receiving_charts_receive_chart_staff" value="' . $ddr->receive_chart_staff . '">
                                <input class="form-check-input checkbox_send_doctor" type="checkbox" name="check_sending_chart">
                            </div>
                        </td>
                    </tr>';
                }
            }
            $output .= '</tbody></table>';
            return $output; 
        } else {
            return '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลคนไข้ที่ Dischange ภายในวันนี้!</h1>';
        }
    }

    private function setting_table_receiving_charts_data_send($receivingChartsModel) {
        $output = '';

        if($receivingChartsModel->count() > 0) {
            $output .= '<table id="table-list-receiving-charts-data-send" class="table table-hover table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead class="table-dark">
              <tr>
                <th style="width: auto;">ลำดับ</th>
                <th style="width: auto;">AN</th>
                <th style="width: auto;">HN</th>
                <th style="width: auto;">Name</th>
                <th style="width: auto;">Ward</th>
                <th style="width: auto;">วันที่ Dischange</th>
                <th style="width: auto;">แพทย์</th>
                <th style="width: auto;">วันที่ส่ง Charts ให้แพทย์</th>
                <th style="width: auto;">ติ๊กเพื่อรับ Charts จากแพทย์</th>
              </tr>
            </thead>
            <tbody>';
            $id = 0;
			foreach ($receivingChartsModel as $rcm) {
                // ถ้าไม่พบข้อมูล
                if(!$rcm->check_receipt_of_chart) {
                    $output .= '<tr>
                        <td>' . ++$id . '</td>
                        <td>' . $rcm->an . '</td>
                        <td>' . $rcm->hn . '</td>
                        <td>' . $rcm->name . '</td>
                        <td>' . $rcm->ward . '</td>
                        <td>' . $rcm->dch_date . '</td>
                        <td>' . $rcm->doctor . '</td>
                        <td>' . $rcm->check_sending_chart_date_time . '</td>
                        <td class="text-center align-middle">
                            <div class="form-check d-flex justify-content-center align-items-center receiving-charts-update">
                                <input type="hidden" class="receiving_charts_an" value="' . $rcm->an . '">
                                <input type="hidden" class="receiving_charts_hn" value="' . $rcm->hn . '">
                                <input class="form-check-input checkbox_receive_doctor" type="checkbox" name="checkbox_receive_doctor">
                            </div>
                        </td>
                    </tr>';
                } else {

                }
            }
            $output .= '</tbody></table>';
            return $output;            
        } else {
            return '<h1 class="text-center text-secondary my-5">ไม่มีรายการ Charts ของวันนี้ที่ส่งให้แพทย์!</h1>';
        }
    }

    private function setting_table_receiving_charts_data_receive($receivingChartsModel) {
        $output = '';

        if($receivingChartsModel->count() > 0) {
            $output .= '<table id="table-list-receiving-charts-data-receive" class="table table-hover table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead class="table-dark">
              <tr>
                <th style="width: auto;">AN</th>
                <th style="width: auto;">HN</th>
                <th style="width: auto;">Name</th>
                <th style="width: auto;">Ward</th>
                <th style="width: auto;">วันที่ Dischange</th>
                <th style="width: auto;">แพทย์</th>
                <th style="width: auto;">ส่ง Chart ให้ห้องเรียกเก็บ</th>
                <th style="width: auto;">วัน - เวลา ที่ส่ง Charts ให้แพทย์</th>
                <th style="width: auto;">วัน - เวลา ที่รับ Charts จากแพทย์</th>
              </tr>
            </thead>
            <tbody>';
            $id = 0;
			foreach ($receivingChartsModel as $rcm) {
                // ถ้าไม่พบข้อมูล
                if(!$rcm->check_sending_chart_billing_room) {
                    $output .= '<tr>
                        <td>' . $rcm->an . '</td>
                        <td>' . $rcm->hn . '</td>
                        <td>' . $rcm->name . '</td>
                        <td>' . $rcm->ward . '</td>
                        <td>' . $rcm->dch_date . '</td>
                        <td>' . $rcm->doctor . '</td>
                        <td class="text-center align-middle">
                            <div class="form-check d-flex justify-content-center align-items-center send-billing-room-charts-update">
                                <input type="hidden" class="send_billing_room_charts_an" value="' . $rcm->an . '">
                                <input type="hidden" class="send_billing_room_charts_hn" value="' . $rcm->hn . '">
                                <input class="form-check-input checkbox_send_billing_room" type="checkbox" name="checkbox_send_billing_room">
                            </div>
                        </td>
                        <td>' . $rcm->check_sending_chart_date_time . '</td>
                        <td>' . $rcm->check_receipt_of_chart_date_time . '</td>
                    </tr>';
                } else {

                }
            }
            $output .= '</tbody></table>';
            return $output;            
        } else {
            return '<h1 class="text-center text-secondary my-5">ไม่มีรายการ Charts ของวันนี้ที่รับจากแพทย์!</h1>';
        }
    }

    private function setting_table_receiving_charts_data_send_billing_room($receivingChartsModel) {
        $output = '';

        if($receivingChartsModel->count() > 0) {
            $output .= '<table id="table-list-receiving-charts-data-send-billing-room" class="table table-hover table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead class="table-dark">
              <tr>
                <th style="width: auto;">AN</th>
                <th style="width: auto;">HN</th>
                <th style="width: auto;">Name</th>
                <th style="width: auto;">Ward</th>
                <th style="width: auto;">วันที่ Dischange</th>
                <th style="width: auto;">แพทย์</th>
                <th style="width: auto;">วัน - เวลา ที่ส่ง Charts ให้ห้องเรียกเก็บ</th>
              </tr>
            </thead>
            <tbody>';
            $id = 0;
			foreach ($receivingChartsModel as $rcm) {
                // ถ้าไม่พบข้อมูล
                if($rcm->check_sending_chart_billing_room) {
                    $output .= '<tr>
                        <td>' . $rcm->an . '</td>
                        <td>' . $rcm->hn . '</td>
                        <td>' . $rcm->name . '</td>
                        <td>' . $rcm->ward . '</td>
                        <td>' . $rcm->dch_date . '</td>
                        <td>' . $rcm->doctor . '</td>
                        <td>' . $rcm->check_sending_chart_billing_room_date_time . '</td>
                    </tr>';
                } else {
                    
                }
            }
            $output .= '</tbody></table>';
            return $output;            
        } else {
            return '<h1 class="text-center text-secondary my-5">ไม่มีรายการ Charts ของวันนี้ที่ส่งให้ห้องเรียกเก็บ!</h1>';
        }
    }

    private function query_count_dischange(Request $request, $date) {
        
        if(is_array($date)) {
            $min_date = $date['min_date'];
            $max_date = $date['max_date'];

            $startTime_1 = microtime(true);

            // สร้าง query ตามช่วงวันที่
            $query_1 = DB::table('ipt as i')
                ->join('patient as pt', 'i.hn', '=', 'pt.hn')
                ->join('doctor as dt', 'i.admdoctor', '=', 'dt.code')
                ->join('ward as w', 'i.ward', '=', 'w.ward')
                ->select('dt.name as doctor', DB::raw('COUNT(*) as result'), 'i.dchdate')
                ->whereBetween('i.dchdate', [$min_date, $max_date])
                ->groupBy('i.admdoctor')
            ;  // รับข้อมูลทั้งหมด

            // ดึงผลลัพธ์ของ query_1
            $count_dischange_report_1 = $query_1->get();
        
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_count_dischange',
                'username' => $username,
                'command_sql' => $fullSql_1,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);

            return $count_dischange_report_1;  // คืนค่าผลลัพธ์จาก query
        } else {
            $startTime_2 = microtime(true);
    
            // สร้าง query ตามปกติ
            $query_2 = DB::table('ipt as i')
                ->join('patient as pt', 'i.hn', '=', 'pt.hn')
                ->join('doctor as dt', 'i.admdoctor', '=', 'dt.code')
                ->join('ward as w', 'i.ward', '=', 'w.ward')
                ->select('dt.name as doctor', DB::raw('COUNT(*) as result'))
                ->where('i.dchdate', '=', $date)
                ->groupBy('i.admdoctor')
            ;
        
            // ดึงผลลัพธ์ของ query_2
            $count_dischange_report_2 = $query_2->get();
        
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_count_dischange',
                'username' => $username,
                'command_sql' => $fullSql_2,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);
        
            return $count_dischange_report_2;
        }
    }

    private function query_count_receiving_charts_sending(Request $request, $date) {
        
        if(is_array($date)) {
            $min_date = $date['min_date'];
            $max_date = $date['max_date'];

            $startTime_1 = microtime(true);

            // สร้าง query ตามช่วงวันที่
            $query_1 = ReceivingChartsModel::whereBetween('check_sending_chart_date_time', [$min_date, $max_date])
                ->select('doctor', DB::raw('COUNT(*) as result'))
                ->groupBy('doctor')
            ;  // รับข้อมูลทั้งหมด

            // ดึงผลลัพธ์ของ query_1
            $count_receiving_charts_sending_report_1 = $query_1->get();
        
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_count_receiving_charts_sending',
                'username' => $username,
                'command_sql' => $fullSql_1,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);

            return $count_receiving_charts_sending_report_1;  // คืนค่าผลลัพธ์จาก query
        } else {
            $startTime_2 = microtime(true);
    
            // สร้าง query ตามปกติ
            $query_2 = ReceivingChartsModel::whereDate('check_sending_chart_date_time', '=', $date)
                ->select('doctor', DB::raw('COUNT(*) as result'))
                ->groupBy('doctor')
            ;
        
            // ดึงผลลัพธ์ของ query_2
            $count_receiving_charts_sending_report_2 = $query_2->get();
        
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_count_receiving_charts_sending',
                'username' => $username,
                'command_sql' => $fullSql_2,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);
        
            return $count_receiving_charts_sending_report_2;
        }
    }

    private function query_count_receiving_charts_receive(Request $request, $date) {
        
        if(is_array($date)) {
            $min_date = $date['min_date'];
            $max_date = $date['max_date'];

            $startTime_1 = microtime(true);

            // สร้าง query ตามช่วงวันที่
            $query_1 = ReceivingChartsModel::whereBetween('check_receipt_of_chart_date_time', [$min_date, $max_date])
                ->select('doctor', DB::raw('COUNT(*) as result'))
                ->groupBy('doctor')
            ;  // รับข้อมูลทั้งหมด

            // ดึงผลลัพธ์ของ query_1
            $count_receiving_charts_receive_report_1 = $query_1->get();
        
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_count_receiving_charts_receive',
                'username' => $username,
                'command_sql' => $fullSql_1,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);

            return $count_receiving_charts_receive_report_1;  // คืนค่าผลลัพธ์จาก query
        } else {
            $startTime_2 = microtime(true);
    
            // สร้าง query ตามปกติ
            $query_2 = ReceivingChartsModel::whereDate('check_receipt_of_chart_date_time', '=', $date)
                ->select('doctor', DB::raw('COUNT(*) as result'))
                ->groupBy('doctor')
            ;
        
            // ดึงผลลัพธ์ของ query_2
            $count_receiving_charts_receive_report_2 = $query_2->get();
        
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_count_receiving_charts_receive',
                'username' => $username,
                'command_sql' => $fullSql_2,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);
        
            return $count_receiving_charts_receive_report_2;
        }
    }

    private function query_count_receiving_charts_send_billing_room(Request $request, $date) {
        
        if(is_array($date)) {
            $min_date = $date['min_date'];
            $max_date = $date['max_date'];

            $startTime_1 = microtime(true);

            // สร้าง query ตามช่วงวันที่
            $query_1 = ReceivingChartsModel::whereBetween('check_sending_chart_billing_room_date_time', [$min_date, $max_date])
                ->select('doctor', DB::raw('COUNT(*) as result'))
                ->groupBy('doctor')
            ;  // รับข้อมูลทั้งหมด

            // ดึงผลลัพธ์ของ query_1
            $count_receiving_charts_send_billing_room_report_1 = $query_1->get();
        
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_count_receiving_charts_send_billing_room',
                'username' => $username,
                'command_sql' => $fullSql_1,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);

            return $count_receiving_charts_send_billing_room_report_1;  // คืนค่าผลลัพธ์จาก query
        } else {
            $startTime_2 = microtime(true);
    
            // สร้าง query ตามปกติ
            $query_2 = ReceivingChartsModel::whereDate('check_sending_chart_billing_room_date_time', '=', $date)
                ->select('doctor', DB::raw('COUNT(*) as result'))
                ->groupBy('doctor')
            ;
        
            // ดึงผลลัพธ์ของ query_2
            $count_receiving_charts_send_billing_room_report_2 = $query_2->get();
        
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_count_receiving_charts_send_billing_room',
                'username' => $username,
                'command_sql' => $fullSql_2,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);
        
            return $count_receiving_charts_send_billing_room_report_2;
        }
    }

    private function query_building_from_receiving_charts(Request $request, $date) {
        
        if(is_array($date)) {
            $min_date = $date['min_date'];
            $max_date = $date['max_date'];

            $startTime_1 = microtime(true);

            // สร้าง query ตามช่วงวันที่
            $query_1 = DB::table('ipt as i')
                ->join('patient as pt', 'i.hn', '=', 'pt.hn')
                ->join('doctor as dt', 'i.admdoctor', '=', 'dt.code')
                ->join('ward as w', 'i.ward', '=', 'w.ward')
                ->select(
                    'i.an as an',
                    'i.hn as hn',
                    DB::raw("CONCAT(pt.pname, pt.fname, ' ', pt.lname) as fullname"),
                    'w.name as ward',
                    'i.dchdate as dch_date',
                    'dt.name as doctor'
                )
                ->whereNull('receive_chart_date_time')
                ->whereBetween('dchdate', [$min_date, $max_date])
            ;  // รับข้อมูลทั้งหมด

            // ดึงผลลัพธ์ของ query_1
            $count_building_from_receiving_charts = $query_1->get();
        
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_building_from_receiving_charts',
                'username' => $username,
                'command_sql' => $fullSql_1,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);

            return $count_building_from_receiving_charts;  // คืนค่าผลลัพธ์จาก query
        } else {
            $year_new = $date;
            $year_old = $date - 1;

            $startTime_2 = microtime(true);
    
            // สร้าง query ตามปกติ
            $query_2 = DB::table('ipt as i')
                ->join('patient as pt', 'i.hn', '=', 'pt.hn')
                ->join('doctor as dt', 'i.admdoctor', '=', 'dt.code')
                ->join('ward as w', 'i.ward', '=', 'w.ward')
                ->select(
                    'i.an as an',
                    'i.hn as hn',
                    DB::raw("CONCAT(pt.pname, pt.fname, ' ', pt.lname) as fullname"),
                    'w.name as ward',
                    'i.dchdate as dch_date',
                    'dt.name as doctor'
                )
                ->whereNull('receive_chart_date_time')
                ->whereBetween('dchdate', [$year_old . '-10-01', $year_new . '-09-30'])
            ;
        
            // ดึงผลลัพธ์ของ query_2
            $count_building_from_receiving_charts_2 = $query_2->get();
        
            $sql_2 = $query_2->toSql();
            $bindings_2 = $query_2->getBindings();
            $fullSql_2 = vsprintf(str_replace('?', "'%s'", $sql_2), $bindings_2);
        
            $endTime_2 = microtime(true);
            $executionTime_2 = $endTime_2 - $startTime_2;
            $formattedExecutionTime_2 = number_format($executionTime_2, 3);
        
            // ดึง username จาก method someMethod
            $username = $this->someMethod($request);
            
            // สร้างข้อมูลสำหรับบันทึกใน log
            $receiving_charts_log_data = [
                'function' => 'query_count_building_from_receiving_charts',
                'username' => $username,
                'command_sql' => $fullSql_2,  // เก็บ SQL ที่ถูกแทนค่าจริง
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ReceivingChartsLogModel
            ReceivingChartsLogModel::create($receiving_charts_log_data);
        
            return $count_building_from_receiving_charts_2;
        }
    }

    private function query_get_data_from_an_ipt(Request $request, $an) {

        $startTime_1 = microtime(true);

        // สร้าง query ตามช่วงวันที่
        $query_1 = DB::table('ipt as i')
            ->join('patient as pt', 'i.hn', '=', 'pt.hn')
            ->join('doctor as dt', 'i.admdoctor', '=', 'dt.code')
            ->join('ward as w', 'i.ward', '=', 'w.ward')
            ->select(
                'i.an as an',
                'i.hn as hn',
                DB::raw("CONCAT(pt.pname, pt.fname, ' ', pt.lname) as fullname"),
                'w.name as ward',
                'i.dchdate as dchdate',
                'dt.name as doctor',
                'i.receive_chart_date_time',
                'i.receive_chart_staff'
            )
            ->where('i.an', '=', $an)
        ;  // รับข้อมูลทั้งหมด

        // ดึงผลลัพธ์ของ query_1
        $get_data_from_an_ipt = $query_1->first();
    
        $sql_1 = $query_1->toSql();
        $bindings_1 = $query_1->getBindings();
        $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
    
        $endTime_1 = microtime(true);
        $executionTime_1 = $endTime_1 - $startTime_1;
        $formattedExecutionTime_1 = number_format($executionTime_1, 3);
    
        // ดึง username จาก method someMethod
        $username = $this->someMethod($request);
        
        // สร้างข้อมูลสำหรับบันทึกใน log
        $receiving_charts_log_data = [
            'function' => 'query_get_data_from_an',
            'username' => $username,
            'command_sql' => $fullSql_1,  // เก็บ SQL ที่ถูกแทนค่าจริง
            'query_time' => $formattedExecutionTime_1,
            'operation' => 'SELECT'
        ];
    
        // บันทึกข้อมูลลงใน ReceivingChartsLogModel
        ReceivingChartsLogModel::create($receiving_charts_log_data);

        return $get_data_from_an_ipt;  // คืนค่าผลลัพธ์จาก query
    }

    private function setting_table_count_dischange($count_dischange_report) {
        $output = '';

        if(!$count_dischange_report->isEmpty()) {
            $output .= '<table id="table-list-count-dischange" class="table table-hover table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead class="table-dark">
              <tr>
                <th style="width: auto;">ลำดับ</th>
                <th style="width: auto;">ชื่อแพทย์</th>
                <th style="width: auto;">จำนวนที่ Dischange</th>
              </tr>
            </thead>
            <tbody>';
            $id = 0;
			foreach ($count_dischange_report as $cdr) {
                // ถ้าไม่พบข้อมูล
                $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td>' . $cdr->doctor . '</td>
                    <td>' . $cdr->result . '</td>
                </tr>';
            }
            $output .= '</tbody></table>';
            return $output;           
        } else {
            return '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลคนไข้ที่ Dischange ภายในวันนี้!</h1>';
        }
    }

    private function setting_table_count_receiving_chart_sending($receivingChartsSending) {
        $output = '';

        if(!$receivingChartsSending->isEmpty()) {
            $output .= '<table id="table-list-count-receiving-charts-send" class="table table-hover table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead class="table-dark">
              <tr>
                <th style="width: auto;">ลำดับ</th>
                <th style="width: auto;">ชื่อแพทย์</th>
                <th style="width: auto;">จำนวน Charts ที่ส่งไปให้แพทย์</th>
              </tr>
            </thead>
            <tbody>';
            $id = 0;
			foreach ($receivingChartsSending as $rcs) {
                // ถ้าไม่พบข้อมูล
                $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td>' . $rcs->doctor . '</td>
                    <td>' . $rcs->result . '</td>
                </tr>';
            }
            $output .= '</tbody></table>';
            return $output;           
        } else {
            return '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลคน Charts ที่ส่งไปให้แพทย์ภายในวันนี้!</h1>';
        }
    }

    private function setting_table_count_receiving_chart_receive($receivingChartsReceive) {
        $output = '';

        if(!$receivingChartsReceive->isEmpty()) {
            $output .= '<table id="table-list-count-receiving-charts-receive" class="table table-hover table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead class="table-dark">
              <tr>
                <th style="width: auto;">ลำดับ</th>
                <th style="width: auto;">ชื่อแพทย์</th>
                <th style="width: auto;">จำนวน Charts ที่รับจากแพทย์</th>
              </tr>
            </thead>
            <tbody>';
            $id = 0;
			foreach ($receivingChartsReceive as $rcr) {
                // ถ้าไม่พบข้อมูล
                $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td>' . $rcr->doctor . '</td>
                    <td>' . $rcr->result . '</td>
                </tr>';
            }
            $output .= '</tbody></table>';
            return $output;           
        } else {
            return '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลคน Charts ที่รับจากแพทย์ภายในวันนี้!</h1>';
        }
    }

    private function setting_table_count_receiving_chart_send_billing_room($receivingChartsSendBillingRoom) {
        $output = '';

        if(!$receivingChartsSendBillingRoom->isEmpty()) {
            $output .= '<table id="table-list-count-receiving-charts-send-billing-room" class="table table-hover table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead class="table-dark">
              <tr>
                <th style="width: auto;">ลำดับ</th>
                <th style="width: auto;">ชื่อแพทย์</th>
                <th style="width: auto;">จำนวน Charts ที่รับจากแพทย์</th>
              </tr>
            </thead>
            <tbody>';
            $id = 0;
			foreach ($receivingChartsSendBillingRoom as $rcr) {
                // ถ้าไม่พบข้อมูล
                $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td>' . $rcr->doctor . '</td>
                    <td>' . $rcr->result . '</td>
                </tr>';
            }
            $output .= '</tbody></table>';
            return $output;           
        } else {
            return '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูล Charts คนไข้ที่ส่งให้ห้องเรียกเก็บภายในวันนี้!</h1>';
        }
    }

    private function setting_table_building_from_receiving_charts($query_building_from_receiving_charts) {
        $output = '';

        if(!$query_building_from_receiving_charts->isEmpty()) {
            $output .= '<table id="table-building-from-receiving-charts" class="table table-hover table-striped align-middle dt-responsive nowrap" style="width: 100%">
            <thead class="table-dark">
              <tr>
                <th style="width: auto;">AN</th>
                <th style="width: auto;">HN</th>
                <th style="width: auto;">Name</th>
                <th style="width: auto;">Ward</th>
                <th style="width: auto;">วันที่ Dischange</th>
                <th style="width: auto;">แพทย์</th>
              </tr>
            </thead>
            <tbody>';
            $id = 0;
			foreach ($query_building_from_receiving_charts as $qbfrc) {
                // ถ้าไม่พบข้อมูล
                $output .= '<tr>
                    <td>' . $qbfrc->an . '</td>
                    <td>' . $qbfrc->hn . '</td>
                    <td>' . $qbfrc->fullname . '</td>
                    <td>' . $qbfrc->ward . '</td>
                    <td>' . $qbfrc->dch_date . '</td>
                    <td>' . $qbfrc->doctor . '</td>
                </tr>';
            }
            $output .= '</tbody></table>';
            return $output;           
        } else {
            return '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูล Charts คนไข้ Dischange แล้วแต่ยังค้างอยู่ในตึก!</h1>';
        }
    }

    public function index(Request $request) {
        // Retrieve session data
        $data = $request->session()->all();
        // Get the current year
        $year = date('Y');

        // ดึง username จาก method someMethod
        $username = $this->someMethod($request);
        
        // สร้างข้อมูลสำหรับบันทึกใน log
        $receiving_charts_log_data = [
            'function' => 'Come to the Receiving Charts page ',
            'username' => $username,
            'command_sql' => "", // SQL query ที่มีการแทนค่าจริง
            'query_time' => "",
            'operation' => 'OPEN'
        ];
    
        // บันทึกข้อมูลลงใน ReceivingChartsLogModel
        ReceivingChartsLogModel::create($receiving_charts_log_data);

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
            'function' => "Where sidebar_sub1_menu_name = {$SidebarSub1MenuId->sidebar_sub1_menu_name}", // ใช้ double quotes และการแทนที่ตัวแปรใน string
            'username' => $data['loginname'],
            'command_sql' => $fullSql_1,
            'query_time' => $formattedExecutionTime_1,
            'operation' => 'SELECT'
        ];
    
        // บันทึกข้อมูลลงใน ModuleLogModel
        SidebarSub1MenuLogModel::create($sidebar_sub1_menu_log_data);

        if($SidebarSub1MenuId->status_id === 1) {
            $startTime_2 = microtime(true);

            $query_2 = AccessibilityModel::where('accessibility_name', $data['groupname'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);
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
                'function' => "Where accessibility_name = {$data['groupname']} AND sidebar_sub1_menu_id = {$SidebarSub1MenuId->id}",
                'username' => $data['loginname'],
                'command_sql' => $fullSql_2,
                'query_time' => $formattedExecutionTime_2,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน AccessibilityLogModel
            AccessibilityLogModel::create($accessibility_log_data);

            if($accessibility_groupname_model !== null && $accessibility_groupname_model->status_id === 1) {
                return view('program.receiving_charts', compact('data', 'year'));
            } else {
                $startTime_3 = microtime(true);

                $query_3 = AccessibilityModel::where('accessibility_name', $data['name'])->where('sidebar_sub1_menu_id', $SidebarSub1MenuId->id);
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
                    'function' => "Where accessibility_name = {$data['name']} AND sidebar_sub1_menu_id = {$SidebarSub1MenuId->id}",
                    'username' => $data['loginname'],
                    'command_sql' => $fullSql_3,
                    'query_time' => $formattedExecutionTime_3,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน AccessibilityLogModel
                AccessibilityLogModel::create($accessibility_log_data);

                if($accessibility_name_model !== null && $accessibility_name_model->status_id === 1) {
                    return view('program.receiving_charts', compact('data', 'year'));
                } else {
                    $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบ Receving Charts หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                    return redirect()->route('dashboard');
                }
            }
        } else {
            $request->session()->put('error', 'ขณะนี้ระบบ Receving Charts ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
            return redirect()->route('dashboard');
        }
    } 

    public function dischangeDataFetchAll(Request $request) {
        $date_now = date('Y-m-d');

        $dischange_data_report = $this->query_dischange_data($request, $date_now);

        $receivingChartsModel = ReceivingChartsModel::select('*');

        $output = $this->setting_table_dischage_data($dischange_data_report, $receivingChartsModel);

        if($output) {
            echo $output;
        }
    }

    public function getDischangeDataSelectDate(Request $request) {
        $min_date = $request->ddsdf_min_date;
        $max_date = $request->ddsdf_max_date;
    
        // ตรวจสอบว่า min_date และ max_date มีค่าหรือไม่
        if (!$min_date || !$max_date) {
            return response()->json(['error' => 'Invalid date range'], 400);
        }
    
        // สร้าง array โดยใช้ key 'min_date' และ 'max_date'
        $date = [
            'min_date' => $min_date,
            'max_date' => $max_date
        ];
    
        $dischange_data_report = $this->query_dischange_data($request, $date);
    
        $receivingChartsModel = ReceivingChartsModel::select('*');

        $output = $this->setting_table_dischage_data($dischange_data_report, $receivingChartsModel);

        if($output) {
            echo $output;
        }
    } 
    
    public function receivingChartsInsert(Request $request) {
        $an = $request->input('an');
        $hn = $request->input('hn');
        $fullname = $request->input('fullname');
        $ward = $request->input('ward');
        $dchdate = $request->input('dchdate');
        $doctor = $request->input('doctor');
        $receive_chart_date_time = $request->input('receive_chart_date_time');
        $receive_chart_staff = $request->input('receive_chart_staff');
        $isChecked = $request->input('isChecked');

        $receiving_model_check_an = ReceivingChartsModel::where('an', $an)->exists();

        if ($receiving_model_check_an) {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => 'AN นี้มีอยู่แล้วในระบบ',  // คุณสามารถปรับข้อความได้ตามต้องการ
                'icon' => 'error'
            ]);
        } else {
            if($receive_chart_staff == Null && $receive_chart_date_time == Null) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'ไม่สามารถบันทึกข้อมูลได้เนื่องจากยังไม่มีการรับ Chart จากตึก!',
                    'icon' => 'error'
                ]);
            } else {
                $receiving_charts_data = [
                    'an' => $an,
                    'hn' => $hn,
                    'name' => $fullname,
                    'ward' => $ward,
                    'dch_date' => $dchdate,
                    'doctor' => $doctor,
                    'receive_chart_date_time' => $receive_chart_date_time,
                    'receive_chart_staff' => $receive_chart_staff,
                    'check_sending_chart' => $isChecked,
                    'check_sending_chart_date_time' => date('Y-m-d H:i:s')
                ];
    
                if(ReceivingChartsModel::create($receiving_charts_data)) {
                    return response()->json([
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'ส่งข้อมูล Chart ให้แพทย์เรียบร้อย',
                        'icon' => 'success'
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'title' => 'Error',
                        'message' => 'ไม่สามารถส่งข้อมูล Chart ให้แพทย์ได้',
                        'icon' => 'error'
                    ]);
                }
            }
        }
    }  

    public function receivingChartsUpdate(Request $request) {
        $an = $request->input('an');
        $hn = $request->input('hn');
        $isChecked = $request->input('isChecked');

        $receiving_charts_model = ReceivingChartsModel::where('an', '=', $an)
            ->where('hn', '=', $hn)
            ->whereNull('check_receipt_of_chart')
            ->whereNull('check_receipt_of_chart_date_time')
            ->first()
        ;

        if($receiving_charts_model) {
            $receiving_charts_data = [
                'check_receipt_of_chart' => $isChecked,
                'check_receipt_of_chart_date_time' => date('Y-m-d')
            ];
    
            if($receiving_charts_model->update($receiving_charts_data)) {
                return response()->json([
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'รับข้อมูล Chart จากแพทย์เรียบร้อย',
                    'icon' => 'success'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'ไม่สามารถรับข้อมูล Chart จากแพทย์ได้',
                    'icon' => 'error'
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => 'ไม่สามารถรับข้อมูล Chart จากแพทย์ได้ เนื่องจากมีการรับข้อมูลซ้ำ!',
                'icon' => 'error'
            ]);
        }
        
    } 

    public function receivingChartsDataSendFetchAll(Request $request) {
        $date_now = date('Y-m-d');

        $receivingChartsModel = ReceivingChartsModel::where('check_sending_chart_date_time', '=', $date_now)->get();

        $output = $this->setting_table_receiving_charts_data_send($receivingChartsModel);

        if($output) {
            echo $output;
        }
    }

    public function getReceivingChartsDataSelectDate(Request $request) {
        $min_date = $request->rdssdf_min_date;
        $max_date = $request->rdssdf_max_date;
    
        // ตรวจสอบว่า min_date และ max_date มีค่าหรือไม่
        if (!$min_date || !$max_date) {
            return response()->json(['error' => 'Invalid date range'], 400);
        }
    
        $receivingChartsModel = ReceivingChartsModel::whereBetween('check_sending_chart_date_time', [$min_date, $max_date])->get();

        $output = $this->setting_table_receiving_charts_data_send($receivingChartsModel);

        if($output) {
            echo $output;
        }
    } 

    public function receivingChartsDataReceiveFetchAll(Request $request) {
        $date_now = date('Y-m-d');

        $receivingChartsModel = ReceivingChartsModel::where('check_receipt_of_chart_date_time', '=', $date_now)->get();

        $output = $this->setting_table_receiving_charts_data_receive($receivingChartsModel);

        if($output) {
            echo $output;
        }
    }

    public function getReceivingChartsDataReceiveSelectDate(Request $request) {
        $min_date = $request->rcdsdf_min_date;
        $max_date = $request->rcdsdf_max_date;
    
        // ตรวจสอบว่า min_date และ max_date มีค่าหรือไม่
        if (!$min_date || !$max_date) {
            return response()->json(['error' => 'Invalid date range'], 400);
        }
    
        $receivingChartsModel = ReceivingChartsModel::whereBetween('check_receipt_of_chart_date_time', [$min_date, $max_date])->get();

        $output = $this->setting_table_receiving_charts_data_receive($receivingChartsModel);

        if($output) {
            echo $output;
        }
    } 

    public function fetchAllCountDischange(Request $request) {
        if ($request->has(['ddsdf_min_date', 'ddsdf_max_date'])) {
            
            // ดึงค่าจากฟิลด์
            $minDate = $request->ddsdf_min_date;
            $maxDate = $request->ddsdf_max_date;
    
            // ตรวจสอบว่ามีค่าหรือไม่
            if (empty($minDate) || empty($maxDate)) {
                return response()->json(['error' => 'กรุณากรอกข้อมูลให้ครบถ้วน'], 400);
            }

            $date = [
                'min_date' => $minDate,
                'max_date' => $maxDate
            ];
    
            $count_dischange_report = $this->query_count_dischange($request, $date);
        
            $output = $this->setting_table_count_dischange($count_dischange_report);
        
            echo $output;  // ส่งกลับ HTML แทน JSON
        } else {
            $date_now = date('Y-m-d');
    
            $count_dischange_report = $this->query_count_dischange($request, $date_now);
        
            $output = $this->setting_table_count_dischange($count_dischange_report);
        
            echo $output;  // ส่งกลับ HTML แทน JSON
        }
    }

    public function fetchAllCountReceivingChartsSending(Request $request) {
        if ($request->has(['rdssdf_min_date', 'rdssdf_max_date'])) {
            
            // ดึงค่าจากฟิลด์
            $minDate = $request->rdssdf_min_date;
            $maxDate = $request->rdssdf_max_date;
    
            // ตรวจสอบว่ามีค่าหรือไม่
            if (empty($minDate) || empty($maxDate)) {
                return response()->json(['error' => 'กรุณากรอกข้อมูลให้ครบถ้วน'], 400);
            }

            $date = [
                'min_date' => $minDate,
                'max_date' => $maxDate
            ];
    
            $receivingChartsSending = $this->query_count_receiving_charts_sending($request, $date);
        
            $output = $this->setting_table_count_receiving_chart_sending($receivingChartsSending);
        
            echo $output;  // ส่งกลับ HTML แทน JSON
        } else {
            $date_now = date('Y-m-d');
    
            $receivingChartsSending = $this->query_count_receiving_charts_sending($request, $date_now);
        
            $output = $this->setting_table_count_receiving_chart_sending($receivingChartsSending);
        
            echo $output;  // ส่งกลับ HTML แทน JSON
        }
    }

    public function fetchAllCountReceivingChartsReceive(Request $request) {
        if ($request->has(['rcdsdf_min_date', 'rcdsdf_max_date'])) {
            
            // ดึงค่าจากฟิลด์
            $minDate = $request->rcdsdf_min_date;
            $maxDate = $request->rcdsdf_max_date;
    
            // ตรวจสอบว่ามีค่าหรือไม่
            if (empty($minDate) || empty($maxDate)) {
                return response()->json(['error' => 'กรุณากรอกข้อมูลให้ครบถ้วน'], 400);
            }

            $date = [
                'min_date' => $minDate,
                'max_date' => $maxDate
            ];
    
            $receivingChartsReceive = $this->query_count_receiving_charts_receive($request, $date);
        
            $output = $this->setting_table_count_receiving_chart_receive($receivingChartsReceive);
        
            echo $output;  // ส่งกลับ HTML แทน JSON
        } else {
            $date_now = date('Y-m-d');
    
            $receivingChartsReceive = $this->query_count_receiving_charts_receive($request, $date_now);
        
            $output = $this->setting_table_count_receiving_chart_receive($receivingChartsReceive);
        
            echo $output;  // ส่งกลับ HTML แทน JSON
        }
    }

    public function searchDataFromAn(Request $request) {
        $an = $request->search_an;

        $query_data_1 = $this->query_get_data_from_an_ipt($request, $an);
        $query_data_2 = ReceivingChartsModel::where('an', $an)->first();

        if($query_data_1->receive_chart_staff == Null && $query_data_1->receive_chart_date_time == Null) {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => 'ยังไม่มีการรับ Chart จากตึก',
                'icon' => 'error'
            ]);
        } else if($query_data_1->receive_chart_staff != Null && $query_data_1->receive_chart_date_time != Null && $query_data_2 == Null) {
            return response()->json([
                'status' => 200,
                'title' => 'Success',
                'message' => 'ข้อมูลคนไข้อยู่ในหน้า ( ข้อมูลคนไข้ Dischange ) วันที่คนไข้ Dischange : ' . $query_data_1->dchdate,
                'icon' => 'success'
            ]);
        } else if($query_data_1->receive_chart_staff != Null && $query_data_1->receive_chart_date_time != Null && $query_data_2->check_sending_chart_date_time != Null && $query_data_2->check_receipt_of_chart_date_time == Null) {
            return response()->json([
                'status' => 200,
                'title' => 'Success',
                'message' => 'ข้อมูลคนไข้อยู่ในหน้า ( ข้อมูล Chart คนไข้ที่ส่งแพทย์ ) วันที่ส่ง Chart ให้แพทย์ : ' . $query_data_2->check_sending_chart_date_time,
                'icon' => 'success'
            ]);
        } else if($query_data_1->receive_chart_staff != Null && $query_data_1->receive_chart_date_time != Null && $query_data_2->check_sending_chart_date_time != Null && $query_data_2->check_receipt_of_chart_date_time != Null && $query_data_2->check_sending_chart_billing_room_date_time == Null) {
            return response()->json([
                'status' => 200,
                'title' => 'Success',
                'message' => 'ข้อมูลคนไข้อยู่ในหน้า ( ข้อมูล Chart คนไข้ที่รับจากแพทย์ ) วันที่รับ Chart จากแพทย์ : ' . $query_data_2->check_receipt_of_chart_date_time,
                'icon' => 'success'
            ]);
        } else if($query_data_1->receive_chart_staff != Null && $query_data_1->receive_chart_date_time != Null && $query_data_2->check_sending_chart_date_time != Null && $query_data_2->check_receipt_of_chart_date_time != Null && $query_data_2->check_sending_chart_billing_room_date_time != Null) {
            return response()->json([
                'status' => 200,
                'title' => 'Success',
                'message' => 'ข้อมูลคนไข้อยู่ในหน้า ( ข้อมูล Chart คนไข้ที่ส่งไปยังห้องเรียกเก็บ ) วันที่ส่ง Chart ไปยังห้องเรียกเก็บ : ' . $query_data_2->check_sending_chart_billing_room_date_time,
                'icon' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => 'เกิดข้อผิดพลาดกรุณาแจ้งทีม IT เพื่อแก้ไขปัญหาโดยด่วน!',
                'icon' => 'error'
            ]);
        }
        
    }

    // All Send to Billing Room Start
        public function receivingChartsDataSendBillingRoomFetchAll(Request $request) {
            $date_now = date('Y-m-d');

            $receivingChartsModel = ReceivingChartsModel::where('check_sending_chart_billing_room_date_time', '=', $date_now)->get();

            $output = $this->setting_table_receiving_charts_data_send_billing_room($receivingChartsModel);

            if($output) {
                echo $output;
            }
        }

        public function getReceivingChartsDataSendBillingRoomSelectDate(Request $request) {
            $min_date = $request->rcdst16_min_date;
            $max_date = $request->rcdst16_max_date;
        
            // ตรวจสอบว่า min_date และ max_date มีค่าหรือไม่
            if (!$min_date || !$max_date) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'กรุณากรอกวันที่ให้ครบ',
                    'icon' => 'error'
                ]);
            }
        
            $receivingChartsModel = ReceivingChartsModel::whereBetween('check_sending_chart_billing_room_date_time', [$min_date, $max_date])->get();

            $output = $this->setting_table_receiving_charts_data_send_billing_room($receivingChartsModel);

            if($output) {
                echo $output;
            }
        } 

        public function receivingChartsUpdateBillingRoom(Request $request) {
            $an = $request->input('an');
            $hn = $request->input('hn');
            $isChecked = $request->input('isChecked');

            $receiving_charts_model = ReceivingChartsModel::where('an', '=', $an)
                ->where('hn', '=', $hn)
                ->whereNull('check_sending_chart_billing_room')
                ->whereNull('check_sending_chart_billing_room_date_time')
                ->first()
            ;

            if($receiving_charts_model) {
                $receiving_charts_data = [
                    'check_sending_chart_billing_room' => $isChecked,
                    'check_sending_chart_billing_room_date_time' => date('Y-m-d')
                ];
    
                if($receiving_charts_model->update($receiving_charts_data)) {
                    return response()->json([
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'ส่งข้อมูล Chart ให้ห้องเรียกเก็บเรียบร้อย',
                        'icon' => 'success'
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'title' => 'Error',
                        'message' => 'ไม่สามารถส่งข้อมูล Chart ไปยังห้องเรียกเก็บได้',
                        'icon' => 'error'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'ไม่สามารถส่งข้อมูลซ้ำได้ เนื่องจากมีการส่งข้อมูลเรียบร้อย!',
                    'icon' => 'error'
                ]);
            }

        }

        public function fetchAllCountReceivingChartsSendBillingRoom(Request $request) {
            if ($request->has(['rcdst16_min_date', 'rcdst16_max_date'])) {
                
                // ดึงค่าจากฟิลด์
                $minDate = $request->rcdst16_min_date;
                $maxDate = $request->rcdst16_max_date;
        
                // ตรวจสอบว่ามีค่าหรือไม่
                if (empty($minDate) || empty($maxDate)) {
                    return response()->json(['error' => 'กรุณากรอกข้อมูลให้ครบถ้วน'], 400);
                }
    
                $date = [
                    'min_date' => $minDate,
                    'max_date' => $maxDate
                ];
        
                $receivingChartsSendBillingRoom = $this->query_count_receiving_charts_send_billing_room($request, $date);
            
                $output = $this->setting_table_count_receiving_chart_send_billing_room($receivingChartsSendBillingRoom);
            
                echo $output;  // ส่งกลับ HTML แทน JSON
            } else {
                $date_now = date('Y-m-d');
        
                $receivingChartsSendBillingRoom = $this->query_count_receiving_charts_send_billing_room($request, $date_now);
            
                $output = $this->setting_table_count_receiving_chart_send_billing_room($receivingChartsSendBillingRoom);
            
                echo $output;  // ส่งกลับ HTML แทน JSON
            }
        }
    // All Send to Billing Room End

    // Building From Receiving Charts( คนไข้ Dischange แล้วแต่ Charts ยังค้างอยู่ในตึก ) Start
    public function getBuildingFromReceivingCharts(Request $request) {
        if($request->has(['bfrcs_min_date', 'bfrcs_max_date'])) {
            // ดึงค่าจากฟิลด์
            $min_date = $request->bfrcs_min_date;
            $max_date = $request->bfrcs_max_date;

            $date = [
                'min_date' => $min_date,
                'max_date' => $max_date
            ];

            $query_building_from_receiving_charts = $this->query_building_from_receiving_charts($request, $date);

            $setting_table_building_from_receiving_charts = $this->setting_table_building_from_receiving_charts($query_building_from_receiving_charts);

            echo $setting_table_building_from_receiving_charts;
        } else {
            $year_now = date('Y');

            $query_building_from_receiving_charts = $this->query_building_from_receiving_charts($request, $year_now);

            $setting_table_building_from_receiving_charts = $this->setting_table_building_from_receiving_charts($query_building_from_receiving_charts);

            echo $setting_table_building_from_receiving_charts;
        }
    }
    // Building From Receiving Charts( คนไข้ Dischange แล้วแต่ Charts ยังค้างอยู่ในตึก ) End
}
