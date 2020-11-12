<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\Beach;
use App\Models\BeachBreak;

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

    /**
     * Relationship between country and user_follows model    
     * @return object
     */
    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * Relationship between state and user_follows model    
     * @return object
     */
    public function states()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    /**
     * Relationship between beach_breaks and user_profile model    
     * @return object
     */
    public function beach_breaks()
    {
        return $this->belongsTo(BeachBreak::class, 'local_beach_break_id', 'id');
    }
}