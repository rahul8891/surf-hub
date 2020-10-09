<?php

namespace App\Actions\Fortify;
use Laravel\Fortify\Fortify;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Storage;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
              
        $user = new User(); // user tabel object 
        $userProfile = new UserProfile(); // user profile table object

        Validator::make($input, [
            'first_name' => ['required', 'string'],
            'last_name' => ['string'],
            'name' => ['required', 'string', 'max:255','unique:users','alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required','numeric','digits:10'],
            'account_type'=>['required','string'],
            'language' => ['required','string'],
            'profile_photo_name' => ['image','mimes:jpeg,jpg,png'],
            'password' => $this->passwordRules(),
        ])->validate(); 

        try{
            $getImageArray = $this->uploadImage($input);
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->password = Hash::make($input['password']);
            $user->account_type = $input['account_type'];
            $user->profile_photo_name = ($getImageArray['status']) ? $getImageArray['profile_photo_name'] :'';
            $user->profile_photo_path = ($getImageArray['status']) ? $getImageArray['profile_photo_path'] :'';
            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();                 
            if($user->save()){
                $userProfile->user_id = $user->id;
                $userProfile->first_name =  $input['first_name'];
                $userProfile->last_name = $input['last_name'];
                $userProfile->facebook = $input['facebook'];
                $userProfile->instagram = $input['instagram'];
                $userProfile->language = $input['language'];
                $userProfile->phone = $input['phone'];
                $userProfile->created_at = Carbon::now();
                $userProfile->updated_at = Carbon::now();
                if($userProfile->save()){
                    return $user;
                }
            }
        }catch (\Exception $e){         
            if($user->id){
                $this->deleteUplodedProfileImage($getImageArray['profile_photo_name']);
                $this->deletUserRecord($user->id);
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
            $image_name = $filename.'_'.$timeDate.'.'.$ext;
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
        $user = new User();
        $user = $user::find($id);           
        $user->delete();
    }
}
