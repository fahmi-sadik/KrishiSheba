<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'বিক্রয়';

    protected $fillable = [
        'পণ্য_আইডি',
        'ক্রেতা_আইডি',
        'বিক্রেতা_আইডি',
        'পরিমাণ',
        'মোট_মূল্য',
        'অবস্থা',
        'ডেলিভারি_ঠিকানা',
    ];

    protected $casts = [
        'বিক্রয়_তারিখ' => 'datetime',
    ];

    // Relations
    public function product()
    {
        return $this->belongsTo(Product::class, 'পণ্য_আইডি');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'ক্রেতা_আইডি');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'বিক্রেতা_আইডি');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('অবস্থা', 'ডেলিভার_করা');
    }
}
