<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Services\AdminUserService;
use App\Services\PostService;
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
    public function __construct(UserService $user, AdminUserService $users, PostService $posts)
    {
        $this->user = $user;
        $this->users = $users;     
        $this->posts = $posts;       
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
        $uploads = $this->posts->getUploads();
        $resort = $this->user->getActiveUserType('SURFER CAMP');
        $photographer = $this->user->getActiveUserType('PHOTOGRAPHER');
        $advertiser = $this->user->getActiveUserType('ADVERTISEMENT');


        return view('admin/dashboard.index', compact('totalPost','totalUser', 'uploads', 'resort', 'photographer', 'advertiser'));
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