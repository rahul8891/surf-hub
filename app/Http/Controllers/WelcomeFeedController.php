<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendMail;
use App\Services\MasterService;
use App\Services\UserService;
use App\Services\PostService;
use Carbon\Carbon;

class WelcomeFeedController extends Controller
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

    /**
     * The home/welcome page for users
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        /**
         * Admin cant access this url
         */
        if (Auth::user()) {
            if (!Gate::allows('isUser')) {
                // admin not allow to access this page
                return Redirect::to('/admin/dashboard/index')->withErrors('Sorry, You Are Not Authorized to Access This Page');
            }else{
                
                // return Logged-in user to dashbord
                return Redirect::to('/dashboard');
            }
        }
        $customArray = $this->customArray;
        // non logged in user redirect to home page
        $postsList = $this->postService->getPostsListing();
        
        return view('welcome',compact('customArray','postsList'));
    }

    public function privacy(){
        $pages = new Page();
        $pages = $pages->where('alias','privacy')->first();      
        return view('static-pages.privacy',compact('pages'));
    }

    public function terms(){
        $pages = new Page();
        $pages = $pages->where('alias','terms')->first();      
        return view('static-pages.terms',compact('pages'));
    }


    public function faq(){
        $pages = new Page();
        $pages = $pages->where('alias','help')->first();      
        return view('static-pages.faq',compact('pages'));
    }


    public function contact(){
        return view('static-pages.contact');
    }
    
    public function query_submit(Request $request){
        
        $input= $request->all();
        $rules = array (
                'name' => ['required','string','min:3'],
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
                'subject' => ['required', 'string', 'max:50'],
                'description' => ['required', 'string'],
        );

        $validator = Validator::make($input, $rules);

        
        if($validator -> passes()){
            $data=array(
                'name'=>$request->name,
                'email'=>$request->email,
                'subject'=>$request->subject,
                'description'=>$request->description,
                );

            Mail::to('Sharma.shubham@evontech.com')
            ->cc('shubh@yopmail.com')
            ->send(new sendMail($data));

            return redirect()->back()->with('success','Thanks for Contacting Us, Feedback Submitted!');
        } else {
            return redirect()->back()->with('error','Thanks for Contacting Us but for now Feedback is not Submitted!');
        }
    }
}