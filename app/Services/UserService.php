<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Tag;
use App\Models\Notification;
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
use File;

class UserService {

    /**
     * Create a new Service instance.
     *
     * @return void
     */
    protected $currentUserDetails;

    protected $users;

    protected $tags;

    protected $notification;
    

    public function __construct() {
        // Current user object
        $this->currentUserDetails = Auth::user();
        // User model object
        $this->users = new User();
        // get custom config file
        $this->checkUserType = config('customarray');
        // dd($this->checkUserType['error']['MODEL_ERROR']);
        // tag model object
        $this->tag = new Tag();
        // notification model object
        $this->notification = new Notification();
    }  
    
     /**
     * [getUserDetailByID]
     * @param  int $id [current user id which need to be update]
     * @param  string &$message    [description ]
     * @return $object
     */
    public function getUserDetailByID($id,&$message=''){      
        return $this->users->find($id);
    }

    
    /**
     * [updateUserProfile]
     * @param  [object] $dataRequest [description contain data which need to be update]
     * @param  string &$message    [description ]
     * @return [object]              [description]
     */
    public function updateUserProfile($dataRequest,&$message=''){
       
        $users = $this->users->find(Auth::user()->id); 
        $userProfiles =  new UserProfile();
        try {
            if($users){
                $user_profiles = $userProfiles->where('user_id',Auth::user()->id)->first(); 
                if($users->status !== $this->checkUserType['status']['ACTIVE'] || $users->is_deleted == '1'){
                    $message = $this->checkUserType['common']['BLOCKED_USER'];
                    return false;
                }        
                $users->account_type = $dataRequest['account_type'];
                $user_profiles->first_name = $dataRequest['first_name'];
                $user_profiles->last_name = $dataRequest['last_name'];
                $user_profiles->icc = $dataRequest['telephone_prefix'];
                $user_profiles->phone = $dataRequest['phone'];
                $user_profiles->country_id = $dataRequest['country_id'];
                $user_profiles->language = $dataRequest['language'];
                $user_profiles->facebook = $dataRequest['facebook'];
                $user_profiles->instagram = $dataRequest['instagram'];
                $user_profiles->local_beach_break_id = $dataRequest['local_beach_break_id'];
                if($users->save() && $user_profiles->save()){
                    $message = $this->checkUserType['success']['UPDATE_SUCCESS'];;
                    return true;  
                }
            }else{
                $message = $this->checkUserType['common']['NO_RECORDS'];                
                return false;
            }    
        } catch (\Exception $e) {
            $message = $e->getPrevious()->getMessage();
            return false;
        }  
    }

    /**
     * [updateUserProfileImage]
     * @param  [object] $dataRequest [description contain data which need to be update]
     * @param  string &$message    [description ]
     * @return [object]              [description]
     */
    public function updateUserProfileImage($dataRequest,&$message=''){
        
        $id = Auth::user()->id;
        
        if(isset($dataRequest['userId']) && !empty($dataRequest['userId'])){
            $id = $dataRequest['userId'];
        }
        $users = $this->users->find($id);
        
        if($users){                   
            $userOldProfileImageName = $users->profile_photo_name; 
            $path = public_path() . "/storage/images/";
            $timeDate = strtotime(Carbon::now()->toDateTimeString());
            $cropped_image = $dataRequest['image'];      
            $image_parts = explode(";base64,", $cropped_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image_name = $timeDate .'.' .$image_type; // '_'.rand().
            $image_path_forDB = 'images/' . $image_name;
            $imgNewName = $path.$image_name; 
            if(!file_put_contents($imgNewName, $image_base64)){
                // Error message
                $message = $this->checkUserType['common']['DEFAULT_ERROR'];                
                return false;                
            }else{
                $users->id = $id;
                $users->profile_photo_path = $image_path_forDB;
                $users->profile_photo_name = $image_name;
                // update user auth image 
                if(empty($dataRequest['userId'])){
                    Auth::user()->profile_photo_path = $image_path_forDB;
                    Auth::user()->profile_photo_path = $image_name;
                }
                if($users->save()){
                    // delete old image file 
                    File::delete(public_path("/storage/images/".$userOldProfileImageName));
                    $message = $this->checkUserType['success']['IMAGE_UPDATE_SUCCESS'];  
                    return true;
                }                
            } 
        }else{
            $message = $this->checkUserType['common']['NO_RECORDS'];                
            return false;
        }
    }

    public function getAllUserForCreatePost(){
        $users = $this->users->select('id','user_name')->where('email_verified_at','!=',null)   
                    ->where('status',$this->checkUserType['status']['ACTIVE'])   
                    ->where('is_deleted','0')
                    ->where('user_type',$this->checkUserType['userType']['USER']) 
                    ->whereNotIn('id',[Auth::user()->id])
                    ->orderBy('id','asc')->get();
        return $users;
    }

    public function checkAlreadyTagged($dataRequest)
    {
        $result = $this->tag
            ->where('post_id',$dataRequest['post_id'])
            ->where('user_id',$dataRequest['user_id'])
            ->first();
        return $result;
    }

    public function tagUserOnPost($input)
    {
        $this->tag->post_id = $input['post_id'];
        $this->tag->user_id = $input['user_id'];
        $this->tag->created_at = Carbon::now();
        $this->tag->updated_at = Carbon::now();
        if($this->tag->save()){
            $this->setTagNotification($input);
        }
    }

    public function setTagNotification($input)
    {
        $this->notification->post_id = $input['post_id'];
        $this->notification->sender_id = Auth::user()->id;
        $this->notification->receiver_id = $input['user_id'];
        $this->notification->notification_type = 'Tag';
        $this->notification->created_at = Carbon::now();
        $this->notification->updated_at = Carbon::now();
        $this->notification->save();
    }
}