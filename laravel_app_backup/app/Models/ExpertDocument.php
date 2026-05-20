<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertDocument extends Model
{
    protected $fillable = [
        'user_id',
        'certificate_path',
        'paperwork_path',
        'status',
    ];
}
