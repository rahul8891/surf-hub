<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;
use App\Services\AdminUserService;
use App\Services\MasterService;
use App\Services\PostService;
use App\Models\SurferRequest;
use App\Models\AdvertPost;
use App\Traits\PasswordTrait;
use App\Models\User;
use App\Models\Post;
use App\Models\Report;
use App\Models\Notification;
use App\Models\UserFollow;
use App\Models\UserProfile;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Closure;
use Redirect;
use Session;
use File;
use DB, URL;
use FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Config;
use PreSignedUrl;

class UserPostController extends Controller
{

    use PasswordTrait;

    /**
     * The user sevices implementation.
     *
     * @var AdminUserService
     */
    protected $posts;
    protected $masterService;
    public $language;
    public $accountType;
    public $notifications;

    /**
     * Create a new controller instance.
     *
     * @param  AdminUserService  $users
     * @return void
     */
    public function __construct(PostService $posts, AdminUserService $users, MasterService $masterService, UserService $userService)
    {
        $this->posts = $posts;
        $this->users = $users;
        $this->userService = $userService;
        $this->masterService = $masterService;
        $this->customArray = config('customarray');
        $this->language = config('customarray.language');
        $this->accountType = config('customarray.accountType');
        $this->post_type = config('customarray.post_type');
    }

