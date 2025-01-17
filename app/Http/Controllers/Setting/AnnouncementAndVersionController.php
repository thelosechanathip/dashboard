<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\VersionModel;
use App\Models\Dashboard_Setting\VersionDetailModel;
use App\Models\Dashboard_Setting\FiscalYearModel;

class AnnouncementAndVersionController extends Controller
{
    private function checkYear($year){

        // ตรวจสอบว่าปีที่ส่งมาเป็น พ.ศ. หรือ ค.ศ.
        if ($year > 2500) {
            // ถ้ามากกว่า 2500 ถือว่าเป็น พ.ศ. 
            $era = 'พ.ศ.';
            $converted_year = $year - 543; // แปลงเป็น ค.ศ.
        } elseif ($year >= 1900 && $year <= 2500) {
            // ช่วงของปีที่น่าจะเป็น ค.ศ.
            $era = 'ค.ศ.';
            $converted_year = $year; // ไม่ต้องแปลง
        } else {
            // ถ้าปีไม่อยู่ในช่วงที่เป็นไปได้ อาจเป็นข้อมูลไม่ถูกต้อง
            return response()->json(['error' => 'ข้อมูลปีไม่ถูกต้อง'], 400);
        }

        // ส่งข้อมูลกลับไปที่ client
        return $converted_year;
    }

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

            $version_model = VersionModel::orderBy('id', 'desc')->get();

