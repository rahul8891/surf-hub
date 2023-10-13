<?php

namespace App\Http\Controllers\admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
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
use App\Models\Upload;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\State;
use App\Models\Rating;
use App\Models\Report;
use App\Models\BeachBreak;
use App\Models\SurferRequest;
use Carbon\Carbon;
use Closure;
use Redirect;
use Session;
use Illuminate\Support\Facades\DB;


class AdminUserController extends Controller
{   
    use PasswordTrait;
    /**
     * The user sevices implementation.
     *
     * @var AdminUserService
     */
    protected $users;

    Protected $masterService;

    public $language;

    public $accountType;

    /**
     * Create a new controller instance.
     *
     * @param  AdminUserService  $users
     * @return void
     */
    public function __construct(AdminUserService $users,MasterService $masterService, PostService $post)
    {
        $this->users = $users;
        $this->masterService = $masterService;
        $this->language = config('customarray.language'); 
        $this->accountType = config('customarray.accountType');
        $this->customArray = config('customarray');
        $this->post = $post;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $params = $request->all();
        $currentUserCountryId = (isset(Auth::user()->user_profiles->country_id) && !empty(Auth::user()->user_profiles->country_id)) ? Auth::user()->user_profiles->country_id : '';
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $gender_type = config('customarray.gender_type');
        $users = $this->users->getUsersList($params);
        $postArr = array();
        foreach ($users as $val) {
            $userPosts = $this->post->getPostByUserId($val->user_id);
            $postIds = array_filter(array_column($userPosts, 'id'));

            $postArr[$val->user_id]['nPost'] = count($userPosts);
            if (!empty($postIds)) {
                $uploads = $this->post->getUploads($postIds);
                $postArr[$val->user_id]['nUpload'] = count($uploads);
            } else {
                $postArr[$val->user_id]['nUpload'] = 0;
            }
        }

        $spiner = ($users) ? true : false;
        return view('admin/admin_user/index', compact('users', 'spiner', 'countries', 'states', 'gender_type', 'postArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->masterService->getCountries();
        $language = $this->language;
        $accountType = $this->accountType;       
        return view('admin/admin_user/create', compact('countries','language','accountType'));
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
            $rules = array(
                'profile_photo_name' => ['nullable','image','mimes:jpeg,jpg,png'],
                'user_name' => ['required', 'string', 'max:255','unique:users','alpha_dash'],
                'first_name' => ['required', 'string'],
                'last_name' => ['nullable','string'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required'],
                'country_id' => ['required','numeric'],
                'language' => ['required','string'],
                'local_beach_break_id' => ['required', 'string'],
                'account_type'=>['required','string'],
                'password' => $this->passwordRules(),
                'terms' => ['required'],
            );
            
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->users->saveAdminUser($data,$message);
                if($result){  
                    return Redirect::to('admin/users/index')->withSuccess($message);
                }else{
                    return Redirect::to('admin/users/index')->withErrors($message);
                }
            }
        }catch (\Exception $e){ 
            throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
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
            $users = new User();    
            $users = $users::findOrFail(Crypt::decrypt($id));
            $spiner = ($users) ? true : false;
        }catch (\Exception $e){ 
            throw ValidationException::withMessages([$e->getMessage()]);
        }
        return view('admin/admin_user/show', compact('users','spiner'));  
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
            $customArray = $this->customArray;
            $beaches = $states = $postsList = [];
            $gender_type = config('customarray.gender_type');
            $countries = DB::table('countries')->select('id', 'name', 'phone_code')->orderBy('name', 'asc')->get();
            $beachBreaks = DB::table('beach_breaks')->orderBy('beach_name', 'asc')->get();
            $language = config('customarray.language');
            $board_type = config('customarray.board_type');
            $accountType = config('customarray.accountType');
            $user = $this->users->getUserDetailByID(Crypt::decrypt($id));
            $states = State::select('id', 'name')->where('country_id',$user->user_profiles->country_id)->orderBy('name','asc')->get();
            $beach = '';
            if($user->user_profiles->local_beach_break_id) {
            $beachData = BeachBreak::where('id',$user->user_profiles->local_beach_break_id)->get()->toArray();
            $beach = $beachData[0]['beach_name'];
        }

        if($user->user_type == 'USER') {
        return view('admin/admin_user/admin_edit_surfer_profile', compact('user', 'countries', 'beachBreaks', 'language', 'accountType', 'postsList', 'states', 'beaches', 'customArray', 'gender_type','board_type','beach'));
            
        } elseif ($user->user_type == 'PHOTOGRAPHER') {
        return view('admin/admin_user/admin_edit_photographer_profile', compact('user', 'countries', 'beachBreaks', 'language', 'accountType', 'postsList', 'states', 'beaches', 'customArray', 'gender_type','beach'));
        
        } elseif ($user->user_type == 'SURFER CAMP') {
        return view('admin/admin_user/admin_edit_resort_profile', compact('user', 'countries', 'beachBreaks', 'language', 'accountType', 'postsList', 'states', 'beaches', 'customArray', 'gender_type','beach'));
        } elseif ($user->user_type == 'ADVERTISEMENT') {
        return view('admin/admin_user/admin_edit_advertiser_profile', compact('user', 'countries', 'beachBreaks', 'language', 'accountType', 'postsList', 'states', 'beaches', 'customArray','states'));
        } 
            
        } catch (\Exception $e){         
            throw ValidationException::withMessages([$e->getMessage()]);
        }
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
        try{
            $data = $request->all();
            $rules = array(
                'profile_photo_name' => ['nullable','image','mimes:jpeg,jpg,png'],            
                'first_name' => ['required', 'string'],
                'last_name' => ['nullable','string'],
            );       
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->users->updateAdminUser($data,Crypt::decrypt($id),$message);
                if($result){
                    return redirect()->route('adminUserListIndex', ['id' => $id])->withSuccess($message);  
                }else{
                    return redirect()->route('adminUserEdit', ['id' => $id])->withErrors($message); 
                }
            }
        }catch (\Exception $e){
            return redirect()->route('adminUserEdit', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage()); 
        }
    }


    /**
     * Activate /Deactivate user.
     *
     * @param  json object  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserStatus(Request $request){
        $data = $request->all();
        $rules = array(
            'id' => ['required'],
            'status' => ['required'] 
        );
        $inputArry = ['id' => $data['user_id'], 'status' => $data['status']];
        $validate = Validator::make($inputArry, $rules);
        if ($validate->fails()) {
            echo json_encode(array('status'=>'failure', 'message'=>'Invalid param.'));
            die;
        } else {
            $result = $this->users->updateUserStatus($inputArry,$message);
            if($result){
                 echo json_encode(array('status'=>'success', 'message'=>$message));
             }else{
                 echo json_encode(array('status'=>'failure', 'message'=>$message));
             }
            die;
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user_id = Crypt::decrypt($id);
        try {
            $user = $this->users->getUserDetailByID($user_id);
            if ( !empty($user) ) {
                $posts = Post::where("user_id", "=", $user_id)->pluck('id');
                Upload::whereIn("post_id", $posts->id)->delete();
                Comment::whereIn("post_id", $posts->id)->delete();
                Notification::where("sender_id", $user_id)->whereOr("receiver_id", $user_id)->delete();
                Rating::whereIn("user_id", $user_id)->get();
                Report::where("user_id", $user_id)->delete();
                SurferRequest::where("user_id", $user_id)->delete();
                $posts->delete();
                $user->delete();
                return redirect()->route('adminUserListIndex')->withSuccess("User deleted successfully!"); 
            } else {
                return redirect()->route('adminUserListIndex')->withErrors("Please try again."); 
            }
        } catch (\Exception $e){
            return redirect()->route('adminUserListIndex')->withErrors($e->getMessage()); 
        }
    }
}