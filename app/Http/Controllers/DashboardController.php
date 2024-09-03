<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Ovst;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $data = $request->session()->all();

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


        return view('dashboard', compact('data', 'ovst_count', 'er_regist_count', 'refer_out_count', 'refer_in_count', 'ipt_count'));
    }

}
