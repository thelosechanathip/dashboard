<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\VersionModel;

class AnnouncementAndVersionController extends Controller
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

    // Index Sidebar e Menu Start
        public function index(Request $request) {
            $data = $request->session()->all();

            if($data['groupname'] == 'ผู้ดูแลระบบ'){
                // Return the view with the necessary data
                return view('setting.announcement_and_version', compact('data'));
            } else {
                $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบ');
                return redirect()->route('dashboard');
            }
        }
    // Index Sidebar e Menu End

    // Fetch All Data Version Start
        public function fetchAllDataVersion() {
            $version_model = VersionModel::orderBy('id', 'desc')->get();
            $output = '';
            if ($version_model->count() > 0) {
                $output .= '<table class="table table-striped table-bordered table-sm text-center align-middle" id="version_table">
                <thead>
                    <tr>
                        <th style="width: auto;">ลำดับ</th>
                        <th style="width: auto;">Version</th>
                        <th style="width: auto;">วันที่เพิ่มข้อมูล</th>
                        <th style="width: auto;">วันที่แก้ไขข้อมูล</th>
                        <th style="width: auto;">Action</th>
                    </tr>
                </thead>
                <tbody>';
                $id = 0;
                foreach ($version_model as $vm) {
                    $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td class="text-start">' . $vm->version_name . '</td>
                    <td>' . $vm->created_at . '</td>
                    <td>' . $vm->updated_at . '</td>
                    <td>
                        <a href="#" id="' . $vm->id . '" class="text-success mx-1 version_modal_find" data-bs-toggle="modal" data-bs-target="#version_modal"><i class="bi-pencil-square h4"></i></a>

                        <a href="#" id="' . $vm->id . '" class="text-danger mx-1 version_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูล Version บน Database!</h1>';
            }
        }
    // Fetch All Data Version End

    // Insert Data Version Start
        public function insertDataVersion(Request $request) {
            if($request->version_name) {
                $data_version = [
                    'version_name' => $request->version_name
                ];
    
                if($data_version) {
                    VersionModel::create($data_version);
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
    // Insert Data Version End

    // Find One Data Version Start
        public function findOneDataVersion(Request $request) {
            $oneVersion = VersionModel::find($request->id);
            return response()->json($oneVersion);
        }
    // Find One Data Version End

    // Update Data Version Start
        public function updateDataVersion(Request $request) {
            $version_model = VersionModel::find($request->version_id_find_one);
            if($request->version_name) {
                $data_version = [
                    'version_name' => $request->version_name
                ];
    
                if($version_model->update($data_version)) {
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
    // Update Data Version End

    // Delete Data Version Start
        public function deleteDataVersion(Request $request) {
            $version_model = VersionModel::find($request->id);
            if($version_model) {
                VersionModel::destroy($request->id);
                $success = $this->messageSuccess("ลบข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถลบข้อมูลได้");
                return $error;
            }
        }
    // Delete Data Version End
}
