<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Closure;
use Illuminate\Http\Request;
use Redirect;

class CommonMiddleware
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
            $user = Auth::user();
            $checkUserType = config('customarray.userType');
            if (in_array($user->user_type, $checkUserType)) {
                return $next($request);
            } else {
                return Redirect::to('/dashboard')->withErrors('Sorry, You Are Not Authorized to Access Administrator Route');
            }
        }catch (\Exception $e){           
            throw ValidationException::withMessages([trans('customErrorMessage.unauthorized')]);
        }       
    }
}