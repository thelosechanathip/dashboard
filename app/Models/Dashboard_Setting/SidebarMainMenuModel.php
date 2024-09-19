<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidebarMainMenuModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "sidebar_main_menu";

    protected $fillable = [
        'sidebar_main_menu_name',
        'link_url'
    ];

    public function sidebarSub1Menu() {
        return $this->hasMany(SidebarSub1MenuModel::class, 'sidebar_main_menu_id', 'id');
    }
}
