<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        $redirectRoute = '/';
        $user = Auth::user();
        $checkUserType = config('customarray.userType');
        if (in_array($user->user_type, $checkUserType)) {
            if($user->user_type == $checkUserType['ADMIN']){
                // if user type belongs to ADMIN then redirect to the admin dashboard
                $redirectRoute = config('customarray.adminhome');
            }else{
                // if user type belongs to USER then redirect to the admin dashboard
                $redirectRoute = config('fortify.home');
            }
        }

        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade
        
        return $request->wantsJson()
                    ? response()->json(['two_factor' => false])
                    : redirect()->intended($redirectRoute);
    }

}