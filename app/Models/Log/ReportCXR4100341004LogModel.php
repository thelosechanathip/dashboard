<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCXR4100341004LogModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "report_cxr_41003_41004_log";

    protected $fillable = [
        'function',
        'username',
        'command_sql',
        'query_time',
        'operation',
    ];
}
