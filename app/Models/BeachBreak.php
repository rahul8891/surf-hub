<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserProfile;
class BeachBreak extends Model
{
    use HasFactory;

    /************************************************************************************************************
     *                                          Eloquent: Relationships
     ************************************************************************************************************/

     /**
     * Get the user that owns the profile.
     */
    public function user_profiles()
    {
        return $this->hasOne(UserProfile::class, 'local_beach_break_id', 'id');
    }

    
}