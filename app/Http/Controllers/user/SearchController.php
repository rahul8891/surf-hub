<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Search;
use App\Services\MasterService;
use App\Services\UserService;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SearchController extends Controller
{

    protected $posts;
    protected $searches;

    public function __construct(MasterService $masterService,UserService $userService,PostService $postService)
    {
            $this->masterService = $masterService;
            $this->customArray = config('customarray');
            $this->userService = $userService;
            $this->postService = $postService;
            $this->posts = new Post();
            $this->searches = new Search();
    }

    /**
     * search the specified resource from storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        // ***************check user's recent searches******************************
        

        // *************************************************************************

        $el=$request->input('sort');
        $currentUserCountryId = Auth::user()->user_profiles->country_id;      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $userDetail=Auth::user()->user_profiles;
        $postsList=$this->sort($el);
        return view('user.search',compact('customArray','countries','states','currentUserCountryId','postsList','userDetail')); 
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
        $params=$request->all();
        $order=$request->input('order');
        $currentUserCountryId = Auth::user()->user_profiles->country_id;      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $postsList=$this->postService->getFilteredList($params,'search');
        
        // ***********************************adding it to search table***************************************
        

        // ***************************************************************************************************
        

        $userDetail=Auth::user()->user_profiles;
        return view('user.search',compact('customArray','countries','states','currentUserCountryId','postsList','userDetail')); 
    }
}
