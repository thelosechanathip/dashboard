<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\TypeModel;
use App\Models\Dashboard_Setting\StatusModel;
use App\Models\Dashboard_Setting\ModuleModel;

class ModuleAccessRightsController extends Controller
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

    // Index Start
        public function index(Request $request) {
            // Retrieve session data
            $data = $request->session()->all();

            $status_model = StatusModel::orderBy('id', 'desc')->get();

            // Return the view with the necessary data
            return view('setting.module_access_rights', compact('data', 'status_model'));
        }
    // Index End

    // Fetch All Data Type Start
        public function fetchAllDataType() {
            $type_model = TypeModel::orderBy('id', 'desc')->get();
            $output = '';
            if ($type_model->count() > 0) {
                $output .= '<table class="table table-striped table-sm text-center align-middle">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Type Name</th>
                    <th>วันที่เพิ่มข้อมูล</th>
                    <th>วันที่แก้ไขข้อมูล</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($type_model as $tm) {
                    $output .= '<tr>
                    <td>' . $tm->id . '</td>
                    <td>' . $tm->type_name . '</td>
                    <td>' . $tm->created_at . '</td>
                    <td>' . $tm->updated_at . '</td>
                    <td>
                        <a href="#" id="' . $tm->id . '" class="text-success mx-1 type_modal_find" data-bs-toggle="modal" data-bs-target="#type_modal"><i class="bi-pencil-square h4"></i></a>

                        <a href="#" id="' . $tm->id . '" class="text-danger mx-1 type_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูล Type บน Database!</h1>';
            }
        }
    // Fetch All Data Type End

    // Insert Data Type Start
        public function insertDataType(Request $request) {
            if($request->type_name) {
                $data_type = [
                    'type_name' => $request->type_name
                ];

                if($data_type) {
                    TypeModel::create($data_type);
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
    // Insert Data Type End

    // Find One Data Type Start
        public function findOneDataType(Request $request) {
            $oneType = TypeModel::find($request->id);
            return response()->json($oneType);
        }
    // Find One Data Type End

    // Update Data Type Start
        public function updateDataType(Request $request) {
            $type_model = TypeModel::find($request->type_id_find_one);
            if($request->type_name) {
                $data_type = [
                    'type_name' => $request->type_name
                ];

                if($type_model->update($data_type)) {
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
    // Update Data Type End

    // Delete Data Type Start
        public function deleteDataType(Request $request) {
            $type_model = TypeModel::find($request->id);
            if($type_model) {
                TypeModel::destroy($request->id);
                $success = $this->messageSuccess("ลบข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถลบข้อมูลได้");
                return $error;
            }
        }
    // Delete Data Type End

    // Fetch All Data Status Start
        public function fetchAllDataStatus() {
            $status_model = StatusModel::orderBy('id', 'desc')->get();
            $output = '';
            if ($status_model->count() > 0) {
                $output .= '<table class="table table-striped table-sm text-center align-middle">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Status Name</th>
                    <th>วันที่เพิ่มข้อมูล</th>
                    <th>วันที่แก้ไขข้อมูล</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($status_model as $sm) {
                    $output .= '<tr>
                    <td>' . $sm->id . '</td>
                    <td>' . $sm->status_name . '</td>
                    <td>' . $sm->created_at . '</td>
                    <td>' . $sm->updated_at . '</td>
                    <td>
                        <a href="#" id="' . $sm->id . '" class="text-success mx-1 status_modal_find" data-bs-toggle="modal" data-bs-target="#status_modal"><i class="bi-pencil-square h4"></i></a>

                        <a href="#" id="' . $sm->id . '" class="text-danger mx-1 status_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูล Status บน Database!</h1>';
            }
        }
    // Fetch All Data Status End

    // Insert Data Status Start
        public function insertDataStatus(Request $request) {
            if($request->status_name) {
                $data_status = [
                    'status_name' => $request->status_name
                ];

                if($data_status) {
                    StatusModel::create($data_status);
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
    // Insert Data Status End

    // Find One Data Status Start
        public function findOneDataStatus(Request $request) {
            $oneStatus = StatusModel::find($request->id);
            return response()->json($oneStatus);
        }
    // Find One Data Status End

    // Update Data Status Start
        public function updateDataStatus(Request $request) {
            $status_model = StatusModel::find($request->status_id_find_one);
            if($request->status_name) {
                $data_status = [
                    'status_name' => $request->status_name
                ];

                if($status_model->update($data_status)) {
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
    // Update Data Status End

    // Delete Data Status Start
        public function deleteDataStatus(Request $request) {
            $status_model = StatusModel::find($request->id);
            if($status_model) {
                StatusModel::destroy($request->id);
                $success = $this->messageSuccess("ลบข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถลบข้อมูลได้");
                return $error;
            }
        }
    // Delete Data Status End

    // Fetch All Data Module Start
        public function fetchAllDataModule() {
            $module_model = ModuleModel::orderBy('id', 'desc')->get();
            $output = '';
            if ($module_model->count() > 0) {
                $output .= '<table class="table table-striped table-sm text-center align-middle">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 20%;">Module Name</th>
                        <th style="width: 15%;">วันที่เพิ่มข้อมูล</th>
                        <th style="width: 15%;">วันที่แก้ไขข้อมูล</th>
                        <th style="width: 10%;">สถานะการใช้งาน</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($module_model as $mm) {
                    $output .= '<tr>
                    <td>' . $mm->id . '</td>
                    <td>' . $mm->module_name . '</td>
                    <td>' . $mm->created_at . '</td>
                    <td>' . $mm->updated_at . '</td>
                    <td>
                        <form id="change_status_form" method="POST">
                            ' . csrf_field() . '
                            <input class="visually-hidden" id="module_id" value="' . $mm->id . '">
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input class="form-check-input status_checked_in_module" type="checkbox" id="status_id_in_module" name="status_id_in_module" value="' . $mm->status_id . '"' . ($mm->status_id == 1 ? ' checked' : '') . '>
                            </div>
                        </form>
                    </td>
                    <td>
                        <a href="#" id="' . $mm->id . '" class="text-success mx-1 module_modal_find" data-bs-toggle="modal" data-bs-target="#module_modal"><i class="bi-pencil-square h4"></i></a>

                        <a href="#" id="' . $mm->id . '" class="text-danger mx-1 module_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูล Module บน Database!</h1>';
            }
        }
    // Fetch All Data Module End

    // Insert Data Module Start
        public function insertDataModule(Request $request) {
            if($request->status_id == '0') {
                $error = $this->messageError("กรุณาเลือกสถานะด้วยครับ");
                return $error;
            } else {
                if($request->module_name) {
                    $data_module = [
                        'module_name' => $request->module_name,
                        'status_id' => $request->status_id
                    ];

                    if($data_module) {
                        ModuleModel::create($data_module);
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
        }
    // Insert Data Module End

    // Find One Data Module Start
        public function findOneDataModule(Request $request) {
            $oneModule = ModuleModel::find($request->id);
            return response()->json($oneModule);
        }
    // Find One Data Module End

    // Update Data Module Start
        public function updateDataModule(Request $request) {
            $module_model = ModuleModel::find($request->module_id_find_one);
            if($request->module_name) {
                $data_module = [
                    'module_name' => $request->module_name
                ];

                if($module_model->update($data_module)) {
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
    // Update Data Module End

    // Change Status Id In Module Realtime Start
        public function ChangeStatusIdInModuleRealtime(Request $request) {
            $module_model = ModuleModel::find($request->id);
            if($request->status_id && $request->id) {
                $module_data = [
                    'status_id' => $request->status_id
                ];

                if($module_model->update($module_data)) {
                    $success = $this->messageSuccess("Update สถานะการใช้งานเสร็จสิ้น");
                    return $success;
                } else {
                    $error = $this->messageError("ไม่สามารถ Update สถานะการใช้งานได้!");
                    return $error;
                }
            } else {
                $error = $this->messageError("กรุณาเลือกรายการสถานะ!");
                return $error;
            }
        }
    // Change Status Id In Module Realtime End
}
