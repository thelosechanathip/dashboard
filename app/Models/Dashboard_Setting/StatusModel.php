<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "status";

    protected $fillable = [
        'status_name'
    ];

    public function modules() {
        return $this->hasMany(ModuleModel::class, 'status_id', 'id');
    }
}