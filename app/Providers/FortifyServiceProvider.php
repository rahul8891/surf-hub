<?php

namespace App\Providers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {      
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        $this->customLoginAuth();       
        $this->sendEmailVerificationMail();
    }

    /**
     * Custom user login check weater active or not 
     */
    public function customLoginAuth(){        
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)
                    ->orWhere('name', $request->email)->first();
            if ($user &&
                Hash::check($request->password, $user->password)) {
                if($user->user_type === config('customarray.userType.ADMIN')){
                    throw ValidationException::withMessages([
                        Fortify::username() => [trans('auth.authAccess')],
                        ]);
                }else{
                    if($user->status === config('customarray.status.ACTIVE')){
                        return $user;                   
                    }elseif($user->status === config('customarray.status.PENDING')){
                        throw ValidationException::withMessages([
                            Fortify::username() => [trans('auth.pending')],
                            ]);
                    }elseif($user->status === config('customarray.status.DEACTIVATED')){
                        throw ValidationException::withMessages([
                            Fortify::username() => [trans('auth.deactivate')],
                            ]);
                    } 
                }
            }
        });
    }

    /**
     * send email verification email to rewgister user
     */
    public function sendEmailVerificationMail(){
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });
    }
}
