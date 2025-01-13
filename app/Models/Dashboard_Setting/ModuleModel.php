<?php

namespace App\Models\Dashboard_Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
    use HasFactory;

    protected $connection = "dashboard_setting";

    protected $table = "module";

    protected $fillable = [
        'module_name',
        'status_id'
    ];

    public function status() {
        return $this->belongsTo(StatusModel::class, 'status_id', 'id');
    }
}
