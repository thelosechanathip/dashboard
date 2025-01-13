<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Dashboard_Setting\ModuleModel;
use App\Models\Dashboard_Setting\SidebarMainMenuModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;
use App\Models\Dashboard_Setting\VersionModel;
use App\Models\Dashboard_Setting\VersionDetailModel;

use DB;

use Carbon\Carbon;

// use Illuminate\Support\Facades\URL;

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
        // if (app()->environment('local') || app()->environment('production')) {
        //     URL::forceScheme('https');
        // }

        Carbon::setLocale('th'); // ตั้งค่า Locale เป็นภาษาไทย
        date_default_timezone_set('Asia/Bangkok'); // ตั้งค่า Timezone เป็นเวลาประเทศไทย

        View::composer('layout.template.sidebar', function ($view) {

            $sidebarMainMenuModel = SidebarMainMenuModel::with('sidebarSub1Menu')->get();
            $sidebarSub1MenuModel = SidebarSub1MenuModel::get();

            // ส่งตัวแปรไปยัง Sidebar พร้อมค่า
            $view->with([
                'sidebarMainMenuModel' => $sidebarMainMenuModel,
                'sidebarSub1MenuModel' => $sidebarSub1MenuModel,
            ]);
        });

        View::composer('layout.dashboard_template', function($view) {
            $version_first = VersionModel::orderBy('id', 'desc')->first();

            if ($version_first) {
                $version_id = $version_first->id;
                $version_detail_model = VersionDetailModel::where('version_id', $version_id)->get();
            } else {
                // Handle the case when there is no version data
                $version_detail_model = collect(); // or whatever fallback logic you need
            }

            $id = 0;

            $date_now = Carbon::now()->format('d');
            $month_now = Carbon::now()->format('m');
            logger()->info('Date now:', ['date' => $date_now]);

            $view->with([
                'version_first' => $version_first,
                'version_detail_model' => $version_detail_model,
                'id' => $id,
                'date_now' => $date_now,
                'month_now' => $month_now,
            ]);

        });

        View::composer('layout.template.footer', function($view) {
            $version_first = VersionModel::orderBy('id', 'desc')->first();

            if ($version_first) {
                $version_id = $version_first->id;
                $version_detail_model = VersionDetailModel::where('version_id', $version_id)->get();
            } else {
                // Handle the case when there is no version data
                $version_detail_model = collect(); // or whatever fallback logic you need
            }
            $id = 0;
            $view->with([
                'version_first' => $version_first,
            ]);
        });

    }
}
