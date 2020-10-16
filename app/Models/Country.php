<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\UserProfile;
class Country extends Model
{
    use HasFactory;

    /************************************************************************************************************
     *                                          Eloquent: Relationships
     ************************************************************************************************************/

    /**
     * Relationship between country  and states model    
     * @return object
     */
    
    public function states()
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }

     /**
     * Get the user that owns the profile.
     */
    public function user_profiles()
    {
        return $this->hasOne(UserProfile::class, 'country_id', 'id');
    }
}
