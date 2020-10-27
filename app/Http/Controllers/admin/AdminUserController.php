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
use App\Traits\PasswordTrait;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Redirect;
use Session;


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
    public function __construct(AdminUserService $users,MasterService $masterService)
    {
        $this->users = $users;
        $this->masterService = $masterService;
        $this->language = config('customarray.language'); 
        $this->accountType = config('customarray.accountType');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->users->getUsersListing();
        $spiner = ($users) ? true : false;
        return view('admin/admin_user.index', compact('users','spiner'));     
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
        return view('admin/admin_user.create', compact('countries','language','accountType'));
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
                'first_name' => ['required', 'string'],
                'last_name' => ['nullable','string'],
                'name' => ['required', 'string', 'max:255','unique:users','alpha_dash'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['nullable','numeric','digits:10'],
                'account_type'=>['required','string'],
                'language' => ['required','string'],
                'country_id' => ['required','numeric'],
                'profile_photo_name' => ['nullable','image','mimes:jpeg,jpg,png'],
                'terms' => ['required'],
                'password' => $this->passwordRules(),
            );       
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->users->saveAdminUser($data,$message);
                if($result){  
                    return Redirect::to('admin/users/create')->withSuccess($message);
                }else{
                    return Redirect::to('admin/users/create')->withErrors($message);
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
        return view('admin/admin_user.show', compact('users','spiner'));  
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
            $users = new User();
            $countries = $this->masterService->getCountries();
            $language = $this->language;
            $accountType = $this->accountType;
            $users = $users::findOrFail(Crypt::decrypt($id));
            $spiner = ($users) ? true : false;
        }catch (\Exception $e){         
            throw ValidationException::withMessages([$e->getMessage()]);
        }
        
        return view('admin/admin_user.edit', compact('users','countries','language','accountType','spiner'));
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
        // $id = Crypt::decrypt($id);
        // return redirect()->route('adminUserEdit', ['id' => $id])->withSuccess('welcoem');       
        try{
            $data = $request->all();
            $rules = array(
                'first_name' => ['required', 'string'],
                'last_name' => ['nullable','string'],
                'name' => ['required', 'string','alpha_dash'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone' => ['nullable','numeric','digits:10'],
                'account_type'=>['required','string'],
                'language' => ['required','string'],
                'country_id' => ['required','numeric'],
                'profile_photo_name' => ['nullable','image','mimes:jpeg,jpg,png'],               
            );       
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->users->updateAdminUser($data,$message);
                if($result){
                    return redirect()->route('adminUserEdit', ['id' => $id])->withSuccess($message);  
                }else{
                    return redirect()->route('adminUserEdit', ['id' => $id])->withErrors($message); 
                }
            }
        }catch (\Exception $e){
            throw ValidationException::withMessages([$e->getMessage()]);
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
    public function destroy($id)
    {
        //
    }
}