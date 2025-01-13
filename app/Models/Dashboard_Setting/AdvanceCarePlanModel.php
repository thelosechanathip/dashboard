<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceCarePlanModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "advance_care_plan";

    protected $fillable = [
        'acp_vn',
        'acp_hn',
        'acp_cid',
        'acp_fullname',
        'detail_of_talking_with_patients',
        'file_acp',
        'acp_staff'
    ];
}
