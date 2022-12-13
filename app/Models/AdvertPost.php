<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;
use App\Models\User;
use App\Models\Country;
use App\Models\BeachBreak;
use App\Models\State;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class AdvertPost extends Model
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
    public function advert_post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
    public function beach()
    {
        return $this->belongsTo(BeachBreak::class, 'optional_beach_id', 'id');
    }

    
}