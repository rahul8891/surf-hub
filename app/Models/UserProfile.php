<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'dob',
        'relationship',
        'address',
        'suburb',
        'country_id',
        'state_id',
        'city_id',
        'facebook',
        'instagram',
        'preferred_location',
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
