<?php

use Illuminate\Support\Facades\Auth;
use App\Models\SpotifyUser;

class SpotifyUserAuth {
    /*public function __construct(UserService $users)
    {
        $this->users = $users;       
    }*/
   

    function getSpotifyUser() {
        $spotifyUser = SpotifyUser::where('user_id',Auth::user()->id)->get()->toArray();
        return $spotifyUser;
    }

     public static function instance()
     {
         return new SpotifyUserAuth();
     }
}