<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Dashboard_Setting\ModuleModel;
use App\Models\Dashboard_Setting\SidebarMainMenuModel;
use App\Models\Dashboard_Setting\SidebarSub1MenuModel;

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

            $sidebarMainMenuModel = SidebarMainMenuModel::with('sidebarSub1Menu')->get();
            $sidebarSub1MenuModel = SidebarSub1MenuModel::get();

            // ส่งตัวแปรไปยัง Sidebar พร้อมค่า
            $view->with([
                'sidebarMainMenuModel' => $sidebarMainMenuModel,
                'sidebarSub1MenuModel' => $sidebarSub1MenuModel,
            ]);
        });

    }
}
