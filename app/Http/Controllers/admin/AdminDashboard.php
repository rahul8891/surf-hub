<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Services\AdminUserService;
use App\Services\PostService;
use App\Services\MasterService;
use App\Models\Post;
use App\Models\SurferRequest;
use App\Services\UserService;


class AdminDashboard extends Controller
{
    /**
     * The user repository implementation.
     *
     * @var AdminUserService
     */
    protected $users;

    /**
     * Create a new controller instance.
     *
     * @param  AdminUserService  $users
     * @return void
     */
    public function __construct()
    {
 	    $this->user = New UserService();
        $this->users = New AdminUserService();
        $this->posts = New PostService();
        $this->masterService = New MasterService();
        $this->customArray = config('customarray');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalUser = $this->users->getUserTotal();
        $totalPost = $this->posts->getPostTotal();
        // $uploads = $this->posts->getUploads();
        $uploads = $this->posts->getUploadsAdmin();
        $resort = $this->user->getActiveUserType('SURFER CAMP');
        $photographer = $this->user->getActiveUserType('PHOTOGRAPHER');
        $advertiser = $this->user->getActiveUserType('ADVERTISEMENT');


        return view('admin/dashboard.index', compact('totalPost','totalUser', 'uploads', 'resort', 'photographer', 'advertiser'));
    }

    public function feed(Request $request) {
        $param = $request->all();
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $beaches = $this->masterService->getBeaches();
        $customArray = $this->customArray;

        $postsList = $this->posts->getFeedFilteredList($param);

        $requestSurfer = array();
        foreach ($postsList as $val) {
            $surferRequest = SurferRequest::where("post_id", "=", $val['id'])
                    ->where("user_id", "=", Auth::user()->id)
                    ->get();
            foreach ($surferRequest as $res) {
                $requestSurfer[$res->post_id] = $res->user_id;
            }
        }

        $url = url()->current();
        $usersList = $this->masterService->getAllUsers();

        if ($request->ajax()) {
            $page = (isset($param['page']) && !empty($param['page']))?$param['page']:1;
            $view = view('elements/homedata', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer','beaches', 'page'))->render();
            return response()->json(['html' => $view]);
        }
        return view('admin/dashboard.admin_feed', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer','beaches'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myHub($post_type = null, Request $request) {
        $beach_name = "";
        $post_type = (!empty($post_type))?$post_type:'all';
        $urlData = (!empty($request->getQueryString()))?$request->getQueryString():"";
        $params = $request->all();
        $order = $request->input('order');
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $userDetail = Auth::user()->user_profiles;

        if (isset($post_type) && !empty($post_type)) {
            $postsList = $myHubs = $this->posts->getAdminFilteredData($params, 'myhub', $post_type);
        } else {
            $postsList = $myHubs = $this->posts->getAdminFilteredData($params, 'myhub');
        }

        $beaches = $this->masterService->getBeaches();

        if (!empty($request->input('local_beach_break_id'))) {
            $bb = BeachBreak::where('id', $request->input('local_beach_break_id'))->first();
            $beach_name = $bb->beach_name . ',' . $bb->break_name . '' . $bb->city_region . ',' . $bb->state . ',' . $bb->country;
        }

        if ($request->ajax()) {
            $data = $request->all();
            $page = $data['page'];
            $view = view('elements/myhubdata', compact('postsList', 'customArray', 'countries', 'states', 'currentUserCountryId', 'myHubs', 'userDetail', 'beach_name', 'beaches','page','urlData','post_type'))->render();
            return response()->json(['html' => $view]);
        }

        return view('admin/dashboard.myhub', compact('postsList', 'customArray', 'countries', 'states', 'currentUserCountryId', 'myHubs', 'userDetail', 'beach_name', 'beaches', 'post_type','urlData'));
    }

    /**
     * search the specified resource from storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $beach_name="";
        $params = $request->all();
        $urlData = (!empty($request->getQueryString()))?$request->getQueryString():"";
        $currentUserCountryId = (isset(Auth::user()->user_profiles->country_id) && !empty(Auth::user()->user_profiles->country_id))?Auth::user()->user_profiles->country_id:'';
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $beaches = $this->masterService->getBeaches();

        $customArray = $this->customArray;
        $userDetail = (isset(Auth::user()->user_profiles) && !empty(Auth::user()->user_profiles))?Auth::user()->user_profiles:'';
        $postsList = $this->posts->getAdminFilteredData($params, 'search');

        if(!empty($request->input('local_beach_break_id'))){
            $bb = BeachBreak::where('id',$request->input('local_beach_break_id'))->first();
            $beach_name = $bb->beach_name.','.$bb->break_name.''.$bb->city_region.','.$bb->state.','.$bb->country;
        }

        if ($request->ajax()) {
            $data = $request->all();
            $page = $data['page'];
            $view = view('elements/searchdata', compact('customArray','countries','states','currentUserCountryId','postsList','userDetail','beach_name','beaches','page','urlData'))->render();
            return response()->json(['html' => $view]);
        }

        return view('admin/dashboard.search', compact('customArray','countries','states','currentUserCountryId','postsList','userDetail','beach_name','beaches','urlData'));
    }

    public function leftSideCounts(Request $request) {
        $userPostsUnknown = $this->posts->getPostUnknownByUserId();
        $postUnIds = array_filter(array_column($userPostsUnknown, 'id'));
        $surferRequests = $this->posts->getSurferRequest($postUnIds, 0);
        $reports = $this->posts->getReportsCount();
        $comments = $this->posts->getCommentsCount();
        // $uploads = $this->posts->getUploads();
        $uploads = $this->posts->getUploadsAdmin();
        $totalPost = $this->posts->getPostTotal();
        $fCounts = array(
            'posts' => $totalPost,
            'surferRequest' => count($surferRequests),
            'uploads' => count($uploads),
            'reports' => $reports,
            'comments' => $comments,
        );

        echo json_encode($fCounts);
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
