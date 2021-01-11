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
        $el=$request->input('sort');
        $beach_name="";
        $currentUserCountryId = Auth::user()->user_profiles->country_id;      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $userDetail=Auth::user()->user_profiles;

        // ***************check user's recent searches******************************

        $searchRecord=Search::select('*')->where('user_id',[Auth::user()->id])->get();
        foreach($searchRecord as $post){
            $postsList[]=$post->post;
        }
        // *************************************************************************
        if(empty($postsList)){
            $postsList=$this->sort($el);
        }

        return view('user.search',compact('customArray','countries','states','currentUserCountryId','postsList','userDetail','beach_name')); 
    }

    /**
     * Display a listing of post with sorting.
     *
     * @return \Illuminate\Http\Response
     */
    public function sort($el){
        $postList=$this->posts;
        
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
        $postsList=$this->postService->getFilteredList($params,'search');
        
        // ***********************************adding it to search table***************************************
        Search::where('user_id',[Auth::user()->id])->delete();
        foreach($postsList as $posts){
            $search = new Search();
            $search->user_id = Auth::user()->id;
            $search->post_id = $posts->id;
            $search->save();
        }
        // ***************************************************************************************************
        if(!empty($request->input('local_beach_break_id'))){
            $bb = BeachBreak::where('id',$request->input('local_beach_break_id'))->first(); 
            $beach_name=$bb->beach_name.','.$bb->break_name.''.$bb->city_region.','.$bb->state.','.$bb->country;
        }

        return view('user.search',compact('customArray','countries','states','currentUserCountryId','postsList','userDetail','beach_name')); 
    }
}
