<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Page;

class AdminAd extends Model
{
    use HasFactory;


    /************************************************************************************************************
     *                                          Eloquent: Relationships
     ************************************************************************************************************/

    /**
     * Relationship between upload and post model    
     * @return object
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }
}
