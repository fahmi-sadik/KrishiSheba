<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'নাম',
        'ইমেইল',
        'ফোন',
        'ঠিকানা',
        'ভূমিকা',
        'পাসওয়ার্ড',
        'অনুমোদিত',
        'প্রোফাইল_ছবি',
        'বায়ো',
        'ব্যবসার_নাম',
    ];

    protected $hidden = [
        'পাসওয়ার্ড',
        'remember_token',
    ];

    protected $casts = [
        'ইমেইল_যাচাই_করা_এ' => 'datetime',
        'পাসওয়ার্ড' => 'hashed',
    ];

    // Relations
    public function products()
    {
        return $this->hasMany(Product::class, 'কৃষক_আইডি');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'বিক্রেতা_আইডি');
    }

    public function purchases()
    {
        return $this->hasMany(Sale::class, 'ক্রেতা_আইডি');
    }

    // Check role
    public function isAdmin()
    {
        return $this->ভূমিকা === 'প্রশাসক';
    }

    public function isFarmer()
    {
        return $this->ভূমিকা === 'কৃষক';
    }

    public function isBuyer()
    {
        return $this->ভূমিকা === 'ক্রেতা';
    }

    public function isExpert()
    {
        return $this->ভূমিকা === 'বিশেষজ্ঞ';
    }
}
