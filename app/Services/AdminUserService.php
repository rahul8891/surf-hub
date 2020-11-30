<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Post;
use App\Models\Upload;
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
    
    protected $posts;

    protected $userProfile;

    protected $checkUserType;

    public function __construct() {
        // Current user object
        $this->currentUserDetails = Auth::user();
        // User model object
        $this->users = new User();

        // post model object
        $this->posts = new Post();

        // upload model object
        $this->upload = new Upload();

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
                               ->whereNull('deleted_at')
                               ->count();

        // get all DEACTIVATED/PENDING/NOT VERIFIED user count
        $userArray['deactivate'] =  $this->users->where('user_type',$this->checkUserType['userType']['USER'])
                                   ->whereNull('email_verified_at')
                                   ->whereNull('deleted_at')
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
                                  ->whereNull('deleted_at')                               
                                  ->orderBy('id','DESC')
                                  ->paginate(10);
        return $userArray;
    }

    /**
     * [getPostTotal] we are getiing number of total posts
     * @param  
     * @param  
     * @return dataCount
     */
    public function getPostTotal(){

        $postArray =  $this->posts->whereNull('deleted_at')                               
                                  ->orderBy('created_at','ASC')
                                  ->count();
        return $postArray;
    }
    /**
     * [getPostListing] we are getiing all the post
     * @param  
     * @param  
     * @return dataArray
     */
    public function getPostsListing(){

        $postArray =  $this->posts->whereNull('deleted_at')                               
                                  ->orderBy('created_at','ASC')
                                  ->paginate(10);
        return $postArray;
    }


    /**
     * [saveAdminUser] we are storing the User Details from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveAdminUser($input,&$message=''){
        try{
            $getImageArray = $this->uploadImage($input);
            $this->users->user_name = trim(Str::lower($input['user_name']));
            $this->users->email = trim(Str::lower($input['email']));
            $this->users->password = Hash::make($input['password']);
            $this->users->account_type = $input['account_type'];
            $this->users->profile_photo_name = (isset($getImageArray['profile_photo_name']) && !empty($getImageArray['profile_photo_name'])) ? $getImageArray['profile_photo_name'] :'';
            $this->users->profile_photo_path = (isset($getImageArray['profile_photo_path']) && !empty($getImageArray['profile_photo_path'])) ? $getImageArray['profile_photo_path'] :'';
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
                $this->userProfile->local_beach_break_id = $input['local_beach_break_id'];
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
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            return false;
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
     * upload image into directory
     * @param  object  $input
     * @return object array
     */
    public function getPostImage($image){
        
        $destinationPath = 'storage/images/';
        $timeDate = strtotime(Carbon::now()->toDateTimeString());
        $ext = $image->getClientOriginalExtension();
        // $imageNameWithExt = $requestImageName->getClientOriginalName(); 
        $filename = $timeDate.'_'.rand().'.'.$ext;
        $image->move($destinationPath, $filename);
        return $filename;
    }
    
    /**
     * upload video into directory
     * @param  object  $video
     * @return object array
     */
    public function getPostVideo($video){
        $destinationPath = 'storage/videos/';
        $timeDate = strtotime(Carbon::now()->toDateTimeString());
        $filenameWithExt= $video->getClientOriginalName();
        $extension = $video->getClientOriginalExtension();
        $fileNameToStore = $filenameWithExt. '_'.$timeDate.'.'.$extension;
        $path = $video->move($destinationPath,$fileNameToStore);
        return $fileNameToStore;
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

    public function updateUserStatus($input,&$message=''){
        try{
            $users = $this->users::find($input['id']);
            if($users){
                $users->id = $input['id'];
                $users->status = ($input['status'] === 'true') ? $this->checkUserType['status']['ACTIVE'] : $this->checkUserType['status']['DEACTIVATED'];
                if($users->save()){
                    $message='User Status has been updated!';
                    return true;
                }else{
                    $message='The user details not be updated. Please, try again.';
                    return false;
                }
            }
        }catch(\Exception $e){
            $message=$e->getPrevious()->getMessage();
            return false;
        }        
    }


    public function updateAdminUser($dataRequest,$id,&$message=''){
      
        $users = $this->users->find($id); 
        $userProfiles =  new UserProfile();
        try {
            if($users){
                $user_profiles = $userProfiles->where('user_id',$id)->first(); 
                if($users->status !== $this->checkUserType['status']['ACTIVE'] || $users->is_deleted == '1'){
                    $message = $this->checkUserType['common']['BLOCKED_USER'];
                    return false;
                }        
                $users->account_type = $dataRequest['account_type'];
                $user_profiles->first_name = $dataRequest['first_name'];
                $user_profiles->last_name = $dataRequest['last_name'];
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
            $message = $e->getMessage();
            return false;
        }  
        // try{
        //     $getImageArray = $this->uploadImage($input);
        //     $this->users->name = trim(Str::lower($input['name']));
        //     $this->users->email = trim(Str::lower($input['email']));
        //     $this->users->password = Hash::make($input['password']);
        //     $this->users->account_type = $input['account_type'];
        //     $this->users->profile_photo_name = ($getImageArray['status']) ? $getImageArray['profile_photo_name'] :'';
        //     $this->users->profile_photo_path = ($getImageArray['status']) ? $getImageArray['profile_photo_path'] :'';
        //     $this->users->created_at = Carbon::now();
        //     $this->users->updated_at = Carbon::now();
        //     if($this->users->save()){
        //         $this->userProfile->user_id = $this->users->id;
        //         $this->userProfile->first_name =  $input['first_name'];
        //         $this->userProfile->last_name = $input['last_name'];
        //         $this->userProfile->facebook = $input['facebook'];
        //         $this->userProfile->instagram = $input['instagram'];
        //         $this->userProfile->language = $input['language'];
        //         $this->userProfile->country_id = $input['country_id'];
        //         $this->userProfile->phone = trim(Str::lower($input['phone']));
        //         $this->userProfile->created_at = Carbon::now();
        //         $this->userProfile->updated_at = Carbon::now();
        //         if($this->userProfile->save()){
        //             $message = 'User account has been created successfully.!';
        //             return true;
        //         }
        //     }
        // }catch (\Exception $e){            
        //     if($this->users->id){
        //         $this->deleteUplodedProfileImage($getImageArray['profile_photo_name']);
        //         $this->deletUserRecord($this->users->id);
        //     }         
        //     throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
        // }
    }


     /**
     * get postImageArray to store
     * @param  object  $imageArray,$post_id
     * @return object array
     */
    public function getPostImageArray($imageArray,$post_id){
        $newImageArray=[];
        $oldUploadJsonString=Upload::where('post_id',$post_id)->get('image');
        // dd(json_decode($oldUploadJsonString, true)[0]['image']);
        if(!empty($imageArray)){
            foreach($imageArray as $image){
                $newImageArray[] = $this->getPostImage($image);
            }
            if(!empty($oldUploadJsonString) || $oldUploadJsonString!=null){
                $oldPostImageArray=explode(' ', json_decode($oldUploadJsonString, true)[0]['image']);
                $imageArray=array_merge($oldPostImageArray,$newImageArray);
                return $imageArray;
            }
            else{
                return $newImageArray;
            }
        }
        // dd(array_merge($newImageArray,json_decode($oldUploadJsonString, true)));
        $finalArray= array_merge($newImageArray,json_decode($oldUploadJsonString, true));
        return $finalArray[0];
    }

     /**
     * get postVideoArray to store
     * @param  object  $imageArray,$post_id
     * @return object array
     */
    public function getPostVideoArray($videoArray,$post_id){
        $newVideoArray=[];
        $oldUploadJsonString=Upload::where('post_id',$post_id)->get('video');
        if(!empty($videoArray)){
            foreach($videoArray as $video){
                $newVideoArray[] = $this->getPostVideo($video);
            }
            if($oldUploadJsonString!=null || $oldUploadJsonString!=[] ){
                $oldPostVideoArray=explode(' ', json_decode($oldUploadJsonString, true)[0]['video']);
                $videoArray=array_merge($oldPostVideoArray,$newVideoArray);
                return $videoArray;
            }
            else{
                return $newVideoArray;
            }
        }
        $finalArray =array_merge($newVideoArray,json_decode($oldUploadJsonString, true));
        return $finalArray[0];
    }


     /**
     * [savePost] we are storing the post Details from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function savePost($input,$imageArray,$videoArray,&$message=''){
        try{
            $this->posts->post_type = $input['post_type'];
            $this->posts->user_id = $input['user_id'];
            $this->posts->post_text = $input['post_text'];
            $this->posts->country_id =$input['country_id'];
            $this->posts->surf_start_date = $input['surf_date'];
            $this->posts->wave_size = $input['wave_size'];
            $this->posts->board_type = $input['board_type'];
            $this->posts->state_id = $input['state_id'];
            $this->posts->local_beach_break_id = $input['local_beach_break_id'];
            $this->posts->surfer = $input['surfer'];
            $this->posts->optional_info = implode(" ",$input['optional_info']);
            $this->posts->created_at = Carbon::now();
            $this->posts->updated_at = Carbon::now();
            if($this->posts->save()){  
                $post_id=$this->posts->id;
                $newImageArray = $this->getPostImageArray($imageArray,$post_id);
                $newVideoArray = $this->getPostVideoArray($videoArray,$post_id);
                $this->upload->post_id = $this->posts->id;
                $this->upload->image = ($newImageArray!=[]) ? implode(" ",$newImageArray) : null;
                $this->upload->video = ($newVideoArray!=[]) ? implode(" ",$newVideoArray) : null;
                $this->upload->save();
            }
                
            if($this->posts->save()){
                    $message = 'Post has been created successfully.!';
                    return true;
                    
             }
                
            }
        catch (\Exception $e){     
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

    /**
     * [updatePost] we are updating the post Details from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function updatePost($input,$imageArray,$videoArray,$id,&$message=''){
        $posts=$this->posts->find($id);
        try{
            $posts->post_type = $input['post_type'];
            $posts->user_id = $input['user_id'];
            $posts->post_text = $input['post_text'];
            $posts->country_id =$input['country_id'];
            $posts->surf_start_date = $input['surf_date'];
            $posts->wave_size = $input['wave_size'];
            $posts->board_type = $input['board_type'];
            $posts->state_id = $input['state_id'];
            $posts->local_beach_break_id = $input['local_beach_break_id'];
            $posts->surfer = $input['surfer'];
            $posts->optional_info = implode(" ",$input['optional_info']);
            $posts->created_at = Carbon::now();
            $posts->updated_at = Carbon::now();
            
            if($posts->save()){
                $newImageArray = $this->getPostImageArray($imageArray,$posts->id);
                $newVideoArray = $this->getPostVideoArray($videoArray,$posts->id);
                
                //updating the image field
                    Upload::where('post_id', $posts->id)
                    ->update([
                        'image'=>($newImageArray!=[]) ? implode(' ', array_filter($newImageArray)) : null,
                        'video'=>($newVideoArray!=[]) ? implode(' ', array_filter($newVideoArray)) : null,
                        ]);
            }
            
            if($posts->save()){
                $message = 'Post has been updated successfully.!';
                    return $message;
                
            }
        }
        catch (\Exception $e){     
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }
}