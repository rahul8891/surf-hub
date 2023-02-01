<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Closure;
use Illuminate\Http\Request;
use Redirect;
class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            if (!Auth::user()){
                return Redirect::to('/login')->withErrors('Sorry, please login to access this page.'); 
            } else {
                $user = Auth::user();
                $checkUserType = config('customarray.userType');
                if (in_array($user->user_type, $checkUserType)) {
                    if($user->user_type == $checkUserType['USER'] || $user->user_type == $checkUserType['PHOTOGRAPHER'] || $user->user_type == $checkUserType['ADVERTISEMENT'] || $user->user_type == $checkUserType['SURFER CAMP']){
                        // return true and allow route to USER
                        return $next($request);
                    }else{
                        return Redirect::to('/admin/dashboard/index')->withErrors('Sorry, You Are Not Authorized to Access User Route'); 
                    }
                }
            }
        }catch (\Exception $e){
            throw ValidationException::withMessages([trans('customErrorMessage.unauthorized')]);
        }  
    }
}