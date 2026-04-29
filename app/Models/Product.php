<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'পণ্য';

    protected $fillable = [
        'নাম',
        'বর্ণনা',
        'মূল্য',
        'পরিমাণ',
        'এককরণ',
        'কৃষক_আইডি',
        'অবস্থা',
        'ছবি',
        'বিভাগ',
        'প্রশাসক_আইডি',
        'প্রত্যাখ্যানের_কারণ',
    ];

    // Relations
    public function farmer()
    {
        return $this->belongsTo(User::class, 'কৃষক_আইডি');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'প্রশাসক_আইডি');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'পণ্য_আইডি');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('অবস্থা', 'অপেক্ষমান');
    }

    public function scopeApproved($query)
    {
        return $query->where('অবস্থা', 'অনুমোদিত');
    }

    public function scopeRejected($query)
    {
        return $query->where('অবস্থা', 'নিরস্ত করা');
    }
}
