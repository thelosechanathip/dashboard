<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairNotificationSystemModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "repair_notification_system";

    protected $fillable = [
        'working_type_id',
        'name_of_informant',
        'detail',
        'signature',
        'repair_staff'
    ];

    public function workingType() {
        return $this->belongsTo(WorkingTypeModel::class, 'working_type_id', 'id');
    }
}
