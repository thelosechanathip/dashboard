<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPatientsUtilizingIcd10CodesLogModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "report_patients_utilizing_icd10_codes_log";

    protected $fillable = [
        'function',
        'username',
        'command_sql',
        'query_time',
        'operation',
    ];
}
