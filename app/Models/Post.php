<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;
use App\Models\User;
use App\Models\Country;
use App\Models\BeachBreak;
use App\Models\State;
use App\Models\Upload;
use App\Models\Comment;
use App\Models\Tag;

class Post extends Model
{
    use HasFactory;
    use Rateable;

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
     * Relationship between user and user_profile model    
     * @return object
     */
    
    public function user_profiles()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }
    
    /**
     * Relationship between post and upload model    
     * @return object
     */
    
    public function upload()
    {
        return $this->hasOne(Upload::class, 'post_id', 'id');
    }
    
    /**
     * Relationship between post and search model    
     * @return object
     */
    
    public function search()
    {
        return $this->hasOne(search::class, 'post_id', 'id');
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
     * Relationship between country and user_follows model    
     * @return object
     */
    public function beach_breaks()
    {
        return $this->belongsTo(BeachBreak::class, 'local_beach_break_id', 'id');
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
     * Relationship between posts and comments model    
     * @return object
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
    

    /**
     * Relationship between posts and tags model    
     * @return object
     */
    public function tags()
    {
        return $this->hasMany(Tag::class, 'post_id', 'id');
    }

}