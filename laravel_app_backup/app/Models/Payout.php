<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = [
        'expert_id',
        'advice_request_id',
        'amount',
        'status',
    ];
}
