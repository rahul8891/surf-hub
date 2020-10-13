<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
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

}
