<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportMixedBuildingLogModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "report_mixed_building_log";

    protected $fillable = [
        'function',
        'username',
        'command_sql',
        'query_time',
        'operation',
    ];
}
