<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /************************************************************************************************************
     *                                          Eloquent: Folow Relationships
     ************************************************************************************************************/
    /**
     * Get the user that owns the profile.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    /**
     * Get the user that owns the profile.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    /**
     * Get the user that owns the profile.
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
