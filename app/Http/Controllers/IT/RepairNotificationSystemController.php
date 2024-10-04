<?php

namespace App\Http\Controllers\IT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// use App\Models\Ovst;
// use App\Models\Dashboard_Setting\ModuleModel;
// use App\Models\Dashboard_Setting\SidebarMainMenuModel;

class RepairNotificationSystemController extends Controller
{
    public function index(Request $request) {
        $data = $request->session()->all();

        $request->session()->forget('error');

        return view('it.repair_notification_system', compact(
            'data', 
        ));
    }
}
