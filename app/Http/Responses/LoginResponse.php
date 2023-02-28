<?php

namespace App\Http\Responses;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        $redirectRoute = '/';
        $user = Auth::user();
        $checkUserType = config('customarray.userType');
        // dd($checkUserType);
        if (isset($checkUserType[$user->user_type])) {
            if($user->user_type == 'ADMIN') {
                // if user type belongs to ADMIN then redirect to the admin dashboard
                $redirectRoute = config('customarray.adminhome');
            }else{
                // if ($user->user_type == $checkUserType['PHOTOGRAPHER']) {
                //     // if user type belongs to ADMIN then redirect to the admin dashboard
                //     $redirectRoute = config('customarray.photographerhome');
                // }
                // elseif ($user->user_type == $checkUserType['ADVERTISEMENT']) {
                //     // if user type belongs to ADMIN then redirect to the admin dashboard
                //     $redirectRoute = config('customarray.advertiserhome');
                // }
                // elseif ($user->user_type == $checkUserType['SURFER CAMP']) {
                //     // if user type belongs to ADMIN then redirect to the admin dashboard
                //     $redirectRoute = config('customarray.surfercamphome');
                // }
                // else {

                // if user type belongs to USER then redirect to the admin dashboard
                $redirectRoute = config('fortify.home');
                // }
            }
        }else{
            Auth::logout();
            throw ValidationException::withMessages([trans('customErrorMessage.unauthorizedType')]);
        }

        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade
        
        return $request->wantsJson()
                    ? response()->json(['two_factor' => false])
                    : redirect()->intended($redirectRoute);
    }

}