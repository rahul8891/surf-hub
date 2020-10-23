<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Page;

class WelcomeFeedController extends Controller
{
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
        
        // non logged in user redirect to home page
        return view('welcome');
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
    
}