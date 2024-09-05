<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Dashboard_Setting\ModuleModel;

use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layout.template.sidebar', function ($view) {
            // ดึงข้อมูลจากฐานข้อมูล
            $palliativeCareId = ModuleModel::where('module_name', 'Palliative Care')->first();

            $dashboard = "dashboard";

            // ส่งตัวแปรไปยัง Sidebar พร้อมค่า
            $view->with([
                'palliativeCareId' => $palliativeCareId,
                'dashboard' => $dashboard,
            ]);
        });

        View::composer('dashboard', function($view) {
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

            $view->with([
                'ovst_count' => $ovst_count,
                'er_regist_count' => $er_regist_count,
                'refer_out_count' => $refer_out_count,
                'refer_in_count' => $refer_in_count,
                'ipt_count' => $ipt_count,
            ]);
        });
    }
}
