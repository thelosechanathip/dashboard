<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class TypeModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "type";

    protected $fillable = [
        'type_name'
    ];

    public function accessibilities() {
        return $this->hasMany(AccessibilityModel::class, 'type_id', 'id');
    }
}
