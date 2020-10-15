<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Storage;
use DB;

class AdminUserService {
    /**
     * Create a new Service instance.
     *
     * @return void
     */
    protected $currentUserDetails;

    protected $users;

    protected $checkUserType;

    public function __construct() {
        // Current user object
        $this->currentUserDetails = Auth::user();
        // User model object
        $this->users = new User();
        // get custom config file
        $this->checkUserType = config('customarray');
    }

    /**
     * [getUserTotal] we are getiing all the user count based on the condition 
     * @param  
     * @param  
     * @return dataArray
     */
    public function getUserTotal(){

        $userArray = [];
        // get all active user count
        $userArray['active'] =  $this->users->where('user_type',$this->checkUserType['userType']['USER'])
                               ->where('status',$this->checkUserType['status']['ACTIVE'])
                               ->count();

        // get all DEACTIVATED/PENDING/NOT VERIFIED user count
        $userArray['deactivate'] =  $this->users->where('user_type',$this->checkUserType['userType']['USER'])
                                   ->whereNull('email_verified_at')
                                   ->whereIn('status', [$this->checkUserType['status']['DEACTIVATED'], $this->checkUserType['status']['PENDING']])
                                ->count(); 
        return $userArray;
      

    }
}