<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessibilityModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "accessibility";

    protected $fillable = [
        'type_accessibility_id',
        'module_id',
        'sidebar_sub1_menu_id',
        'type_id',
        'accessibility_name',
        'status_id',
    ];

    public function module() {
        return $this->belongsTo(ModuleModel::class, 'module_id', 'id');
    }

    public function type() {
        return $this->belongsTo(TypeModel::class, 'type_id', 'id');
    }

    public function status() {
        return $this->belongsTo(StatusModel::class, 'status_id', 'id');
    }

    public function type_accessibility() {
        return $this->belongsTo(TypeAccessibilityModel::class, 'type_accessibility_id', 'id');
    }

    public function sidebar_sub1_menu() {
        return $this->belongsTo(SidebarSub1MenuModel::class, 'sidebar_sub1_menu_id', 'id');
    }
}
