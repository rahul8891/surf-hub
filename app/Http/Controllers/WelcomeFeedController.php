<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
class WelcomeFeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        /**
         * Admin cant access this url
         */
        if(Auth::user()){
            if(\Gate::allows('isAdmin')){
                return Redirect::to('/admin/dashboard/index')->withErrors('sorry admin not allow to access this page');               
            }
        }
        
        
        // return view('welcome', compact('totalUser'));
        return view('welcome');
    }

}
