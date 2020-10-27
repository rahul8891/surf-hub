<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Country;
use App\Models\State;

class Post extends Model
{
    use HasFactory;

    /************************************************************************************************************
     *                                          Eloquent: Relationships
     ************************************************************************************************************/

    /**
     * Relationship between Post and user model    
     * @return object
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
    

}