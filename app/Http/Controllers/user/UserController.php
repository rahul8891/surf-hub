<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Traits\PasswordTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;
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
            'phone' => ['required', 'numeric'],
            'language' => ['required', 'string'],
            'country_id' => ['required', 'numeric'],
            'account_type' => ['required', 'string'],           
            'local_beach_break' => ['required', 'numeric'],           
        ])->validate();
        
        $result = $this->users->updateUserProfile($data,$message);        
        if($result){
            return Redirect::to('user/profile')->withSuccess($message);
        }else{           
           return Redirect::to('user/profile')->withErrors($message);
        }
    }
    
    public function updateProfileImage(Request $request){
        $data = $request->all();       
        $rules = array(          
            'image' => ['required'] 
        );
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
        $string = $data['searchTerm'];
        if(!empty($string)){
            $field = ['beach_name','break_name','city_region','state','country'];
            $resultData = DB::Table('beach_breaks')->Where(function ($query) use($string, $field) {
                for ($i = 0; $i < count($field); $i++){             
                    $query->orWhere($field[$i], 'LIKE',  '%' . $string .'%');
                }      
            })->get(); 
        
            $returnObject = '';
            if(!$resultData->isEmpty()){
                
                $returnObject = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($resultData as $key => $value) {
                    $first = ($value->beach_name) ? $value->beach_name.',' : '';
                    $val = $first.$value->break_name.','.$value->city_region.','.$value->state.','.$value->country;             
                    $returnObject .= '<li class="list-group-item" data-id="'.$value->id.'">'.$val.'</li>';
                }
                $returnObject .='</ul>';
                /*foreach ($resultData as $key => $value) {
                    $myArray['id'] = $value->id;
                    $first = ($value->beach_name) ? $value->beach_name.',' : '';
                    $myArray['value'] = $first.$value->break_name.','.$value->city_region.','.$value->state.','.$value->country;
                    $returnObject[] = $myArray;
                }*/
                return response()->json($returnObject);       
            }else{               
                return response()->json($returnObject); 
            }
        }
    }   

}