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
use App\Traits\PasswordTrait;
use App\Models\User;
use App\Models\Post;
use App\Models\Report;
use App\Models\Notification;
use App\Models\UserProfile;
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

class UserPostController extends Controller
{
    use PasswordTrait;
    /**
     * The user sevices implementation.
     *
     * @var AdminUserService
     */
    protected $posts;

    Protected $masterService;

    public $language;

    public $accountType;

    public $notifications;

    /**
     * Create a new controller instance.
     *
     * @param  AdminUserService  $users
     * @return void
     */
    public function __construct(PostService $posts,AdminUserService $users,MasterService $masterService)
    {
        $this->posts = $posts;
        $this->users = $users;
        $this->masterService = $masterService;
        $this->customArray = config('customarray');
        $this->language = config('customarray.language'); 
        $this->accountType = config('customarray.accountType');
        $this->post_type = config('customarray.post_type');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for creating a new comment.
     *
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request)
    {
        try{
            $data = $request->all();   
            $rules = array(
                'comment' => ['required', 'string'],
            );       
            $validate = Validator::make($data, $rules);          
            if ($validate->fails()) {
                // If validation falis redirect back to current page.
                //return response()->json(['error'=>$validate->errors()]); 
                return Redirect::to(redirect()->getUrlGenerator()->previous())->withErrors('The comment field is required.');    
            }else {
                $result = $this->posts->saveComment($data,$message);
                if($result){  
                    $this->posts->saveCommentNotification($data,$message);
                    return Redirect::to(redirect()->getUrlGenerator()->previous())->withSuccess($message);
                }else{
                    return Redirect::to(redirect()->getUrlGenerator()->previous())->withErrors($message);
                }
            }
        }catch (\Exception $e){
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
        try{
            $data = $request->all();   
            $rules = array(
                'comments' => ['required', 'string'],
            );       
            $validate = Validator::make($data, $rules);          
            if ($validate->fails()) {
                // If validation falis redirect back to current page.
                return Redirect::to(redirect()->getUrlGenerator()->previous())->withErrors('The comment field is required.');    
            }else {
                $result = $this->posts->saveReport($data,$message);
                if($result){  
                    return Redirect::to(redirect()->getUrlGenerator()->previous())->withSuccess($message);
                }else{
                    return Redirect::to(redirect()->getUrlGenerator()->previous())->withErrors($message);
                }
            }
        }catch (\Exception $e){
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
        try{
            $data = $request->all();   
            
            $result = $this->posts->saveFollow($data,$message);
            if($result){  
                return Redirect::to(redirect()->getUrlGenerator()->previous())->withSuccess($message);
            }else{
                return Redirect::to(redirect()->getUrlGenerator()->previous())->withErrors($message);
            }
            
        }catch (\Exception $e){
            throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);             
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /* public function store(Request $request)
    {
        $postArray = [];
    
        try{
            $data = $request->all();   
            if(!empty($data['other_surfer'])){
                $data['surfer'] = $data['other_surfer'];
            } elseif (isset($data['surfer']) && ($data['surfer'] == 'Me')) {
                $data['surfer'] = Auth::user()->user_name;
            } 
            
            $imageArray = (isset($data['files'][0]) && !empty($data['files'][0]))?$data['files']:[];
            $videoArray = (isset($data['videos'][0]) && !empty($data['videos'][0]))?$data['videos']:[];
            
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
                return response()->json(['error'=>$validate->errors()]);     
            }else {                
                if(!empty($postArray)) {
                    $fileData = [];
                    foreach ($postArray as $value) { 
                        $fileName = "";
                        
                        $fileType = explode('/', $value->getMimeType());
                        
                        if($fileType[0] == 'image'){
                            $destinationPath = public_path('storage/images/');
                        } elseif ($fileType[0] == 'video') {
                            $destinationPath = public_path('storage/fullVideos/');
                        }
                        
                        $timeDate = strtotime(Carbon::now()->toDateTimeString());
                        $filenameWithExt= $value->getClientOriginalName();
                        $extension = $value->getClientOriginalExtension();
                        while (in_array($timeDate, $fileData)) {
                            $timeDate = $timeDate . 1;
                        }
                        
                        $fileData[] = $timeDate;
                        $fileName = $timeDate.'.'.$extension;
                        $value->move($destinationPath, $fileName);
                        
                        $result = $this->posts->savePost($data, $fileType[0], $fileName, $message);
                    }
                } else {
                    $result = $this->posts->savePost($data, '', '', $message);
                }
                
                if($result){  
                    return Redirect()->route('myhub')->withSuccess($message);
                }else{
                    return Redirect()->route('myhub')->withErrors($message);
                }
            }
        }catch (\Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);             
        }
    } */
    public function store(Request $request)
    {
        try{
            $data = $request->all();   
//    echo "<pre>";print_r($data);die;
            if(!empty($data['other_surfer'])){
                $data['surfer'] = $data['other_surfer'];
            } elseif (isset($data['surfer']) && ($data['surfer'] == 'Me')) {
                $data['surfer'] = Auth::user()->user_name;
            } 
            
            $postArray = (isset($data['files']) && !empty($data['files']))?$data['files']:[];
//            $videoArray$postArray = (isset($data['videos'][0]) && !empty($data['videos'][0]))?$data['videos']:[];
            
//            $postArray = array_filter(array_merge($imageArray, $videoArray));
//            echo '<pre>';print_r($postArray);die;
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
                return response()->json(['error'=>$validate->errors()]);     
            }else {                
                if(!empty($postArray)) {
                    $fileData = [];
                    foreach ($postArray as $value) { 
                        
                        $fileType = explode('/', $value->getMimeType());
                        
                        if($fileType[0] == 'image'){
                            $fileFolder = 'images/' . $request->user_id;
                            // $destinationPath = public_path('storage/images/');
                        } elseif ($fileType[0] == 'video') {
                            $fileFolder = 'videos/' . $request->user_id;
                            // $destinationPath = public_path('storage/fullVideos/');
                        }

                        $path = Storage::disk('s3')->put($fileFolder, $value);
                        $filePath = Storage::disk('s3')->url($path);

                        $fileArray = explode("/", $filePath);
                        $filename = end($fileArray);
                        
                        // $timeDate = strtotime(Carbon::now()->toDateTimeString());
                        // $filenameWithExt= $value->getClientOriginalName();
                        // $extension = $value->getClientOriginalExtension();
                        // while (in_array($timeDate, $fileData)) {
                        //     $timeDate = $timeDate . 1;
                        // }
                        
                        // $fileData[] = $timeDate;
                        // $fileName = $timeDate.'.'.$extension;
                        // $value->move($destinationPath, $fileName);
                        
                        $result = $this->posts->savePost($data, $fileType[0], $filename, $message);
                    }
                } else {
                    $result = $this->posts->savePost($data, '', '', $message);
                }
                
                if($result){  
                    return Redirect()->route('myhub')->withSuccess($message);
                }else{
                    return Redirect()->route('myhub')->withErrors($message);
                }
            }
        }catch (\Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);             
        }
    }
    public function uploadLargeFiles(Request $request) {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
//        print_r($request);die;

        if (!$receiver->isUploaded()) {
            // file not uploaded
            return ;
        }
        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk(config('filesystems.default'));
            $x = $disk->putFileAs('videos', $file, $fileName);
            $p = storage_path('app/' . $x);
//            $source = fopen($p, 'rb');

//            $s3Client = new S3Client([
//                'version' => 'latest',
//                'region' => 'ap-southeast-2',
////            'endpoint' => 'https://d1d39qm6rlhacy.cloudfront.net',
////            's3BucketEndpoint' => true,    
//            ]);
//            $c = 1;
//            $key = 'myvid' . $c . '.mp4';
//            $uploader = new MultipartUploader($s3Client, $p, [
//                'bucket' => 'surfhub',
//                'key' => $key,
//            ]);
//
//            try {
//                $result = $uploader->upload();
////            echo "Upload complete: {$result['ObjectURL']}\n";
//            } catch (MultipartUploadException $e) {
//                echo $e->getMessage() . "\n";
//            }
//            $c++;
//            $path = Storage::disk('s3')->getDriver()->putStream('videos/test2.mp4', $file);
//            $path2 = Storage::disk('s3')->put('video', $file);
//            $upload = new Upload();
//            $upload->post_id = 1;
//            $upload->video = $path2;
//            $upload->save();
//            $url = Storage::disk('s3')->url($path2);
//            $source = fopen($p, 'rb');
//            $s3 = new S3Client([
//                    'version' => 'latest',
//                    'region'  => 'ap-southeast-2',
////                    'endpoint'  => 'https://d1d39qm6rlhacy.cloudfront.net/video/'
//                ]);
////                $path = Storage::disk('s3');
////            foreach($file as $chunck) {
//                $uploader = new MultipartUploader($s3, $source, [
//                    'bucket' => env('AWS_BUCKET'),
//                    'key'    => 'testvideo2.mp4',
//                ]);
//    
//                try {
//                    $result = $uploader->upload();
//                   
//                } catch (MultipartUploadException $e) {
//                    return $e->getMessage();
//                }
//            }
//            $path = $disk->putFileAs('videos', $file, $fileName);
//            $path = Storage::disk('s3')->put('video', $file);
//            echo '<pre>';print_r($result);die;
            // delete chunked file
//            unlink($file->getPathname());
            return ;
        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }
    
    public function uploadMedia(Request $request)
    {
        try{
            $data = $request->all();   
            if(!empty($data['other_surfer'])){
                $data['surfer'] = $data['other_surfer'];
            } elseif (isset($data['surfer']) && ($data['surfer'] == 'Me')) {
                $data['surfer'] = Auth::user()->user_name;
            } 
            
            $postArray = (isset($data['file']) && !empty($data['file']))?$data['file']:[];
                if(!empty($postArray)) {
                    
    
                    $fileData = [];
//                    foreach ($postArray as $value) { 
                        $filePath = "";
                        
                        $fileType = explode('/', $postArray->getMimeType());
//                        echo "<pre>";print_r($fileType);die;
                        if($fileType[0] == 'image'){
                            $fileFolder = 'images/' . $request->user_id;
                            // $destinationPath = public_path('storage/images/');
                        } elseif ($fileType[0] == 'video') {
                            $fileFolder = 'videos/' . $request->user_id;
                            // $destinationPath = public_path('storage/fullVideos/');
                        }

                        $path = Storage::disk('s3')->put($fileFolder, $postArray);
                        $filePath = Storage::disk('s3')->url($path);

                        $fileArray = explode("/", $filePath);
                        $filename = end($fileArray);
                        $result = $this->posts->savePost($data, $fileType[0], $filename, $message);
                        echo json_encode(array('status' => 'success', 'message' => 'true', 'data' => $result));die;
//                    }
                }  else {
                   
                    if($data['post_id'] && !empty($data['post_id'])) {
                        $result = $this->posts->updatePostM($data, $message);
                    } else {
                        $result = $this->posts->savePost($data, '', '', $message);
                    }
                }
                if($result){  
                    return Redirect()->route('myhub')->withSuccess($message);
                }else{
                    return Redirect()->route('myhub')->withErrors($message);
                }
            
        }catch (\Exception $e) {
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
            try{
                $result = $this->posts->ratePost($data,$message);

                if($result){
                   return json_encode(array('status'=>$result['status'], 'message'=>$result['message'],
                                     'averageRating'=>$result['averageRating'], 'usersRated'=>$result['usersRated']));
                }else{
                  return json_encode(array('status'=>$result['status'], 'message'=>$result['message'],
                                     'averageRating'=>$result['averageRating'], 'usersRated'=>$result['usersRated']));
                }
            }catch (\Exception $e){
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
        try{
            $result = $this->posts->deletePost(Crypt::decrypt($id),$message);
            if($result){
                return redirect()->route('myhub')->withSuccess($message);  
            }else{
                return redirect()->route('myhub')->withErrors($message); 
            }
        }catch (\Exception $e){
            return redirect()->route('myhub', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage());
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
        try{
            $result = $this->posts->saveToMyHub(Crypt::decrypt($id),$message);
            if($result){
                return redirect()->route('dashboard')->withSuccess($message);  
            }else{
                return redirect()->route('dashboard')->withErrors($message); 
            }
        }catch (\Exception $e){
            return redirect()->route('dashboard', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage());
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
        try{
            $result = $this->posts->surferRequest(Crypt::decrypt($id),$message);
            if($result){
                return redirect()->route('dashboard')->withSuccess($message);  
            }else{
                return redirect()->route('dashboard')->withErrors($message); 
            }
        }catch (\Exception $e){
            return redirect()->route('dashboard', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage());
        }
    }
    /**
     * Move post to the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function acceptRejectRequest($id,$type)
    {
        try{
            $request_id = Crypt::decrypt($id);
            $surferRequest = SurferRequest::select("*")->where("id", "=", $request_id)->get()->toArray();
            foreach ($surferRequest as $res) {
            $userName = User::select("user_name")->where("id", "=", $res['user_id'])->get();
            }
//            echo '<pre>';            print_r($userName);die;
            if($type == 'accept') {
                SurferRequest::where(['id'=>$request_id])
                ->update(['status'=>1]);
                foreach ($userName as $uu) {
                $result =   Post::where(['id'=>$surferRequest[0]['post_id']])
                ->update(['surfer'=>$uu['user_name']]);   
                }
                $message = 'Surfer request accepted';
                
            }
            if($type == 'reject') {
            $result =     SurferRequest::where(['id'=>$request_id])
                ->update(['status'=>2]);
                $message = 'Surfer request rejected';    
            }
            
//            echo '<pre>';            print_r($data);die;
            if($result){
                return redirect()->route('surferRequestList')->withSuccess($message);  
            }else{
                return redirect()->route('surferRequestList')->withErrors($message); 
            }
        }catch (\Exception $e){
            return redirect()->route('surferRequestList')->withErrors($e->getMessage());
        }
    }
    public function surferFollowRequest($id)
    {
            $request_id = Crypt::decrypt($id);
            $customArray = $this->customArray;
            $postsList = Post::where('is_deleted', '0')
                ->join('surfer_requests', 'surfer_requests.post_id', '=', 'posts.id')    
                ->where('surfer_requests.id', $request_id)
                ->where('parent_id', '0')
                ->where(function ($query) {
                    $query->where('post_type', 'PUBLIC')
                    ->orWhere('is_feed', '1');
                })
                ->orderBy('posts.created_at', 'DESC')
                ->get('posts.*');
//        echo '<pre>';        print_r($postsList);die;
            return view('user.surfer-follow-request', compact('customArray','postsList','request_id'));

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
        $detail = $this->posts->getPostDetails($post_id,$notification_id);
        $this->posts->updateNotificationStatus($notification_id);
        //dd($detail->post);
        return view('user.posts',compact('customArray','countries','states','currentUserCountryId','detail'));
        /*try{
            $result = $this->posts->deletePost(Crypt::decrypt($id),$message);
            if($result){
                return redirect()->route('myhub')->withSuccess($message);  
            }else{
                return redirect()->route('myhub')->withErrors($message); 
            }
        }catch (\Exception $e){
            return redirect()->route('myhub', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage());
        }*/
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
        return view('user.postData',compact('customArray','countries','states','currentUserCountryId','postData'));
    }

    public function updateNotificationCountStatus(Request $request)
    {
        $data = $request->all();
        $result = $this->posts->updateNotificationCountStatus($data);
        if($result){
         echo json_encode(array('status'=>'success'));
        }else{
         echo json_encode(array('status'=>'fails'));
        }
    }
    
    public function uploadFiles(Request $request, PostService $postService)
    {
        $fileArray = [];
        
        $data = $request->all();
        $timeDate = strtotime(Carbon::now()->toDateTimeString());        
        
        if (isset($data['photos'])) { 
            $file = $request->file('photos');
            $filename = $timeDate.'.'.$file[0]->extension();
            
            $file[0]->move(public_path('storage/images/'), $filename);
        } elseif (isset($data['videos'])) {
            $destinationPath = storage_path().'/app/public/fullVideos/';
            $file = $request->file('videos');
            $fileExt = $file[0]->getClientOriginalExtension();
            
            $filename = $timeDate.'.'.$fileExt;
            
            $file[0]->move($destinationPath, $filename);
            // $path = 'public/fullVideos/' . $filename;
            // $path = $file>storeAs($destinationPath, $filename);
            // $fileArray[] = $filename;
            // dd($path);
            //**********trimming video********************//
            /*$start = \FFMpeg\Coordinate\TimeCode::fromSeconds(0);
            $end   = \FFMpeg\Coordinate\TimeCode::fromSeconds(120);
            $clipFilter = new \FFMpeg\Filters\Video\ClipFilter($start,$end);*/
            //dd($path);
            /*FFMpeg::open('public/fullVideos/' . $filename)
                ->addFilter($clipFilter)
                ->export()
                ->toDisk('trim')
                ->inFormat(new FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
                ->save($filename); */
            
            //****removing untrimmed file******//
            /*$oldFullVideo = $destinationPath . $filename;
            /if(File::exists($oldFullVideo)){
                unlink($oldFullVideo);
            }*/
        }
    
        return response()->json(['success' => $filename]);
    }
    
    public function surferRequestList()
    {      
        $posts = Post::select("*")
                    ->where("user_id", "=", Auth::user()->id)
                    ->where("is_deleted", '0')
                    ->where("surfer", 'Unknown')
                    ->get()
                    ->toArray();
                    $postIds = array_filter(array_column($posts, 'id'));
                    
                    $surferRequest = SurferRequest::join('user_profiles', 'surfer_requests.user_id', '=', 'user_profiles.user_id')
//                    ->join('posts', 'posts.user_id', '=', 'surfer_requests.user_id')
                    ->whereIn("surfer_requests.post_id", $postIds)
                    ->where("surfer_requests.status", "=", 0)
                    ->get(['surfer_requests.*', 'user_profiles.first_name', 'user_profiles.last_name']);
                    
        return view('user.surfersRequestList',compact('surferRequest'));
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
//            $surferRequest = SurferRequest::select("*")
//                    ->where("post_id", "=", $val['id'])
//                    ->where("status", "=", 0)
//                    ->get();

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
//        echo '<pre>'; print_r($postsList);die;
        $url = url()->current();
        $usersList = $this->masterService->getAllUsers();

        if ($request->ajax()) {
            $view = view('elements/homedata', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url'))->render();
            return response()->json(['html' => $view]);
        }
        return view('user.upload', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer','beaches'));
    }
}