<?php
namespace App\Services;

use App\Models\Country;
use App\Models\State;
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

    public function __construct() {
       
        // Country model object
        $this->countries = new Country();

  
        // State model object
        $this->states = new State();
       
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
        return $this->countries->select('id', 'name', 'phone_code')->orderBy('name','asc')->get();
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
        return $this->states->select('id', 'name')->where('country_id',$countryId)->orderBy('name','asc')->get();
    }
}