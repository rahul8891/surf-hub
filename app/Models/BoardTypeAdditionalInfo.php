<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardTypeAdditionalInfo extends Model
{
    use HasFactory;

    /************************************************************************************************************
     *                                          Eloquent: Folow Relationships
     ************************************************************************************************************/
    /**
     * Get the user that owns the profile.
     */
    protected $fillable = [
        'board_type',
        'info_name',
        'created_at',
    ];
}
