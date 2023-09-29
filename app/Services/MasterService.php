<?php
namespace App\Services;

use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Models\BeachBreak;
use App\Models\UserFollow;
use App\Models\UserProfile;
use App\Models\SpotifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Storage;
use DB;

class MasterService {

    /**
     * Create a new Service instance.
     *
     * @return void
     */
    protected $countries;

    protected $states;

    protected $users;

    protected $beach_break;

    protected $user_follow;

    public function __construct() {

        // Country model object
        $this->countries = new Country();

        // State model object
        $this->states = new State();

        // User model object
        $this->users = new User();

        // Beach break model object
        $this->beach_break = new BeachBreak();

        // User Follow model object
        $this->user_follow = new UserFollow();

        // get custom config file
        $this->checkUserType = config('customarray');
    }

    /**
     * [getCountries] we are getiing all the countries
     * @param
     * @param
     * @return dataArray
     */
    public function getCountries(){
        return $this->countries->select('id', 'name','phone_code')->orderBy('name','asc')->get();
    }

    /**
     * [getCountryByName] we are getiing all the states based on the country id
     * @param $countryId
     * @return dataArray
     */
    public function getCountryByName($name){
        if(isset($countryId) && !empty($countryId)) {
            return $this->countries->select('id', 'name')->where('name',$name)->first();
        } else {
            return false;
        }
    }


    /**
     * [getStates] we are getiing all the states
     * @param
     * @param
     * @return dataArray
     */
    public function getStates(){
        return $this->states->select('id', 'name')->orderBy('name','asc')->get();
    }

    /**
     * [getStateByCountryId] we are getiing all the states based on the country id
     * @param $countryId
     * @return dataArray
     */
    public function getStateByCountryId($countryId){
        if(isset($countryId) && !empty($countryId)) {
            return $this->states->select('id', 'name')->where('country_id',$countryId)->orderBy('name','asc')->get();
        } else {
            return $this->states->select('id', 'name')->orderBy('name','asc')->get();
        }
    }
    public function getBeachById($beach_id){
        if(isset($beach_id) && !empty($beach_id)) {
            return $this->beach_break->select('id', 'beach_name')->where('id',$beach_id)->orderBy('beach_name','asc')->get()->toArray();
        } else {
            return $this->beach_break->select('id', 'beach_name')->orderBy('beach_name','asc')->get()->toArray();
        }
    }
    public function getBeaches(){
            return $this->beach_break->select('id', 'beach_name')->groupBy('beach_name')->orderBy('beach_name','asc')->get()->toArray();
    }
    public function getBreakByBeachName($beach_name){
        if(isset($beach_name) && !empty($beach_name)) {
            return $this->beach_break->select('id', 'break_name')->where('beach_name',$beach_name)->orderBy('break_name','asc')->get();
        } else {
            return $this->beach_break->select('id', 'break_name')->orderBy('break_name','asc')->get();
        }
    }
    public function getBreakByBeachId($beach_id){
        if(isset($beach_id) && !empty($beach_id)) {
            return $this->beach_break->select('id', 'break_name')->where('id',$beach_id)->orderBy('break_name','asc')->get();
        } else {
            return $this->beach_break->select('id', 'break_name')->orderBy('break_name','asc')->get();
        }
    }

    /**
     * [getAllUsers] we are getiing all the users
     * @param
     * @param
     * @return dataArray
     */
    public function getAllUsers(){
        $users = $this->users->where('status',$this->checkUserType['status']['ACTIVE'])
                    ->where('is_deleted','0')
                    ->where('user_type',$this->checkUserType['userType']['USER'])
                    ->orderBy('id','asc')->get();

        return $users;
    }
    public function getSpotifyTrack() {
        $arr = [];
        $trackArray['track_uri'] = '';
        $spotifyUser = SpotifyUser::where('user_id', Auth::user()->id)->get()->toArray();
        if ($spotifyUser) {
            $client = new \GuzzleHttp\Client;

            // get new access token in case if old is expire
            $getToken = $client->post('https://accounts.spotify.com/api/token', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . base64_encode(env('SPOTIFY_CLIENT_ID') . ':' . env('SPOTIFY_CLIENT_SECRET'))
                ],
                'form_params' => [
                    'refresh_token' => $spotifyUser[0]['refresh_token'],
                    'grant_type' => 'refresh_token'
                ]
            ]);

            $tokenArr = json_decode($getToken->getBody(), true);
            $token = $tokenArr['access_token'];

            // get tracks of the user
            $response = $client->get('https://api.spotify.com/v1/me/top/tracks', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer " . $token,
                ],
            ]);
            $top_user_tracks = json_decode($response->getBody(), true);

            $counter = 0;
            foreach ($top_user_tracks['items'] as $track) {
                $trackArray = $track['uri'];
                $counter++;
            }

            $arr ['token'] = $token;
            $arr ['track_uri'] = $trackArray;
        }

        return $arr;
    }

    public function getBeachNameLike($beach_name){
        if(isset($beach_name) && !empty($beach_name)) {
            $beach_lists = DB::table('beach_breaks')->select('id', 'beach_name')->where('beach_name', 'like', '%'.$beach_name.'%')->orderBy('break_name','asc')->get();

            $result = '';
            if (!$beach_lists->isEmpty()) {

                $result = '<ul class="list-group" style="display: block; position: absolute; z-index: 1"  >';
                $dupArr = [];
                foreach ($beach_lists as $key => $value) {
                    if (!in_array($value->beach_name, $dupArr)) {
                        $dupArr[] = $value->beach_name;
                        $val = ($value->beach_name) ? $value->beach_name : '';
                        $result .= '<li class="list-group-item" data-id="' . $value->id . '">' . $val . '</li>';
                    }
                }
                $result .= '</ul>';
                return $result;
            }
        }
    }
}
