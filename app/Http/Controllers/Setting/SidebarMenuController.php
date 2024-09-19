<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\SidebarMainMenuModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;

class SidebarMenuController extends Controller
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
            $sidebar_main_menu_model = SidebarMainMenuModel::orderBy('id', 'desc')->get();

                if($data['groupname'] == 'ผู้ดูแลระบบ'){
                    // Return the view with the necessary data
                    return view('setting.sidebar_menu', compact('data', 'sidebar_main_menu_model'));
                } else {
                    $request->session()->put('error', 'คุณไม่มีสิทธิ์เข้าใช้งานระบบ');
                    return redirect()->route('dashboard');
                }
        }
    // Index Sidebar e Menu End

    // Fetch All Data Sidebar Main Menu Start
        public function fetchAllDataSidebarMainMenu() {
            $sidebar_main_menu_model = SidebarMainMenuModel::orderBy('id', 'desc')->get();
            $output = '';
            if ($sidebar_main_menu_model->count() > 0) {
                $output .= '<table class="table table-striped table-bordered table-sm text-center align-middle" id="sidebar_main_menu_table">
                <thead>
                    <tr>
                        <th style="width: 5%;">ลำดับ</th>
                        <th style="width: 30%;">Sidebar Main Menu Name</th>
                        <th style="width: 30%;">Link URL || Route</th>
                        <th style="width: 10%;">วันที่เพิ่มข้อมูล</th>
                        <th style="width: 10%;">วันที่แก้ไขข้อมูล</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>';
                $id = 0;
                foreach ($sidebar_main_menu_model as $smmm) {
                    $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td class="text-start">' . $smmm->sidebar_main_menu_name . '</td>
                    <td>' . $smmm->link_url_or_route . '</td>
                    <td>' . $smmm->created_at . '</td>
                    <td>' . $smmm->updated_at . '</td>
                    <td>
                        <a href="#" id="' . $smmm->id . '" class="text-success mx-1 sidebar_main_menu_modal_find" data-bs-toggle="modal" data-bs-target="#sidebar_main_menu_modal"><i class="bi-pencil-square h4"></i></a>

                        <a href="#" id="' . $smmm->id . '" class="text-danger mx-1 sidebar_main_menu_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูล Sidebar Main Menu บน Database!</h1>';
            }
        }
    // Fetch All Data Sidebar Main Menu End

    // Insert Data Sidebar Main Menu Start
        public function insertDataSidebarMainMenu(Request $request) {
            if($request->sidebar_main_menu_name) {
                if($request->link_url_or_route) {
                    $link_url_or_route = $request->link_url_or_route;
                } else {
                    $link_url_or_route = '';
                }
            } else {
                $error = $this->messageError("ไม่มีข้อมูลถูกส่งมา");
                return $error;
            }

            $data_sidebar_main_menu = [
                'sidebar_main_menu_name' => $request->sidebar_main_menu_name,
                'link_url_or_route' => $link_url_or_route
            ];

            if($data_sidebar_main_menu) {
                SidebarMainMenuModel::create($data_sidebar_main_menu);
                $success = $this->messageSuccess("บันทึกข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถบันทึกข้อมูลได้");
                return $error;
            }
        }
    // Insert Data Sidebar Main Menu End

    // Find One Data Sidebar Main Menu Start
        public function findOneDataSidebarMainMenu(Request $request) {
            $oneSidebarMainMenu = SidebarMainMenuModel::find($request->id);
            return response()->json($oneSidebarMainMenu);
        }
    // Find One Data Sidebar Main Menu End

    // Update Data Sidebar Main Menu Start
        public function updateDataSidebarMainMenu(Request $request) {
            $sidebar_main_menu_model = SidebarMainMenuModel::find($request->sidebar_main_menu_id_find_one);
            if($request->sidebar_main_menu_name) {
                if($request->link_url) {
                    $link_url_or_route = $request->link_url_or_route;
                } else {
                    $link_url_or_route = '';
                }
            } else {
                $error = $this->messageError("ไม่มีข้อมูลถูกส่งมา");
                return $error;
            }

            $data_sidebar_main_menu = [
                'sidebar_main_menu_name' => $request->sidebar_main_menu_name,
                'link_url_or_route' => $link_url_or_route,
            ];

            if($sidebar_main_menu_model->update($data_sidebar_main_menu)) {
                $success = $this->messageSuccess("แก้ไขข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถแก้ไขข้อมูลได้");
                return $error;
            }
        }
    // Update Data Sidebar Main Menu End

    // Delete Data Sidebar Main Menu Start
        public function deleteDataSidebarMainMenu(Request $request) {
            $sidebar_main_menu_model = SidebarMainMenuModel::find($request->id);
            if($sidebar_main_menu_model) {
                SidebarMainMenuModel::destroy($request->id);
                $success = $this->messageSuccess("ลบข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถลบข้อมูลได้");
                return $error;
            }
        }
    // Delete Data Sidebar Main Menu End

    // Fetch All Data Sidebar Sub1 Menu Start
        public function fetchAllDataSidebarSub1Menu() {
            $sidebar_sub1_menu_model = SidebarSub1MenuModel::orderBy('id', 'desc')->get();
            $output = '';
            if ($sidebar_sub1_menu_model->count() > 0) {
                $output .= '<table class="table table-striped table-bordered table-sm text-center align-middle" id="sidebar_main_menu_table">
                <thead>
                    <tr>
                        <th style="width: 5%;">ลำดับ</th>
                        <th style="width: 20%;">Sidebar Main Menu Name</th>
                        <th style="width: 20%;">Sidebar Sub1 Menu Name</th>
                        <th style="width: 25%;">Link URL || Route</th>
                        <th style="width: 10%;">วันที่เพิ่มข้อมูล</th>
                        <th style="width: 10%;">วันที่แก้ไขข้อมูล</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>';
                $id = 0;
                foreach ($sidebar_sub1_menu_model as $ssmm) {
                    $output .= '<tr>
                    <td>' . ++$id . '</td>
                    <td class="text-start">' . $ssmm->sidebarMainMenu->sidebar_main_menu_name . '</td>
                    <td class="text-start">' . $ssmm->sidebar_sub1_menu_name . '</td>
                    <td>' . $ssmm->link_url_or_route . '</td>
                    <td>' . $ssmm->created_at . '</td>
                    <td>' . $ssmm->updated_at . '</td>
                    <td>
                        <a href="#" id="' . $ssmm->id . '" class="text-success mx-1 sidebar_sub1_menu_modal_find" data-bs-toggle="modal" data-bs-target="#sidebar_sub1_menu_modal"><i class="bi-pencil-square h4"></i></a>

                        <a href="#" id="' . $ssmm->id . '" class="text-danger mx-1 sidebar_sub1_menu_delete"><i class="bi-trash h4"></i></a>
                    </td>
                    </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">ไม่มีข้อมูล Sidebar Sub1 Menu บน Database!</h1>';
            }
        }
    // Fetch All Data Sidebar Sub1 Menu End

    // Insert Data Sidebar Sub1 Menu Start
        public function insertDataSidebarSub1Menu(Request $request) {
            if($request->sidebar_sub1_menu_name) {
                if($request->sidebar_main_menu_id !== '0') {
                    if($request->link_url_or_route_sub1) {
                        $link_url_or_route = $request->link_url_or_route_sub1;
                        // $success = $this->messageSuccess($link_url_or_route);
                        // return $success;
                    } else {
                        $link_url_or_route = '';
                        // $error = $this->messageError("ไม่มีข้อมูล");
                        // return $error;
                    }
                } else {
                    $error = $this->messageError("กรุณากรอกข้อมูล Main ด้วยครับ");
                    return $error;
                }
            } else {
                $error = $this->messageError("ไม่มีข้อมูลถูกส่งมา");
                return $error;
            }

            $data_sidebar_sub1_menu = [
                'sidebar_main_menu_id' => $request->sidebar_main_menu_id,
                'sidebar_sub1_menu_name' => $request->sidebar_sub1_menu_name,
                'link_url_or_route' => $link_url_or_route
            ];

            if($data_sidebar_sub1_menu) {
                SidebarSub1MenuModel::create($data_sidebar_sub1_menu);
                $success = $this->messageSuccess("บันทึกข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถบันทึกข้อมูลได้");
                return $error;
            }
        }
    // Insert Data Sidebar Sub1 Menu End

    // Find One Data Sidebar Sub1 Menu Start
        public function findOneDataSidebarSub1enu(Request $request) {
            $oneSidebarSub1Menu = SidebarSub1MenuModel::find($request->id);
            return response()->json($oneSidebarSub1Menu);
        }
    // Find One Data Sidebar Sub1 Menu End

    // Update Data Sidebar Sub1 Menu Start
        public function updateDataSidebarSub1Menu(Request $request) {
            $sidebar_sub1_menu_model = SidebarSub1MenuModel::find($request->sidebar_sub1_menu_id_find_one);
            if($request->sidebar_sub1_menu_name) {
                if($request->sidebar_main_menu_id !== '0') {
                    if($request->link_url) {
                        $link_url_or_route = $request->link_url_or_route;
                    } else {
                        $link_url_or_route = '';
                    }
                } else {
                    $error = $this->messageError("กรุณากรอกข้อมูล Main ด้วยครับ");
                    return $error;
                }
            } else {
                $error = $this->messageError("ไม่มีข้อมูลถูกส่งมา");
                return $error;
            }

            $data_sidebar_sub1_menu = [
                'sidebar_main_menu_id' => $request->sidebar_main_menu_id,
                'sidebar_sub1_menu_name' => $request->sidebar_sub1_menu_name,
                'link_url_or_route' => $link_url_or_route,
            ];

            if($sidebar_sub1_menu_model->update($data_sidebar_sub1_menu)) {
                $success = $this->messageSuccess("แก้ไขข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถแก้ไขข้อมูลได้");
                return $error;
            }
        }
    // Update Data Sidebar Sub1 Menu End

    // Delete Data Sidebar Sub1 Menu Start
        public function deleteDataSidebarSub1Menu(Request $request) {
            $sidebar_sub1_menu_model = SidebarSub1MenuModel::find($request->id);
            if($sidebar_sub1_menu_model) {
                SidebarSub1MenuModel::destroy($request->id);
                $success = $this->messageSuccess("ลบข้อมูลเสร็จสิ้น");
                return $success;
            } else {
                $error = $this->messageError("ไม่สามารถลบข้อมูลได้");
                return $error;
            }
        }
    // Delete Data Sidebar Sub1 Menu End
}
