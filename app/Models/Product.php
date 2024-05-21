<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title','category','price','description','image'];

    protected $appends = ['rating'];

    protected $hidden = ['created_at','updated_at'];
    /**
     * @OA\Schema(
     * schema="products",
     * description="products",
     *
     * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
     * @OA\Property(property="name", type="string" ),
     * @OA\Property(property="icon", type="string"),
     * ),
     */

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    
    public function avgReviewRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function getRatingAttribute()
    {
        return [
            'rate'=> $this->avgReviewRating(),
            'count'=> $this->reviews()->count(),
        ];
    }

}
