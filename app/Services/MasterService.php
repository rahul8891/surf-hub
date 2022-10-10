<?php
namespace App\Services;

use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Models\BeachBreak;
use App\Models\UserProfile;
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

    public function __construct() {
       
        // Country model object
        $this->countries = new Country();

  
        // State model object
        $this->states = new State();

        // User model object
        $this->users = new User();
       
        // Beach break model object
        $this->beach_break = new BeachBreak();
       
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
                    //->whereNotIn('id',[Auth::user()->id])
                    ->orderBy('id','asc')->get();

        return $users;
    }
}