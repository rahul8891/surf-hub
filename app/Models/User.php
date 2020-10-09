<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use App\Models\UserProfile;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'name',
        'language',
        'account_type',
        'email',
        'password',
        'profile_photo_name',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /************************************************************************************************************
     *                                          Eloquent: Relationships
     ************************************************************************************************************/

    
     
    /**
     * Relationship between user and user_profile model    
     * @return object
     */
    
    public function user_profiles()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }

    /**
     * Relationship between user and user_follows model    
     * @return object
     */
    
    public function user_follows()
    {
        return $this->hasMany(UserFollow::class, 'followed_user_id', 'id');
    }


}
