<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertGuide extends Model
{
    protected $fillable = [
        'expert_id',
        'title',
        'body',
    ];
}
