<?php
namespace App\Services;

use App\Models\Country;
use App\Models\State;
use App\Models\User;
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

    public function __construct() {
       
        // Country model object
        $this->countries = new Country();

  
        // State model object
        $this->states = new State();

        // User model object
        $this->users = new User();
       
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