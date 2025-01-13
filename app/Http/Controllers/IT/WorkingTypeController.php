<?php

namespace App\Http\Controllers\IT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\WorkingTypeModel;

class WorkingTypeController extends Controller
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

    // Index Working Type Start
        public function index(Request $request) {
            $data = $request->session()->all();

            if($data['groupname'] == 'ผู้ดูแลระบบ'){
                // Return the view with the necessary data
                return view('it.working_type', compact(
                    'data', 
                ));
            } else {
                $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบนี้!');
                return redirect()->route('dashboard');
            }
        }
    // Index Working Type End

    // Fetch All Data Working Type Start
        public function fetchAllDataWorkingType() {
            $working_type_model = WorkingTypeModel::orderBy('id', 'desc')->get();
            $output = '';
            if ($working_type_model->count() > 0) {
                $output .= '<table class="table table-striped table-bordered table-sm text-center align-middle" id="working_type_table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: auto;">ลำดับ</th>
                        <th style="width: auto;">ชื่อประเภทการทำงาน</th>
                        <th style="width: auto;">วันที่เพิ่มข้อมูล</th>
                        <th style="width: auto;">วันที่แก้ไขข้อมูล</th>
                        <th style="width: auto;">Action</th>
                    </tr>
                </thead>
                <tbody>';
                $id = 0;
                foreach ($working_type_model as $wtm) {
                    $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td class="text-start">' . $wtm->working_type_name . '</td>
                    <td>' . $wtm->created_at . '</td>
                    <td>' . $wtm->updated_at . '</td>
                    <td>
                        <a href="#" id="' . $wtm->id . '" class="text-success mx-1 working_type_modal_find" data-bs-toggle="modal" data-bs-target="#working_type_modal"><i class="bi-pencil-square h4"></i></a>

                        <a href="#" id="' . $wtm->id . '" class="text-danger mx-1 working_type_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูล Working Type บน Database!</h1>';
            }
        }
    // Fetch All Data Working Type End

    // Insert Data Working Type Start
        public function insertDataWorkingType(Request $request) {
            if($request->working_type_name) {
                $data_working_type = [
                    'working_type_name' => $request->working_type_name
                ];
    
                if($data_working_type) {
                    WorkingTypeModel::create($data_working_type);
                    $success = $this->messageSuccess("บันทึกข้อมูลเสร็จสิ้น");
                    return $success;
                } else {
                    $error = $this->messageError("ไม่สามารถบันทึกข้อมูลได้");
                    return $error;
                }
            } else {
                $error = $this->messageError("ไม่มีข้อมูลถูกส่งมา");
                return $error;
            }
        }
    // Insert Data Working Type End

    // Find One Data Working Type Start
        public function findOneDataWorkingType(Request $request) {
            $oneWorkingType = WorkingTypeModel::find($request->id);
            return response()->json($oneWorkingType);
        }
    // Find One Data Working Type End

    // Update Data Working Type Start
        public function updateDataWorkingType(Request $request) {
            $working_type_model = WorkingTypeModel::find($request->working_type_id_find_one);
            if($request->working_type_name) {
                $data_working_type = [
                    'working_type_name' => $request->working_type_name
                ];
    
                if($working_type_model->update($data_working_type)) {
                    $success = $this->messageSuccess("แก้ไขข้อมูลเสร็จสิ้น");
                    return $success;
                } else {
                    $error = $this->messageError("ไม่สามารถแก้ไขข้อมูลได้");
                    return $error;
                }
            } else {
                $error = $this->messageError("ไม่มีข้อมูลถูกส่งมา");
                return $error;
            }
        }
    // Update Data Working Type End

    // Delete Data Working Type Start
        public function deleteDataWorkingType(Request $request) {
            $working_type_model = WorkingTypeModel::find($request->id);
            if($working_type_model) {
                WorkingTypeModel::destroy($request->id);
                $success = $this->messageSuccess("ลบข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถลบข้อมูลได้");
                return $error;
            }
        }
    // Delete Data Working Type End
}
