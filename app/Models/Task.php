<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Task extends Model
{
    use BelongsToTenant;
    
    protected $fillable = [
        'content', 'ended_at', 'status', 'user_id'
    ];

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive() 
    {
        return $this->query()->where('status' , '!=' , 'completed');
    }
}
