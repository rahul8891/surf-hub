<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;
use App\Services\AdminUserService;
use App\Services\MasterService;
use App\Services\PostService;
use App\Traits\PasswordTrait;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Report;
use App\Models\Upload;
use Closure;
use Redirect;
use Session;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  AdminUserService  $users
     * @return void
     */
    public function __construct(AdminUserService $users)
    {
        $this->users = $users;
        $this->common = config('customarray.common');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Report::with(['user', 'post' => function($q) {
                    $q->with('user')->get();
                }])->get();
        
        return view('admin/report/index', compact('data'));     
    }
    public function searchReport(Request $request) {

        $serachTerm = $request->searchTerm;

        $data = $this->users->searchReport($serachTerm);
//        dd($followers);
        $common = $this->common;
        $view = view('elements/searchReport', compact('data', 'common'))->render();
        return response()->json(['html' => $view]);
    }
    
}