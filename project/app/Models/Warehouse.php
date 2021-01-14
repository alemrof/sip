<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class Warehouse extends Model
{
    use HasFactory;
    use SpatialTrait;

    protected $guarded = [''];

    protected $spatialFields = [
        'location'
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
