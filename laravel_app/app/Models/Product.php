<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'farmer_id', 'name', 'description', 'price', 'stock_quantity', 'image_url', 'status'
    ];

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }
}
