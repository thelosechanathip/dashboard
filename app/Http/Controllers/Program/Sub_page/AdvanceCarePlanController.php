<?php

namespace App\Http\Controllers\Program\Sub_page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// เรียกใช้งาน Database
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

use App\Models\Dashboard_Setting\ModuleModel;
use App\Models\Dashboard_Setting\AccessibilityModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;
use App\Models\Dashboard_Setting\AdvanceCarePlanModel;

use App\Models\Log\PalliativeCareLogModel;
use App\Models\Log\ModuleLogModel;
use App\Models\Log\AccessibilityLogModel;
use App\Models\Log\SidebarSub1MenuLogModel;

use Illuminate\Support\Facades\Storage;

class AdvanceCarePlanController extends Controller
{
    // Message Success Start
        private function messageSuccess($message) {
            return response()->json([
                'status' => 200,
                'title' => 'Success',
                'message' => $message,
                'icon' => 'success'
            ]);
        }
    // Message Success End

    // Message Error Start
        private function messageError($message) {
            return response()->json([
                'status' => 400,
                'title' => 'Error',
                'message' => $message,
                'icon' => 'error'
            ]);
        }
    // Message Error End

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

    // หน้าแรกของ Advance Care Plan Start
        public function index(Request $request) {
            $data = $request->session()->all();

            $er_log_data = [
                'function' => 'Come to the Advance Care Plan page',
                'username' => $data['loginname'],
                'command_sql' => '',
                'query_time' => '',
                'operation' => 'OPEN'
            ];
        
            // บันทึกข้อมูลลงใน PalliativeCareLogModel
            PalliativeCareLogModel::create($er_log_data);

            $startTime_1 = microtime(true);

            $query_1 = ModuleModel::where('module_name', 'Advance Care Plan');

            $advanceCarePlanId = $query_1->first();
        
            // ดึง SQL query_1 พร้อม bindings
            $sql_1 = $query_1->toSql();
            $bindings_1 = $query_1->getBindings();
            $fullSql_1 = vsprintf(str_replace('?', "'%s'", $sql_1), $bindings_1);
        
            $endTime_1 = microtime(true);
            $executionTime_1 = $endTime_1 - $startTime_1;
            $formattedExecutionTime_1 = number_format($executionTime_1, 3);

            // สร้างข้อมูลสำหรับบันทึกใน log
            $module_log_data = [
                'function' => 'Where module_name = Advance Care Plan',
                'username' => $data['loginname'],
                'command_sql' => $fullSql_1,
                'query_time' => $formattedExecutionTime_1,
                'operation' => 'SELECT'
            ];
        
            // บันทึกข้อมูลลงใน ModuleLogModel
            ModuleLogModel::create($module_log_data);

            if($advanceCarePlanId->status_id === 1) {
                $startTime_2 = microtime(true);

                $query_2 = AccessibilityModel::where('accessibility_name', $data['groupname'])->where('module_id', $advanceCarePlanId->id);
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
                    'function' => 'Where accessibility_name = {groupname} AND {module_id}',
                    'username' => $data['loginname'],
                    'command_sql' => $fullSql_2,
                    'query_time' => $formattedExecutionTime_2,
                    'operation' => 'SELECT'
                ];
            
                // บันทึกข้อมูลลงใน AccessibilityLogModel
                AccessibilityLogModel::create($accessibility_log_data);

                if($accessibility_groupname_model !== null && $accessibility_groupname_model->status_id === 1) {
                    return view('program.sub_page.advance_care_plan', compact('data'));
                } else {
                    $startTime_3 = microtime(true);

                    $query_3 = AccessibilityModel::where('accessibility_name', $data['name'])->where('module_id', $advanceCarePlanId->id);
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
                        'function' => 'Where accessibility_name = {name} AND {module_id}',
                        'username' => $data['loginname'],
                        'command_sql' => $fullSql_3,
                        'query_time' => $formattedExecutionTime_3,
                        'operation' => 'SELECT'
                    ];
                
                    // บันทึกข้อมูลลงใน AccessibilityLogModel
                    AccessibilityLogModel::create($accessibility_log_data);

                    if($accessibility_name_model !== null && $accessibility_name_model->status_id === 1) {
                        return view('program.sub_page.advance_care_plan', compact('data'));
                    } else {
                        $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบ ER หากต้องการใช้งานกรุณาติดต่อ Admin ของระบบ!');
                        return redirect()->route('dashboard');
                    }
                }
            } else {
                $request->session()->put('error', 'ขณะนี้ระบบ ER ไม่ได้เปิดใช้งาน กรุณาแจ้ง Admin หากต้องการใช้งาน!');
                return redirect()->route('dashboard');
            }
        }
    // หน้าแรกของ Advance Care Plan End

    // insertDataAdvanceCarePlan Start
        public function insertDataAdvanceCarePlan(Request $request) {
            if($request->hasFile('file_acp')) {
                $validator = Validator::make($request->all(), [
                    'file_acp' => 'required|mimes:jpg,jpeg,png|max:2048' // จำกัดขนาดไฟล์เป็น 2MB
                ]);
            
                // ถ้าไฟล์ไม่ถูกต้อง ให้ส่ง response กลับไปว่าไฟล์ไม่ถูกต้อง
                if ($validator->fails()) {
                    return response()->json([
                        'title' => 'error',
                        'message' => 'ไฟล์ที่อัปโหลดไม่ถูกต้อง ต้องเป็น JPG, JPEG หรือ PNG เท่านั้น',
                        'icon' => 'error'
                    ]); // 400 = Bad Request
                } else {
                    $file = $request->file('file_acp');
                    $fileName = 'ACP_' . $request->acp_vn . '_' .time() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/advance_care_plan/images', $fileName);
                }
            } else {
                $fileName = '';
            }
            $acp_staff = $this->someMethod($request);

            $acp_data = [
                'acp_vn' => $request->acp_vn,
                'acp_hn' => $request->acp_hn,
                'acp_cid' => $request->acp_cid,
                'acp_fullname' => $request->acp_fullname,
                'detail_of_talking_with_patients' => $request->detail_of_talking_with_patients,
                'file_acp' => $fileName,
                'acp_staff' => $acp_staff,
            ];

            if(AdvanceCarePlanModel::create($acp_data)) {
                $success = $this->messageSuccess("บันทึกข้อมูล Advance Care Plan เสร็จสิ้น!");
                return $success;
            } else {
                $error = $this->messageError("บันทึกข้อมูลล้มเหลว กรุณาติดต่องาน IT!");
                return $error;
            }
        }
    // insertDataAdvanceCarePlan End

    // showDataAdvanceCarePlanDetail Start
        public function showDataAdvanceCarePlanDetail(Request $request) {
            $vn = $request->query('vn'); // ดึง vn จาก query string
        
            // ดึงข้อมูลจาก AdvanceCarePlanModel โดยใช้ get() และเช็คข้อมูล
            $acp_model = AdvanceCarePlanModel::where('acp_vn', $vn)
                ->orderBy('id', 'DESC') // เรียงจากเก่าสุดไปล่าสุด
                ->get();
        
            // เช็คว่ามีข้อมูลใน $acp_model หรือไม่
            if ($acp_model->isEmpty()) {
                return response()->json([
                    'status' => 400,
                    'title' => 'Error',
                    'message' => 'ไม่พบข้อมูล ACP',
                    'icon' => 'error'
                ]);
            }
        
            $output = ''; // เริ่มต้นตัวแปร output เป็นค่าว่าง
        
            foreach ($acp_model as $am) {
                if($am->file_acp != '') {
                    $file_acp = '
                        <img src="' . asset('storage/advance_care_plan/images/' . $am->file_acp) . '" 
                        width="100%" 
                        class="img-thumbnail"
                        data-bs-toggle="modal" 
                        data-bs-target="#imageModal" 
                        data-img="' . asset('storage/advance_care_plan/images/' . $am->file_acp) . '">
                    ';
                } else {
                    $file_acp = 'ไม่มีไฟล์รูปภาพ';
                }
                $output .= '
                    <div class="mt-4 d-flex justify-content-center align-items-center fw-bold">
                        <p><i class="bi bi-house-fill me-2"></i>รายละเอียดของ Advance Care Plan บันทึกครั้งที่ : '. $am->id .'<i class="bi bi-house-fill ms-2"></i></p>
                    </div>
                    <div class="mt-2 row">
                        <div class="col-4 border p-3">
                            <div>' . $file_acp . '</div>
                        </div>
                        <div class="col-8 border p-3">
                            <div><span class="text-danger">เลขที่ Visit : </span>' . $am->acp_vn . '</div>
                            <div><span class="text-danger">HN : </span>' . $am->acp_hn . '</div>
                            <div><span class="text-danger">เลขที่บัตรประจำตัวประชาชน : </span>' . $am->acp_cid . '</div>
                            <div><span class="text-danger">ชื่อ - สกุล : </span>' . $am->acp_fullname . '</div>
                            <div><span class="text-danger">รายละเอียดการคุยกับคนไข้ : </span>' . $am->detail_of_talking_with_patients . '</div>
                            <div><span class="text-danger">ชื่อผู้บันทึกข้อมูล : </span>' . $am->acp_staff . '</div>
                            <div><span class="text-danger">วัน - เวลาที่บันทึกข้อมูล : </span>' . $am->created_at . '</div>
                            <div><span class="text-danger">วัน - เวลาที่อัพเดทข้อมูล : </span>' . $am->updated_at . '</div>
                        </div>
                    </div>';
            }                      
        
            return response()->json($output); // ส่งข้อมูล HTML ที่สร้างไปยัง Ajax
        }
    // showDataAdvanceCarePlanDetail End

    // fetchAllAdvanceCarePlan Start
        public function fetchAllAdvanceCarePlan() {
            $acp_model = AdvanceCarePlanModel::orderBy('id', 'desc')->get();
            $output = '';
            if ($acp_model->count() > 0) {
                $output .= '<table class="table table-hover table-striped table-bordered table-sm text-center align-middle" id="table_advance_care_plan_fetch_data">
                <thead class="table-dark">
                    <tr>
                        <th style="width: auto;">ลำดับ</th>
                        <th style="width: auto;">VN</th>
                        <th style="width: auto;">HN</th>
                        <th style="width: auto;">เลขบัตรประชาชน</th>
                        <th style="width: auto;">ชื่อ - สกุล</th>
                        <th style="width: auto;">รายละเอียดการคุยกับคนไข้</th>
                        <th style="width: auto;">Image</th>
                        <th style="width: auto;">วันที่บันทึกข้อมูล</th>
                        <th style="width: auto;">วันที่แก้ไขข้อมูล</th>
                        <th style="width: auto;">Action</th>
                    </tr>
                </thead>
                <tbody>';
                $id = 0;
                foreach ($acp_model as $am) {
                    $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td class="text-start">' . $am->acp_vn . '</td>
                    <td class="text-start">' . $am->acp_hn . '</td>
                    <td class="text-start">' . $am->acp_cid . '</td>
                    <td class="text-start">' . $am->acp_fullname . '</td>
                    <td class="text-start">' . $am->detail_of_talking_with_patients . '</td>
                    <td class="text-start">
                        <img src="' . asset('storage/advance_care_plan/images/' . $am->file_acp) . '" 
                            width="100%" 
                            class="img-thumbnail"
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" 
                            data-img="' . asset('storage/advance_care_plan/images/' . $am->file_acp) . '">
                    </td>
                    <td class="text-start">' . $am->created_at . '</td>
                    <td class="text-start">' . $am->updated_at . '</td>
                    <td>
                        <a href="#" id="' . $am->id . '" class="text-success mx-1 advance_care_plan_find" data-bs-toggle="modal" data-bs-target="#advance_care_plan_modal"><i class="bi-pencil-square h4"></i></a>
                        <a href="#" id="' . $am->id . '" class="text-danger mx-1 advance_care_plan_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการ Advance Care Plan บน Database!</h1>';
            }
        }
    // fetchAllAdvanceCarePlan End

    // findOneAdvanceCarePlan Start
        public function findOneAdvanceCarePlan(Request $request) {
            $acp_model = AdvanceCarePlanModel::find($request->id);

            return response()->json($acp_model);
        }
    // findOneAdvanceCarePlan End

    // updateDataAdvanceCarePlan Start
        public function updateDataAdvanceCarePlan(Request $request) {
            $fileName = '';
            $acp_model = AdvanceCarePlanModel::find($request->acp_id);
        
            // ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
            if ($request->hasFile('file_acp')) {
                // ตรวจสอบความถูกต้องของไฟล์
                $validator = Validator::make($request->all(), [
                    'file_acp' => 'nullable|mimes:jpg,jpeg,png|max:2048', // จำกัดชนิดไฟล์และขนาดไฟล์ไม่เกิน 2MB
                ]);
        
                if ($validator->fails()) {
                    return response()->json([
                        'title' => 'error',
                        'message' => 'ไฟล์ที่อัปโหลดไม่ถูกต้อง ต้องเป็น JPG, JPEG หรือ PNG เท่านั้น',
                        'icon' => 'error'
                    ]); 
                } else {
                    $file = $request->file('file_acp');
                    $fileName = 'ACP_' . $request->acp_vn . '_' .time() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/advance_care_plan/images', $fileName);
                    
                    // ลบไฟล์เก่าออกหากมี
                    if ($acp_model->file_acp) {
                        // Storage::disk('public')->delete('public/advance_care_plan/images/' . $acp_model->file_acp);
                        Storage::delete('public/advance_care_plan/images/' . $acp_model->file_acp);
                    }
                }
            } else {
                // ถ้าไม่มีการอัปโหลดไฟล์ใหม่ ใช้ไฟล์เดิม
                $fileName = $request->acp_file_acp;
            }
        
            // ดึงชื่อพนักงานหรือข้อมูลอื่นที่จำเป็น
            $acp_staff = $this->someMethod($request);
        
            // อัปเดตข้อมูลในฐานข้อมูล
            $acp_data = [
                'acp_vn' => $request->acp_vn,
                'acp_hn' => $request->acp_hn,
                'acp_cid' => $request->acp_cid,
                'acp_fullname' => $request->acp_fullname,
                'detail_of_talking_with_patients' => $request->detail_of_talking_with_patients,
                'file_acp' => $fileName,
                'acp_staff' => $acp_staff,
            ];
        
            // ใช้ update สำหรับ instance ของโมเดล
            if ($acp_model->update($acp_data)) {
                $success = $this->messageSuccess("อัพเดทข้อมูล Advance Care Plan เสร็จสิ้น!");
                return $success;
            } else {
                $error = $this->messageError("อัพเดทข้อมูลล้มเหลว กรุณาติดต่องาน IT!");
                return $error;
            }
        }
    // updateDataAdvanceCarePlan End

    // deleteAdvanceCarePlan Start
        public function deleteAdvanceCarePlan(Request $request) {
            $id = $request->id;
            $acp_model = AdvanceCarePlanModel::find($id);
            if (Storage::delete('public/advance_care_plan/images/' . $acp_model->file_acp)) {
                AdvanceCarePlanModel::destroy($id);
                $success = $this->messageSuccess("ลบรายการดังกล่าวเสร็จสิ้น!");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถลบรายการได้กรุณาติดต่อเจ้าหน้าที่ IT!");
                return $error;
            }
        }
    // deleteAdvanceCarePlan End
}
