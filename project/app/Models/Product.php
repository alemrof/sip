<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function productImages() {
        return $this->hasMany(ProductImage::class);
    }

    public function productComments() {
        return $this->hasMany(ProductComment::class);
    }

    public function calculateRating() {
        $comments = $this->productComments;
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
