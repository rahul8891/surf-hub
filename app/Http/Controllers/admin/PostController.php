<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
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
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Upload;
use Closure;
use Redirect;
use Session;

class PostController extends Controller
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
        $posts = $this->posts->getAllPostsListing();
        $spiner = ($posts) ? true : false;
        return view('admin/post/index', compact('posts','spiner'));     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $language = $this->language;
        $users=User::all();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;   
        return view('admin/post/create', compact('users','countries','currentUserCountryId','customArray','language','states'));
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
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->posts->savePost($data,$imageArray,$videoArray,$message);
                if($result){  
                    return redirect()->route('postIndex')->withSuccess($message);
                }else{
                    return redirect()->route('postCreate')->withErrors($message);
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
        $post=Post::findOrFail(Crypt::decrypt($id));
        $postMedia=Upload::where('post_id',Crypt::decrypt($id))->get();
            $spiner = ($post) ? true : false;
        }catch (\Exception $e){ 
            throw ValidationException::withMessages([$e->getMessage()]);
        }
        return view('admin/post/show', compact('post','postMedia','spiner'));  
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
            $currentUserCountryId = Auth::user()->user_profiles->country_id;    
            $countries = $this->masterService->getCountries();
            $language = $this->language;
            $users = $this->users->getUsersListing();
            $customArray = $this->customArray;  
            $posts = Post::findOrFail(Crypt::decrypt($id));
            $states = $this->masterService->getStateByCountryId($posts->country_id);
            $postMedia=Upload::where('post_id',Crypt::decrypt($id))->get();
            $spiner = ($this->posts) ? true : false;
        }catch (\Exception $e){         
            throw ValidationException::withMessages([$e->getMessage()]);
        }
        
        return view('admin/post/edit', compact('users','countries','postMedia','posts','currentUserCountryId','customArray','language','states'));
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
        $id=Crypt::decrypt($id);
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
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->posts->updatePost($data,$imageArray,$videoArray,$id,$message);
                if($result){
                    return redirect()->route('postDetail', ['id' => Crypt::encrypt($id)])->withSuccess($message);
                }else{
                    return redirect()->route('postEdit', ['id' => Crypt::encrypt($id)])->withErrors($message); 
                }
            }
        }catch (\Exception $e){
                
            return redirect()->route('postEdit', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage()); 
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
        try{
            $result = $this->posts->deletePost(Crypt::decrypt($id),$message);
            if($result){
                return redirect()->route('postIndex')->withSuccess($message);  
            }else{
                return redirect()->route('postIndex')->withErrors($message); 
            }
        }catch (\Exception $e){
            return redirect()->route('postIndex', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage());
        }

    }
    
    /**
     * Update feed status of the post.
     *
     * @param  int  $id & $status
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        $post->is_feed = $request->status;
        if ($post->save()) {
            return response()->json(['statuscode' => 200, 'status' => true, 'message' =>  "Feed status updated successfully.", 'data' => $post], 200);
        } else {
            return response()->json(['statuscode' => 400, 'status' => false, 'message' =>  "Something went wrong. Please try later."], 400);
        }
    }
    
}