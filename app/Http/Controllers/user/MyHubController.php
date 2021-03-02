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


class MyHubController extends Controller
{

    protected $posts;

    public function __construct(MasterService $masterService,UserService $userService,PostService $postService)
    {
            $this->masterService = $masterService;
            $this->customArray = config('customarray');
            $this->userService = $userService;
            $this->postService = $postService;
            $this->posts = new Post();
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $beach_name ="";    
        $el=$request->input('sort');
        $currentUserCountryId = Auth::user()->user_profiles->country_id;      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $myHubs=$this->sort($el);
        //dd($myHubs[0]->upload);
        $userDetail=Auth::user()->user_profiles;
        return view('user.myhub',compact('customArray','countries','states','currentUserCountryId','myHubs','userDetail','beach_name'));      

    }


    /**
     * Display a listing of post with sorting.
     *
     * @return \Illuminate\Http\Response
     */
    public function sort($el){
        $postList=$this->posts->where('user_id',[Auth::user()->id]);

        if($el=="dateAsc"){
            return $this->postService->getMyHubListing($postList,'posts.created_at','ASC');
        }
        else if($el=="dateDesc"){
            return $this->postService->getMyHubListing($postList,'posts.created_at','DESC');
        }
        else if($el=="beach"){
            return $this->postService->getMyHubListing($postList,'beach','ASC');
        }
        else if($el=="star"){
            return $this->postService->getMyHubListing($postList,'posts.created_at','DESC');
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