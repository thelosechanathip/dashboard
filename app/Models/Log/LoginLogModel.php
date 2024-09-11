<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLogModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "login_log";

    protected $fillable = [
        'fullname',
        'username',
        'command_sql',
        'type',
        'ipaddress',
        'hostname',
    ];
}