            if($data['groupname'] == 'ผู้ดูแลระบบ'){
                // Return the view with the necessary data
                return view('setting.announcement_and_version', compact('data', 'version_model'));
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
                $output .= '<div class="table-responsive">';
                $output .= '<table class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap" style="width: 100%" id="version_table">
                <thead class="table-dark">
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
                    <td class="text-center">' . $vm->version_name . '</td>
                    <td>' . $vm->created_at . '</td>
                    <td>' . $vm->updated_at . '</td>
                    <td>
                        <a href="#" id="' . $vm->id . '" class="text-success mx-1 version_modal_find" data-bs-toggle="modal" data-bs-target="#version_modal"><i class="bi-pencil-square h4"></i></a>

                        <a href="#" id="' . $vm->id . '" class="text-danger mx-1 version_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                $output .= '</div>';
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

    // Fetch All Data Version Detail Start
        public function fetchAllDataVersionDetail() {
            $version_detail_model = VersionDetailModel::orderBy('id', 'desc')->get();
            $output = '';
            if ($version_detail_model->count() > 0) {
                $output .= '<table class="table table-striped table-bordered table-sm text-center align-middle" id="version_detail_table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: auto;">ลำดับ</th>
                        <th style="width: auto;">Version</th>
                        <th style="width: auto;">รายละเอียดการ Update</th>
                        <th style="width: auto;">วันที่เพิ่มข้อมูล</th>
                        <th style="width: auto;">วันที่แก้ไขข้อมูล</th>
                        <th style="width: auto;">Action</th>
                    </tr>
                </thead>
                <tbody>';
                $id = 0;
                foreach ($version_detail_model as $vdm) {
                    $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td class="text-center">' . $vdm->version->version_name . '</td>
                    <td class="text-start">' . $vdm->version_detail_name . '</td>
                    <td>' . $vdm->created_at . '</td>
                    <td>' . $vdm->updated_at . '</td>
                    <td>
                        <a href="#" id="' . $vdm->id . '" class="text-success mx-1 version_detail_modal_find" data-bs-toggle="modal" data-bs-target="#version_detail_modal"><i class="bi-pencil-square h4"></i></a>

                        <a href="#" id="' . $vdm->id . '" class="text-danger mx-1 version_detail_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูล Version Detail บน Database!</h1>';
            }
        }
    // Fetch All Data Version Detail End

    // Insert Data Version Detail Start
        public function insertDataVersionDetail(Request $request) {
            if($request->version_detail_name) {
                $data_version_detail = [
                    'version_id' => $request->version_id,
                    'version_detail_name' => $request->version_detail_name
                ];

                if($data_version_detail) {
                    VersionDetailModel::create($data_version_detail);
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
    // Insert Data Version Detail End

    // Find One Data Version Detail Start
        public function findOneDataVersionDetail(Request $request) {
            $oneVersionDetail = VersionDetailModel::find($request->id);
            return response()->json($oneVersionDetail);
        }
    // Find One Data Version Detail End

    // Update Data Version Detail Start
        public function updateDataVersionDetail(Request $request) {
            $version_detail_model = VersionDetailModel::find($request->version_detail_id_find_one);
            if($request->version_detail_name) {
                if($request->version_id) {
                    $data_version_detail = [
                        'version_detail_name' => $request->version_detail_name,
                        'version_id' => $request->version_id,
                    ];
    
                    if($version_detail_model->update($data_version_detail)) {
                        $success = $this->messageSuccess("แก้ไขข้อมูลเสร็จสิ้น");
                        return $success;
                    } else {
                        $error = $this->messageError("ไม่สามารถแก้ไขข้อมูลได้");
                        return $error;
                    }
                } else {
                    $error = $this->messageError("ไม่มีข้อมูล Version ถูกส่งมา");
                    return $error;
                }
            } else {
                $error = $this->messageError("ไม่ข้อมูล Version Detail ถูกส่งมา");
                return $error;
            }
        }
    // Update Data Version Detail End

    // Delete Data Version Detail Start
        public function deleteDataVersionDetail(Request $request) {
            $version_detail_model = VersionDetailModel::find($request->id);
            if($version_detail_model) {
                VersionDetailModel::destroy($request->id);
                $success = $this->messageSuccess("ลบข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถลบข้อมูลได้");
                return $error;
            }
        }
    // Delete Data Version Detail End

    // Fetch All Data Fiscal Year Start
        public function fetchAllDataFiscalYear() {
            $fiscal_year_model = FiscalYearModel::orderBy('id', 'desc')->get();
            $output = '';
            if ($fiscal_year_model->count() > 0) {
                $output .= '<table class="table table-striped table-bordered table-sm text-center align-middle" id="fiscal_year_table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: auto;">ลำดับ</th>
                        <th style="width: auto;">ปีงบประมาณ</th>
                        <th style="width: auto;">วันที่เพิ่มข้อมูล</th>
                        <th style="width: auto;">วันที่แก้ไขข้อมูล</th>
                        <th style="width: auto;">Action</th>
                    </tr>
                </thead>
                <tbody>';
                $id = 0;
                foreach ($fiscal_year_model as $fym) {
                    $fiscal_year_convert = $fym->fiscal_year_name + 543;
                    $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td class="text-center">' . $fiscal_year_convert . '</td>
                    <td>' . $fym->created_at . '</td>
                    <td>' . $fym->updated_at . '</td>
                    <td>
                        <a href="#" id="' . $fym->id . '" class="text-success mx-1 fiscal_year_modal_find" data-bs-toggle="modal" data-bs-target="#fiscal_year_modal"><i class="bi-pencil-square h4"></i></a>

                        <a href="#" id="' . $fym->id . '" class="text-danger mx-1 fiscal_year_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูลปีงบประมาณบน Database!</h1>';
            }
        }
    // Fetch All Data Fiscal Year End

    // Insert Data Fiscal Year Start
        public function insertDataFiscalYear(Request $request) {
            if($request->fiscal_year_name) {
                $fiscal_year_convert = $this->checkYear($request->fiscal_year_name);

                $data_fiscal_year = [
                    'fiscal_year_name' => $fiscal_year_convert
                ];

                if($data_fiscal_year) {
                    FiscalYearModel::create($data_fiscal_year);
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
    // Insert Data Fiscal Year End

    // Find One Data Fiscal Year Start
        public function findOneDataFiscalYear(Request $request) {
            $oneFiscalYear = FiscalYearModel::find($request->id);
            return response()->json($oneFiscalYear);
        }
    // Find One Data Fiscal Year End

    // Update Data Fiscal Year Start
        public function updateDataFiscalYear(Request $request) {
            $fiscal_year_model = FiscalYearModel::find($request->fiscal_year_id_find_one);
            if($request->fiscal_year_name) {
                $fiscal_year_convert = $this->checkYear($request->fiscal_year_name);

                $data_fiscal_year = [
                    'fiscal_year_name' => $fiscal_year_convert
                ];

                if($fiscal_year_model->update($data_fiscal_year)) {
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
    // Update Data Fiscal Year End

    // Delete Data Fiscal Year Start
        public function deleteDataFiscalYear(Request $request) {
            $fiscal_year_model = FiscalYearModel::find($request->id);
            if($fiscal_year_model) {
                FiscalYearModel::destroy($request->id);
                $success = $this->messageSuccess("ลบข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถลบข้อมูลได้");
                return $error;
            }
        }
    // Delete Data Fiscal Year End
}
