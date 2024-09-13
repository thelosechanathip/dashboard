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
            $palliativeCareStatusId = ModuleModel::where('module_name', 'Palliative Care')->first();
            $authenCodeStatusId = ModuleModel::where('module_name', 'Authen Code')->first();

            $dashboard = "dashboard";

            // ส่งตัวแปรไปยัง Sidebar พร้อมค่า
            $view->with([
                'palliativeCareStatusId' => $palliativeCareStatusId,
                'dashboard' => $dashboard,
                'authenCodeStatusId' => $authenCodeStatusId,
            ]);
        });

    }
}
