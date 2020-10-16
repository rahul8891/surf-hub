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

    protected $userProfile;

    protected $checkUserType;

    public function __construct() {
        // Current user object
        $this->currentUserDetails = Auth::user();
        // User model object
        $this->users = new User();

        $this->userProfile = new UserProfile();

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

   /**
     * [getUsersListing] we are getiing all the user 
     * @param  
     * @param  
     * @return dataArray
     */
    public function getUsersListing(){

        $userArray =  $this->users->where('user_type',$this->checkUserType['userType']['USER'])
                                  ->whereIn('status', [$this->checkUserType['status']['ACTIVE'], 
                                        $this->checkUserType['status']['DEACTIVATED']])
                                  ->orderBy('id','DESC')
                                  ->paginate(10);
        return $userArray;
    }

    /**
     * [saveAdminUser] we are storing the User Details from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the confition 
     * @return dataArray with message
     */
    public function saveAdminUser($input,&$message=''){
        
        try{
            $getImageArray = $this->uploadImage($input);
            $this->users->name = trim(Str::lower($input['name']));
            $this->users->email = trim(Str::lower($input['email']));
            $this->users->password = Hash::make($input['password']);
            $this->users->account_type = $input['account_type'];
            $this->users->profile_photo_name = ($getImageArray['status']) ? $getImageArray['profile_photo_name'] :'';
            $this->users->profile_photo_path = ($getImageArray['status']) ? $getImageArray['profile_photo_path'] :'';
            $this->users->created_at = Carbon::now();
            $this->users->updated_at = Carbon::now();
            if($this->users->save()){
                $this->userProfile->user_id = $this->users->id;
                $this->userProfile->first_name =  $input['first_name'];
                $this->userProfile->last_name = $input['last_name'];
                $this->userProfile->facebook = $input['facebook'];
                $this->userProfile->instagram = $input['instagram'];
                $this->userProfile->language = $input['language'];
                $this->userProfile->country_id = $input['country_id'];
                $this->userProfile->phone = trim(Str::lower($input['phone']));
                $this->userProfile->created_at = Carbon::now();
                $this->userProfile->updated_at = Carbon::now();
                if($this->userProfile->save()){
                    $message = 'User account has been created successfully.!';
                    return true;
                }
            }
        }catch (\Exception $e){            
            if($this->users->id){
                $this->deleteUplodedProfileImage($getImageArray['profile_photo_name']);
                $this->deletUserRecord($this->users->id);
            }         
            throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
        }
    }

    /**
     * upload image into directory
     * @param  object  $input
     * @return object array
     */
    public function uploadImage($input){
        $returnArray = [];
        $path = public_path()."/storage/images/";
        $timeDate = strtotime(Carbon::now()->toDateTimeString()); 
        $returnArray['status'] = false;
        if(isset($input['profile_photo_name']) && !empty($input['profile_photo_name'])){
            $requestImageName = $input['profile_photo_name'];
            $imageNameWithExt = $requestImageName->getClientOriginalName();
            $filename = pathinfo($imageNameWithExt, PATHINFO_FILENAME); 
            $ext = $requestImageName->getClientOriginalExtension();
            $image_name = $timeDate.'_'.rand().'.'.$ext;
            $image_path = 'images/'.$image_name;
            if(!$requestImageName->move($path,$image_name)){
                throw ValidationException::withMessages([trans('auth.profile_image')]);
            }else{
                $returnArray['status'] = true;
                $returnArray['profile_photo_name'] = $image_name;
                $returnArray['profile_photo_path'] = $image_path;
            }
           return $returnArray;
        }
    }

     /**
     * Delete profile image if data not stor in db
     * @param  string  $imageName
     * @return void
     */
    public function deleteUplodedProfileImage($imageName){
        if($imageName){
            unlink(public_path()."/storage/images/". $imageName);
        }
    }

    /**
     * Delete user details if user profile data not store in db
     * @param  number  $id
     * @return void
     */
    public function deletUserRecord($id){       
        $user = $this->users::find($id);
        $user->delete();
    }
}