<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Traits\PasswordTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\RequestGuard;
use Illuminate\Support\Facades\DB;
use App\Services\UserService;
use App\Services\PostService;
use Redirect;
use App\Services\MasterService;
use App\Models\Post;
use App\Models\SurferRequest;
use App\Models\BoardTypeAdditionalInfo;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller {

    use PasswordTrait;

    /**
     * Create a new controller instance.
     *
     * @param  UserService  $users
     * @return void
     */
    public function __construct(UserService $users, PostService $post, MasterService $masterService) {
        $this->users = $users;
        $this->post = $post;
        $this->common = config('customarray.common');
        $this->customArray = config('customarray');
        $this->language = config('customarray.language');
        $this->accountType = config('customarray.accountType');
        $this->post_type = config('customarray.post_type');
        $this->masterService = $masterService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function showChangePassword() {
        return view('user.change-password');
    }

    /**
     * Show User Profile Page
     */
    public function showProfile() {
        $customArray = $this->customArray;
        $beaches = $states = $postsList = [];
        $countries = DB::table('countries')->select('id', 'name', 'phone_code')->orderBy('name', 'asc')->get();
        $beachBreaks = DB::table('beach_breaks')->orderBy('beach_name', 'asc')->get();
        $language = config('customarray.language');
        $accountType = config('customarray.accountType');
        $user = $this->users->getUserDetailByID(Auth::user()->id);
        return view('user.profile', compact('user', 'countries', 'beachBreaks', 'language', 'accountType', 'postsList', 'states', 'beaches', 'customArray'));
    }

    /**
     * Show User Profile Page
     */
    public function editProfile() {
        $customArray = $this->customArray;
        $beaches = $states = $postsList = [];
        $gender_type = config('customarray.gender_type');
        $countries = DB::table('countries')->select('id', 'name', 'phone_code')->orderBy('name', 'asc')->get();
        $beachBreaks = DB::table('beach_breaks')->orderBy('beach_name', 'asc')->get();
        $language = config('customarray.language');
        $board_type = config('customarray.board_type');
        $accountType = config('customarray.accountType');
        $user = $this->users->getUserDetailByID(Auth::user()->id);
//        echo '<pre>';print_r($user->user_type);die;
//        foreach ($user as $v) {
//        }
        if($user->user_type == 'USER') {
        return view('user.edit_surfer_profile', compact('user', 'countries', 'beachBreaks', 'language', 'accountType', 'postsList', 'states', 'beaches', 'customArray', 'gender_type','board_type'));
            
        } elseif ($user->user_type == 'PHOTOGRAPHER') {
        return view('user.edit_photographer_profile', compact('user', 'countries', 'beachBreaks', 'language', 'accountType', 'postsList', 'states', 'beaches', 'customArray', 'gender_type'));
        
        } elseif ($user->user_type == 'SURFER CAMP') {
        return view('user.edit_resort_profile', compact('user', 'countries', 'beachBreaks', 'language', 'accountType', 'postsList', 'states', 'beaches', 'customArray', 'gender_type'));
        } elseif ($user->user_type == 'ADVERTISEMENT') {
        return view('user.edit_advertiser_profile', compact('user', 'countries', 'beachBreaks', 'language', 'accountType', 'postsList', 'states', 'beaches', 'customArray', 'gender_type'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request    
     * @return \Illuminate\Http\Response
     */
    public function storeProfile(Request $request) {
        $data = $request->all();
        Validator::make($data, [
            'first_name' => ['required', 'min:3', 'string'],
            'last_name' => ['required', 'min:3', 'string'],
            'user_name' => ['required', 'string', 'min:5', 'alpha_dash'],
//            'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
            'phone' => ['required'],
            'language' => ['required', 'string'],
            'country_id' => ['required', 'numeric'],
            'account_type' => ['required', 'string'],
            'paypal' => ['required', 'string'],
//            'local_beach_break' => ['required', 'string'],         
        ])->validate();

        $result = $this->users->updateUserProfile($data, $message);
        if ($result) {
            return Redirect::to('dashboard')->withSuccess($message);
        } else {
            return Redirect::to('user/profile')->withErrors($message);
        }
    }

    public function updateProfileImage(Request $request) {
        $data = $request->all();
        $rules = array(
            'image' => ['required']
        );
        // dd($data);
        $inputArry = ['image' => $data['image']];
        $validate = Validator::make($inputArry, $rules);
        if ($validate->fails()) {
            echo json_encode(array('status' => 'failure', 'message' => 'Invalid Image.'));
            die;
        } else {
            $result = $this->users->updateUserProfileImage($data, $message);
            if ($result) {
                echo json_encode(array('status' => 'success', 'message' => $message));
            } else {
                echo json_encode(array('status' => 'failure', 'message' => $message));
            }
            die;
        }
    }

    // https://www.codechief.org/article/autocomplete-search-with-laravel-jquery-and-ajax
    public function getBeachBreach(Request $request) {
        $data = $request->all();
        $searchTerm = $data['searchTerm'];
        if (!empty($searchTerm)) {
            $searchTerm = explode(",", $searchTerm);
            $string = $searchTerm['0'];
            $field = ['beach_name'];
            $resultData = DB::Table('beach_breaks')->Where(function ($query) use ($string, $field) {
                        for ($i = 0; $i < count($field); $i++) {
                            $query->orWhere($field[$i], 'LIKE', '%' . $string . '%');
                        }
                    })->get();

            $returnObject = '';
            if (!$resultData->isEmpty()) {

                $returnObject = '<ul class="list-group" style="display: block; position: absolute; z-index: 1"  >';
                $dupArr = [];
                foreach ($resultData as $key => $value) {
                    if (!in_array($value->beach_name, $dupArr)) {
                        $dupArr[] = $value->beach_name;
                        $val = ($value->beach_name) ? $value->beach_name : '';
                        $returnObject .= '<li class="list-group-item" data-id="' . $value->id . '">' . $val . '</li>';
                    }
                }
                $returnObject .= '</ul>';
                return response()->json($returnObject);
            } else {
                return response()->json($returnObject);
            }
        }
    }
    
    public function getAdditionalBoardTypeInfo(Request $request) {
        $data = $request->all();
        $board_type = $data['board_type'];
        if (!empty($board_type)) {
            
            $resultData = BoardTypeAdditionalInfo::where('board_type', $board_type)->get();
            $returnObject = '';
            if (!$resultData->isEmpty()) {

                $returnObject = '<div class="col-md-12"><div class="row mb-3 align-items-center"></label><div class="col-md-12"><div class="row">';
                foreach ($resultData as $key => $value) {
                        $val = ($value->beach_name) ? $value->beach_name : '';
                        $returnObject .= '<div class="col-lg-4 col-md-6 col-sm-12 mb-3"><div class="form-check d-flex">
                                        <input type="checkbox" class="form-check-input" name="additional_info[]" value="'.$value->id.'"
                                               id="'.$value->id.'" />
                                        <label for="'.$value->id.'" class="">'.$value->info_name.'</label>
                                    </div></div>';
                }
                $returnObject .= '</div></div></div></div>';
                return response()->json($returnObject);
            } else {
                return response()->json($returnObject);
            }
        }
    }

    public function getUsers(Request $request) {
        $data = $request->all();
        $searchTerm = $data['searchTerm'];
        if (!empty($searchTerm)) {
            $searchTerm = explode(",", $searchTerm);
            $string = $searchTerm['0'];

            /* $resultData = DB::Table('users')->Where(function ($query) use($string, $field) {
              for ($i = 0; $i < count($field); $i++){
              $query->orWhere($field[$i], 'LIKE',  '%' . $string .'%');
              }
              })->get(); */
            $resultData = $this->users->getUsersForTagging($string);

            $returnObject = '';
            if (!$resultData->isEmpty()) {
                $returnObject = '<ul class="list-group" style="display: block; position: absolute; z-index: 1; width:50%; height:25%;overflow: scroll;overflow-x: hidden;">';
                foreach ($resultData as $key => $value) {
                    $val = $value->user_name;
                    $img = (!empty($value->profile_photo_path)) ? "/storage/$value->profile_photo_path" : '/img/img_4.jpg';
                    $returnObject .= '<li class="list-group-item" data-id="' . $value->id . '">
                    <img src="' . $img . '" width="30px" style="float:right; border-radius: 50%; border: 1px solid #4c8df5;" class="img-fluid">' . $val . '
                    </li>';
                }
                $returnObject .= '</ul>';
                return response()->json($returnObject);
            } else {
                return response()->json($returnObject);
            }
        }
    }

    public function getTagUsers(Request $request) {
        $data = $request->all();
        $searchTerm = $data['searchTerm'];
        if (!empty($searchTerm)) {
            $searchTerm = explode(",", $searchTerm);
            $string = $searchTerm['0'];

            //get users list for tagging
            $resultData = $this->users->getUsersForTagging($string);
            // dd($resultData);
            $returnObject = '';
            if (!$resultData->isEmpty()) {
                $returnObject = '<ul class="list-group" style="display: block; position: absolute; z-index: 1; width:100%">';
                foreach ($resultData as $key => $value) {
                    $val = ucfirst($value->first_name) . ' ' . ucfirst($value->last_name);

                    $requestData = ['post_id' => $data['post_id'], 'user_id' => $value->user_id];
                    //Check if already tagged not come in user list
                    $responceResult = $this->users->checkAlreadyTagged($requestData);
                    if (!$responceResult) {
                        $img = (!empty($value->user->profile_photo_path)) ? "/storage/" . $value->user->profile_photo_path : '/img/img_4.jpg';
                        $returnObject .= '<li class="list-group-item tagUserInPost" style="color: #4c8df5;" data-id="' . $value->user_id . '" data-post_id="' . $data['post_id'] . '" id="rowId' . $value->user_id . '">
                        <img src="' . $img . '" width="30px" style="float:right; border-radius: 50%; border: 1px solid #4c8df5; bottom: 5px;" class="img-fluid">' . $val . '
                        </li>';
                    }
                }
                $returnObject .= '</ul>';
                return response()->json($returnObject);
            } else {
                return response()->json($returnObject);
            }
        }
    }

    public function setTagUsers(Request $request) {
        $data = $request->all();
        //dd($data);
        //check if user already tagged
        $result = $this->users->checkAlreadyTagged($data);
        //dd($result->user);
        if ($result) {
            //user already tagged
            return json_encode(array('status' => 'failure', 'message' => $result->user->user_name . ' ' . 'already tagged for this post.'));
        } else {
            $result = $this->users->tagUserOnPost($data);
            $responceResult = $this->users->getAllTaggedUsers($data);
            // dd($responceResult[0]->user);
            // dd($responceResult[0]->user->user_profiles);
            $returnObject = '';
            foreach ($responceResult as $key => $value) {
                $val = ucfirst($value->user->user_profiles->first_name) . ' ' . ucfirst($value->user->user_profiles->last_name);
                $img = (!empty($value->user->profile_photo_path)) ? "/storage/" . $value->user->profile_photo_path : '';
                $returnObject .= '<div class="post-head"><div class="userDetail"><div class="imgWrap">';
                if ($value->user->profile_photo_path) {
                    $returnObject .= '<img src="' . $img . '" class="taggedUserImg" alt="">';
                } else {
                    $returnObject .= '<div class="taggedUserImg no-image">' . ucwords(substr($value->user->user_profiles->first_name, 0, 1)) . '' . ucwords(substr($value->user->user_profiles->last_name, 0, 1)) . '</div>';
                }
                $returnObject .= '</div><span class="userName">' . $val . '</span></div></div>';
            }
            return json_encode(array('status' => 'success', 'responsData' => $returnObject));
        }
    }

    public function followRequests() {
        $followRequests = $this->users->followRequests();
        $common = $this->common;

        return view('user.followRequests', compact('followRequests', 'common'));
    }

    public function followers() {
        $followers = $this->users->followers(Auth::user()->id);
        $common = $this->common;
        return view('user.followers', compact('followers', 'common'));
    }
   
    public function following() {
        $following = $this->users->following(Auth::user()->id);
        $common = $this->common;
        return view('user.following', compact('following', 'common'));
    }

    public function unfollow(Request $request) {
        $data = $request->all();
        $result = $this->users->updateFollowStatus($data, $message, 'follower_user_id');
        if ($result) {
            echo json_encode(array('status' => $result['status'], 'message' => $result['message'], 'count' => $result['count']));
        } else {
            echo json_encode(array('status' => $result['status'], 'message' => $result['message'], 'count' => $result['count']));
        }
    }

    public function accept(Request $request) {
        $data = $request->all();
        $result = $this->users->updateAcceptStatus($data, $message, 'followed_user_id');
        if ($result) {
            echo json_encode(array('status' => $result['status'], 'message' => $result['message'], 'count' => $result['count']));
        } else {
            echo json_encode(array('status' => $result['status'], 'message' => $result['message'], 'count' => $result['count']));
        }
    }

    public function reject(Request $request) {
        $data = $request->all();
        $result = $this->users->updateRejectStatus($data, $message, 'followed_user_id');
        if ($result) {
            echo json_encode(array('status' => $result['status'], 'message' => $result['message'], 'count' => $result['count']));
        } else {
            echo json_encode(array('status' => $result['status'], 'message' => $result['message'], 'count' => $result['count']));
        }
    }

    public function remove(Request $request) {
        $data = $request->all();
        $result = $this->users->updateRemoveStatus($data, $message, 'followed_user_id');
        if ($result) {
            echo json_encode(array('status' => $result['status'], 'message' => $result['message'], 'count' => $result['count']));
        } else {
            echo json_encode(array('status' => $result['status'], 'message' => $result['message'], 'count' => $result['count']));
        }
    }

    public function follow(Request $request) {
        $data = $request->all();
        $result = $this->users->followToFollower($data, $message);
        if ($result) {
            echo json_encode(array('status' => $result['status'], 'message' => $result['message']));
        } else {
            echo json_encode(array('status' => $result['status'], 'message' => $result['message']));
        }
    }

    public function followCounts(Request $request) {
//        $data = $request->all();
        $followersCount = $this->users->getFollowDataCount('followed_user_id', array('0', '1'), Auth::user()->id);
        $followingCount = $this->users->getFollowDataCount('follower_user_id', array('0', '1'), Auth::user()->id);
        $followRequestCount = $this->users->getFollowDataCount('followed_user_id', array('1'), Auth::user()->id);
        $notification = $this->users->getNotificationCount();
        $userPosts = $this->post->getPostByUserId(Auth::user()->id);

        $postIds = array_filter(array_column($userPosts, 'id'));
        $userPostsUnknown = $this->post->getPostUnknownByUserId();
        $postUnIds = array_filter(array_column($userPostsUnknown, 'id'));
        $surferRequests = $this->post->getSurferRequest($postUnIds, 0);
//          echo '<pre>';        print_r($notification);die;
        $uploads = $this->post->getUploads($postIds);
        $fCounts = array(
            'follwers' => $followersCount,
            'follwing' => $followingCount,
            'follwerRequest' => $followRequestCount,
            'posts' => count($userPosts),
            'surferRequest' => count($surferRequests),
            'uploads' => count($uploads),
            'notification' => $notification
        );

        echo json_encode($fCounts);
    }

    public function checkUsername(Request $request) {

        $data = $request->all(); // This will get all the request data.
        $userCount = $this->users->checkUsername($data);
        if ($userCount > 0) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function searchFollwers(Request $request,$id) {

        $serachTerm = $request->searchTerm;

        $followers = $this->users->searchFollowers($serachTerm,$id);
//        dd($followers);
        $common = $this->common;
        $view = view('elements/searchFollower', compact('followers', 'common'))->render();
        return response()->json(['html' => $view]);
    }

    public function searchFollowing(Request $request,$id) {

        $serachTerm = $request->searchTerm;

        $following = $this->users->searchFollowing($serachTerm,$id);
//        dd($followers);
        $common = $this->common;
        $view = view('elements/searchFollowing', compact('following', 'common'))->render();
        return response()->json(['html' => $view]);
    }

    public function searchFollowRequest(Request $request) {

        $serachTerm = $request->searchTerm;

        $followRequests = $this->users->searchFollowRequest($serachTerm);
//        dd($followers);
        $common = $this->common;
        $view = view('elements/searchFollowRequest', compact('followRequests', 'common'))->render();
        return response()->json(['html' => $view]);
    }

    public function surferProfile(Request $request, $id) {
        $surfer_id = Crypt::decrypt($id);
        $url = url()->current();
//        print_r($surfer_id);die;
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $beaches = $this->masterService->getBeaches();
        $customArray = $this->customArray;
        $postsList = Post::with('followPost')->where('is_deleted', '0')
                ->where('parent_id', '0')
                ->where('user_id', $surfer_id)
                ->where(function ($query) {
                    $query->where('post_type', 'PUBLIC')
                    ->orWhere('is_feed', '1');
                })
                ->orderBy('posts.created_at', 'DESC')
                ->paginate(10);
        $requestSurfer = array();
        $userType = '';
        foreach ($postsList as $val) {
//            $surferRequest = SurferRequest::select("*")
//                    ->where("post_id", "=", $val['id'])
//                    ->where("status", "=", 0)
//                    ->get();
            $userType = $val->user->user_type;
            $surferRequest = SurferRequest::join('user_profiles', 'surfer_requests.user_id', '=', 'user_profiles.user_id')
                    ->where("surfer_requests.post_id", "=", $val['id'])
                    ->where("surfer_requests.status", "=", 0)
                    ->get(['surfer_requests.id', 'user_profiles.first_name', 'user_profiles.last_name']);

            foreach ($surferRequest as $res) {
//                echo '<pre>'; print_r($res['id']);die;
                $requestSurfer[$val['id']]['id'] = $res['id'];
                $requestSurfer[$val['id']]['name'] = $res['first_name'] . ' ' . $res['last_name'];
            }
        }
        $userProfile = $this->users->getUserDetail($surfer_id);

        $followersCount = $this->users->getFollowDataCount('followed_user_id', array('0', '1'), $surfer_id);
        $followingCount = $this->users->getFollowDataCount('follower_user_id', array('0', '1'), $surfer_id);
        $userPosts = $this->post->getPostByUserId($surfer_id);
        $postIds = array_filter(array_column($userPosts, 'id'));
        $uploads = $this->post->getUploads($postIds);
        $fCounts = array(
            'follwers' => $followersCount,
            'follwing' => $followingCount,
            'posts' => count($userPosts),
            'uploads' => count($uploads),
        );
//        echo '<pre>'; print_r($userProfile);die;
        if ($request->ajax()) {
            $view = view('elements/surferProfileData', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer', 'beaches'))->render();
            return response()->json(['html' => $view]);
        }
        return view('user.surfer-profile', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer', 'beaches', 'userProfile', 'fCounts','userType'));
    }
    
    public function resortProfile(Request $request, $id) {
        $resort_id = Crypt::decrypt($id);
        $url = url()->current();
//        print_r($resort_id);die;
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $beaches = $this->masterService->getBeaches();
        $customArray = $this->customArray;
        $postsList = Post::with('followPost')->where('is_deleted', '0')
                ->where('parent_id', '0')
                ->where('user_id', $resort_id)
                ->where(function ($query) {
                    $query->where('post_type', 'PUBLIC')
                    ->orWhere('is_feed', '1');
                })
                ->orderBy('posts.created_at', 'DESC')
                ->paginate(10);
        $requestSurfer = array();
        $userType = '';
        foreach ($postsList as $val) {
//            $surferRequest = SurferRequest::select("*")
//                    ->where("post_id", "=", $val['id'])
//                    ->where("status", "=", 0)
//                    ->get();
            $userType = $val->user->user_type;
            $surferRequest = SurferRequest::join('user_profiles', 'surfer_requests.user_id', '=', 'user_profiles.user_id')
                    ->where("surfer_requests.post_id", "=", $val['id'])
                    ->where("surfer_requests.status", "=", 0)
                    ->get(['surfer_requests.id', 'user_profiles.first_name', 'user_profiles.last_name']);

            foreach ($surferRequest as $res) {
//                echo '<pre>'; print_r($res['id']);die;
                $requestSurfer[$val['id']]['id'] = $res['id'];
                $requestSurfer[$val['id']]['name'] = $res['first_name'] . ' ' . $res['last_name'];
            }
        }
        $userProfile = $this->users->getUserDetail($resort_id);
        $resortImages = $this->users->getResortImages($resort_id);

        $followersCount = $this->users->getFollowDataCount('followed_user_id', array('0', '1'), $resort_id);
        $followingCount = $this->users->getFollowDataCount('follower_user_id', array('0', '1'), $resort_id);
        $userPosts = $this->post->getPostByUserId($resort_id);
        $postIds = array_filter(array_column($userPosts, 'id'));
        $uploads = $this->post->getUploads($postIds);
        $fCounts = array(
            'follwers' => $followersCount,
            'follwing' => $followingCount,
            'posts' => count($userPosts),
            'uploads' => count($uploads),
        );
//        echo '<pre>'; print_r($resortImages);die;
        if ($request->ajax()) {
            $view = view('elements/surferProfileData', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer', 'beaches'))->render();
            return response()->json(['html' => $view]);
        }
        return view('user.resort-profile', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer', 'beaches', 'userProfile', 'fCounts','userType','resortImages'));
    }
    
    public function surferFollowers($id) {
        $surfer_id = Crypt::decrypt($id);
        $followers = $this->users->followers($surfer_id);
        $common = $this->common;
        $postsList = Post::with('followPost')->where('is_deleted', '0')
                ->where('parent_id', '0')
                ->where('user_id', $surfer_id)
                ->where(function ($query) {
                    $query->where('post_type', 'PUBLIC')
                    ->orWhere('is_feed', '1');
                })
                ->orderBy('posts.created_at', 'DESC')
                ->paginate(10);
        $userProfile = $this->users->getUserDetail($surfer_id);
        $followersCount = $this->users->getFollowDataCount('followed_user_id', array('0', '1'), $surfer_id);
//        echo '<pre>'; print_r($followersCount);die;
        $followingCount = $this->users->getFollowDataCount('follower_user_id', array('0', '1'), $surfer_id);
        $userPosts = $this->post->getPostByUserId($surfer_id);
        $postIds = array_filter(array_column($userPosts, 'id'));
        $uploads = $this->post->getUploads($postIds);
        $fCounts = array(
            'follwers' => $followersCount,
            'follwing' => $followingCount,
            'posts' => count($userPosts),
            'uploads' => count($uploads),
        );
        
        return view('user.surfer-followers', compact('followers', 'common', 'userProfile', 'fCounts','postsList'));
    }
    
    public function surferFollowing($id) {
        $surfer_id = Crypt::decrypt($id);
        $following = $this->users->following($surfer_id);
        $common = $this->common;
        $postsList = Post::with('followPost')->where('is_deleted', '0')
                ->where('parent_id', '0')
                ->where('user_id', $surfer_id)
                ->where(function ($query) {
                    $query->where('post_type', 'PUBLIC')
                    ->orWhere('is_feed', '1');
                })
                ->orderBy('posts.created_at', 'DESC')
                ->paginate(10);
        $userProfile = $this->users->getUserDetail($surfer_id);
        $followersCount = $this->users->getFollowDataCount('followed_user_id', array('0', '1'), $surfer_id);
//        echo '<pre>'; print_r($followersCount);die;
        $followingCount = $this->users->getFollowDataCount('follower_user_id', array('0', '1'), $surfer_id);
        $userPosts = $this->post->getPostByUserId($surfer_id);
        $postIds = array_filter(array_column($userPosts, 'id'));
        $uploads = $this->post->getUploads($postIds);
        $fCounts = array(
            'follwers' => $followersCount,
            'follwing' => $followingCount,
            'posts' => count($userPosts),
            'uploads' => count($uploads),
        );
        
        return view('user.surfer-following', compact('following', 'common', 'userProfile', 'fCounts','postsList'));
    }

}
