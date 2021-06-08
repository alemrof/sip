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

    public function openingHours() {
        return $this->hasMany(OpeningHours::class);
    }

    public function warehouseComments() {
        return $this->hasMany(WarehouseComment::class);
    }
    
    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('id', 'price');;
    }

    public function warehouseImages() {
        return $this->hasMany(WarehouseImage::class);
    }

    public function calculateRating() {
        $comments = $this->warehouseComments;
        $ratingSum = 0;
        $numberOfRatings = 0;

        foreach ($comments as $comment)
        {
            if ($comment->rating != 0)
            {
                $ratingSum += $comment->rating;
                $numberOfRatings++;
            }
        }
        if ($numberOfRatings > 0)
        {
            $this->rating = $ratingSum / $numberOfRatings;
        }
        else
        {
            $this->rating = 0;
        }
        $this->save();
    }
}
