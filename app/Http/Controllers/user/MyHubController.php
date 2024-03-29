<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Services\MasterService;
use App\Services\UserService;
use App\Services\PostService;
use App\Models\BeachBreak;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;
use App\Services\AdminUserService;
use Carbon\Carbon;
use App\Models\Upload;
use File, URL;
use FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Filters\Video\VideoFilters;

class MyHubController extends Controller
{

    protected $posts;
    
    public $language;

    public function __construct(MasterService $masterService,UserService $userService,PostService $postService, AdminUserService $users)
    {
        $this->masterService = $masterService;
        $this->customArray = config('customarray');
        $this->userService = $userService;
        $this->postService = $postService;
        $this->posts = new Post();
        $this->language = config('customarray.language');
        $this->users = $users;
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $beach_name ="";    
        $el = $request->input('sort');
        $currentUserCountryId = Auth::user()->user_profiles->country_id;      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $myHubs = $this->sort($el);
        $userDetail=Auth::user()->user_profiles;
//        dd($myHubs);
        if ($request->ajax()) {
            $view = view('elements/myhubdata',compact('customArray','countries','states','currentUserCountryId','myHubs','userDetail','beach_name'))->render();
            return response()->json(['html' => $view]);
        }
        
        return view('user.feed',compact('customArray','countries','states','currentUserCountryId','myHubs','userDetail','beach_name'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newIndex(Request $request)
    {   
        $beach_name="";
        $params = $request->all();
        $order = $request->input('order');
        $currentUserCountryId = Auth::user()->user_profiles->country_id;      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $userDetail = Auth::user()->user_profiles;
        $postsList = $myHubs = $this->postService->getFilteredData($params,'myhub');
        $beaches = $this->masterService->getBeaches();
        
        if(!empty($request->input('local_beach_break_id'))){
            $bb = BeachBreak::where('id',$request->input('local_beach_break_id'))->first(); 
            $beach_name=$bb->beach_name.','.$bb->break_name.''.$bb->city_region.','.$bb->state.','.$bb->country;
        }
        
        if ($request->ajax()) {
            $view = view('elements/myhubdata',compact('postsList','customArray','countries','states','currentUserCountryId','myHubs','userDetail','beach_name','beaches'))->render();
            return response()->json(['html' => $view]);
        }
        
        /*$beach_name ="";
        $params=$request->all();
        $order=$request->input('order');
        
        $el = $request->input('sort');
        $currentUserCountryId = Auth::user()->user_profiles->country_id;      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $myHubs = $this->sort($el);
        $userDetail=Auth::user()->user_profiles;
//        dd($myHubs);
        if ($request->ajax()) {
            $view = view('elements/myhubdata',compact('customArray','countries','states','currentUserCountryId','myHubs','userDetail','beach_name'))->render();
            return response()->json(['html' => $view]);
        }*/
        
        return view('user.feed',compact('postsList','customArray','countries','states','currentUserCountryId','myHubs','userDetail','beach_name','beaches'));
    }


    /**
     * Display a listing of post with sorting.
     *
     * @return \Illuminate\Http\Response
     */
    public function sort($el){
        $postList = $this->posts->where('user_id',[Auth::user()->id]);

        if($el=="dateAsc"){
            return $this->postService->getMyHubListing($postList,'posts.created_at','ASC');
        }
        else if($el=="dateDesc"){
            return $this->postService->getMyHubListing($postList,'posts.created_at','DESC');
        }
        else if($el=="surfDateAsc"){
            return $this->postService->getMyHubListing($postList,'posts.surf_start_date','ASC');
        }
        else if($el=="surfDateDesc"){
            return $this->postService->getMyHubListing($postList,'posts.surf_start_date','DESC');
        }
        else if($el=="beach"){
            return $this->postService->getMyHubListing($postList,'beach','ASC');
        }
        else if($el=="star"){
            return $this->postService->getMyHubListing($postList,'star','DESC');
        }
        else{
            return $this->postService->getMyHubListing($postList,'posts.created_at','DESC');
        }       

    }

    /**
     * display the post after filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        //
        $beach_name="";
        $params=$request->all();
        $order=$request->input('order');
        $currentUserCountryId = Auth::user()->user_profiles->country_id;      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $userDetail=Auth::user()->user_profiles;
        $myHubs=$this->postService->getFilteredList($params,'myhub');
        if(!empty($request->input('local_beach_break_id'))){
            $bb = BeachBreak::where('id',$request->input('local_beach_break_id'))->first(); 
            $beach_name=$bb->beach_name.','.$bb->break_name.''.$bb->city_region.','.$bb->state.','.$bb->country;
        }
        
        if ($request->ajax()) {
            $view = view('elements/myhubdata',compact('customArray','countries','states','currentUserCountryId','myHubs','beach_name'))->render();
            return response()->json(['html' => $view]);
        }
        
        return view('user.myhub',compact('customArray','countries','states','currentUserCountryId','myHubs','beach_name'));    

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id, Request $request)
    {   try{
            $currentUserCountryId = Auth::user()->user_profiles->country_id;    
            $countries = $this->masterService->getCountries();
            $language = $this->language;
            $users = $this->users->getUsersListing();
            $customArray = $this->customArray;  
            $myHubs = Post::findOrFail($id);
            $states = $this->masterService->getStateByCountryId($myHubs->country_id);
            $postMedia = Upload::where('post_id', $id)->get();
            $spiner = ($this->posts) ? true : false;
            
            if(!empty($myHubs->local_beach_id)){
                $bb = BeachBreak::where('id',$myHubs->local_beach_id)->first(); 
                $beach_name=$bb->beach_name.','.$bb->break_name.''.$bb->city_region.','.$bb->state.','.$bb->country;
            
                $breaks = $this->masterService->getBreakByBeachName($bb->beach_name);
                $breakId = $myHubs->local_break_id;
            }
        }catch (\Exception $e){         
            throw ValidationException::withMessages([$e->getMessage()]);
        }
        
        if ($request->ajax()) {
            $view = view('elements/edit_image_upload',compact('customArray','countries','states','currentUserCountryId','myHubs','users','beach_name','breaks','breakId'))->render();
            return response()->json(['html' => $view]);
        }
        // return view('user.edit', compact('users','countries','postMedia','posts','currentUserCountryId','customArray','language','states'));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $data = $request->all();
            if (!empty($data['other_surfer'])) {
                $data['surfer'] = $data['other_surfer'];
            } elseif (isset($data['surfer']) && ($data['surfer'] == 'Me')) {
                $data['surfer'] = Auth::user()->user_name;
            }

            $rules = array(
                'post_type' => ['required'],
                'user_id' => ['required', 'numeric'],
                'post_text' => ['nullable', 'string', 'max:255'],
                'surf_date' => ['required', 'string'],
                'wave_size' => ['required', 'string'],
//                'state_id' => ['nullable', 'numeric'],
//                'board_type' => ['required', 'string'],
                'surfer' => ['required'],
//                'country_id' => ['required','numeric'],
//                'local_beach_break_id' => ['nullable', 'string'],
//                'optional_info'=>['nullable'],
            );
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {

                $postArray = (isset($data['files']) && !empty($data['files'])) ? $data['files'] : [];

                $filePath = $type = "";
                // $timeDate = strtotime(Carbon::now()->toDateTimeString());
                if (!empty($postArray)) {

                    
                    $fileType = explode('/', $request->file('files')->getMimeType());
                    if($fileType[0] == 'image'){
                        $fileFolder = 'images/' . $request->user_id;
                        // $destinationPath = public_path('storage/images/');
                    } elseif ($fileType[0] == 'video') {
                        $fileFolder = 'videos/' . $request->user_id;
                        // $destinationPath = public_path('storage/fullVideos/');
                    }
                    $file = $request->file('files');
                    $path = Storage::disk('s3')->put($fileFolder, $file);
                    $filePath = Storage::disk('s3')->url($path);

                    $fileArray = explode("/", $filePath);
                    $filename = end($fileArray);

                    $result = $this->postService->updatePostData($data, $filename, $fileType[0], $message);
                } else {
                    $result = $this->postService->updatePostData($data, '', '', $message);
                }
                if ($result['status'] === TRUE) {
                    return Redirect()->route('myhub')->withSuccess($result['message']);
                } else {
                    return Redirect()->route('myhub')->withErrors($result['message']);
                }
            }
        }catch (\Exception $e){
                
            return redirect()->route('myhub')->withErrors($e->getMessage()); 
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
        //
    }

}