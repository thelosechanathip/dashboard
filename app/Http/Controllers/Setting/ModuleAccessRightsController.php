<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Dashboard_Setting\TypeModel;

class ModuleAccessRightsController extends Controller
{
    public function index(Request $request) {
        // Retrieve session data
        $data = $request->session()->all();

        // Return the view with the necessary data
        return view('setting.module_access_rights', compact('data'));
    }

    public function insertDataType(Request $request) {
        if($request->type_name) {
            return response()->json($request->type_name);
        } else {
            return response()->json('ไม่มีข้อมูลถูกส่งมา');
        }
    }
}
