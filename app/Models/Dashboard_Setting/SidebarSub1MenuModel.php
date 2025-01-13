<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidebarSub1MenuModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "sidebar_sub1_menu";

    protected $fillable = [
        'sidebar_main_menu_id',
        'sidebar_sub1_menu_name',
        'link_url_or_route',
        'status_id',
    ];

    public function sidebarMainMenu() {
        return $this->belongsTo(SidebarMainMenuModel::class, 'sidebar_main_menu_id', 'id');
    }

    public function status() {
        return $this->belongsTo(StatusModel::class, 'status_id', 'id');
    }

    public function accessibilities() {
        return $this->hasMany(AccessibilityModel::class, 'type_accessibility_id', 'id');
    }
}
