<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthMedServiceLogModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "health_med_service_log";

    protected $fillable = [
        'function',
        'username',
        'command_sql',
        'query_time',
        'operation',
    ];
}
