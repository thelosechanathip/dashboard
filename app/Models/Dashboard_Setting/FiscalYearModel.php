<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscalYearModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "fiscal_year";

    protected $fillable = [
        'fiscal_year_name'
    ];
}
