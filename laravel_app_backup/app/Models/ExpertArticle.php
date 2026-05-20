<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertArticle extends Model
{
    protected $fillable = [
        'expert_id',
        'title',
        'body',
    ];
}
