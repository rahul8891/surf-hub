<?php

namespace App\Http\Controllers\user;

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
use App\Models\Post;
use Carbon\Carbon;
use Closure;
use Redirect;
use Session;

class UserPostController extends Controller
{
    use PasswordTrait;
    /**
     * The user sevices implementation.
     *
     * @var AdminUserService
     */
    protected $posts;

    Protected $masterService;

    public $language;

    public $accountType;

    /**
     * Create a new controller instance.
     *
     * @param  AdminUserService  $users
     * @return void
     */
    public function __construct(PostService $posts,AdminUserService $users,MasterService $masterService)
    {
        $this->posts = $posts;
        $this->users = $users;
        $this->masterService = $masterService;
        $this->customArray = config('customarray');
        $this->language = config('customarray.language'); 
        $this->accountType = config('customarray.accountType');
        $this->post_type = config('customarray.post_type');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
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
        try{
            $data = $request->all();   
            $imageArray=$request->file('files');
            $videoArray=$request->file('videos');
            $rules = array(
                'post_type' => ['required'],
                'user_id' => ['required','numeric'],
                'post_text' => ['nullable', 'string', 'max:255'],
                'surf_date' => ['required', 'string'],
                'wave_size' => ['required', 'string'],
                'state_id' => ['nullable', 'numeric'],
                'board_type' => ['required', 'string'],
                'surfer' => ['required'],
                'country_id' => ['required','numeric'],
                'local_beach_break_id' => ['nullable', 'string'],
                'optional_info'=>['nullable'],
            );       
            $validate = Validator::make($data, $rules);          
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return response()->json(['error'=>$validate->errors()]);     
            }else {
                $result = $this->posts->savePost($data,$imageArray,$videoArray,$message);
                if($result){  
                    return Redirect::to('dashboard')->withSuccess($message);
                }else{
                    return Redirect::to('dashboard')->withErrors($message);
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
        try{
            $result = $this->posts->deletePost(Crypt::decrypt($id),$message);
            if($result){
                return redirect()->route('myhub')->withSuccess($message);  
            }else{
                return redirect()->route('myhub')->withErrors($message); 
            }
        }catch (\Exception $e){
            return redirect()->route('myhub', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage());
        }
    }

    /**
     * Move post to the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveToMyHub($id)
    {
        try{
            $result = $this->posts->saveToMyHub(Crypt::decrypt($id),$message);
            if($result){
                return redirect()->route('dashboard')->withSuccess($message);  
            }else{
                return redirect()->route('dashboard')->withErrors($message); 
            }
        }catch (\Exception $e){
            return redirect()->route('dashboard', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage());
        }
    }
}