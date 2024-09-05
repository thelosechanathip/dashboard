<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Ovst;
use App\Models\Dashboard_Setting\ModuleModel;

class DashboardController extends Controller
{
    public function query_all_count_data(){
        $ovst_count = DB::table('ovst')
            ->select(DB::raw('COUNT(*) as count'))
            ->whereDate('vstdate', '=', DB::raw('CURRENT_DATE()'))
            ->first()
            ->count;

        $er_regist_count = DB::table('er_regist')
            ->select(DB::raw('COUNT(*) as count'))
            ->whereDate('vstdate', '=', DB::raw('CURRENT_DATE()'))
            ->first()
            ->count;

        $refer_out_count = DB::table('referout')
            ->select(DB::raw('COUNT(*) as count'))
            ->whereDate('refer_date', '=', DB::raw('CURRENT_DATE()'))
            ->first()
            ->count;

        $refer_in_count = DB::table('referin')
            ->select(DB::raw('COUNT(*) as count'))
            ->whereDate('refer_date', '=', DB::raw('CURRENT_DATE()'))
            ->first()
            ->count;

        $ipt_count = DB::table('ipt')
            ->select(DB::raw('COUNT(*) as count'))
            ->whereDate('regdate', '=', DB::raw('CURRENT_DATE'))
            ->whereNull('dchdate')
            ->value('count');

        return response()->json([
            'ovst_count' => $ovst_count,
            'er_regist_count' => $er_regist_count,
            'refer_out_count' => $refer_out_count,
            'refer_in_count' => $refer_in_count,
            'ipt_count' => $ipt_count,
        ]);
    }

    public function index(Request $request) {
        $data = $request->session()->all();

        return view('dashboard', compact('data'));
    }

    public function check_status(Request $request) {
        // รับค่าจาก request
        $request_data = $request->palliativeCare;

        // ดึงข้อมูล status_name ที่มีค่าเท่ากับ "Palliative Care"
        $query_request_data = ModuleModel::select()
            ->where('module_name', '=', $request_data)
            ->first();  // ใช้ first() แทน get()

        // ตรวจสอบว่าค่าที่รับจาก request ตรงกับค่าที่ได้จากฐานข้อมูลหรือไม่
        if ($query_request_data) {
            if($query_request_data->status_id === 1) {
                return response()->json([
                    'palliativeCareStatus' => true
                ]);
            } else {
                return response()->json([
                    'palliativeCareStatus' => false
                ]);
            }
        } else {
            return response()->json('ข้อมูล 2 ชุดไม่เหมือนกัน');
        }
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
