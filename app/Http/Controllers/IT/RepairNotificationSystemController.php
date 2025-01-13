<?php

namespace App\Http\Controllers\IT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OpdUser;
use App\Models\Dashboard_Setting\WorkingTypeModel;
use App\Models\Dashboard_Setting\RepairNotificationSystemModel;

use Illuminate\Support\Facades\Storage;

class RepairNotificationSystemController extends Controller
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

    // Repair Notification System Index Start
        public function index(Request $request) {
            $data = $request->session()->all();

            $opduser_model = OpdUser::all();
            $working_type_model = WorkingTypeModel::all();

            if($data['groupname'] == 'ผู้ดูแลระบบ'){
                // Return the view with the necessary data
                return view('it.repair_notification_system', compact(
                    'data', 
                    'opduser_model',
                    'working_type_model',
                ));
            } else {
                $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบนี้!');
                return redirect()->route('dashboard');
            }
        }
    // Repair Notification System Index End

    // Fetch All Data Repair Notification System Start
        public function fetchAllDataRepairNotificationSystem() {
            $repair_notification_system_model = RepairNotificationSystemModel::orderBy('id', 'desc')->get();
            $output = '';
            if ($repair_notification_system_model->count() > 0) {
                $output .= '<table class="table table-striped table-bordered table-sm text-center align-middle" id="repair_notification_system_table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: auto;">ลำดับ</th>
                        <th style="width: auto;">ชื่อประเภทของงาน</th>
                        <th style="width: auto;">ชื่อผู้แจ้ง</th>
                        <th style="width: auto;">Action</th>
                    </tr>
                </thead>
                <tbody>';
                $id = 0;
                foreach ($repair_notification_system_model as $rnsm) {
                    $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td class="text-start">' . $rnsm->workingType->working_type_name . '</td>
                    <td class="text-start">' . $rnsm->name_of_informant . '</td>
                    <td>
                        <a href="#" id="' . $rnsm->id . '" class="text-warning mx-1 repair_notification_system_modal_detail" data-bs-toggle="modal" data-bs-target="#repair_notification_system_detail_modal"><i class="bi bi-clipboard-fill h4"></i></a>
                        <a href="#" id="' . $rnsm->id . '" class="text-success mx-1 repair_notification_system_modal_find" data-bs-toggle="modal" data-bs-target="#repair_notification_system_modal"><i class="bi-pencil-square h4"></i></a>
                        <a href="#" id="' . $rnsm->id . '" class="text-danger mx-1 repair_notification_system_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีรายการซ่อมบน Database!</h1>';
            }
        }
    // Fetch All Data Repair Notification System End

    // Insert Data Repair Notification System Start
        public function insertDataRepairNotificationSystem(Request $request) {
            $fullname = $this->someMethod($request);

            $signatureData = $request->input('signature');
        
            // ลบ "data:image/png;base64," ออกจากข้อมูล base64
            $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
            $signatureData = str_replace(' ', '+', $signatureData);
            $image = base64_decode($signatureData);
            $fileName = 'signature_' . time() . '.png';
            
            // บันทึกไฟล์ไปยังโฟลเดอร์ Path = "storage/app/public/signatures/repairNotificationSystem"
            $path = 'signatures/repairNotificationSystem/' . $fileName;
            $saveSuccess = Storage::disk('public')->put($path, $image);
            
            // ตรวจสอบว่าการบันทึกไฟล์สำเร็จหรือไม่
            if ($saveSuccess) {
                $repair_notification_system_data = [
                    'working_type_id' => $request->working_type_id,
                    'name_of_informant' => $request->name_of_informant,
                    'detail' => $request->detail,
                    'signature' => $fileName,
                    'repair_staff' => $fullname,
                ];

                if(RepairNotificationSystemModel::create($repair_notification_system_data)) {
                    $success = $this->messageSuccess("บันทึกข้อมูลซ่อมเสร็จสิ้น");
                    return $success;
                } else {
                    $error = $this->messageError("ไม่สามารถบันทึกข้อมูลทั้งหมดลง Database ได้!");
                    return $error;
                }
            } else {
                $error = $this->messageError("ไม่สามารถบันทึกลายเซ็นได้!");
                return $error;
            }
        }
    // Insert Data Repair Notification System End

    // Find One Data Repair Notification System Start
        public function findOneDataRepairNotificationSystem(Request $request) {
            $oneRepairNotificationSystem = RepairNotificationSystemModel::find($request->id);
            return response()->json($oneRepairNotificationSystem);
        }
    // Find One Data Repair Notification System End

    // Update Data Repair Notification System Start
        public function updateDataRepairNotificationSystem(Request $request) {
            $repair_notification_system_model = RepairNotificationSystemModel::find($request->repair_notification_system_id_find_one);
            $fullname = $this->someMethod($request);
            $data_repair_notification_system = [
                'working_type_id' => $request->working_type_id,
                'name_of_informant' => $request->name_of_informant,
                'detail' => $request->detail,
                'repair_staff' => $fullname,
            ];

            if($repair_notification_system_model->update($data_repair_notification_system)) {
                $success = $this->messageSuccess("แก้ไขข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถแก้ไขข้อมูลได้");
                return $error;
            }
        }
    // Update Data Repair Notification System End

    // Delete Data Repair Notification System Start
        public function deleteDataRepairNotificationSystem(Request $request) {
            // ค้นหาข้อมูลจาก Database ด้วย id
            $repair_notification_system_model = RepairNotificationSystemModel::find($request->id);
            
            if ($repair_notification_system_model) {
                // Path ของไฟล์ลายเซ็นที่ถูกบันทึก
                $fileName = 'signatures/repairNotificationSystem/' . $repair_notification_system_model->signature;
                
                // ตรวจสอบว่าไฟล์มีอยู่ใน Storage หรือไม่และลบไฟล์ออก
                if (Storage::disk('public')->exists($fileName)) {
                    Storage::disk('public')->delete($fileName);
                }
                
                // ลบข้อมูลใน Database
                RepairNotificationSystemModel::destroy($request->id);
                
                $success = $this->messageSuccess("ลบข้อมูลและลายเซ็นเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถลบข้อมูลได้");
                return $error;
            }
        }
    // Delete Data Repair Notification System End

    // Detail Data Repair Notification System Start
        public function detailDataRepairNotificationSystem(Request $request) {
            $repair_notification_system = RepairNotificationSystemModel::find($request->id);
            
            if($repair_notification_system) {
                $signaturePath = null;
                
                if ($repair_notification_system->signature) {
                    // สร้าง URL สำหรับไฟล์ที่เก็บใน storage
                    $signaturePath = asset('storage/signatures/repairNotificationSystem/' . $repair_notification_system->signature);
                }
                
                return response()->json([
                    'id' => $repair_notification_system->id,
                    'working_type_id' => $repair_notification_system->workingType->working_type_name,
                    'name_of_informant' => $repair_notification_system->name_of_informant,
                    'repair_staff' => $repair_notification_system->repair_staff,
                    'detail' => $repair_notification_system->detail,
                    'signature' => $signaturePath, // ส่ง URL ของลายเซ็นกลับไปด้วย
                ]);
            } else {
                return response()->json(['error' => 'ไม่พบข้อมูล'], 404);
            }
        }
    // Detail Data Repair Notification System End
}
