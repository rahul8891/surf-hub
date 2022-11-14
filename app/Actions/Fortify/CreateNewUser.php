<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use Carbon\Carbon;
use Redirect;
use Closure;

class CreateNewUser implements CreatesNewUsers {

    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input) {
        $user = new User(); // user tabel object 
        $userProfile = new UserProfile(); // user profile table object   

        Validator::make($input, [
            'first_name' => ['required', 'min:3', 'string'],
            'last_name' => ['required', 'min:3', 'string'],
//            'user_name' => ['required', 'string','min:5', 'max:25', 'unique:users', 'alpha_dash'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'phone' => ['required', 'string'],
//            'language' => ['required', 'string'],
            'country_id' => ['required', 'numeric'],
            'user_type_id' => ['required', 'numeric'],
//            'account_type' => ['required', 'string'],
            'profile_photo_name' => ['image', 'mimes:jpeg,jpg,png'],
//            'local_beach_break' => ['required', 'string'],
            'terms' => ['required'],
            'password' => $this->passwordRules(),
        ])->validate();
//         echo '<pre>';print_r($input);die;
        try {

            $getImageArray = $this->uploadImage($input);
//            echo '<pre>';print_r($getImageArray);die;
            $user->user_name = !empty($input['user_name']) ? $input['user_name'] : '';
            $user->email = $input['email'];
            $user->user_type = $input['user_type_id'];
            $user->password = Hash::make($input['password']);
            $user->account_type = !empty($input['account_type']) ? $input['account_type'] : 1;
            $user->profile_photo_name = !empty($getImageArray['status']) ? $getImageArray['profile_photo_name'] : '';
            $user->profile_photo_path = !empty($getImageArray['status']) ? $getImageArray['profile_photo_path'] : '';
            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();
            if ($user->save()) {

                if ($input['user_type_id'] == 6 && !empty($input['resort_pics'])) {
                    $getResortImageArray = $this->uploadResortImages($input);
                }

                $userProfile->user_id = $user->id;
                $userProfile->first_name = $input['first_name'];
                $userProfile->last_name = $input['last_name'];
//                $userProfile->facebook = $input['facebook'];
//                $userProfile->instagram = $input['instagram'];
                $userProfile->language = !empty($input['language']) ? $input['language'] : '';
                $userProfile->country_id = $input['country_id'];
                $userProfile->local_beach_break_id = !empty($input['local_beach_break_id']) ? $input['local_beach_break_id'] : '';
                $userProfile->icc = !empty($input['telephone_prefix']) ? $input['telephone_prefix'] : '';
                $userProfile->phone = $input['phone'];
                $userProfile->website = !empty($input['website']) ? $input['website'] : '';
//                if($input['gender']) {
                $userProfile->gender = !empty($input['gender']) ? $input['gender'] : '';
//                }
//                if($input['dob']) {
                $userProfile->dob = !empty($input['dob']) ? $input['dob'] : '';
//                }
                $userProfile->business_name = !empty($input['business_name']) ? $input['business_name'] : '';
//                if($input['photographer_type']) {
                $userProfile->business_type = !empty($input['photographer_type']) ? $input['photographer_type'] : '';
//                }
//                if($input['resort_name']) {
                $userProfile->resort_name = !empty($input['resort_name']) ? $input['resort_name'] : '';
                $userProfile->resort_type = !empty($input['resort_type']) ? $input['resort_type'] : '';
//                }
//                if($input['camera_brand']) {
                $userProfile->preferred_camera = !empty($input['camera_brand']) ? $input['camera_brand'] : '';
//                }
//                if($input['company_name']) {
                $userProfile->company_name = !empty($input['company_name']) ? $input['company_name'] : '';
                $userProfile->company_address = !empty($input['company_address']) ? $input['company_address'] : '';
                $userProfile->industry = !empty($input['industry']) ? $input['industry'] : '';
                $userProfile->suburb = !empty($input['suburb']) ? $input['suburb'] : '';
                $userProfile->state_id = !empty($input['state_id']) ? $input['state_id'] : '';
//                }
                $userProfile->paypal = $input['paypal'];
                $userProfile->created_at = Carbon::now();
                $userProfile->updated_at = Carbon::now();
                if ($userProfile->save()) {
                    return $user;
                }
            }
        } catch (\Exception $e) {
            if ($user->id) {
                $this->deleteUplodedProfileImage($getImageArray['profile_photo_name']);
                $this->deleteUplodedResortImages($input['resort_name']);
                $this->deletUserRecord($user->id);
            }
//            echo '<pre>';
//            print_r($e->getMessage());
//            die;
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    /**
     * upload image into directory
     * @param  object  $input
     * @return object array
     */
    public function uploadImage($input) {

        $returnArray = [];
        $path = public_path() . "/storage/images/";
        $timeDate = strtotime(Carbon::now()->toDateTimeString());
        $returnArray['status'] = false;
        if (isset($input['profile_photo_blob']) && !empty($input['profile_photo_blob'])) {
            $cropped_image = $input['profile_photo_blob'];
            $image_parts = explode(";base64,", $cropped_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image_name = $timeDate . '.' . $image_type; // '_'.rand().
            $image_path_forDB = 'images/' . $image_name;
            $imgNewName = $path . $image_name;
            if (!file_put_contents($imgNewName, $image_base64)) {
                throw ValidationException::withMessages([trans('auth.profile_image')]);
            } else {
                $returnArray['status'] = true;
                $returnArray['profile_photo_name'] = $image_name;
                $returnArray['profile_photo_path'] = $image_path_forDB;
            }
        }
        return $returnArray;
        // Form Data without croping
        /* $returnArray = [];
          $path = public_path() . "/storage/images/";
          $timeDate = strtotime(Carbon::now()->toDateTimeString());
          $returnArray['status'] = false;
          if (isset($input['profile_photo_name']) && !empty($input['profile_photo_name'])) {
          $requestImageName = $input['profile_photo_name'];
          $imageNameWithExt = $requestImageName->getClientOriginalName();
          $filename = pathinfo($imageNameWithExt, PATHINFO_FILENAME);
          $ext = $requestImageName->getClientOriginalExtension();
          $image_name = $filename . '_' . $timeDate . '.' . $ext;
          $image_path = 'images/' . $image_name;
          if (!$requestImageName->move($path, $image_name)) {
          throw ValidationException::withMessages([trans('auth.profile_image')]);
          } else {
          $returnArray['status'] = true;
          $returnArray['profile_photo_name'] = $image_name;
          $returnArray['profile_photo_path'] = $image_path;
          }
          return $returnArray;
          } */
    }

    /**
     * upload image into directory
     * @param  object  $input
     * @return object array
     */
    public function uploadResortImages($input) {


        $timeDate = strtotime(Carbon::now()->toDateTimeString());
        $dir = public_path('storage/') . $input['resort_name'];
        mkdir($dir);
        chmod("$dir", 0755);
        foreach ($input['resort_pics'] as $file) {
            $filename = $timeDate . '.' . $file->getClientOriginalName();
            $file->move(public_path('storage/' . $input['resort_name'] . '/'), $filename);
        }
    }

    /**
     * Delete profile image if data not stor in db
     * @param  string  $imageName
     * @return void
     */
    public function deleteUplodedProfileImage($imageName) {
        if ($imageName) {
            unlink(public_path() . "/storage/images/" . $imageName);
        }
    }

    public function deleteUplodedResortImages($input) {
        $dir = public_path('storage/') . $input;
        $files = glob($dir . '/*');

// Deleting all the files in the list
        foreach ($files as $file) {

            if (is_file($file))

            // Delete the given file
                unlink($file);
        }
    }

    /**
     * Delete user details if user profile data not store in db
     * @param  number  $id
     * @return void
     */
    public function deletUserRecord($id) {
        $user = new User();
        $user = $user::find($id);
        $user->delete();
    }

}
