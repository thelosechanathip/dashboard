<?php

namespace App\Http\Controllers\IT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OpdUser;
use App\Models\Dashboard_Setting\WorkingTypeModel;

class RepairNotificationSystemController extends Controller
{
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
}