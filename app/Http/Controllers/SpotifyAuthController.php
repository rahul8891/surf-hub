<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\SpotifyUser;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SpotifyAuthController extends Controller
{
    public function redirectToProvider()
{
    return Socialite::driver('spotify')->scopes(['user-read-email user-read-private app-remote-control user-top-read user-read-currently-playing user-read-recently-played streaming app-remote-control user-read-playback-state user-modify-playback-state'])->redirect();
}

public function handleProviderCallback()
{
    $user = Socialite::driver('spotify')->user();
    // echo '<pre>';    print_r($user);die;
    if(!$user) {
            $SpotifyUser =  new SpotifyUser();
            $SpotifyUser->user_id = Auth::user()->id;
            $SpotifyUser->spotify_user_id = $user->id;
            $SpotifyUser->token = $user->token;
            $SpotifyUser->refresh_token = $user->refreshToken;
            $SpotifyUser->created_at = Carbon::now();
            $SpotifyUser->updated_at = Carbon::now();
            //dd($this->comments);
            $SpotifyUser->save();
        } else {
            $SpotifyUser = $user;
        }
            return redirect()->intended('dashboard');
   
    
    // $user->token;
}
}
