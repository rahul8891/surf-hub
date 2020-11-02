<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Traits\PasswordTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
class UserController extends Controller
{
    use PasswordTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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

    public function showChangePassword(){      
        return view('user.change-password');
    }

    public function updateUserPassword(Request $request){
       $data = $request->all();      
        $rules = array(
            'current_password' => ['required',new MatchOldPassword],           
            'password' => $this->passwordRules(),
        );       
        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {          
            // If validation falis redirect back to register.
            return redirect()->back()->withErrors($validate)->withInput();
        } else {       
            $result = User::find(Auth::user()->id)->update(['password'=> Hash::make($data['password'])]);
            if($result){  
                return redirect()->route('showPassword')->withSuccess('Password changed successfully !');
            }else{
                return redirect()->route('showPassword')->withErrors('Somthing went wrong !');
            }
        } 
      
    }
}