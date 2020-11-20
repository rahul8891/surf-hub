<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Redirect;
use Session;

class PostController extends Controller
{

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        /*
         "post_type" => "PRIVATE"
        "post_text" => "ghjkhgjk"
        "surf_date" => "2020-11-17"
        "wave_size" => "2"
        "country_id" => "101"
        "local_beach_break" => "Avalon Beach,South Avalon,Sydney,NSW,Australia"
        "local_beach_break_id" => "2"
        "state_id" => "4024"
        "board_type" => "GUN"
        "surfer" => "me"
        "other_surfer" => null
        "optional_info[" => "AIR"
        "_token" => "ezRB08R6Nkgn4o0jh2OxbIY4r8t7NmJM1BjpUbwW"
        "optional" => array:2 [
        0 => "FLOATER"
        1 => "AIR"
        ]
    ]
    "_token" => "ezRB08R6Nkgn4o0jh2OxbIY4r8t7NmJM1BjpUbwW"
        */
        try{
            $data = $request->all();      
            dd($data['formData']);   
            $rules = array(
                'post_type' => ['required', 'string'],
                'post_text' => ['required','string'],
                'wave_size' => ['required','numeric'],
                'surf_date' => ['required','date_format:Y-m-d'],
                'country_id' => ['required','numeric'],
                'state_id' => ['required','numeric'],
                'local_beach_break_id' => ['required','numeric'],
                'board_type' => ['required', 'string'],
                'surfer' => ['required', 'string'],
            );       
            $validate = Validator::make($data['formData'], $rules);          
            if ($validate->fails()) {
                return response()->json(['error'=>$validate->errors()]);     
            }else {
                dd($data['formData']);
                return response()->json(['success'=>'Data Successfully updated']);  
            }
           /* if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->users->saveAdminUser($data,$message);
                if($result){  
                    return Redirect::to('admin/users/create')->withSuccess($message);
                }else{
                    return Redirect::to('admin/users/create')->withErrors($message);
                }
            }*/
        }catch (\Exception $e){     
            return response()->json(['error'=>$e->getMessage()]);               
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}