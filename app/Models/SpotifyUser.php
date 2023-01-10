<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SpotifyUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'spotify_user_id',
        'token',
        'refresh_token',
        'created_at',
    ];

    /************************************************************************************************************
     *                                          Eloquent: Relationships
     ************************************************************************************************************/

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}