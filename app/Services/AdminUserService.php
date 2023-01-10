<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Upload;
use App\Models\BeachBreak;
use App\Models\Report;
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
    
    protected $beach_break;
    
    protected $report;

    public function __construct() {
        // Current user object
        $this->currentUserDetails = Auth::user();
        // User model object
        $this->users = new User();

        // upload model object
        $this->upload = new Upload();

        $this->userProfile = new UserProfile();
        
        $this->beach_break = new BeachBreak();
        
        $this->report = new Report();

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
    
   public function getUsersList($params) {

        $userArray = $this->users
                ->join('user_profiles', 'user_profiles.user_id', '=', 'users.id')
                ->whereNotNull('users.user_type')
                ->whereNull('users.deleted_at')
                ->orderBy('users.id', 'DESC');
        if (isset($params['user_type']) && !empty($params['user_type'])) {
            $userArray->where('users.user_type', $params['user_type']);
        }
        if (isset($params['status']) && !empty($params['status'])) {
            $userArray->where('users.status', $params['status']);
        }
        if (isset($params['username']) && !empty($params['username'])) {
            $userArray->where('users.user_name', $params['username']);
        }
        if (isset($params['country_id']) && !empty($params['country_id'])) {
            $userArray->where('user_profiles.country_id', $params['country_id']);
        }
        if (isset($params['postcode']) && !empty($params['postcode'])) {
            $userArray->where('user_profiles.postal_code', $params['postcode']);
        }
        if (isset($params['gender']) && !empty($params['gender'])) {
            $userArray->where('user_profiles.gender', $params['gender']);
        }
        if (isset($params['state_id']) && !empty($params['state_id'])) {
            $userArray->where('user_profiles.state_id', $params['state_id']);
        }
        if (isset($params['age_from']) && $params['age_from'] > 0 && empty($params['age_to'])) {
            $from = date('Y-m-d', strtotime('-'.$params['age_from'].' year'));
            $userArray->where('user_profiles.dob','<=', $from);
        }
        if (isset($params['age_to']) && $params['age_to'] > 0 && empty($params['age_from'])) {
            $to = date('Y-m-d', strtotime('-'.$params['age_to'].' year'));
            $userArray->where('user_profiles.dob','>=', $to);
        }
        if (isset($params['age_to']) && $params['age_to'] > 0 && isset($params['age_from']) && $params['age_from'] > 0) {
            $from = date('Y-m-d', strtotime('-'.($params['age_from']-1).' year'));
            $to = date('Y-m-d', strtotime('-'.$params['age_to'].' year'));
            $userArray->whereBetween('user_profiles.dob', [$to, $from]);
        }
        if (isset($params['fName']) && !empty($params['fName'])) {
            $userArray->where('user_profiles.first_name', 'LIKE',  '%' . $params['fName'] .'%');
        }
        if (isset($params['lName']) && !empty($params['lName'])) {
            $userArray->where('user_profiles.last_name', 'LIKE',  '%' . $params['lName'] .'%');
        }
        
//         dd($userArray->toSql());
        return $userArray->paginate(10);
    }
   /**
     * [getBeachBreakListing] we are getiing all the Beach Break 
     * @param  
     * @param  
     * @return dataArray
     */
   public function getBeachBreakListing($params) {

        $userArray = $this->beach_break
                ->where('beach_breaks.flag','1')
                ->orderBy('beach_breaks.id', 'DESC');
        if (isset($params['user_type']) && !empty($params['user_type'])) {
            $userArray->where('users.user_type', $params['user_type']);
        }
        if (isset($params['status']) && !empty($params['status'])) {
            $userArray->where('users.status', $params['status']);
        }
        if (isset($params['username']) && !empty($params['username'])) {
            $userArray->where('users.user_name', $params['username']);
        }
        if (isset($params['country_id']) && !empty($params['country_id'])) {
            $userArray->where('user_profiles.country_id', $params['country_id']);
        }
        if (isset($params['postcode']) && !empty($params['postcode'])) {
            $userArray->where('user_profiles.postal_code', $params['postcode']);
        }
        if (isset($params['gender']) && !empty($params['gender'])) {
            $userArray->where('user_profiles.gender', $params['gender']);
        }
        if (isset($params['state_id']) && !empty($params['state_id'])) {
            $userArray->where('user_profiles.state_id', $params['state_id']);
        }
        if (isset($params['fName']) && !empty($params['fName'])) {
            $userArray->where('user_profiles.first_name', 'LIKE',  '%' . $params['fName'] .'%');
        }
        if (isset($params['lName']) && !empty($params['lName'])) {
            $userArray->where('user_profiles.last_name', 'LIKE',  '%' . $params['lName'] .'%');
        }
        
//         dd($userArray->toSql());
        return $userArray->paginate(10);
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
                $this->userProfile->icc = $input['telephone_prefix'];
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
     * [saveBeachBreak] we are storing the Beach Break from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveBeachBreak($input,&$message=''){
        try{
            $this->beach_break->beach_name = trim(ucwords($input['beach_name']));
            $this->beach_break->break_name = trim(ucwords($input['break_name']));
            $this->beach_break->city_region = trim(ucwords($input['city_region']));
            $this->beach_break->state = trim(ucwords($input['state']));
            $this->beach_break->country = trim(ucwords($input['country']));
            $this->beach_break->flag = 1;
            $this->beach_break->latitude = $input['latitude'];
            $this->beach_break->longitude = $input['longitude'];
            $this->beach_break->created_at = Carbon::now();
            $this->beach_break->updated_at = Carbon::now();
            $this->beach_break->save();
                
            $message = 'Beach Break has been added successfully.!';
            return $message;
        }catch (\Exception $e){  
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            die($message);
            return false;
        }
    }
    /**
     * [importBeachBreak] we are storing the Beach Break from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function importBeachBreak($data,&$message=''){
        try{
            foreach ($data as $input) {
            $beach_break = new BeachBreak();
            $beach_break->beach_name = trim(ucwords($input['beach_name']));
            $beach_break->break_name = trim(ucwords($input['break_name']));
            $beach_break->city_region = trim(ucwords($input['city_region']));
            $beach_break->state = trim(ucwords($input['state']));
            $beach_break->country = trim(ucwords($input['country']));
            $beach_break->flag = 1;
            $beach_break->latitude = $input['latitude'];
            $beach_break->longitude = $input['longitude'];
            $beach_break->created_at = Carbon::now();
            $beach_break->updated_at = Carbon::now();
            $beach_break->save(); 
            }
            $message = 'Beach Break has been added successfully.!';
            return $message;
        }catch (\Exception $e){  
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            die($message);
            return false;
        }
    }
    /**
     * [updateBeachBreak] we are updating the Beach Break from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function updateBeachBreak($input,&$message=''){
        try{
            $beach_break = $this->beach_break->find($input['beach_break_id']); 
            
            $beach_break->beach_name = trim(ucwords($input['beach_name']));
            $beach_break->break_name = trim(ucwords($input['break_name']));
            $beach_break->city_region = trim(ucwords($input['city_region']));
            $beach_break->state = trim(ucwords($input['state']));
            $beach_break->country = trim(ucwords($input['country']));
            $beach_break->flag = 1;
            $beach_break->latitude = $input['latitude'];
            $beach_break->longitude = $input['longitude'];
            $beach_break->created_at = Carbon::now();
            $beach_break->updated_at = Carbon::now();
            $beach_break->save();
                
            $message = 'Beach Break has been updated successfully.!';
            return $message;
        }catch (\Exception $e){  
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            return false;
        }
    }
    
    /**
     * [deleteBeachBreak] we are updating the beach break section 
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function deleteBeachBreak($id,&$message=''){
        
        $beach_break=$this->beach_break->find($id);
        try{
            $beach_break->flag = 0;
            $beach_break->updated_at = Carbon::now();
            
            if($beach_break->save()){
                $message = 'Beach/Break has been deleted successfully.!';
                    return $message;                
            }
        }
        catch (\Exception $e){     
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }
    
    /**
     * upload image into directory
     * @param  object  $input
     * @return object array
     */
    public function uploadImage($input){
        $returnArray = [];
        $path = public_path()."/storage/uploads/";
        $timeDate = strtotime(Carbon::now()->toDateTimeString()); 
        $returnArray['status'] = false;
        if(isset($input['profile_photo_name']) && !empty($input['profile_photo_name'])){
            $requestImageName = $input['profile_photo_name'];
            $imageNameWithExt = $requestImageName->getClientOriginalName();
            $filename = pathinfo($imageNameWithExt, PATHINFO_FILENAME); 
            $ext = $requestImageName->getClientOriginalExtension();
            $image_name = $timeDate.'_'.rand().'.'.$ext;
            $image_path = 'uploads/'.$image_name;
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
        $user = $this->users->find($id);
        $user->delete();
    }

    public function updateUserStatus($input,&$message=''){
        try{
            $users = $this->users->find($input['id']);
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


    public function updateAdminUser($dataRequest,$user_id,&$message=''){
        $users = $this->users->find($user_id);
        $userProfiles = new UserProfile();
        try {
            if ($users) {
                $user_profiles = $userProfiles->where('user_id', $user_id)->first();
                if ($users->status !== $this->checkUserType['status']['ACTIVE'] || $users->is_deleted == '1') {
                    $message = $this->checkUserType['common']['BLOCKED_USER'];
                    return false;
                }

                $userType = $users->user_type;
                if (isset($dataRequest['profile_photo_blob']) && !empty($dataRequest['profile_photo_blob'])) {

                    $path = public_path() . "/storage/images/";
                    $timeDate = strtotime(Carbon::now()->toDateTimeString());
                    $cropped_image = $dataRequest['profile_photo_blob'];
                    $image_parts = explode(";base64,", $cropped_image);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $image_name = $timeDate . '.' . $image_type; // '_'.rand().
                    $image_path_forDB = 'images/' . $image_name;
                    $imgNewName = $path . $image_name;
                    if (file_put_contents($imgNewName, $image_base64)) {
                        $users->profile_photo_name = $image_name;
                        $users->profile_photo_path = $image_path_forDB;
                    }
                }
                $users->user_name = !empty($dataRequest['user_name']) ? $dataRequest['user_name'] : '';
                $user_profiles->first_name = $dataRequest['first_name'];
                $user_profiles->last_name = $dataRequest['last_name'];
                $user_profiles->phone = $dataRequest['phone'];
                $user_profiles->paypal = $dataRequest['paypal'];
                $user_profiles->country_id = $dataRequest['country_id'];
                $user_profiles->postal_code = $dataRequest['postal_code'];
                $user_profiles->local_beach_break_id = !empty($dataRequest['local_beach_break_id']) ? $dataRequest['local_beach_break_id'] : '';
                $users->account_type = !empty($dataRequest['account_type']) ? $dataRequest['account_type'] : $users->account_type;

                if ($userType == 'USER') {
                    $user_profiles->preferred_board = $dataRequest['board_type'];
                    $user_profiles->dob = $dataRequest['dob'];
                    $user_profiles->gender = $dataRequest['gender'];
                } elseif ($userType == 'PHOTOGRAPHER') {
                    $user_profiles->business_name = $dataRequest['business_name'];
                    $user_profiles->business_type = $dataRequest['photographer_type'];
                    $user_profiles->preferred_camera = $dataRequest['camera_brand'];
                    $user_profiles->language = $dataRequest['language'];
                    $user_profiles->website = $dataRequest['website'];
                } elseif ($userType == 'SURFER CAMP') {
                    $user_profiles->resort_name = $dataRequest['resort_name'];
                    $user_profiles->resort_type = $dataRequest['resort_type'];
                    $user_profiles->website = $dataRequest['website'];
                    $user_profiles->language = $dataRequest['language'];
                } elseif ($userType == 'ADVERTISEMENT') {
                    $user_profiles->company_name = $dataRequest['company_name'];
                    $user_profiles->company_address = $dataRequest['company_address'];
                    $user_profiles->industry = $dataRequest['industry'];
                    $user_profiles->state_id = $dataRequest['state_id'];
                    $user_profiles->suburb = $dataRequest['suburb'];
                }
                if ($users->save() && $user_profiles->save()) {
                    $message = $this->checkUserType['success']['UPDATE_SUCCESS'];
                    ;
                    return true;
                }
            } else {
                $message = $this->checkUserType['common']['NO_RECORDS'];
                return false;
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
//            echo '<pre>34';        print_r($message);die;
            return false;
        }
    }
    /**
     * [getUserDetailByID]
     * @param  int $id [current user id which need to be update]
     * @param  string &$message    [description ]
     * @return $object
     */
    public function getUserDetailByID($id, &$message = '') {
        return $this->users->find($id);
    }

    public function searchReport($string) {
        if ($string != '') {
            $report = $this->report
                    ->join('users', 'users.id', '=', 'reports.user_id')
                    ->join('user_profiles', 'user_profiles.user_id', '=', 'users.id')
                    ->whereRaw("concat(first_name, ' ', last_name) like '%" . $string . "%' ")
                    ->get();
        } else {
            $report = $this->report
                            ->join('users', 'users.id', '=', 'reports.user_id')
                            ->join('user_profiles', 'user_profiles.user_id', '=', 'users.id')
                            ->get();
        }
        //dd($result);
        return $report;
    }
    
}