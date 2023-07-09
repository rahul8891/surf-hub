<?php

namespace App\Http\Controllers\admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;
use App\Services\AdminUserService;
use App\Services\MasterService;
use App\Traits\PasswordTrait;
use App\Models\User;
use App\Models\BeachBreak;
use Carbon\Carbon;
use Closure;
use Redirect;
use Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BeachBreakController extends Controller
{   
    use PasswordTrait;
    /**
     * The user sevices implementation.
     *
     * @var AdminUserService
     */
    protected $users;

    Protected $masterService;

    public $language;

    public $accountType;

    /**
     * Create a new controller instance.
     *
     * @param  AdminUserService  $users
     * @return void
     */
    public function __construct(AdminUserService $users,MasterService $masterService)
    {
        $this->users = $users;
        $this->masterService = $masterService;
        $this->language = config('customarray.language'); 
        $this->accountType = config('customarray.accountType');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $currentUserCountryId = (isset(Auth::user()->user_profiles->country_id) && !empty(Auth::user()->user_profiles->country_id))?Auth::user()->user_profiles->country_id:'';      
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $gender_type = config('customarray.gender_type');
        $beach_break = $this->users->getBeachBreakListing($params);
        // dd($beach_break);
        $spiner = ($beach_break) ? true : false;
        return view('admin/beach_break/index', compact('beach_break','spiner','countries','states','gender_type'));     
    }
    

    /**
     * Display a Beach Break Detail of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBeachBreakDetail($id)
    {
        $beach_break = BeachBreak::where('id', $id)->get()->toArray();
//        dd($beach_break);
        $view = view('admin/beach_break/beach_break_data', compact('beach_break','id'))->render();
        return response()->json(['html' => $view]);  
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        try{
            $data = $request->all();
            $rules = array(
                'beach_name' => ['required', 'string'],
                'break_name' => ['required','string'],
                'city_region' => ['required','string'],
                'state' => ['required','string'],
                'country' => ['required','string'],
                'longitude' => ['required'],
                'latitude' => ['required'],
            );
            
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->users->saveBeachBreak($data,$message);
                if($result){  
                    return Redirect::to('admin/breachbreak/index')->withSuccess($message);
                }else{
                    return Redirect::to('admin/breachbreak/index')->withErrors($message);
                }
            }
        }catch (\Exception $e){ 
            throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
        }
        
    }
    /**
     * importBeachBreak a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importBeachBreak(Request $request)
    {    
        
        try{
            $reqdata = $request->all();
            $file = $request->file('excel_file');
//            dd($file);
            $rules = array(
//                'beach_name' => ['required', 'string'],
//                'break_name' => ['required','string'],
//                'city_region' => ['required','string'],
//                'state' => ['required','string'],
//                'country' => ['required','string'],
//                'longitude' => ['required'],
//                'latitude' => ['required'],
            );
            
            $validate = Validator::make($reqdata, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                
           $spreadsheet = IOFactory::load($file->getRealPath());
           $sheet        = $spreadsheet->getActiveSheet();
           $row_limit    = $sheet->getHighestDataRow();
           $column_limit = $sheet->getHighestDataColumn();
           $row_range    = range( 2, $row_limit );
           $column_range = range( 'F', $column_limit );
           $data = array();
           foreach ( $row_range as $row ) {
               $data[] = [
                   'beach_name' =>$sheet->getCell( 'A' . $row )->getValue(),
                   'break_name' =>$sheet->getCell( 'B' . $row )->getValue(),
                   'city_region' =>$sheet->getCell( 'C' . $row )->getValue(),
                   'country' =>$sheet->getCell( 'D' . $row )->getValue(),
                   'state' =>$sheet->getCell( 'E' . $row )->getValue(),
                   'latitude' =>$sheet->getCell( 'F' . $row )->getValue(),
                   'longitude' =>$sheet->getCell( 'G' . $row )->getValue()
               ];
           }
       
            $result = $this->users->importBeachBreak($data,$message);
            return json_encode(array('status' => 'success', 'responsData' => $result));    
            }
        }catch (\Exception $e){ 
            throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
        }
        
    }
    
    /**
     * update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {    
        try{
            $data = $request->all();
            $rules = array(
                'beach_name' => ['required', 'string'],
                'break_name' => ['required','string'],
                'city_region' => ['required','string'],
                'state' => ['required','string'],
                'country' => ['required','string'],
                'longitude' => ['required'],
                'latitude' => ['required'],
            );
            
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->users->updateBeachBreak($data,$message);
                if($result){  
                    return Redirect::to('admin/breachbreak/index')->withSuccess($message);
                }else{
                    return Redirect::to('admin/breachbreak/index')->withErrors($message);
                }
            }
        }catch (\Exception $e){ 
            throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
        }
        
    }
    /**
     * Delete a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {    
        try {
            $result = $this->users->deleteBeachBreak(Crypt::decrypt($id), $message);
            if ($result) {
                return redirect()->route('beachBreakListIndex')->withSuccess($message);
            } else {
                return redirect()->route('beachBreakListIndex')->withErrors($message);
            }
        } catch (\Exception $e) {
            return redirect()->route('beachBreakListIndex')->withErrors($e->getMessage());
        }
        
    }
}