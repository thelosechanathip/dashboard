<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAccessibilityModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "type_accessibility";

    protected $fillable = [
        'type_accessibility_name'
    ];

    public function accessibilities() {
        return $this->hasMany(AccessibilityModel::class, 'type_accessibility_id', 'id');
    }
}
