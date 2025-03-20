<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPatientsWithNoServiceHistoryLogModel extends Model
{
    use HasFactory;

    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "report_patients_with_no_service_history_log";

    protected $fillable = [
        'function',
        'username',
        'command_sql',
        'query_time',
        'operation',
    ];
}
