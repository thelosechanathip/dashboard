<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidebarSub1MenuLogModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "sidebar_sub1_menu_log";

    protected $fillable = [
        'function',
        'username',
        'command_sql',
        'query_time',
        'operation',
    ];
}
