<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingChartsModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "receiving_charts";

    protected $fillable = [
        'an',
        'hn',
        'name',
        'ward',
        'dch_date',
        'doctor',
        'check_sending_chart',
        'check_sending_chart_date_time',
        'check_receipt_of_chart',
        'check_receipt_of_chart_date_time',
        'check_sending_chart_billing_room',
        'check_sending_chart_billing_room_date_time',
    ];
}
