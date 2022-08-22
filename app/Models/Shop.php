<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    public function shop_category()
    {
        return $this->belongsTo(ShopCategory::class);
    }

    public function shop_following()
    {
        return $this->hasOne(UserShopFollow::class)
            ->where('user_id', auth()->user()->id);
    }
}
