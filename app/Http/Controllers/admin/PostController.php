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
use App\Models\Upload;
use Closure;
use Redirect;
use Session;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;

class PostController extends Controller
{
    use PasswordTrait;
    /**
     * The user sevices implementation.
     *
     * @var AdminUserService
     */
    protected $posts;

    Protected $masterService;

    public $language;

    public $accountType;

    /**
     * Create a new controller instance.
     *
     * @param  AdminUserService  $users
     * @return void
     */
    public function __construct(PostService $posts,AdminUserService $users,MasterService $masterService)
    {
        $this->posts = $posts;
        $this->users = $users;
        $this->masterService = $masterService;
        $this->customArray = config('customarray');
        $this->language = config('customarray.language'); 
        $this->accountType = config('customarray.accountType');
        $this->post_type = config('customarray.post_type');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->posts->getPostsListing();
        $spiner = ($posts) ? true : false;
        return view('admin/Post/index', compact('posts','spiner'));     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $language = $this->language;
        $users=User::all();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;   
        return view('admin/post/create', compact('users','countries','currentUserCountryId','customArray','language','states'));
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
            $imageArray=$request->file('files');
            $videoArray=$request->file('videos');
            $rules = array(
                'post_type' => ['required'],
                'user_id' => ['required','numeric'],
                'post_text' => ['nullable', 'string', 'max:255'],
                'surf_date' => ['required', 'string'],
                'wave_size' => ['required', 'string'],
                'state_id' => ['nullable', 'numeric'],
                'board_type' => ['required', 'string'],
                'surfer' => ['required'],
                'country_id' => ['required','numeric'],
                'local_beach_break_id' => ['nullable', 'string'],
                'optional_info'=>['nullable'],
            );
            
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->posts->savePost($data,$imageArray,$videoArray,$message);
                if($result){  
                    return Redirect::to('admin/post/index')->withSuccess($message);
                }else{
                    return Redirect::to('admin/post/create')->withErrors($message);
                }
            }
        }catch (\Exception $e){ 
            throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
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
        try{
        $post=Post::findOrFail(Crypt::decrypt($id));
        $postMedia=Upload::where('post_id',Crypt::decrypt($id))->get();
            $spiner = ($post) ? true : false;
        }catch (\Exception $e){ 
            throw ValidationException::withMessages([$e->getMessage()]);
        }
        return view('admin/post/show', compact('post','postMedia','spiner'));  
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
            $currentUserCountryId = Auth::user()->user_profiles->country_id;    
            $countries = $this->masterService->getCountries();
            $language = $this->language;
            $users = $this->users->getUsersListing();
            $states = $this->masterService->getStateByCountryId($currentUserCountryId);
            $customArray = $this->customArray;  
            $posts = Post::findOrFail(Crypt::decrypt($id));
            $postMedia=Upload::where('post_id',Crypt::decrypt($id))->get();
            $spiner = ($this->posts) ? true : false;
        }catch (\Exception $e){         
            throw ValidationException::withMessages([$e->getMessage()]);
        }
        
        return view('admin/post/edit', compact('users','countries','postMedia','posts','currentUserCountryId','customArray','language','states'));
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
        // dd($request->all());
        $id=Crypt::decrypt($id);
        try{
            $data = $request->all();
            $imageArray=$request->file('files');
            $videoArray=$request->file('videos');
            $rules = array(
                'post_type' => ['required'],
                'user_id' => ['required','numeric'],
                'post_text' => ['nullable', 'string', 'max:255'],
                'surf_date' => ['required', 'string'],
                'wave_size' => ['required', 'string'],
                'state_id' => ['nullable', 'numeric'],
                'board_type' => ['required', 'string'],
                'surfer' => ['required'],
                'country_id' => ['required','numeric'],
                'local_beach_break_id' => ['nullable', 'string'],
                'optional_info'=>['nullable'],
            );
            $validate = Validator::make($data, $rules);
            if ($validate->fails()) {
                // If validation falis redirect back to register.
                return redirect()->back()->withErrors($validate)->withInput();
            } else {
                $result = $this->posts->updatePost($data,$imageArray,$videoArray,$id,$message);
                if($result){
                    return redirect()->route('postDetail', ['id' => Crypt::encrypt($id)])->withSuccess($message);
                }else{
                    return redirect()->route('postEdit', ['id' => Crypt::encrypt($id)])->withErrors($message); 
                }
            }
        }catch (\Exception $e){
                
            return redirect()->route('postEdit', ['id' => Crypt::encrypt($id)])->withErrors($e->getMessage()); 
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::find(Crypt::decrypt($id));
        $post->delete();
        return Redirect::to('admin/post/index')->withSuccess("succesfully deleted");
    }


    public function trimmer(Request $request){
        $text=$request->text;
        $files=$request->file('files');
        if($files){
            foreach($files as $video){
                $filename= $video->getClientOriginalName();
                $extension = $video->getClientOriginalExtension();
                $fileNameToStore = time().'_'.$filename;
                $path = $video->storeAs('/public/videos',$fileNameToStore);
                $videoArray[]=$fileNameToStore;

            }
            $media=FFMpeg::open('public/videos'.'/'.$videoArray[0])
            ->filters()
            ->clip(FFMpeg\Coordinate\TimeCode::fromSeconds(1), FFMpeg\Coordinate\TimeCode::fromSeconds(60));
            dd($media);
        return view('video',compact('media','text'));
    }

}
// exec("ffmpeg -ss 00:01:00 -i input.mp4 -to 00:02:00 -c copy output.mp4");


// FFMpeg::fromDisk('local')
            //     ->open('/public/videos'.'/'.$videoArray[0])
            //     ->addFilter($clipFilter)
            //     ->export()
            //     ->toDisk('local')
            //     ->inFormat(new \FFMpeg\Format\Video\X264)
            //     ->save('short_steve.mkv');

            //     dd('done');
            //     $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(500);
 
            //     $converted_name = $path;

            //     FFMpeg::open('/public/videos'.'/'.$videoArray[0])
            // // add the 'resize' filter...
            // ->addFilter(function ($filters) {
            //     $filters->resize(new Dimension(960, 540));
            // })
            // // call the 'export' method...
            // ->export()
            // // tell the MediaExporter to which disk and in which format we want to export...
            // ->toDisk('public')
            // ->inFormat($lowBitrateFormat)
            // // call the 'save' method with a filename...
            // ->save($videoArray[0]);
        }