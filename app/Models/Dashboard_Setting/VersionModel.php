<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "version";

    protected $fillable = [
        'version_name'
    ];

    public function versionDetail() {
        return $this->hasMany(VersionDetailModel::class, 'version_id', 'id');
    }
}
