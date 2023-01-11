<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;
use App\Services\AdminUserService;
use App\Services\MasterService;
use App\Services\PostService;
use App\Traits\PasswordTrait;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Upload;
use Closure;
use Redirect;
use Session;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
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
    public function index(Request $request)
    {
        $input = $request->all();
        
        $posts = $this->posts->getAllPostsListing($input);
        $spiner = ($posts) ? true : false;
        return view('admin/post/index', compact('posts','spiner', 'input'));     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $language = $this->language;
        $users= User::all();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;   
        return view('admin/post/create', compact('users','countries','currentUserCountryId','customArray','language','states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try{
            $data = $request->all();
//    echo "<pre>";print_r($data);die;
            if (!empty($data['other_surfer'])) {
                $data['surfer'] = $data['other_surfer'];
            } elseif (isset($data['surfer']) && ($data['surfer'] == 'Me')) {
                $data['surfer'] = Auth::user()->user_name;
            }

//            $postArray = (isset($data['files']) && !empty($data['files'])) ? $data['files'] : [];
            $imageArray["images"] = (isset($data['imagesHid_input'][0]) && !empty($data['imagesHid_input'][0]))?json_decode($data['imagesHid_input'][0]):[];
            $videoArray["videos"] = (isset($data['videosHid_input'][0]) && !empty($data['videosHid_input'][0]))?json_decode($data['videosHid_input'][0]):[];
            $postArray = array_filter(array_merge($imageArray, $videoArray));
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
                return response()->json(['error' => $validate->errors()]);
            } else {
//                if (!empty($postArray)) {
//                    $fileData = [];
//                    foreach ($postArray as $value) {
//
//                        $fileType = explode('/', $value->getMimeType());
//
//                        if ($fileType[0] == 'image') {
//                            $fileFolder = 'images/' . $request->user_id;
//                            // $destinationPath = public_path('storage/images/');
//                        } elseif ($fileType[0] == 'video') {
//                            $fileFolder = 'videos/' . $request->user_id;
//                            // $destinationPath = public_path('storage/fullVideos/');
//                        }
//
//                        $path = Storage::disk('s3')->put($fileFolder, $value);
//                        $filePath = Storage::disk('s3')->url($path);
//
//                        $fileArray = explode("/", $filePath);
//                        $filename = end($fileArray);
//
//                        $result = $this->posts->savePost($data, $fileType[0], $filename, $message);
//                    }
//                } 
                
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
//                    return Redirect()->route('adminMyHub')->withSuccess($message);
                    return json_encode(array('message' => 'Post has been upload successfully')); 
                } else {
                    return json_encode(array('message' => 'Error while posting')); 
//                    return Redirect()->route('adminMyHub')->withErrors($message);
                }
            }
        }catch (\Exception $e){ 
            throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
        }
        
    }

    public function storeAdminAds(Request $request) {
        try {
            $data = $request->all();
//    echo "<pre>";print_r($data);die;
            

            $postArray = (isset($data['file']) && !empty($data['file'])) ? $data['file'] : [];
//            $videoArray$postArray = (isset($data['videos'][0]) && !empty($data['videos'][0]))?$data['videos']:[];
//            $postArray = array_filter(array_merge($imageArray, $videoArray));
//            echo '<pre>';print_r($postArray);die;
            $rules = array(
//                'post_type' => ['required'],
//                'user_id' => ['required'],
//                'surf_date' => ['required'],
//                'wave_size' => ['required'],
//                'surfer' => ['required'],
//                'country_id' => ['required'],
            );
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return response()->json(['error' => $validate->errors()]);
            } else {
                
                if (!empty($postArray)) {
                    $fileData = [];
//                    foreach ($postArray as $value) {
//                    echo "<pre>";print_r($postArray);die;

                        $fileType = explode('/', $postArray->getMimeType());

                        if ($fileType[0] == 'image') {
                            $fileFolder = 'images/' . Auth::user()->id;
                            // $destinationPath = public_path('storage/images/');
                        } 
                        
//                        elseif ($fileType[0] == 'video') {
//                            $fileFolder = 'videos/' . $request->user_id;
//                            // $destinationPath = public_path('storage/fullVideos/');
//                        }

                        $path = Storage::disk('s3')->put($fileFolder, $postArray);
                        $filePath = Storage::disk('s3')->url($path);

                        $fileArray = explode("/", $filePath);
                        $filename = end($fileArray);

                        $result = $this->posts->saveAdminAds($data, $fileType[0], $filename, $message);
//                    }
                } 

                if ($result) {
                    return Redirect()->route('adminPageIndex')->withSuccess($message);
                } else {
                    return Redirect()->route('adminPageIndex')->withErrors($message);
                }
            }
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
        try{
        $post=Post::findOrFail(Crypt::decrypt($id));
        $postMedia=Upload::where('post_id',Crypt::decrypt($id))->get();
            $spiner = ($post) ? true : false;
        }catch (\Exception $e){ 
            throw ValidationException::withMessages([$e->getMessage()]);
        }
        return view('admin/post/show', compact('post','postMedia','spiner'));  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {         
        try{
            $currentUserCountryId = Auth::user()->user_profiles->country_id;    
            $countries = $this->masterService->getCountries();
            $language = $this->language;
            $users = $this->users->getUsersListing();
            $customArray = $this->customArray;  
            $posts = Post::findOrFail(Crypt::decrypt($id));
            $states = $this->masterService->getStateByCountryId($posts->country_id);
            $postMedia=Upload::where('post_id',Crypt::decrypt($id))->get();
            $spiner = ($this->posts) ? true : false;
        }catch (\Exception $e){         
            throw ValidationException::withMessages([$e->getMessage()]);
        }
        
        return view('admin/post/edit', compact('users','countries','postMedia','posts','currentUserCountryId','customArray','language','states'));
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
        $id=Crypt::decrypt($id);
        try{
            $data = $request->all();
            $imageArray=$request->file('files');
            $videoArray=$request->file('videos');
            $rules = array(
                'post_type' => ['required'],
                'user_id' => ['required','numeric'],
                'post_text' => ['nullable', 'string', 'max:255'],
                'surf_date' => ['required', 'string'],
                'wave_size' => ['required', 'string'],
                'state_id' => ['nullable', 'numeric'],
                'board_type' => ['required', 'string'],
                'surfer' => ['required'],
                'country_id' => ['required','numeric'],
                'local_beach_break_id' => ['nullable', 'string'],
                'optional_info'=>['nullable'],
            );
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->posts->updatePost($data,$imageArray,$videoArray,$id,$message);
                if($result){
                    return redirect()->route('postDetail', ['id' => Crypt::encrypt($id)])->withSuccess($message);
                }else{
                    return redirect()->route('postEdit', ['id' => Crypt::encrypt($id)])->withErrors($message); 
                }
            }
        }catch (\Exception $e){
                
            return redirect()->route('postEdit', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage()); 
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
                return redirect()->route('postIndex')->withSuccess($message);  
            }else{
                return redirect()->route('postIndex')->withErrors($message); 
            }
        }catch (\Exception $e){
            return redirect()->route('postIndex', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage());
        }

    }
    
    /**
     * Update feed status of the post.
     *
     * @param  int  $id & $status
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        $post->is_feed = $request->status;
        if ($post->save()) {
            return response()->json(['statuscode' => 200, 'status' => true, 'message' =>  "Feed status updated successfully.", 'data' => $post], 200);
        } else {
            return response()->json(['statuscode' => 400, 'status' => false, 'message' =>  "Something went wrong. Please try later."], 400);
        }
    }
    
}