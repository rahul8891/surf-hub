<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\UserProfile;
class State extends Model
{
    use HasFactory;

    /************************************************************************************************************
     *                                          Eloquent: Relationships
     ************************************************************************************************************/

    /**
     * Relationship between state  and country model    
     * @return object
     */
    
    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * Relationship between state  and user profile model.
     */
    public function user_profiles()
    {
        return $this->hasOne(UserProfile::class, 'state_id', 'id');
    }

}