    /**
     * Show the form for creating a new comment.
     *
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request)
    {
        try {
            $data = $request->all();
            $rules = array(
                'comment' => ['required', 'string'],
            );
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to current page.
                //return response()->json(['error'=>$validate->errors()]);
                return Redirect::to(redirect()->getUrlGenerator()->previous())->withErrors('The comment field is required.');
            } else {
                $result = $this->posts->saveComment($data, $message);
                if ($result) {
                    $this->posts->saveCommentNotification($data, $message);
                    return Redirect::to(redirect()->getUrlGenerator()->previous())->withSuccess($message);
                } else {
                    return Redirect::to(redirect()->getUrlGenerator()->previous())->withErrors($message);
                }
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new report.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        try {
            $data = $request->all();
            $rules = array(
                'comments' => ['required', 'string'],
            );
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to current page.
                return json_encode(array('status' => 'failure', 'message' => 'The comment field is required.'));
            } else {
                $result = $this->posts->saveReport($data, $message);
                if ($result) {
                    return json_encode(array('status' => 'success', 'message' => $message));
                } else {
                    return json_encode(array('status' => 'failure', 'message' => $message));
                }
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new follow.
     *
     * @return \Illuminate\Http\Response
     */
    public function follow(Request $request)
    {
        try {
            $data = $request->all();

            $result = $this->posts->saveFollow($data, $message);
            if ($result) {
                return Redirect::to(redirect()->getUrlGenerator()->previous())->withSuccess($message);
            } else {
                return Redirect::to(redirect()->getUrlGenerator()->previous())->withErrors($message);
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            if (!empty($data['other_surfer'])) {
                $data['surfer'] = $data['other_surfer'];
            } elseif (isset($data['surfer']) && ($data['surfer'] == 'Me')) {
                $data['surfer'] = Auth::user()->user_name;
            }

            $imageArray["images"] = (isset($data['imagesHid_input'][0]) && !empty($data['imagesHid_input'][0])) ? json_decode($data['imagesHid_input'][0]) : [];
            $videoArray["videos"] = (isset($data['videosHid_input'][0]) && !empty($data['videosHid_input'][0])) ? json_decode($data['videosHid_input'][0]) : [];
            $postArray = array_filter(array_merge($imageArray, $videoArray));

            $rules = array(
                'post_type' => ['required'],
                'user_id' => ['required'],
                'surf_date' => ['required'],
                'wave_size' => ['required'],
                'surfer' => ['required'],
                'country_id' => ['required'],
            );
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return response()->json(['error' => $validate->errors()]);
            } else {
                if (!empty($postArray["images"]) || !empty($postArray["videos"])) {
                    if (!empty($postArray["images"])) {
                        foreach ($postArray["images"] as $value) {
                            $result = $this->posts->savePost($data, "image", $value, $message);
                        }
                    }
                    if (!empty($postArray["videos"])) {
                        foreach ($postArray["videos"] as $value) {
                            $result = $this->posts->savePost($data, "video", $value, $message);
                        }
                    }
                } else {
                    $result = $this->posts->savePost($data, '', '', $message);
                }
                if ($result) {
                    return json_encode(array('message' => 'Post has been upload successfully'));
                } else {
                    return json_encode(array('message' => 'Error'));
                }
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    public function storeAdvert(Request $request)
    {
        try {
            $data = $request->all();
            $postArray = (isset($data['files']) && !empty($data['files'])) ? $data['files'] : [];

            $rules = array();
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return response()->json(['error' => $validate->errors()]);
            } else {
                if (!empty($postArray)) {
                    $fileData = [];
                    foreach ($postArray as $value) {

                        $fileType = explode('/', $value->getMimeType());

                        if ($fileType[0] == 'image') {
                            $fileFolder = 'images/' . Auth::user()->id;
                        } elseif ($fileType[0] == 'video') {
                            $fileFolder = 'videos/' . Auth::user()->id;
                        }

                        $path = Storage::disk('s3')->put($fileFolder, $value);
                        $filePath = Storage::disk('s3')->url($path);

                        $fileArray = explode("/", $filePath);
                        $filename = end($fileArray);
                        if (isset($data['post_id']) && $data['post_id']) {

                            $result = $this->posts->updateAdvertPost($data, $fileType[0], $filename, $message);
                        } else {
                            $result = $this->posts->saveAdvertPost($data, $fileType[0], $filename, $message);
                        }
                    }
                } else {
                    if (isset($data['post_id']) && $data['post_id']) {

                        $result = $this->posts->updateAdvertPost($data, '', '', $message);
                    } else {
                        $result = $this->posts->saveAdvertPost($data, '', '', $message);
                    }
                }

                if ($result) {
                    if ($data['preview'] == 1) {
                        return Redirect()->route('uploadPreview', Crypt::encrypt($result['post_id']))->withSuccess($message);
                    } else {
                        return Redirect()->route('payment', Crypt::encrypt($result['post_id']))->withSuccess($message);
                    }
                } else {
                    return Redirect()->route('myhub')->withErrors($message);
                }
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    public function publishAdvert(Request $request)
    {
        try {
            $data = $request->all();

            if (isset($data['post_id']) && $data['post_id']) {
                $advertPost = AdvertPost::where('post_id', $data['post_id'])->first();
                $advertPost->preview_ad = 0;
                $advertPost->save();
            }
            return Redirect()->route('payment', Crypt::encrypt($data['post_id']))->withSuccess('Advertisment has been published successfully!');
        } catch (\Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * rating the specified post from database.
     *
     * @param $id, $value
     * @return \Illuminate\Http\Response
     */
    public function rating(Request $request)
    {
        $data = $request->all();
        if (isset($data['id']) && !empty($data['id'])) {
            try {
                $result = $this->posts->ratePost($data, $message);

                if ($result) {
                    return json_encode(array(
                        'status' => $result['status'], 'message' => $result['message'],
                        'averageRating' => $result['averageRating'], 'usersRated' => $result['usersRated']
                    ));
                } else {
                    return json_encode(array(
                        'status' => $result['status'], 'message' => $result['message'],
                        'averageRating' => $result['averageRating'], 'usersRated' => $result['usersRated']
                    ));
                }
            } catch (\Exception $e) {
                return redirect()->route('dashboard', ['id' => $data['id']])->withErrors($e->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = $this->posts->deletePost($id, $message);
            if ($result) {
                return json_encode(array('status' => 'success', 'message' => $message));
            } else {
                return json_encode(array('status' => 'error', 'message' => $message));
            }
        } catch (\Exception $e) {
            return json_encode(array('status' => 'error', 'message' => $e->getMessage()));
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAdvert($id)
    {
        try {
            $result = $this->posts->deletePost(Crypt::decrypt($id), $message);
            if ($result) {
                return redirect()->route('myAds')->withSuccess($message);
            } else {
                return redirect()->route('myAds')->withErrors($message);
            }
        } catch (\Exception $e) {
            return redirect()->route('myAds', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage());
        }
    }

    /**
     * Move post to the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveToMyHub($id)
    {
        $message = '';
        try {
            $result = $this->posts->saveToMyHub($id, $message);
            if ($result) {
                return json_encode(array('status' => 'success', 'message' => $message));
            } else {
                return json_encode(array('status' => 'error', 'message' => $message));
            }
        } catch (\Exception $e) {
            return json_encode(array('status' => 'error', 'message' => $e->getMessage()));
        }
    }

    /**
     * Move post to the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function surferRequest($id)
    {
        try {
            $result = $this->posts->surferRequestSave(Crypt::decrypt($id), $message);
            
            $message = $result;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return $message;
    }

    /**
     * Move post to the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function acceptRejectRequest($id, $type)
    {
        try {
            $request_id = Crypt::decrypt($id);

            $notification = Notification::where("id", $request_id)->first();

            // Below code is used in next phase
            $post_id = $notification->post_id;
            $sender_id = $notification->receiver_id;
            $receiver_id = $notification->sender_id;

            $this->posts->updateNotificationStatus($request_id);

            $surferRequest = SurferRequest::where("post_id", $notification->post_id)
                ->where("user_id", $notification->sender_id)->first();

            $userName = User::select("user_name")->where("id", "=", $surferRequest->user_id)->first();

            if ($type == 'accept') {
                SurferRequest::where(['id' => $surferRequest->id])
                    ->update(['status' => 1]);

                $this->posts->createNewPostAfterAccept($notification->sender_id, $post_id, $userName->user_name);

                $result = Post::where(['id' => $surferRequest->post_id])
                    ->update(['surfer' => $userName->user_name]);
                // sender_id, reciver_id, status, post_id // Below code is used in next phase
                // $this->posts->updateNotificationStatusAcceptReject($post_id, $sender_id, $receiver_id, 'Surfer Request Accept');

                $message = 'Surfer request accepted';
            }
            if ($type == 'reject') {
                $result = SurferRequest::where(['id' => $request_id])
                    ->update(['status' => 2]);
                // sender_id, reciver_id, status, post_id // Below code is used in next phase
                // $this->posts->updateNotificationStatusAcceptReject($post_id, $sender_id, $receiver_id, 'Surfer Request Reject');
                $message = 'Surfer request rejected';
            }

            if ($result) {
                return redirect()->route('surferRequestList')->withSuccess($message);
            } else {
                return redirect()->route('surferRequestList')->withErrors($message);
            }
        } catch (\Exception $e) {
            return redirect()->route('surferRequestList')->withErrors($e->getMessage());
        }
    }

    /**
     * Accept and reject follow request
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function acceptRejectFollowRequest($id, $type)
    {
        try {
            $request_id = Crypt::decrypt($id);
            $data = UserFollow::where("id", $request_id)->first();

            if ($data) {
                if ($type == 'accept') {
                    $result = UserFollow::where(['id' => $request_id])
                        ->update(['follower_request_status' => '0', 'status' => 'FOLLOW']);

                    $message = 'Surfer follow request accepted.';
                } elseif ($type == 'reject') {
                    $result = UserFollow::where(['id' => $request_id])
                        ->update(['follower_request_status' => '2', 'status' => 'BLOCK']);

                    $message = 'Surfer follow request rejected.';
                }

                if ($message) {
                    $notify = new Notification();

                    $notify->sender_id = Auth::user()->id;
                    $notify->receiver_id = $data->follower_user_id;
                    $notify->notification_type = ucfirst($type);

                    if ($notify->save()) {
                        return redirect()->route('notifications')->withSuccess($message);
                    }
                }
            }

            if ($result) {
                return redirect()->route('notifications')->withSuccess($message);
            } else {
                return redirect()->route('notifications')->withErrors($message);
            }
        } catch (\Exception $e) {
            return redirect()->route('notifications')->withErrors($e->getMessage());
        }
    }

    public function surferFollowRequest($id)
    {
        $request_id = Crypt::decrypt($id);
        $userProfile = '';
        $reviewPost = $postsList = [];
        // dd($request_id);
        $customArray = $this->customArray;
        $reviewPost = Post::join('notifications', 'notifications.post_id', '=', 'posts.id')
        // ->join('user_profiles', 'user_profiles.user_id', '=', 'notifications.sender_id')
        ->join('users', 'users.id', '=', 'notifications.receiver_id')
        ->join('user_profiles', 'user_profiles.user_id', '=', 'posts.user_id')
        ->where('notifications.status', '0')
        ->where('notifications.id', $request_id)
        ->orderBy('posts.created_at', 'DESC')
        ->get(['posts.*', 'notifications.id as request_id', 'notifications.sender_id as sender_id', 'users.profile_photo_path']);

        $postList = Post::join('notifications', 'notifications.post_id', '=', 'posts.id')
            // ->join('user_profiles', 'user_profiles.user_id', '=', 'notifications.sender_id')
            ->join('users', 'users.id', '=', 'notifications.sender_id')
            ->join('user_profiles', 'user_profiles.user_id', '=', 'posts.user_id')
            ->where('notifications.status', '0')
            ->where('notifications.id', $request_id)
            ->orderBy('posts.created_at', 'DESC')
            ->get(['posts.*', 'notifications.id as request_id', 'notifications.sender_id as sender_id', 'users.profile_photo_path']);
        // dd($request_id);
        foreach ($postList as $post) {
            $userProfile = $this->userService->getUserDetail($post->sender_id);

            $postsList = Post::with('followPost')->where('is_deleted', '0')
                ->where('parent_id', '0')
                ->where('user_id', $post->sender_id)
                ->where('is_highlight', '1')
                ->where(function ($query) {
                    $query->where('post_type', 'PUBLIC')
                        ->orWhere('is_feed', '1');
                })
                ->orderBy('posts.created_at', 'DESC')
                ->get();
        }
        
        return view('user.surfer-follow-request', compact('customArray', 'postsList', 'request_id', 'userProfile', 'postsList', 'reviewPost'));
    }

    /**
     * show the specified post.
     *
     * @param  int  $post_id $notification_id
     * @return \Illuminate\Http\Response
     */
    public function posts($post_id, $notification_id, $notification_type)
    {
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $detail = $this->posts->getPostDetails($post_id, $notification_id);
        $this->posts->updateNotificationStatus($notification_id);
        return view('user.posts', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'detail'));
    }

    /**
     * show the specified post.
     *
     * @param  int  $post_id $notification_id
     * @return \Illuminate\Http\Response
     */
    public function getPostData($post_id)
    {
        $countries = $this->masterService->getCountries();
        $customArray = $this->customArray;
        $postData = Post::where('id', $post_id)->first();
        $currentUserCountryId = UserProfile::where('user_id', $postData->user_id)->pluck('country_id')->first();

        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        return view('user.postData', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postData'));
    }

    public function updateNotificationCountStatus(Request $request)
    {
        $data = $request->all();
        $result = $this->posts->updateNotificationCountStatus($data);
        if ($result) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'fails'));
        }
    }

    public function updateAllNotification()
    {
        $result = $this->posts->updateAllNotification();
        if ($result) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'fails'));
        }
    }

    /*
     *Function use to update the notication count once read
     *
     */
    public function updateNotificationCount(Request $request)
    {
        $data = $request->all();
        $result = $this->posts->updateNotificationCount($data['id']);
        if ($result) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'fails'));
        }
    }

    public function uploadFiles(Request $request, PostService $postService)
    {
        $fileArray = [];

        $data = $request->all();
        $timeDate = strtotime(Carbon::now()->toDateTimeString());

        if (isset($data['photos'])) {
            $file = $request->file('photos');
            $filename = $timeDate . '.' . $file[0]->extension();

            $file[0]->move(public_path('storage/images/'), $filename);
        } elseif (isset($data['videos'])) {
            $destinationPath = storage_path() . '/app/public/fullVideos/';
            $file = $request->file('videos');
            $fileExt = $file[0]->getClientOriginalExtension();

            $filename = $timeDate . '.' . $fileExt;

            $file[0]->move($destinationPath, $filename);
        }

        return response()->json(['success' => $filename]);
    }

    public function surferRequestList()
    {
        $surferRequest = Notification::join('posts', 'notifications.post_id', '=', 'posts.id')
            ->join('user_profiles', 'notifications.sender_id', '=', 'user_profiles.user_id')
            ->join('users', 'notifications.sender_id', '=', 'users.id')
            ->where("notifications.receiver_id", '=', Auth::user()->id)
            ->where("notifications.status", "=", "0")
            ->orderBy('notifications.id', 'DESC')
            ->get(['notifications.*', 'user_profiles.first_name', 'user_profiles.last_name', 'users.profile_photo_path']);
            
        return view('user.surfersRequestList', compact('surferRequest'));
    }

    public function notifications()
    {
        return view('user.notifications');
    }

    public function upload(Request $request)
    {
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $beaches = $this->masterService->getBeaches();
        $customArray = $this->customArray;
        $postsList = Post::with('followPost')->where('is_deleted', '0')
            ->where('parent_id', '0')
            ->where(function ($query) {
                $query->where('post_type', 'PUBLIC')
                    ->orWhere('is_feed', '1');
            })
            ->orderBy('posts.created_at', 'DESC')
            ->paginate(10);
        $requestSurfer = array();
        foreach ($postsList as $val) {
            $surferRequest = SurferRequest::join('user_profiles', 'surfer_requests.user_id', '=', 'user_profiles.user_id')
                ->where("surfer_requests.post_id", "=", $val['id'])
                ->where("surfer_requests.status", "=", 0)
                ->get(['surfer_requests.id', 'user_profiles.first_name', 'user_profiles.last_name']);

            foreach ($surferRequest as $res) {
                $requestSurfer[$val['id']]['id'] = $res['id'];
                $requestSurfer[$val['id']]['name'] = $res['first_name'] . ' ' . $res['last_name'];
            }
        }
        $url = url()->current();
        $usersList = $this->masterService->getAllUsers();

        return view('user.upload', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer', 'beaches'));
    }
    public function getPresignedUrl(Request $request)
    {

        $data = $request->all();

        $key = $data['filepath'];
        $type = $data['fileType'];

        $presignedUrl = PreSignedUrl::getPreSignedUrl($key, $type);

        return response()->json($presignedUrl);
    }

    /**
     * Delete Post via Ajax.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPost(Request $request)
    {
        $param = $request->all();
        try {
            $result = $this->posts->deletePost($param['id']);
            if ($result) {
                echo json_encode(array('status' => 'success', 'message' => $result));
            } else {
                echo json_encode(array('status' => 'error', 'message' => $result));
            }
        } catch (\Exception $e) {
            echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
        }
        die;
    }

    /**
     * Surfer Request via Ajax.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function surferRequestAjax(Request $request)
    {
        $param = $request->all();
        try {
            $result = $this->posts->surferRequestSave($param['id']);
            if ($result) {
                echo json_encode(array('status' => 'success', 'message' => $result));
            } else {
                echo json_encode(array('status' => 'error', 'message' => $result));
            }
        } catch (\Exception $e) {
            echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
        }
        die;
    }

    /**
     * show the specified post.
     *
     * @param  int  $post_id
     * @return \Illuminate\Http\Response
     */
    public function getPostDataReport($post_id)
    {
        $countries = $this->masterService->getCountries();
        $customArray = $this->customArray;
        $postData = Post::where('id', $post_id)->first();
        DB::table('reports')
            ->where('post_id', '=', $post_id)
            ->update([
                'is_read' => '1',
                'updated_at' => Carbon::now()
            ]);
        $currentUserCountryId = UserProfile::where('user_id', $postData->user_id)->pluck('country_id')->first();

        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        return view('user.postData', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postData'));
    }
}
