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
use App\Models\AdvertPost;
use Illuminate\Support\Facades\Auth;

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
        return $this->belongsTo(BeachBreak::class, 'local_beach_id', 'id');
    }

    /**
     * Relationship between country and user_follows model
     * @return object
     */
    public function breakName()
    {
        return $this->belongsTo(BeachBreak::class, 'local_break_id', 'id');
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
     * Relationship between state and advert_post model
     * @return object
     */
    public function advert()
    {
        return $this->belongsTo(AdvertPost::class, 'id', 'post_id');
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
     * Relationship between posts and parent post record
     * @return object
     */
    public function parentPost()
    {
        return $this->hasOne(User::class, 'id', 'parent_id');
    }


    /**
     * Relationship between posts and tags model
     * @return object
     */
    public function tags()
    {
        return $this->hasMany(Tag::class, 'post_id', 'id');
    }

    /**
     * Relationship between posts and reports model
     * @return object
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'post_id', 'id');
    }

    /**
     * Relationship between posts and reports model
     * @return object
     */
    public function ratingPost() {
        return $this->hasMany(Rating::class, 'rateable_id', 'id');
    }

    /**
     * Relationship between posts and reports model
     * @return object
     */
    public function followPost() {
        if(isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return $this->hasOne(UserFollow::class, 'followed_user_id', 'user_id')->where('follower_user_id', Auth::user()->id)->where('is_deleted', '0');
        }else {
            return $this->hasOne(UserFollow::class, 'followed_user_id', 'user_id')->where('is_deleted', '0');
        }
    }

    /**
     * Relationship between posts and follow  model
     * @return object
     */
    public function followRequest() {
        if(isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return $this->hasOne(UserFollow::class, 'follower_user_id', 'user_id');
        }else {
            return $this->hasOne(UserFollow::class, 'follower_user_id', 'user_id')->where('is_deleted', '0');
        }
    }
}
