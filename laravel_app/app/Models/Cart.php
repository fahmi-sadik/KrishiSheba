<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'buyer_id', 'product_name', 'price', 'quantity', 'image_url'
    ];
}
