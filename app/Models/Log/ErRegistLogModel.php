<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErRegistLogModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "er_regist_log";

    protected $fillable = [
        'function',
        'username',
        'command_sql',
        'query_time',
        'operation',
    ];
}
