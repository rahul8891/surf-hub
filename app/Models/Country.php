<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\UserProfile;
use App\Models\Post;
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

    /**
     * Get the user that owns the profile.
     */
    public function posts()
    {
        return $this->hasOne(Post::class, 'country_id', 'id');
    }

}