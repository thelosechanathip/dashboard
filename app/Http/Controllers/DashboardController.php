<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Ovst;
use App\Models\Dashboard_Setting\ModuleModel;
use App\Models\Dashboard_Setting\SidebarMainMenuModel;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $data = $request->session()->all();

        $request->session()->forget('error');

        $ovstStatusId = ModuleModel::where('module_name', 'Ovst')->first();
        $admitStatusId = ModuleModel::where('module_name', 'Admit')->first();
        $referInStatusId = ModuleModel::where('module_name', 'Refer In')->first();
        $referOutStatusId = ModuleModel::where('module_name', 'Refer Out')->first();
        $erStatusId = ModuleModel::where('module_name', 'ER')->first();
        $opdscreenStatusId = ModuleModel::where('module_name', 'Opdscreen')->first();
        $healthMedServiceStatusId = ModuleModel::where('module_name', 'Health Med Service')->first();
        $physicStatusId = ModuleModel::where('module_name', 'Physic')->first();

        $counts = DB::table('ovst')
            ->select([
                DB::raw("(SELECT COUNT(*) FROM ovst WHERE vstdate = CURRENT_DATE()) as ovst_count"),
                DB::raw("(SELECT COUNT(*) FROM opdscreen WHERE vstdate = CURRENT_DATE() AND screen_dep = '027' AND cc IS NOT NULL AND cc != '') as opdscreen_count"),
                DB::raw("(SELECT COUNT(*) FROM er_regist WHERE vstdate = CURRENT_DATE()) as er_regist_count"),
                DB::raw("(SELECT COUNT(*) FROM referout WHERE refer_date = CURRENT_DATE()) as refer_out_count"),
                DB::raw("(SELECT COUNT(*) FROM referin WHERE refer_date = CURRENT_DATE()) as refer_in_count"),
                DB::raw("(SELECT COUNT(*) FROM ipt WHERE regdate = CURRENT_DATE() AND dchdate IS NULL) as ipt_count"),
                DB::raw("(SELECT COUNT(*) FROM health_med_service WHERE service_date = CURRENT_DATE()) as health_med_service_count"),
                DB::raw("(SELECT COUNT(CASE WHEN vstdate = CURRENT_DATE() THEN 1 END) FROM physic_main) + (SELECT COUNT(CASE WHEN vstdate = CURRENT_DATE() THEN 1 END) FROM physic_main_ipd) AS physic_count"),
            ])->first()
        ;

        return view('dashboard', compact(
            'data', 
            'ovstStatusId', 
            'admitStatusId', 
            'referInStatusId', 
            'referOutStatusId', 
            'erStatusId', 
            'opdscreenStatusId',
            'healthMedServiceStatusId',
            'physicStatusId',
            'counts',
        ));
    }

    public function check_group_and_user(Request $request) {
        $data = $request->session()->all();
        $groupname = $data['groupname'];

        $permission = $request->admin_group;

        if($permission == $groupname) {
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false
            ]);
        }
    }

}
