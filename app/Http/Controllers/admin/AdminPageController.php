<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Page;

use Carbon\Carbon;
use Redirect;


class AdminPageController extends Controller
{

    /**
     * The page repository implementation.
     */
    protected $pages;


    /**
     * Create a new controller instance.
     *
     * @param  Page $pages
     * @return void
     */
    public function __construct(Page $pages)
    {
        $this->pages = $pages; 
        $this->message = config('customarray');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->pages->All();     
        $spiner = ($pages) ? true : false;
        return view('admin/admin_static_pages.index', compact('pages','spiner'));     
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
        try{
            $pages = new Page();         
            $pages = $pages::findOrFail(Crypt::decrypt($id));
            $spiner = ($pages) ? true : false;
        }catch (\Exception $e){         
            throw ValidationException::withMessages([$e->getMessage()]);
        }
        
        return view('admin/admin_static_pages.edit', compact('pages','spiner'));
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
        try{
            $data = $request->all();
            $id = Crypt::decrypt($id);
            $rules = array(
                'title' => ['required', 'string'],
                'body' => ['nullable','string'],                             
            );       
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $pages = $this->pages::findOrFail($id);
                if($pages){
                    $pages->id = $id;
                    $pages->title = $data['title'];
                    $pages->body = $data['body'];
                    if($pages->save()){
                        return redirect()->route('adminPageIndex')->withSuccess($this->message['SUCCESS']['UPDATE_SUCCESS']);
                    }
                }else{
                    return redirect()->route('adminPageIndex')->withErrors($this->message['SUCCESS']['MODEL_ERROR']);
                }
            }
        }catch (\Exception $e){
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }


   
    
}