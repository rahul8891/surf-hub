<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\BeachBreak;
use App\Models\Search;
use App\Services\MasterService;
use App\Services\UserService;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SearchController extends Controller
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
     * search the specified resource from storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        /*$el = $request->input('sort');
        $beach_name="";
        $currentUserCountryId = (isset(Auth::user()->user_profiles->country_id) && !empty(Auth::user()->user_profiles->country_id))?Auth::user()->user_profiles->country_id:'';      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $userDetail = (isset(Auth::user()->user_profiles) && !empty(Auth::user()->user_profiles))?Auth::user()->user_profiles:'';

        // ***************check user's recent searches******************************

        if(isset(Auth::user()->id)) {
            $searchRecord = Search::select('*')->where('user_id', Auth::user()->id)->get();
            foreach($searchRecord as $post) {
                $postsList[] = $post->post;
            }
            // *************************************************************************
            if(empty($postsList)) {
                $postsList = $this->sort($el);
            }
        } else {
            $postsList = $this->sort($el);
        }
        // dd($postsList);
        if ($request->ajax()) {
            $view = view('elements/searchdata',compact('customArray','countries','states','currentUserCountryId','postsList','userDetail','beach_name'))->render();
            return response()->json(['html' => $view]);
        }
        
        return view('user.search',compact('customArray','countries','states','currentUserCountryId','postsList','userDetail','beach_name')); */
        
        $beach_name="";
        $params = $request->all();
//        $from_date = date('Y-m-d H:i:s', strtotime('-'.$params["from_age"].' year'));
//        print_r($from_date);die;
//        $order = $request->input('order');
        $currentUserCountryId = (isset(Auth::user()->user_profiles->country_id) && !empty(Auth::user()->user_profiles->country_id))?Auth::user()->user_profiles->country_id:'';
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $beaches = $this->masterService->getBeaches();
//        echo '<pre>';        print_r($beaches);die;
        $customArray = $this->customArray;
        $userDetail = (isset(Auth::user()->user_profiles) && !empty(Auth::user()->user_profiles))?Auth::user()->user_profiles:'';
        $postsList = $this->postService->getFilteredData($params, 'search');
        // echo "<pre>";print_r($postsList);die;
        if(!empty($request->input('local_beach_break_id'))){
            $bb = BeachBreak::where('id',$request->input('local_beach_break_id'))->first();
            $beach_name = $bb->beach_name.','.$bb->break_name.''.$bb->city_region.','.$bb->state.','.$bb->country;
        }
       // print_r($postsList);die;
        if ($request->ajax()) {
            $view = view('elements/searchdata', compact('customArray','countries','states','currentUserCountryId','postsList','userDetail','beach_name','beaches'))->render();
            return response()->json(['html' => $view]);
        }
        
        return view('user.search', compact('customArray','countries','states','currentUserCountryId','postsList','userDetail','beach_name','beaches'));
    }

    /**
     * Display a listing of post with sorting.
     *
     * @return \Illuminate\Http\Response
     */
    public function sort($el){
        $postList = $this->posts->with(['followPost', 'beach_breaks']);
        
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
        $currentUserCountryId = (isset(Auth::user()->user_profiles->country_id) && !empty(Auth::user()->user_profiles->country_id))?Auth::user()->user_profiles->country_id:'';      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $userDetail= (isset(Auth::user()->user_profiles) && !empty(Auth::user()->user_profiles))?Auth::user()->user_profiles:'';
        $postsList=$this->postService->getFilteredList($params,'search');
        
        // ***********************************adding it to search table***************************************
        if(isset(Auth::user()->id)) {
            Search::where('user_id',[Auth::user()->id])->delete();
            foreach($postsList as $posts){
                $search = new Search();
                $search->user_id = Auth::user()->id;
                $search->post_id = $posts->id;
                $search->save();
            }
        }
        // ***************************************************************************************************
        if(!empty($request->input('local_beach_break_id'))){
            $bb = BeachBreak::where('id',$request->input('local_beach_break_id'))->first(); 
            $beach_name=$bb->beach_name.','.$bb->break_name.''.$bb->city_region.','.$bb->state.','.$bb->country;
        }
        
        if ($request->ajax()) {
            $view = view('elements/searchdata',compact('customArray','countries','states','currentUserCountryId','postsList','userDetail','beach_name'))->render();
            return response()->json(['html' => $view]);
        }

        return view('user.search',compact('customArray','countries','states','currentUserCountryId','postsList','userDetail','beach_name')); 
    }
}
