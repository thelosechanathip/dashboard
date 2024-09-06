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
        'module_id',
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
}
