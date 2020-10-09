<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    use HasFactory;

    /************************************************************************************************************
     *                                          Eloquent: Folow Relationships
     ************************************************************************************************************/
    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'followed_user_id', 'id');
    }
}
