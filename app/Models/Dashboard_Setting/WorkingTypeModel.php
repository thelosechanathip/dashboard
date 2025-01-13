<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingTypeModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "working_type";

    protected $fillable = [
        'working_type_name'
    ];

    public function repairNotificationSystem() {
        return $this->hasMany(WorkingTypeModel::class, 'working_type_id', 'id');
    }
}
