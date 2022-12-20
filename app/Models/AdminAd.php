<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Upload extends Model
{
    use HasFactory;


    /************************************************************************************************************
     *                                          Eloquent: Relationships
     ************************************************************************************************************/

    /**
     * Relationship between upload and post model    
     * @return object
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
