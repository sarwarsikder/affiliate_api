<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function product_claimed()
    {
        return $this->hasOne(UserProductClaim::class)
            ->where('user_id', auth()->user()->id);
    }

}
