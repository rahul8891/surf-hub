<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Tag;
use App\Models\UserFollow;
use App\Models\Notification;
use App\Models\AdvertPost;
use App\Models\Post;
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
    public function getUserDetailByID($id, &$message = '') {
        return $this->users->find($id);
    }

    /**
     * [updateUserProfile]
     * @param  [object] $dataRequest [description contain data which need to be update]
     * @param  string &$message    [description ]
     * @return [object]              [description]
     */
    public function updateUserProfile($dataRequest, &$message = '') {

        $users = $this->users->find(Auth::user()->id);
        $userProfiles = new UserProfile();
        try {
            if ($users) {
                $user_profiles = $userProfiles->where('user_id', Auth::user()->id)->first();
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
     * [updateUserProfileImage]
     * @param  [object] $dataRequest [description contain data which need to be update]
     * @param  string &$message    [description ]
     * @return [object]              [description]
     */
    public function updateUserProfileImage($dataRequest, &$message = '') {

        $id = Auth::user()->id;

        if (isset($dataRequest['userId']) && !empty($dataRequest['userId'])) {
            $id = $dataRequest['userId'];
        }
        $users = $this->users->find($id);

        if ($users) {
            $userOldProfileImageName = $users->profile_photo_name;
            $path = public_path() . "/storage/images/";
            $timeDate = strtotime(Carbon::now()->toDateTimeString());
            $cropped_image = $dataRequest['image'];
            $image_parts = explode(";base64,", $cropped_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image_name = $timeDate . '.' . $image_type; // '_'.rand().
            $image_path_forDB = 'images/' . $image_name;
            $imgNewName = $path . $image_name;
            if (!file_put_contents($imgNewName, $image_base64)) {
                // Error message
                $message = $this->checkUserType['common']['DEFAULT_ERROR'];
                return false;
            } else {
                $users->id = $id;
                $users->profile_photo_path = $image_path_forDB;
                $users->profile_photo_name = $image_name;
                // update user auth image 
                if (empty($dataRequest['userId'])) {
                    Auth::user()->profile_photo_path = $image_path_forDB;
                    Auth::user()->profile_photo_path = $image_name;
                }
                if ($users->save()) {
                    // delete old image file 
                    File::delete(public_path("/storage/images/" . $userOldProfileImageName));
                    $message = $this->checkUserType['success']['IMAGE_UPDATE_SUCCESS'];
                    return true;
                }
            }
        } else {
            $message = $this->checkUserType['common']['NO_RECORDS'];
            return false;
        }
    }

    public function getAllUserForCreatePost() {
        $users = $this->users->select('id', 'user_name')->where('email_verified_at', '!=', null)
                        ->where('status', $this->checkUserType['status']['ACTIVE'])
                        ->where('is_deleted', '0')
                        ->where('user_type', $this->checkUserType['userType']['USER'])
                        ->whereNotIn('id', [Auth::user()->id])
                        ->orderBy('id', 'asc')->get();
        return $users;
    }

    public function getUsersForTagging($string) {
        $userProfiles = new UserProfile();

        if (Auth::user()) {
            $result = $userProfiles
                    ->join('users', 'users.id', '=', 'user_profiles.user_id')
                    ->where('user_id', '!=', Auth::user()->id)
                    ->where('first_name', 'LIKE', '%' . $string . '%')
                    ->orWhere('users.user_name', 'LIKE', '%' . $string . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $string . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $string . '%')
                    ->groupBy('users.id')
                    ->get();
        } else {
            $result = $userProfiles
                    ->join('users', 'users.id', '=', 'user_profiles.user_id')
                    ->where('first_name', 'LIKE', '%' . $string . '%')
                    ->orWhere('users.user_name', 'LIKE', '%' . $string . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $string . '%')
                    ->orWhere(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $string . '%')
                    ->groupBy('users.id')
                    ->get();
        }



        //dd($result);
        return $result;
    }

    public function getUsersFilterByUserType($string, $user_type) {
        $userProfiles = new UserProfile();
//        DB::enableQueryLog();
        $result = $userProfiles
                ->join('users', 'users.id', '=', 'user_profiles.user_id')
                ->where('user_id', '!=', Auth::user()->id)
                ->whereIn('user_type', $user_type)
                ->where(function ($q) use ($string) {

                    $q->orWhere('first_name', 'LIKE', '%' . $string . '%');
                    $q->orWhere('users.user_name', 'LIKE', '%' . $string . '%');
                    $q->orWhere('last_name', 'LIKE', '%' . $string . '%');
                    $q->orWhere(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $string . '%');
                    $q->orWhere('resort_name', 'LIKE', '%' . $string . '%');
                    $q->orWhere('business_name', 'LIKE', '%' . $string . '%');
                    $q->orWhere('company_name', 'LIKE', '%' . $string . '%');
                })
                ->groupBy('users.id')
                ->get();
//         $quries = DB::getQueryLog();
//         dd($quries);
        //dd($result);
        return $result;
    }

    public function checkAlreadyTagged($dataRequest) {
        $result = $this->tag
                ->where('post_id', $dataRequest['post_id'])
                ->where('user_id', $dataRequest['user_id'])
                ->first();
        return $result;
    }

    public function tagUserOnPost($input) {
        $this->tag->post_id = $input['post_id'];
        $this->tag->user_id = $input['user_id'];
        $this->tag->created_at = Carbon::now();
        $this->tag->updated_at = Carbon::now();
        if ($this->tag->save()) {
            $this->setTagNotification($input);
        }
    }

    public function setTagNotification($input) {
        $this->notification->post_id = $input['post_id'];
        $this->notification->sender_id = Auth::user()->id;
        $this->notification->receiver_id = $input['user_id'];
        $this->notification->notification_type = 'Tag';
        $this->notification->created_at = Carbon::now();
        $this->notification->updated_at = Carbon::now();
        $this->notification->save();
    }

    public function getAllTaggedUsers($input) {
        //dd($input);
        $result = $this->tag
                        ->where('post_id', $input['post_id'])
                        ->where('is_deleted', '0')
                        ->orderBy('id', 'desc')->get();
        return $result;
    }

    public function getNotificationCount() {
        $count = $this->userFollows->where('followed_user_id', Auth::user()->id)
                ->where('status', 'FOLLOW')
                ->where('follower_request_status', '1')
                ->where('is_deleted', '0')
                ->count();
        return $count;
    }

    public function followRequests() {
        Notification::where(['receiver_id' => Auth::user()->id, 'notification_type' => 'Follow'])->update(['status' => '1', 'count_status' => '1', 'updated_at' => Carbon::now()]);

        $followRequests = $this->userFollows->where('followed_user_id', Auth::user()->id)
                        ->where('status', 'FOLLOW')
                        ->where('follower_request_status', 1)
                        ->where('is_deleted', '0')
                        ->orderBy('id', 'desc')->get();
        return $followRequests;
    }

    public function followers($user_id) {
        $followers = $this->userFollows->where('followed_user_id', $user_id)
                        ->where('status', 'FOLLOW')
//                    ->where('follower_request_status','0') 
                        ->where('is_deleted', '0')
                        ->orderBy('id', 'desc')->get();
        return $followers;
    }

    public function searchFollowRequest($string) {
        if ($string != '') {
            $followRequests = $this->userFollows
                    ->join('user_profiles', 'user_profiles.user_id', '=', 'user_follows.follower_user_id')
                    ->where('followed_user_id', Auth::user()->id)
                    ->where('user_follows.status', 'FOLLOW')
                    ->where('follower_request_status', 1)
                    ->where('user_follows.is_deleted', '0')
                    ->whereRaw("concat(first_name, ' ', last_name) like '%" . $string . "%' ")
                    ->get();
        } else {
            $followRequests = $this->userFollows->where('followed_user_id', Auth::user()->id)
                            ->where('status', 'FOLLOW')
                            ->where('follower_request_status', 1)
                            ->where('is_deleted', '0')
                            ->orderBy('id', 'desc')->get();
        }
        //dd($result);
        return $followRequests;
    }

    public function searchFollowers($string, $user_id) {
        if ($string != '') {
            $followers = $this->userFollows
                    ->join('user_profiles', 'user_profiles.user_id', '=', 'user_follows.follower_user_id')
                    ->where('followed_user_id', $user_id)
                    ->where('user_follows.status', 'FOLLOW')
                    ->where('user_follows.is_deleted', '0')
                    ->whereRaw("concat(first_name, ' ', last_name) like '%" . $string . "%' ")
                    ->get();
        } else {
            $followers = $this->userFollows->where('followed_user_id', $user_id)
                            ->where('status', 'FOLLOW')
//                    ->where('follower_request_status','0') 
                            ->where('is_deleted', '0')
                            ->orderBy('id', 'desc')->get();
        }
        //dd($result);
        return $followers;
    }

    public function searchFollowing($string, $user_id) {
        if ($string != '') {
            $following = $this->userFollows
                    ->join('user_profiles', 'user_profiles.user_id', '=', 'user_follows.followed_user_id')
                    ->where('follower_user_id', $user_id)
                    ->where('user_follows.status', 'FOLLOW')
                    ->where('user_follows.is_deleted', '0')
                    ->whereRaw("concat(first_name, ' ', last_name) like '%" . $string . "%' ")
                    ->get();
        } else {
            $following = $this->userFollows->where('follower_user_id', $user_id)
                            ->where('status', 'FOLLOW')
//                    ->where('follower_request_status','0') 
                            ->where('is_deleted', '0')
                            ->orderBy('id', 'desc')->get();
        }
        //dd($result);
        return $following;
    }

    public function following($user_id) {
        Notification::where(['receiver_id' => $user_id, 'notification_type' => 'Accept'])->orWhere(['notification_type' => 'Reject'])->update(['status' => '1', 'count_status' => '1', 'updated_at' => Carbon::now()]);
        $following = $this->userFollows->where('follower_user_id', $user_id)
                        ->where('status', 'FOLLOW')
//                    ->where('follower_request_status','0') 
                        ->where('is_deleted', '0')
                        ->orderBy('id', 'desc')->get();
        return $following;
    }

    public function updateFollowStatus($input, &$message = '', $column = null) {
        try {
            $userFollows = $this->userFollows->find($input['id']);
            if ($userFollows) {
                $userFollows->id = $input['id'];
                $userFollows->status = $input['status'];
                if ($userFollows->save()) {
                    $resultArray['message'] = 'Status has been updated!';
                    $resultArray['status'] = 'success';
                    $resultArray['count'] = $this->getFollowCount($column, '0');
                    return $resultArray;
                } else {
                    $resultArray['message'] = 'The user details not be updated. Please, try again.';
                    $resultArray['status'] = 'failure';
                    $resultArray['count'] = $this->getFollowCount($column, '0');
                    return $resultArray;
                }
            }
        } catch (\Exception $e) {
            $message = $e->getPrevious()->getMessage();
            return false;
        }
    }

    public function updateAcceptStatus($input, &$message = '', $column = null) {
        try {
            $userFollows = $this->userFollows->find($input['id']);
            if ($userFollows) {
                //dd($userFollows);
                $userFollows->id = $input['id'];
                $userFollows->follower_request_status = $input['follower_request_status'];
                $result = $this->saveFollowRequestAcceptRejectNotification($userFollows, 'Accept');
                //dd($result);
                if ($userFollows->save()) {
                    $resultArray['message'] = 'Status has been updated!';
                    $resultArray['status'] = 'success';
                    $resultArray['count'] = $this->getFollowCount($column, '1');
                    return $resultArray;
                } else {
                    $resultArray['message'] = 'The user details not be updated. Please, try again.';
                    $resultArray['status'] = 'failure';
                    $resultArray['count'] = $this->getFollowCount($column, '1');
                    return $resultArray;
                }
            }
        } catch (\Exception $e) {
            $message = $e->getPrevious()->getMessage();
            return false;
        }
    }

    public function updateRejectStatus($input, &$message = '', $column = null) {
        try {
            $userFollows = $this->userFollows->find($input['id']);
            if ($userFollows) {
                //$userFollows->status = $input['status'];
                $userFollows->is_deleted = '1';
                if ($userFollows->save()) {
                    $this->saveFollowRequestAcceptRejectNotification($userFollows, 'Reject');
                    $resultArray['message'] = 'Status has been updated!';
                    $resultArray['status'] = 'success';
                    $resultArray['count'] = $this->getFollowCount($column, '1');
                    return $resultArray;
                } else {
                    $resultArray['message'] = 'The user details not be updated. Please, try again.';
                    $resultArray['status'] = 'failure';
                    $resultArray['count'] = $this->getFollowCount($column, '1');
                    return $resultArray;
                }
            }
        } catch (\Exception $e) {
            $message = $e->getPrevious()->getMessage();
            return false;
        }
    }

    public function getFollowCount($column = null, $status = null) {
        $count = $this->userFollows->where($column, Auth::user()->id)
                ->where('status', 'FOLLOW')
                ->where('follower_request_status', $status)
                ->where('is_deleted', '0')
                ->count();
        return $count;
    }

    public function getFollowDataCount($column = null, $status = null, $user_id) {
        $count = $this->userFollows->where($column, $user_id)
                ->where('status', 'FOLLOW')
                ->whereIn('follower_request_status', $status)
                ->where('is_deleted', '0')
                ->count();
        return $count;
    }

    public function updateRemoveStatus($input, &$message = '', $column = null) {
        try {
            $userFollows = $this->userFollows->find($input['id']);
            if ($userFollows) {
                $userFollows->id = $input['id'];
                $userFollows->is_deleted = $input['is_deleted'];
                if ($userFollows->save()) {
                    $resultArray['message'] = 'Status has been updated!';
                    $resultArray['status'] = 'success';
                    $resultArray['count'] = $this->getFollowCount($column, '0');
                    return $resultArray;
                } else {
                    $resultArray['message'] = 'The user details not be updated. Please, try again.';
                    $resultArray['status'] = 'failure';
                    $resultArray['count'] = $this->getFollowCount($column, '0');
                    return $resultArray;
                }
            }
        } catch (\Exception $e) {
            $message = $e->getPrevious()->getMessage();
            return false;
        }
    }

    public function followToFollower($input, &$message = '') {
        try {
            $userFollows = new UserFollow();
            if ($userFollows) {
                $resultArray = $this->checkFollow($input['followed_user_id']);
                if ($resultArray) {
                    $responseArray['message'] = 'You are already following to ' . $resultArray->followed->user_profiles->first_name . ' ' . $resultArray->followed->user_profiles->last_name;
                    $responseArray['status'] = 'failure';
                    return $responseArray;
                } else {
                    if ($input['followed_user_id'] == Auth::user()->id) {
                        $responseArray['message'] = 'You can not follow your self.';
                        $responseArray['status'] = 'failure';
                        return $responseArray;
                    } else {
                        $userFollows->followed_user_id = $input['followed_user_id'];
                        $userFollows->follower_user_id = Auth::user()->id;
                        $userFollows->status = $input['sataus'];
                        if ($userFollows->save()) {
                            //set follow request notification
                            $this->saveFollowRequestNotification($input);
                            $responseArray['message'] = 'Follow request has been sent!';
                            $responseArray['status'] = 'success';
                            return $responseArray;
                        } else {
                            $responseArray['message'] = 'Unable to send follow request, Please, try again.';
                            $responseArray['status'] = 'success';
                            return $responseArray;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $message = $e->getPrevious()->getMessage();
            return false;
        }
    }

    public function checkFollow($followed_user_id = null) {
        $result = $this->userFollows->where('follower_user_id', Auth::user()->id)
                ->where('followed_user_id', $followed_user_id)
                ->where('status', 'FOLLOW')
                ->where('is_deleted', '0')
                ->first();

        return $result;
    }

    /**
     * [saveFollowRequestNotification] we are storing the follow request notifications
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveFollowRequestNotification($input, &$message = '') {
        try {
            $this->notification->post_id = $input['post_id'];
            $this->notification->sender_id = Auth::user()->id;
            $this->notification->receiver_id = $input['followed_user_id'];
            $this->notification->notification_type = 'Follow';
            $this->notification->created_at = Carbon::now();
            $this->notification->updated_at = Carbon::now();
            //dd($this->comments);
            $this->notification->save();
        } catch (\Exception $e) {
            $message = '"' . $e->getMessage() . '"';
            return $message;
        }
    }

    /**
     * [saveFollowRequestAcceptRejectNotification] we are storing the accept and reject notifications
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveFollowRequestAcceptRejectNotification($input, $notification_type = '') {
        //dd($input);
        try {
            $this->notification->post_id = $input['id'];
            $this->notification->sender_id = Auth::user()->id;
            $this->notification->receiver_id = $input['followed_user_id'];
            $this->notification->notification_type = $notification_type;
            $this->notification->created_at = Carbon::now();
            $this->notification->updated_at = Carbon::now();
            //dd($this->comments);
            $this->notification->save();
        } catch (\Exception $e) {
            $message = '"' . $e->getMessage() . '"';
            return $message;
        }
    }

    public function checkUsername($dataRequest) {
        $usernameExist = $this->users->where('user_name', $dataRequest['user_name'])->count();
        return $usernameExist;
    }

    public function getUserDetail($surfer_id) {
        $userData = UserProfile::where('user_id', $surfer_id)->get();
        $userProfile = array();
        foreach ($userData as $val) {
            $userProfile['user_id'] = $surfer_id;
            $userProfile['surfer_name'] = $val->first_name . ' ' . $val->last_name;
            $userProfile['profile_photo_path'] = $val->user->profile_photo_path;
            $userProfile['email'] = $val->user->email;
            $userProfile['gender'] = (isset($val->gender) && $val->gender != 0) ? $this->checkUserType['gender_type'][$val->gender] : '-';
            $userProfile['beach_break'] = isset($val->local_beach_break_id) ? $val->beach_breaks->beach_name . " " . $val->beach_breaks->break_name : '-';
            $userProfile['country'] = isset($val->country_id) ? $val->countries->name : '-';
            $userProfile['dob'] = isset($val->dob) ? $val->dob : '-';
            $userProfile['preferred_board'] = (isset($val->preferred_board) && !empty($val->preferred_board)) ? $this->checkUserType['board_type'][$val->preferred_board] : '-';
            $userProfile['website'] = (isset($val->website) && !empty($val->website)) ? $val->website : '-';
            $userProfile['postal_code'] = isset($val->postal_code) ? $val->postal_code : '-';
            $userProfile['camera'] = isset($val->preferred_camera) ? $val->preferred_camera : '-';
            $userProfile['phone'] = isset($val->phone) ? $val->phone : '-';
            $userProfile['user_type'] = $val->user->user_type;
        }
        return $userProfile;
    }

    public function getAdvertPost($id) {
        $advertPost = array();
        $post = AdvertPost::where('post_id', $id)
                ->get();
        
//        echo '<pre>';print_r($post);die;
        foreach ($post as $val) {
         $advertPost['ad_link']  = $val->ad_link;
         $advertPost['surfhub_target']  = $val->surfhub_target;
         $advertPost['profile_target']  = $val->profile_target;
         $advertPost['search_target']  = $val->search_target;
         $advertPost['gender']  = $val->gender;
         $advertPost['optional_user_type']  = $val->optional_user_type;
         $advertPost['optional_country_id']  = $val->optional_country_id;
         $advertPost['optional_state_id']  = $val->optional_state_id;
         $advertPost['optional_postcode']  = $val->optional_postcode;
         $advertPost['optional_beach_id']  = $val->optional_beach_id;
         $advertPost['optional_beach']  = $val->beach->beach_name;
         $advertPost['optional_board_type']  = $val->optional_board_type;
         $advertPost['optional_camera_brand']  = $val->optional_camera_brand;
         $advertPost['optional_surf_resort']  = $val->optional_surf_resort;
         $advertPost['search_user_type']  = $val->search_user_type;
         $advertPost['search_surf_resort']  = $val->search_surf_resort;
         $advertPost['currency_type']  = $val->currency_type;
         $advertPost['your_budget']  = $val->your_budget;
         $advertPost['per_view']  = $val->per_view;
         $advertPost['start_date']  = $val->start_date;
         $advertPost['end_date']  = $val->end_date;
         $advertPost['country_id']  = $val->advert_post->country_id;
         $advertPost['state_id']  = $val->advert_post->state_id;
         $advertPost['local_beach_id']  = $val->advert_post->local_beach_id;
         $advertPost['local_beach']  = $val->advert_post->beach_breaks->beach_name;
         $advertPost['local_break']  = $val->advert_post->beach_breaks->break_name;
         $advertPost['local_break_id']  = $val->advert_post->local_break_id;
         $advertPost['board_type']  = $val->advert_post->board_type;
         $advertPost['surfer']  = $val->advert_post->surfer;
         $advertPost['fin_set_up']  = $val->advert_post->fin_set_up;
         $advertPost['post_text']  = $val->advert_post->post_text;
         $advertPost['advert_img']  = $val->advert_post->upload->image;
         $advertPost['advert_vid']  = $val->advert_post->upload->video;
        }
        return $advertPost;
    }
    
    public function getMyAds() {
        $advertPost = array();
        $post = Post::where('user_id', Auth::user()->id)
                ->where('is_deleted', '=','0')
                ->get();
        $counter = 0;
        foreach ($post as $val) {
            if (isset($val->advert->id)) {
                $advertPost[$counter]['post_id'] = $val->id;
                $advertPost[$counter]['post_text'] = $val->post_text;
                $advertPost[$counter]['ad_link'] = $val->advert->ad_link;
                $advertPost[$counter]['surfhub_target'] = $val->advert->surfhub_target;
                $advertPost[$counter]['profile_target'] = $val->advert->profile_target;
                $advertPost[$counter]['search_target'] = $val->advert->search_target;
                $advertPost[$counter]['gender'] = $val->advert->gender;
                $advertPost[$counter]['optional_user_type'] = $val->advert->optional_user_type;
                $advertPost[$counter]['optional_country_id'] = $val->advert->optional_country_id;
                $advertPost[$counter]['optional_state_id'] = $val->advert->optional_state_id;
                $advertPost[$counter]['optional_postcode'] = $val->advert->optional_postcode;
                $advertPost[$counter]['optional_beach_id'] = $val->advert->optional_beach_id;
                $advertPost[$counter]['optional_beach'] = $val->advert->beach->beach_name;
                $advertPost[$counter]['optional_board_type'] = $val->advert->optional_board_type;
                $advertPost[$counter]['optional_camera_brand'] = $val->advert->optional_camera_brand;
                $advertPost[$counter]['optional_surf_resort'] = $val->advert->optional_surf_resort;
                $advertPost[$counter]['search_user_type'] = $val->advert->search_user_type;
                $advertPost[$counter]['search_surf_resort'] = $val->advert->search_surf_resort;
                $advertPost[$counter]['currency_type'] = $val->advert->currency_type;
                $advertPost[$counter]['your_budget'] = $val->advert->your_budget;
                $advertPost[$counter]['per_view'] = $val->advert->per_view;
                $advertPost[$counter]['start_date'] = $val->advert->start_date;
                $advertPost[$counter]['end_date'] = $val->advert->end_date;
                $advertPost[$counter]['country_id'] = $val->country_id;
                $advertPost[$counter]['state_id'] = $val->state_id;
                $advertPost[$counter]['local_beach_id'] = $val->local_beach_id;
                $advertPost[$counter]['local_beach'] = $val->beach_breaks->beach_name;
                $advertPost[$counter]['local_break'] = $val->beach_breaks->break_name;
                $advertPost[$counter]['local_break_id'] = $val->local_break_id;
                $advertPost[$counter]['board_type'] = $val->board_type;
                $advertPost[$counter]['surfer'] = $val->surfer;
                $advertPost[$counter]['fin_set_up'] = $val->fin_set_up;
                $counter++;
            }
        }
        return $advertPost;
    }

    public function getResortImages($resort_id) {
        $userData = UserProfile::where('user_id', $resort_id)->get();
        foreach ($userData as $val) {
            $resortName = $val->resort_name;
        }
        $dir = public_path('storage/') . $resortName;
        if ($handle = opendir($dir)) {
            $file_display = ['jpg', 'jpeg', 'png', 'gif'];
            while (false !== ($file = readdir($handle))) {
                $file_type = pathinfo($file, PATHINFO_EXTENSION);
                if (in_array($file_type, $file_display) == true) {
                    $ImagesArray[$resortName][] = $file;
                }
            }

            closedir($handle);
        }
        return $ImagesArray;
    }

}
