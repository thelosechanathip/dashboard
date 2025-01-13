<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AncQualityModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "anc_quality";

    protected $fillable = [
        'recorder_name',
        'lmp',
        'edc',
        'fullname',
        'shph',
        'telephone',
        'week_12',
        'week_15',
        'week_18',
        'week_19',
        'week_20',
        'week_21',
        'week_26',
        'week_27',
        'week_30',
        'week_31',
        'week_34',
        'week_35',
        'week_36',
        'week_37',
        'week_38',
        'week_39',
        'week_40',
        'atvt_12',
        'atvt_15_18',
        'atvt_19_20',
        'atvt_21_26',
        'atvt_27_30',
        'atvt_31_34',
        'atvt_35_36',
        'atvt_37_38',
        'atvt_39_40',
        'tt_12',
        'tt_15_18',
        'tt_19_20',
        'tt_21_26',
        'tt_27_30',
        'tt_31_34',
        'tt_35_36',
        'tt_37_38',
        'tt_39_40',
    ];
}
