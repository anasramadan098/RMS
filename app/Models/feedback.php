<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class feedback extends Model
{
    protected $fillable = [
        'ar_name',
        'en_name',
        'en_comment',
        'ar_comment',
        'stars',
        'date'
    ];
}
