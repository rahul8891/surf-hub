<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
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
use App\Models\Upload;

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
        
        return view('user.myhub',compact('customArray','countries','states','currentUserCountryId','myHubs','userDetail','beach_name'));
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
    public function edit($id, $type, Request $request)
    {
        try{
            $currentUserCountryId = Auth::user()->user_profiles->country_id;    
            $countries = $this->masterService->getCountries();
            $language = $this->language;
            $users = $this->users->getUsersListing();
            $customArray = $this->customArray;  
            $myHubs = Post::findOrFail($id);
            $states = $this->masterService->getStateByCountryId($myHubs->country_id);
            $postMedia = Upload::where('post_id', $id)->get();
            $spiner = ($this->posts) ? true : false;
            
            if(!empty($myHubs->local_beach_break_id)){
                $bb = BeachBreak::where('id',$myHubs->local_beach_break_id)->first(); 
                $beach_name=$bb->beach_name.','.$bb->break_name.''.$bb->city_region.','.$bb->state.','.$bb->country;
            }
        }catch (\Exception $e){         
            throw ValidationException::withMessages([$e->getMessage()]);
        }
        
        if ($request->ajax()) {
            $view = view('elements/edit_'.$type.'_upload',compact('customArray','countries','states','currentUserCountryId','myHubs','users','beach_name'))->render();
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
        try{
            $data = $request->all();
            if(!empty($data['other_surfer'])){
                $data['surfer'] = $data['other_surfer'];
            }
            
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
                $result = $this->postService->updatePostData($data, $message);
                if($result['status'] === TRUE){
                    return Redirect()->route('myhub')->withSuccess($message);
                }else{
                    return Redirect()->route('myhub')->withErrors($message);
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
        //
    }

}