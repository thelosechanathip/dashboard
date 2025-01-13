<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionDetailModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "version_detail";

    protected $fillable = [
        'version_id',
        'version_detail_name'
    ];

    public function version() {
        return $this->belongsTo(VersionModel::class, 'version_id', 'id');
    }
}
