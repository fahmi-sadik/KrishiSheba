<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdviceRequest extends Model
{
    protected $fillable = [
        'farmer_id',
        'expert_id',
        'question',
        'answer',
        'status',
    ];
}
