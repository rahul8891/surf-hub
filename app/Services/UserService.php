<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Tag;
use App\Models\UserFollow;
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

    protected $userFollows;

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
        // User model object
        $this->userFollows = new UserFollow();
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

    public function getUsersForTagging($string)
    {
        $userProfiles =  new UserProfile();
        
        $result = $userProfiles
            ->join('users', 'users.id', '=', 'user_profiles.user_id')
            ->where('user_id','!=', Auth::user()->id)
            ->where('first_name', 'LIKE',  '%' . $string .'%')
            ->orWhere('users.user_name', 'LIKE',  '%' . $string .'%')
            ->orWhere('last_name', 'LIKE',  '%' . $string .'%')
            ->groupBy('users.id')
            ->get();
        //dd($result);
        return $result;
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

    public function getAllTaggedUsers($input)
    {
        //dd($input);
        $result = $this->tag
            ->where('post_id',$input['post_id'])
            ->where('is_deleted','0')
            ->orderBy('id','desc')->get();
        return $result;
    }

    public function getNotificationCount()
    {
        $count = $this->userFollows->where('followed_user_id',Auth::user()->id)
                ->where('status','FOLLOW')   
                ->where('follower_request_status','1') 
                ->where('is_deleted','0')
                ->count();
        return $count;
    }

    public function followRequests(){
        Notification::where(['receiver_id'=> Auth::user()->id, 'notification_type'=> 'Follow'])->update(['status'=>'1','count_status'=>'1','updated_at'=>Carbon::now()]);
        
        $followRequests = $this->userFollows->where('followed_user_id',Auth::user()->id)   
                    ->where('status','FOLLOW')   
                    ->where('follower_request_status',1) 
                    ->where('is_deleted','0')
                    ->orderBy('id','desc')->get();
        return $followRequests;
    }

    public function followers(){
        $followers = $this->userFollows->where('followed_user_id',Auth::user()->id)   
                    ->where('status','FOLLOW')   
                    ->where('follower_request_status','0') 
                    ->where('is_deleted','0')
                    ->orderBy('id','desc')->get();
        return $followers;
    }

    public function following(){
        Notification::where(['receiver_id'=> Auth::user()->id, 'notification_type'=> 'Accept'])->orWhere(['notification_type' => 'Reject'])->update(['status'=>'1','count_status'=>'1','updated_at'=>Carbon::now()]);
        $following = $this->userFollows->where('follower_user_id',Auth::user()->id)   
                    ->where('status','FOLLOW')   
                    ->where('follower_request_status','0') 
                    ->where('is_deleted','0')
                    ->orderBy('id','desc')->get();
        return $following;
    }

    public function updateFollowStatus($input, &$message='', $column=null)
    {
        try{
            $userFollows = $this->userFollows->find($input['id']);
            if($userFollows){
                $userFollows->id = $input['id'];
                $userFollows->status = $input['status'];
                if($userFollows->save()){
                    $resultArray['message']='Status has been updated!';
                    $resultArray['status']='success';
                    $resultArray['count']=$this->getFollowCount($column,'0');
                    return $resultArray;
                }else{
                    $resultArray['message']='The user details not be updated. Please, try again.';
                    $resultArray['status']='failure';
                    $resultArray['count']=$this->getFollowCount($column,'0');
                    return $resultArray;
                }
            }
        }catch(\Exception $e){
            $message=$e->getPrevious()->getMessage();
            return false;
        }  
    }

    public function updateAcceptStatus($input,&$message='',$column=null)
    {
        try{
            $userFollows = $this->userFollows->find($input['id']);
            if($userFollows){
                //dd($userFollows);
                $userFollows->id = $input['id'];
                $userFollows->follower_request_status = $input['follower_request_status'];
                $result = $this->saveFollowRequestAcceptRejectNotification($userFollows,'Accept');
                //dd($result);
                if($userFollows->save()){
                    $resultArray['message']='Status has been updated!';
                    $resultArray['status']='success';
                    $resultArray['count']=$this->getFollowCount($column,'1');
                    return $resultArray;
                }else{
                    $resultArray['message']='The user details not be updated. Please, try again.';
                    $resultArray['status']='failure';
                    $resultArray['count']=$this->getFollowCount($column,'1');
                    return $resultArray;
                }
            }
        }catch(\Exception $e){
            $message=$e->getPrevious()->getMessage();
            return false;
        }  
    }

    public function updateRejectStatus($input,&$message='',$column=null)
    {
        try{
            $userFollows = $this->userFollows->find($input['id']);
            if($userFollows){
                //$userFollows->status = $input['status'];
                $userFollows->is_deleted = '1';
                if($userFollows->save()){
                    $this->saveFollowRequestAcceptRejectNotification($userFollows,'Reject');
                    $resultArray['message']='Status has been updated!';
                    $resultArray['status']='success';
                    $resultArray['count']=$this->getFollowCount($column,'1');
                    return $resultArray;
                }else{
                    $resultArray['message']='The user details not be updated. Please, try again.';
                    $resultArray['status']='failure';
                    $resultArray['count']=$this->getFollowCount($column,'1');
                    return $resultArray;
                }
            }
        }catch(\Exception $e){
            $message=$e->getPrevious()->getMessage();
            return false;
        }  
    }

    public function getFollowCount($column=null,$status=null)
    {
        $count = $this->userFollows->where($column,Auth::user()->id)
                ->where('status','FOLLOW')   
                ->where('follower_request_status',$status) 
                ->where('is_deleted','0')
                ->count();
        return $count;
    }

    public function updateRemoveStatus($input,&$message='',$column=null)
    {
        try{
            $userFollows = $this->userFollows->find($input['id']);
            if($userFollows){
                $userFollows->id = $input['id'];
                $userFollows->is_deleted = $input['is_deleted'];
                if($userFollows->save()){
                    $resultArray['message']='Status has been updated!';
                    $resultArray['status']='success';
                    $resultArray['count']=$this->getFollowCount($column,'0');
                    return $resultArray;
                }else{
                    $resultArray['message']='The user details not be updated. Please, try again.';
                    $resultArray['status']='failure';
                    $resultArray['count']=$this->getFollowCount($column,'0');
                    return $resultArray;
                }
            }
        }catch(\Exception $e){
            $message=$e->getPrevious()->getMessage();
            return false;
        }  
    }

    public function followToFollower($input,&$message='')
    {
        try{
            $userFollows =  new UserFollow();
            if($userFollows){
                $resultArray = $this->checkFollow($input['followed_user_id']);
                if($resultArray){
                    $responseArray['message']='You are already following to '.$resultArray->followed->user_profiles->first_name.' '.$resultArray->followed->user_profiles->last_name;
                    $responseArray['status']='failure';
                    return $responseArray;
                }else{
                    if($input['followed_user_id'] == Auth::user()->id){
                        $responseArray['message']='You can not follow your self.';
                        $responseArray['status']='failure';
                        return $responseArray;
                    }else{
                        $userFollows->followed_user_id = $input['followed_user_id'];
                        $userFollows->follower_user_id = Auth::user()->id;
                        $userFollows->status = $input['sataus'];
                        if($userFollows->save()){
                            //set follow request notification
                            $this->saveFollowRequestNotification($input);
                            $responseArray['message']='Follow request has been sent!';
                            $responseArray['status']='success';
                            return $responseArray;
                        }else{
                            $responseArray['message']='Unable to send follow request, Please, try again.';
                            $responseArray['status']='success';
                            return $responseArray;
                        }
                    }
                }
            }
        }catch(\Exception $e){
            $message=$e->getPrevious()->getMessage();
            return false;
        }  
    }

    public function checkFollow($followed_user_id=null)
    {
        $result = $this->userFollows->where('follower_user_id',Auth::user()->id)
                ->where('followed_user_id',$followed_user_id)
                ->where('status','FOLLOW')
                ->where('is_deleted','0')
                ->first();
        
        return $result;
    }

    /**
     * [saveFollowRequestNotification] we are storing the follow request notifications
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveFollowRequestNotification($input,&$message=''){
        try{
            $this->notification->post_id = $input['post_id'];
            $this->notification->sender_id = Auth::user()->id;
            $this->notification->receiver_id = $input['followed_user_id'];
            $this->notification->notification_type = 'Follow';
            $this->notification->created_at = Carbon::now();
            $this->notification->updated_at = Carbon::now();
            //dd($this->comments);
            $this->notification->save();                
        }
        catch (\Exception $e){     
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

    /**
     * [saveFollowRequestAcceptRejectNotification] we are storing the accept and reject notifications
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveFollowRequestAcceptRejectNotification($input,$notification_type=''){
        //dd($input);
        try{
            $this->notification->post_id = $input['id'];
            $this->notification->sender_id = Auth::user()->id;
            $this->notification->receiver_id = $input['followed_user_id'];
            $this->notification->notification_type = $notification_type;
            $this->notification->created_at = Carbon::now();
            $this->notification->updated_at = Carbon::now();
            //dd($this->comments);
            $this->notification->save();
                
        }
        catch (\Exception $e){     
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

    public function checkUsername($dataRequest)
    {
        $usernameExist =  $this->users->where('user_name',$dataRequest['user_name'])->count();
        return $usernameExist;

    }
}