<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Services\MasterService;
use App\Services\UserService;
use App\Services\PostService;
use App\Models\Post;
use App\Models\UserFollow;
use Redirect;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @param  AdminUserService  $users
     * @return void
     */
    public function __construct(MasterService $masterService,UserService $userService,PostService $postService)
    {
            $this->masterService = $masterService;
            $this->customArray = config('customarray');
            $this->userService = $userService;
            $this->postService = $postService;
    }
    
    public function dashboard(Request $request){
        $currentUserCountryId = Auth::user()->user_profiles->country_id;      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;      
        $postsList = Post::with('followPost')->where('is_deleted','0')    
                            ->where('parent_id','0')    
                            ->where('post_type','PUBLIC')                              
                            ->orderBy('posts.created_at','DESC')
                            ->paginate(5);
        
        $url = url()->current();
        $usersList = $this->masterService->getAllUsers();
        
        if ($request->ajax()) {
            $view = view('elements/homedata',compact('customArray','countries','states','currentUserCountryId','postsList', 'url'))->render();
            return response()->json(['html' => $view]);
        }
        
        return view('dashboard',compact('customArray','countries','states','currentUserCountryId','postsList', 'url'));
    }


    public function getState(Request $request){
        $data = $request->all();   

        $getStateArray = $this->masterService->getStateByCountryId($data['country_id']);       
        if($getStateArray){
            echo json_encode(array('status'=>'success', 'message'=>'true','data'=>$getStateArray));
        }else{
            echo json_encode(array('status'=>'failure', 'message'=>'false','data'=>null));
        }
        die;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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