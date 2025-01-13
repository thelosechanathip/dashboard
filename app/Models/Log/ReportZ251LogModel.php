<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportZ251LogModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "report_z251_log";

    protected $fillable = [
        'function',
        'username',
        'command_sql',
        'query_time',
        'operation',
    ];
}
