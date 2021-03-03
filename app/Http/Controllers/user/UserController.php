<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Traits\PasswordTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Tag;
// use App\Http\Controllers\user\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\RequestGuard;
use Illuminate\Support\Facades\DB;
use App\Services\UserService;
use Redirect;

class UserController extends Controller
{
    use PasswordTrait;
    

    /**
     * Create a new controller instance.
     *
     * @param  UserService  $users
     * @return void
     */
    public function __construct(UserService $users)
    {
        $this->users = $users;    
        $this->common = config('customarray.common');   
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

    public function showChangePassword(){      
        return view('user.change-password');
    }

    /**
     * Show User Profile Page
     */
    public function showProfile(){
        $countries = DB::table('countries')->select('id', 'name','phone_code')->orderBy('name','asc')->get();
        $beachBreaks = DB::table('beach_breaks')->orderBy('beach_name','asc')->get();
        $language = config('customarray.language'); 
        $accountType = config('customarray.accountType');         
        $user = $this->users->getUserDetailByID(Auth::user()->id);       
        return view('user.profile',compact('user','countries','beachBreaks','language','accountType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request    
     * @return \Illuminate\Http\Response
     */
    public function storeProfile(Request $request){
        $data = $request->all();
        Validator::make($data, [
            'first_name' => ['required','min:3','string'],
            'last_name' => ['required','min:3','string'],
            'user_name' => ['required', 'string','min:5','alpha_dash'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
            'phone' => ['required'],
            'language' => ['required', 'string'],
            'country_id' => ['required', 'numeric'],
            'account_type' => ['required', 'string'],           
            'local_beach_break' => ['required', 'string'],         
        ])->validate();
        
        $result = $this->users->updateUserProfile($data,$message);        
        if($result){
            return Redirect::to('dashboard')->withSuccess($message);
        }else{           
           return Redirect::to('user/profile')->withErrors($message);
        }
    }
    
    public function updateProfileImage(Request $request){
        $data = $request->all();
        $rules = array(          
            'image' => ['required'] 
        );
       // dd($data);
        $inputArry = ['image' => $data['image']];
        $validate = Validator::make($inputArry, $rules);
        if ($validate->fails()) {
            echo json_encode(array('status'=>'failure', 'message'=>'Invalid Image.'));
            die;
        } else {
            $result = $this->users->updateUserProfileImage($data,$message);
            if($result){
                echo json_encode(array('status'=>'success', 'message'=>$message));
            }else{
                echo json_encode(array('status'=>'failure', 'message'=>$message));
            }
            die;
        }
    }

    // https://www.codechief.org/article/autocomplete-search-with-laravel-jquery-and-ajax
    public function getBeachBreach(Request $request){
        $data = $request->all();   
        $searchTerm = $data['searchTerm'];      
        if(!empty($searchTerm)){
            $searchTerm = explode(",",$searchTerm);
            $string = $searchTerm['0'];        
            $field = ['beach_name','break_name','city_region','state','country'];
            $resultData = DB::Table('beach_breaks')->Where(function ($query) use($string, $field) {
                for ($i = 0; $i < count($field); $i++){             
                    $query->orWhere($field[$i], 'LIKE',  '%' . $string .'%');
                }      
            })->get(); 
           
            $returnObject = '';
            if(!$resultData->isEmpty()){
                
                $returnObject = '<ul class="list-group" style="display: block; position: absolute; z-index: 1">';
                foreach ($resultData as $key => $value) {
                    $first = ($value->beach_name) ? $value->beach_name.',' : '';
                    $val = $first.$value->break_name.','.$value->city_region.','.$value->state.','.$value->country;             
                    $returnObject .= '<li class="list-group-item" data-id="'.$value->id.'">'.$val.'</li>';
                }
                $returnObject .='</ul>';              
                return response()->json($returnObject);       
            }else{               
                return response()->json($returnObject); 
            }
        }
    }   


    public function getUsers(Request $request){
        $data = $request->all();   
        $searchTerm = $data['searchTerm'];      
        if(!empty($searchTerm)){
            $searchTerm = explode(",",$searchTerm);
            $string = $searchTerm['0'];        
            $field = ['user_name'];
            $resultData = DB::Table('users')->Where(function ($query) use($string, $field) {
                for ($i = 0; $i < count($field); $i++){             
                    $query->orWhere($field[$i], 'LIKE',  '%' . $string .'%');
                }      
            })->get(); 
           
            $returnObject = '';
            if(!$resultData->isEmpty()){
                $returnObject = '<ul class="list-group" style="display: block; position: absolute; z-index: 1; width:100%">';
                foreach ($resultData as $key => $value) {
                    $val = $value->user_name;     
                    $img = (!empty($value->profile_photo_path)) ? "/storage/$value->profile_photo_path" : '/img/img_4.jpg';
                    $returnObject .= '<li class="list-group-item" data-id="'.$value->id.'">
                    <img src="'.$img.'" width="30px" style="float:right; border-radius: 50%; border: 1px solid #4c8df5;" class="img-fluid">'.$val.'
                    </li>';
                }
                $returnObject .='</ul>';     
                return response()->json($returnObject);       
            }else{               
                return response()->json($returnObject); 
            }
        }
    }   

    public function getTagUsers(Request $request){
        $data = $request->all();   
        $searchTerm = $data['searchTerm'];      
        if(!empty($searchTerm)){
            $searchTerm = explode(",",$searchTerm);
            $string = $searchTerm['0'];        
            $fieldFirstName = 'first_name';
            $fieldLastName = 'last_name';
            //get users list for tagging
            $resultData = $this->users->getUsersForTagging($string, $fieldFirstName, $fieldLastName);
            
            $returnObject = '';
            if(!$resultData->isEmpty()){
                $returnObject = '<ul class="list-group" style="display: block; position: absolute; z-index: 1; width:100%">';
                foreach ($resultData as $key => $value) {
                    $val = ucfirst($value->first_name).' '.ucfirst($value->last_name);   
                    
                    $requestData = ['post_id'=>$data['post_id'], 'user_id'=>$value->user_id];
                    //Check if already tagged not come in user list
                    $responceResult = $this->users->checkAlreadyTagged($requestData);
                    if(!$responceResult){
                        $img = (!empty($value->user->profile_photo_path)) ? "/storage/".$value->user->profile_photo_path : '/img/img_4.jpg';
                        $returnObject .= '<li class="list-group-item tagUserInPost" style="color: #4c8df5;" data-id="'.$value->user_id.'" data-post_id="'.$data['post_id'].'" id="rowId'.$value->user_id.'">
                        <img src="'.$img.'" width="30px" style="float:right; border-radius: 50%; border: 1px solid #4c8df5; bottom: 5px;" class="img-fluid">'.$val.'
                        </li>';
                    }
                }
                $returnObject .='</ul>';     
                return response()->json($returnObject);       
            }else{               
                return response()->json($returnObject); 
            }
        }
    }

    public function setTagUsers(Request $request)
    {
        $data = $request->all();
        //dd($data);
        //check if user already tagged
        $result = $this->users->checkAlreadyTagged($data);
        //dd($result->user);
        if($result){
            //user already tagged
            return json_encode(array('status'=>'failure', 'message'=>$result->user->user_name.' '.'already tagged for this post.' ));
        }else{
            $result = $this->users->tagUserOnPost($data);
            $responceResult = $this->users->getAllTaggedUsers($data);
            // dd($responceResult[0]->user);
            // dd($responceResult[0]->user->user_profiles);
            $returnObject = '';
            foreach ($responceResult as $key => $value) {
                $val = ucfirst($value->user->user_profiles->first_name).' '.ucfirst($value->user->user_profiles->last_name);
                $img = (!empty($value->user->profile_photo_path)) ? "/storage/".$value->user->profile_photo_path : '';
                $returnObject .='<div class="post-head"><div class="userDetail"><div class="imgWrap">';
                if($value->user->profile_photo_path){
                    $returnObject .='<img src="'.$img.'" class="taggedUserImg" alt="">';
                }else{
                    $returnObject .='<div class="taggedUserImg no-image">'.ucwords(substr($value->user->user_profiles->first_name,0,1)).''.ucwords(substr($value->user->user_profiles->last_name,0,1)).'</div>';
                }
                $returnObject .='</div><span class="userName">'.$val.'</span></div></div>';
            }
            return json_encode(array('status'=>'success','responsData'=>$returnObject));
        }
    }

    public function followRequests()
    {
        $followRequests = $this->users->followRequests();
        $common = $this->common;  
        return view('user.followRequests',compact('followRequests','common'));
    }

    public function followers()
    {
        $followers = $this->users->followers();   
        $common = $this->common;    
        return view('user.followers',compact('followers','common'));
    }

    public function following()
    {
        $following = $this->users->following();   
        $common = $this->common;    
        return view('user.following',compact('following','common'));
    }

    public function unfollow(Request $request)
    {
        $data = $request->all();
        $result = $this->users->updateFollowStatus($data,$message,'follower_user_id');
        if($result){
             echo json_encode(array('status'=>$result['status'], 'message'=>$result['message'], 'count'=>$result['count']));
         }else{
             echo json_encode(array('status'=>$result['status'], 'message'=>$result['message'], 'count'=>$result['count']));
         }
    }

    public function accept(Request $request)
    {
        $data = $request->all();
        $result = $this->users->updateAcceptStatus($data,$message,'followed_user_id');
        if($result){
             echo json_encode(array('status'=>$result['status'], 'message'=>$result['message'], 'count'=>$result['count']));
         }else{
             echo json_encode(array('status'=>$result['status'], 'message'=>$result['message'], 'count'=>$result['count']));
         }
    }

    public function reject(Request $request)
    {
        $data = $request->all();
        $result = $this->users->updateRejectStatus($data,$message,'followed_user_id');
        if($result){
             echo json_encode(array('status'=>$result['status'], 'message'=>$result['message'], 'count'=>$result['count']));
         }else{
             echo json_encode(array('status'=>$result['status'], 'message'=>$result['message'], 'count'=>$result['count']));
         }
    }

    public function remove(Request $request)
    {
        $data = $request->all();
        $result = $this->users->updateRemoveStatus($data,$message,'followed_user_id');
        if($result){
             echo json_encode(array('status'=>$result['status'], 'message'=>$result['message'], 'count'=>$result['count']));
         }else{
             echo json_encode(array('status'=>$result['status'], 'message'=>$result['message'], 'count'=>$result['count']));
         }
    }

    public function follow(Request $request)
    {
        $data = $request->all();
        $result = $this->users->followToFollower($data,$message);
        if($result){
             echo json_encode(array('status'=>$result['status'], 'message'=>$result['message']));
         }else{
             echo json_encode(array('status'=>$result['status'], 'message'=>$result['message']));
         }
    }

    public function checkUsername(Request $request)
    {

        $data = $request->all(); // This will get all the request data.
        $userCount = $this->users->checkUsername($data);
        if ($userCount > 0) {
            return 'false';
        } else {
            return 'true';
        }

    }

}