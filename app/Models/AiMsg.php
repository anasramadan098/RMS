<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiMsg extends Model
{
    protected $fillable = ['message', 'user'];
    protected $hidden = ['created_at', 'updated_at'];

}
