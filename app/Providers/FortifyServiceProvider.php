<?php

namespace App\Providers;
use App\Models\User;
use App\Models\State;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\View;
use DB;
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
        $this->createUsersUsing();
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
                    ->orWhere('user_name', $request->email)->first();                   
            if ($user &&
                Hash::check($request->password, $user->password)) {
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

    /**
     * Customize the user register page    
     * @return object
     */
    public function createUsersUsing(){
        Fortify::registerView(function () {
            $terms = DB::table('pages')->select('id', 'title','body')->where('alias','terms')->first();
            $countries = DB::table('countries')->select('id', 'name','phone_code')->orderBy('name','asc')->get();           
            $beachBreaks = DB::table('beach_breaks')->orderBy('beach_name','asc')->get();
            $language = config('customarray.language'); 
            $accountType = config('customarray.accountType');  
            $board_type = config('customarray.board_type');
            $gender_type = config('customarray.gender_type');
            $states = State::select('id', 'name')->where('country_id',1)->orderBy('name','asc')->get();
            return view('auth.register', compact('countries','language','accountType','terms','beachBreaks','board_type','states','gender_type'));
        });
    }
    
}