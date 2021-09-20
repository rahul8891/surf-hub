<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Post;
use App\Models\Upload;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Report;
use App\Models\UserFollow;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use File;
use DB, Log;
use FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Filters\Video\VideoFilters;
use willvincent\Rateable\Tests\models\Rating;

class PostService {
    /**
     * Create a new Service instance.
     *
     * @return void
     */
    
    protected $posts;

    protected $uploads;

    protected $tags;

    protected $comment;

    protected $report;

    protected $userFollow;

    protected $notification;

    public function __construct() {

        // post model object
        $this->posts = new Post();

        // upload model object
        $this->upload = new Upload();

        // tag model object
        $this->tag = new Tag();

        // comment model object
        $this->comment = new Comment();

        // report model object
        $this->report = new Report();

        // userFollow model object
        $this->userFollow = new UserFollow();

        // notification model object
        $this->notification = new Notification();
    }

    /**
     * [getPostTotal] we are getiing number of total posts
     * @param  
     * @param  
     * @return dataCount
     */
    public function getPostTotal(){

        $postArray =  $this->posts->whereNull('deleted_at')   
                                  ->where('is_deleted','0')                            
                                  ->orderBy('created_at','ASC')
                                  ->count();
        return $postArray;
    }
    /**
     * [getPostListing] we are getiing all the post
     * @param  
     * @param  
     * @return dataArray
     */
    public function getPostsListing() {
        $postArray =  $this->posts->whereNull('deleted_at')  
                                ->where('is_feed', '1')
                                ->where('is_deleted','0')                            
                                ->orderBy('created_at','DESC')
                                ->paginate(10);
        
        return $postArray;
    }

    /**
     * [getPostListing] we are getiing all the post
     * @param  
     * @param  
     * @return dataArray
     */
    public function getAllPostsListing($input){
        if(isset($input['search']) && !empty($input['search'])) {
            $postArray =  $this->posts->orWhere('post_text', 'like', '%'.$input['search'].'%')
                                ->orWhere('surfer', $input['search'])
                                ->where('is_deleted','0')
                                ->orderBy('posts.created_at','DESC')
                                ->paginate(20);
        } else {
            $postArray =  $this->posts
                                  ->where('is_deleted','0') 
                                  ->orderBy('posts.created_at','DESC')
                                  ->paginate(20);
        }
        
        return $postArray;
    }


    /**
     * [getMyHubListing] we are getiing all login user post
     * @param  
     * @param  
     * @return dataArray
     */
    public function getMyHubListing($postList, $el, $order){
        if($el=='beach') { 
            $sortedData = $postList
                ->join('beach_breaks', 'posts.local_beach_break_id', '=', 'beach_breaks.id')
                ->orderBy('beach_breaks.beach_name', $order)
                ->select('posts.*')
                ->paginate(10);
        } else if($el=='star') {
            //////// code for rating, make replica of above condition
            $sortedData = $postList->with(['beach_breaks', 'ratingPost'])->orderByDesc('average_rating')->paginate(10);
            
            
        } else {
            $sortedData =  $postList
                ->with('beach_breaks')
                ->whereNull('posts.deleted_at')   
                ->orderBy($el,$order)
                ->paginate(10);
        }
        //dd($sortedData);
        return $sortedData;
    }

    
    /**
     * [getFilteredList] we are getiing all login user post with filter
     * @param  
     * @param  
     * @return dataArray
     */
    public function getFilteredList($params, $for) {
        if ($for=='search'){
            $postArray =  $this->posts->with(['ratingPost'])->whereNull('posts.deleted_at');
        }
        
        if ($for=='myhub'){
            $postArray =  $this->posts->with(['ratingPost'])->whereNull('posts.deleted_at')->where('user_id',[Auth::user()->id]);
        }
        
        //************* applying conditions *****************/
        if (isset($params['filterUser']) && ($params['filterUser'] == 'me')){
            $username = Auth::user()->user_name;
            $postArray->where('surfer', $username);
        }elseif (isset($params['filterUser']) && ($params['filterUser'] == 'others') && isset($params['other_surfer']) && !empty($params['other_surfer'])) {
            $postArray->where('surfer', $params['other_surfer']);
        }elseif (isset($params['filterUser']) && ($params['filterUser'] == 'unknown')) {
            $postArray->where('surfer', 'Unknown');
        }
        
        $optionalInfo = [];
        
        if(isset($params['FLOATER']) && ($params['FLOATER']=='on')){
            $optionalInfo[] = 'FLOATER';
        }
        
        if(isset($params['AIR']) && ($params['AIR']=='on')){
            $optionalInfo[] = 'AIR';
        }
        
        if(isset($params['360']) && ($params['360']=='on')) {
            $optionalInfo[] = '360';
        }
        
        if(isset($params['DROP_IN']) && ($params['DROP_IN']=='on')){
            $optionalInfo[] = 'DROP_IN';
        }
        
        if(isset($params['BARREL_ROLL']) && ($params['BARREL_ROLL']=='on')){
            $optionalInfo[] = 'BARREL_ROLL';
        }
        
        if(isset($params['WIPEOUT']) && ($params['WIPEOUT']=='on')){
            $optionalInfo[] = 'WIPEOUT';
        }
        
        if(isset($params['CUTBACK']) && ($params['CUTBACK']=='on')){
            $optionalInfo[] = 'CUTBACK';
        }
        if(isset($params['SNAP']) && ($params['SNAP']=='on')){
            $optionalInfo[] = 'SNAP';
            $postArray->where('optional_info','SNAP');
        }
        
        if(isset($optionalInfo[0]) && !empty($optionalInfo[0])) {
            $postArray->whereIn('optional_info', $optionalInfo);
        }        
        
        if (isset($params['surf_date']) && !empty($params['surf_date'])) {
           $postArray->whereDate('surf_start_date','>=',$params['surf_date']);
        }
        if (isset($params['end_date']) && !empty($params['end_date'])) {
           $postArray->whereDate('surf_start_date','<=',$params['end_date']);
        }

        if (isset($params['country_id']) && !empty($params['country_id'])) {
            $postArray->where('country_id',$params['country_id']);
        }
        if (isset($params['local_beach_break_id']) && !empty($params['local_beach_break_id'])) {
            $postArray->where('local_beach_break_id',$params['local_beach_break_id']);
        }
        if (isset($params['board_type']) && !empty($params['board_type'])) {
            $postArray->where('board_type',$params['board_type']);
        }
        if (isset($params['wave_size']) && !empty($params['wave_size'])) {
            $postArray->where('wave_size',$params['wave_size']);
        }
        
        if (isset($params['state_id'])) {
            $postArray->where('state_id',$params['state_id']);
        }
        
        if (isset($params['rating'])) {
            $rate = $params['rating'];
            $postArray->whereHas('ratingPost', function($query) use ($rate){ 
                $query->where('rating', $rate)->groupBy('rateable_id');
            });
        }
        
        return $postArray->orderBy('posts.id','DESC')->paginate(10);
    }
    
    /**
     * [getFilteredList] we are getiing all login user post with filter
     * @param  
     * @param  
     * @return dataArray
     */
    public function getFilteredData($params, $for) {
        if ($for=='search'){
            $postArray =  $this->posts
                        ->join('beach_breaks', 'beach_breaks.id', '=', 'posts.local_beach_break_id')
                        ->join('ratings', 'posts.id', '=', 'ratings.rateable_id')
                        ->select(DB::raw('avg(ratings.rating) as average, posts.*'))
                        ->whereNull('posts.deleted_at')
                        ->groupBy('posts.id');
        }
        
        if ($for=='myhub'){
            $postArray =  $this->posts
                        ->join('beach_breaks', 'beach_breaks.id', '=', 'posts.local_beach_break_id')
                        ->join('ratings', 'posts.id', '=', 'ratings.rateable_id')
                        ->select(DB::raw('avg(ratings.rating) as average, posts.*'))
                        ->whereNull('posts.deleted_at')
                        ->where('posts.user_id', Auth::user()->id)
                        ->groupBy('posts.id');
        }
        
        //************* applying conditions *****************/
        if (isset($params['filterUser']) && ($params['filterUser'] == 'me')){
            $username = Auth::user()->user_name;
            $postArray->where('surfer', $username);
        }elseif (isset($params['filterUser']) && ($params['filterUser'] == 'others') && isset($params['other_surfer']) && !empty($params['other_surfer'])) {
            $postArray->where('surfer', $params['other_surfer']);
        }elseif (isset($params['filterUser']) && ($params['filterUser'] == 'unknown')) {
            $postArray->where('surfer', 'Unknown');
        }
        
        $optionalInfo = [];
        
        if(isset($params['FLOATER']) && ($params['FLOATER']=='on')){
            $optionalInfo[] = 'FLOATER';
        }
        
        if(isset($params['AIR']) && ($params['AIR']=='on')){
            $optionalInfo[] = 'AIR';
        }
        
        if(isset($params['360']) && ($params['360']=='on')) {
            $optionalInfo[] = '360';
        }
        
        if(isset($params['DROP_IN']) && ($params['DROP_IN']=='on')){
            $optionalInfo[] = 'DROP_IN';
        }
        
        if(isset($params['BARREL_ROLL']) && ($params['BARREL_ROLL']=='on')){
            $optionalInfo[] = 'BARREL_ROLL';
        }
        
        if(isset($params['WIPEOUT']) && ($params['WIPEOUT']=='on')){
            $optionalInfo[] = 'WIPEOUT';
        }
        
        if(isset($params['CUTBACK']) && ($params['CUTBACK']=='on')){
            $optionalInfo[] = 'CUTBACK';
        }
        if(isset($params['SNAP']) && ($params['SNAP']=='on')){
            $optionalInfo[] = 'SNAP';
            $postArray->where('optional_info','SNAP');
        }
        
        if(isset($optionalInfo[0]) && !empty($optionalInfo[0])) {
            $postArray->whereIn('optional_info', $optionalInfo);
        }        
        
        if (isset($params['surf_date']) && !empty($params['surf_date'])) {
           $postArray->whereDate('surf_start_date','>=',$params['surf_date']);
        }
        if (isset($params['end_date']) && !empty($params['end_date'])) {
           $postArray->whereDate('surf_start_date','<=',$params['end_date']);
        }

        if (isset($params['country_id']) && !empty($params['country_id'])) {
            $postArray->where('country_id',$params['country_id']);
        }
        if (isset($params['local_beach_break_id']) && !empty($params['local_beach_break_id'])) {
            $postArray->where('local_beach_break_id', $params['local_beach_break_id']);
        }
        if (isset($params['board_type']) && !empty($params['board_type'])) {
            $postArray->where('board_type',$params['board_type']);
        }
        if (isset($params['wave_size']) && !empty($params['wave_size'])) {
            $postArray->where('wave_size',$params['wave_size']);
        }
        
        if (isset($params['state_id'])) {
            $postArray->where('state_id',$params['state_id']);
        }
        
        if (isset($params['rating'])) {
            $postArray->havingRaw('round(avg(ratings.rating)) = '. $params['rating']);
            // $postArray->where('avg(ratings.rating)', $params['rating']);
        }
        
        if (isset($params['sort'])) {
            if($params['sort'] == "dateAsc"){
                $postArray->orderBy('posts.created_at','ASC');
            }
            else if($params['sort'] == "dateDesc"){
                $postArray->orderBy('posts.created_at','DESC');
            }
            else if($params['sort'] == "surfDateAsc"){
                $postArray->orderBy('posts.surf_start_date','ASC');
            }
            else if($params['sort'] == "surfDateDesc"){
                $postArray->orderBy('posts.surf_start_date','DESC');
            }
            else if($params['sort'] == "beach"){
                $postArray->orderBy('beach_breaks.beach_name','ASC');
            }
            else if($params['sort'] == "star"){
                $postArray->orderBy('average','DESC');
            }
            else{
                $postArray->orderBy('posts.created_at','DESC');
            }
        } else {
            $postArray->orderBy('posts.id','DESC');
        }
//        dd($postArray->toSql());
        return $postArray->paginate(10);
    }
    
    
    /**
     * upload image into directory
     * @param  object  $input
     * @return object array
     */
    public function getPostImage($image){
        Log::info('Log message', [$image]);
        $filename = "";
        
        $destinationPath = public_path('storage/images/');
        $timeDate = strtotime(Carbon::now()->toDateTimeString());
        $ext = $image->getClientOriginalExtension();
        // $imageNameWithExt = $requestImageName->getClientOriginalName(); 
        $filename = $timeDate.'.'.$ext;
        $image->move($destinationPath, $filename);
        
        return $filename;
    }
    
    /**
     * upload video into directory and trim
     * @param  object  $video
     * @return object array
     */
    public function getPostVideo($video) {
        Log::info('Log message', [$video]);
        $fileNameToStore = "";
        
        $destinationPath = public_path('storage/fullVideos/');
        $timeDate = strtotime(Carbon::now()->toDateTimeString());
        $filenameWithExt= $video->getClientOriginalName();
        $extension = $video->getClientOriginalExtension();
        $fileNameToStore = $timeDate.'.'.$extension;
        $video->move($destinationPath, $fileNameToStore);


        //**********trimming video********************/

        /*$start = \FFMpeg\Coordinate\TimeCode::fromSeconds(0);
        $end   = \FFMpeg\Coordinate\TimeCode::fromSeconds(120);
        $clipFilter = new \FFMpeg\Filters\Video\ClipFilter($start,$end);
                
                FFMpeg::open($path)
                    ->addFilter($clipFilter)
                    ->export()
                    ->toDisk('trim')
                    ->inFormat(new FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
                    ->save($fileNameToStore);

                    
        //****removing untrimmed file******/
        /*$oldFullVideo = storage_path().'/app/public/fullVideos/'.$fileNameToStore;
        if(File::exists($oldFullVideo)){
            unlink($oldFullVideo);
        }*/

        return $fileNameToStore;
    }


     /**
     * get postImageArray to store
     * @param  object  $imageArray,$post_id
     * @return object array
     */
    public function getPostImageArray($imageArray,$post_id){
        $newImageArray=[];
        $oldUploadedJsonString=Upload::where('post_id',$post_id)->get('image');
        if($imageArray){
            foreach($imageArray as $image){ 
                $newImageArray[] = $this->getPostImage($image);
            }
        }
            if(Upload::where('post_id',$post_id)->exists()){
                if( $oldUploadedJsonString!=null || $oldUploadedJsonString!=[] || $oldUploadedJsonString!=""){
                    $oldPostImageArray=explode(' ', json_decode($oldUploadedJsonString, true)[0]['image']);
                    $imageArray=array_merge($oldPostImageArray,$newImageArray);
                    return $imageArray;
            }}
            return array_merge($newImageArray,json_decode($oldUploadedJsonString, true));
    }

     /**
     * get postVideoArray to store
     * @param  object  $imageArray,$post_id
     * @return object array
     */
    public function getPostVideoArray($videoArray,$post_id){
        $newVideoArray=[];
        $oldUploadedJsonString=Upload::where('post_id',$post_id)->get('video');
        if($videoArray){
            foreach($videoArray as $video){
                $newVideoArray[] = $this->getPostVideo($video);
            }
        }
        if(Upload::where('post_id',$post_id)->exists()){
            if($oldUploadedJsonString!=null || $oldUploadedJsonString!=[] || $oldUploadedJsonString!=""){
                $oldPostVideoArray=explode(' ', json_decode($oldUploadedJsonString, true)[0]['video']);
                $videoArray=array_merge($oldPostVideoArray,$newVideoArray);
                return $videoArray;
            }
        }
        return array_merge($newVideoArray,json_decode($oldUploadedJsonString, true));
    }


    /**
     * [saveAdminPost] we are storing the post Details from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveAdminPost($input, $imageArray = '', $videoArray = '', &$message='') {
        $posts = new Post();

        $posts->post_type = $input['post_type'];
        if(isset($input['post_type']) && ($input['post_type'] == 'PUBLIC')) {
            $posts->is_feed = "1";
        }
        
        $posts->user_id = $input['user_id'];
        $posts->post_text = $input['post_text'];
        $posts->country_id =$input['country_id'];
        $posts->surf_start_date = $input['surf_date'];
        $posts->wave_size = $input['wave_size'];
        $posts->board_type = $input['board_type'];
        $posts->state_id = $input['state_id'];
        $posts->local_beach_break_id = $input['local_beach_break_id'];
        $posts->surfer = (isset($input['surfer']) && ($input['surfer'] == 'Me'))?Auth::user()->user_name:$input['surfer'];
        $posts->optional_info = (!empty($input['optional_info'])) ? implode(" ",$input['optional_info']) : null;
        $posts->created_at = Carbon::now();
        $posts->updated_at = Carbon::now();
        if($posts->save()){
            //for store media into upload table
            $post_id=$posts->id;

            if(isset($input['files'])) {
                foreach ($input['files'] as $file) {
                    $upload = new Upload();
                    $upload->post_id = $post_id;
                    $upload->image = $file;
                    $upload->video = null;
                    $upload->save();
                }
            }
            
            if(isset($input['videos'])){
                foreach ($input['videos'] as $video) {
                    $upload = new Upload();
                    $upload->post_id = $post_id;
                    $upload->image = null;
                    $upload->video = $video;
                    $upload->save();
                }
            } 

            $this->savePostNotification($post_id);
            $message = "Data save successfully.";
        } else {
            $message = "Something went wrong. Please try again later.";
        }    

        return $message;
    }
    
    /**
     * [savePost] we are storing the post Details from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function savePost($input, $fileType = '', $filename = '', &$message=''){
        try{
            $posts = new Post();

            $posts->post_type = $input['post_type'];            
            $posts->user_id = $input['user_id'];
            $posts->post_text = $input['post_text'];
            $posts->country_id =$input['country_id'];
            $posts->surf_start_date = $input['surf_date'];
            $posts->wave_size = $input['wave_size'];
            $posts->board_type = $input['board_type'];
            $posts->state_id = $input['state_id'];
            $posts->local_beach_break_id = $input['local_beach_break_id'];
            $posts->surfer = $input['surfer'];
            $posts->optional_info = (!empty($input['optional_info'])) ? implode(" ",$input['optional_info']) : null;
            $posts->created_at = Carbon::now();
            $posts->updated_at = Carbon::now();

            if($posts->save()){
                if(isset($filename) && !empty($filename)) {                
                    $upload = new Upload();

                    if (isset($fileType) && ($fileType == 'image')) {
                        $upload->image = $filename;
                    } elseif (isset($fileType) && ($fileType == 'video')) {
                        $upload->video = $filename;
                    }
                    
                    $upload->post_id = $posts->id;
                    $upload->save();
                }
            }
            
            $message = 'Post has been created successfully.!';
            return $message;                
        }
        catch (\Exception $e){     
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message = '"'.$e->getMessage().'"';
            return $message;
        }
    }
    
    
    /**
     * [updatePostData] we are storing the post Details from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function updatePostData($input, $filename, $type, &$message = '') {        
        $posts = Post::findOrFail($input['id']);

        $posts->post_type = $input['post_type'];
        $posts->user_id = $input['user_id'];
        $posts->post_text = $input['post_text'];
        $posts->country_id =$input['country_id'];
        $posts->surf_start_date = $input['surf_date'];
        $posts->wave_size = $input['wave_size'];
        $posts->board_type = $input['board_type'];
        $posts->state_id = $input['state_id'];
        $posts->local_beach_break_id = $input['local_beach_break_id'];
        $posts->surfer = (isset($input['surfer']) && ($input['surfer'] == 'Me'))?Auth::user()->user_name:$input['surfer'];
        $posts->optional_info = (!empty($input['optional_info'])) ? implode(" ",$input['optional_info']) : null;
        $posts->created_at = Carbon::now();
        $posts->updated_at = Carbon::now();
        if($posts->save()){ echo "Type = ".$type." -- File =".$filename."<pre>";
            //for store media into upload table
            if (isset($type) && !empty($type)) {
                $upload = Upload::where('post_id', $posts->id)->first();
                
                if($upload) {
                    $upload->image = ($type == 'image')? $filename : NULL;
                    $upload->video = ($type == 'video')? $filename : NULL;
                    
                    $upload->save();
                }
            }

            $this->savePostNotification($posts->id);
            $message = ['status' => TRUE, 'message' => "Data updated successfully."];
        } else {
            $message = ['status' => TRUE, 'message' => "Something went wrong. Please try again later."];
        }    

        return $message;
    }

    /**
     * [updatePost] we are updating the post Details from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function updatePost($input,$imageArray,$videoArray,$id,&$message=''){
        
        $posts=$this->posts->find($id);
        try{
            $posts->post_type = $input['post_type'];
            $posts->user_id = $input['user_id'];
            $posts->post_text = $input['post_text'];
            $posts->country_id =$input['country_id'];
            $posts->surf_start_date = $input['surf_date'];
            $posts->wave_size = $input['wave_size'];
            $posts->board_type = $input['board_type'];
            $posts->state_id = $input['state_id'];
            $posts->local_beach_break_id = $input['local_beach_break_id'];
            $posts->surfer = (isset($input['surfer']) && ($input['surfer'] == 'Me'))?Auth::user()->user_name:$input['surfer'];
            $posts->optional_info = (!empty($input['optional_info'])) ? implode(" ",$input['optional_info']) : null;
            $posts->created_at = Carbon::now();
            $posts->updated_at = Carbon::now();
            
            ///for updating media into upload table
            $post_id=$posts->id;
                if($imageArray){
                    foreach($imageArray as $image){
                        $imageName = $this->getPostImage($image);
                        $upload = new Upload();
                        $upload->post_id = $post_id;
                        $upload->image = $imageName;
                        $upload->video = null;
                        $upload->save();
                    }
                }
                if($videoArray){
                    foreach($videoArray as $video){
                        $videoName = $this->getPostVideo($video);
                        $upload = new Upload();
                        $upload->post_id = $post_id;
                        $upload->image = null;
                        $upload->video = $videoName;
                        $upload->save();
                    }
                }
            
            if($posts->save()){
                $message = 'Post has been updated successfully.!';
                    return $message;
                
            }
        }
        catch (\Exception $e){     
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }



    /**
     * [ratePost] we are updating the post Details from user section 
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function ratePost($data,&$message=''){
        $id = $data['id'];
        $value = $data['value'];
        $posts=$this->posts->find($id);
        
        try{
            //************* saving user's rating *****************/
                if($posts->rateOnce($value)){
                    $responseArray['status']='success';
                    $responseArray['message']='Thanks For Rating!';
                    $responseArray['averageRating']=$posts->averageRating;
                    $responseArray['usersRated']=$posts->usersRated();
                    return $responseArray;
                }
                else{
                    $responseArray['status']='failed';
                    $responseArray['message']='Not Submmited';
                    $responseArray['averageRating']=$posts->averageRating;
                    $responseArray['usersRated']=$posts->usersRated();
                    return $responseArray;
                }
 
        }
        catch (\Exception $e){     
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

    /**
     * [deletePost] we are updating the post Details from user section 
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function deletePost($id,&$message=''){
        
        $posts=$this->posts->find($id);
        try{
            $posts->is_deleted = '1';
            $posts->deleted_at = Carbon::now();
            $posts->updated_at = Carbon::now();
            
            if($posts->save()){
                $message = 'Post has been deleted successfully.!';
                    return $message;                
            }
        }
        catch (\Exception $e){     
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

    /**
     * [updatePost] we are updating the post Details from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveToMyHub($id,&$message=''){
        
        $postSave=$this->posts->find($id);
        $postMedia=Upload::select('*')->where('post_id',$id)->get();

        try{
            $this->posts['post_type'] = $postSave->post_type;
            $this->posts['user_id'] = Auth::user()->id;
            $this->posts['post_text'] = $postSave->post_text;
            $this->posts['country_id'] =$postSave->country_id;
            $this->posts['surf_start_date'] = $postSave->surf_start_date;
            $this->posts['wave_size'] = $postSave->wave_size;
            $this->posts['board_type'] = $postSave->board_type;
            $this->posts['state_id'] = $postSave->state_id;
            $this->posts['local_beach_break_id'] = $postSave->local_beach_break_id;
            $this->posts['surfer'] = $postSave->surfer;
            $this->posts['optional_info'] = $postSave->optional_info;
            $this->posts['parent_id'] = $postSave->user_id;
            $this->posts['created_at'] = Carbon::now();
            $this->posts['updated_at'] = Carbon::now();            
            
            if($this->posts->save()){
                $post_id=$this->posts->id;
                foreach($postMedia as $media){
                        $upload = new Upload();
                        $upload->post_id = $post_id;
                        $upload->image = $media->image;
                        $upload->video = $media->video;
                        $upload->save();
                       
                 }
                
                    $message = 'Post has been saved successfully.!';
                    return $message;
                
            }
        }
        catch (\Exception $e){     
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

    /**
     * [saveComment] we are storing the post comment 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveComment($input,&$message=''){
        try{
            $this->comment->parent_user_id = $input['parent_user_id'];
            $this->comment->user_id = Auth::user()->id;
            $this->comment->post_id = $input['post_id'];
            $this->comment->value = $input['comment'];
            $this->comment->created_at = Carbon::now();
            $this->comment->updated_at = Carbon::now();
            //dd($this->comments);
            if($this->comment->save()){
                //for store media into upload table
                $message = 'Comment has been created successfully.!';
                return $message;                    
            }
                
        }
        catch (\Exception $e){     
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

    /**
     * [saveReport] we are storing the post report 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveReport($input,&$message=''){
        
        try{
            $this->report->post_id = $input['post_id'];
            $this->report->user_id = Auth::user()->id;
            if(isset($input['incorrect'])){
                $this->report->incorrect = $input['incorrect'];
            }
            if(isset($input['inappropriate'])){
                $this->report->inappropriate = $input['inappropriate'];
            }
            if(isset($input['tolls'])){
                $this->report->tolls = $input['tolls'];
            }
            $this->report->comments = $input['comments'];
            $this->report->created_at = Carbon::now();
            $this->report->updated_at = Carbon::now();
            //dd($this->comments);
            if($this->report->save()){
                //for store media into upload table
                $message = 'Report has been created successfully.!';
                return $message;                    
            }
                
        }
        catch (\Exception $e){     
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

    /**
     * [saveFollow] we are storing the follower data 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveFollow($input,&$message=''){
        
        try{
            $this->userFollow->followed_user_id = $input['followed_user_id'];
            $this->userFollow->follower_user_id = Auth::user()->id;
            $this->userFollow->created_at = Carbon::now();
            $this->userFollow->updated_at = Carbon::now();
            
            if($this->userFollow->save()){
                //for store media into upload table
                $message = 'Follow request has been created successfully.!';
                return $message;                    
            }
                
        }
        catch (\Exception $e){     
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

    /**
     * [getPostNotificationsCount] we are getiing unseen post count
     * @param  
     * @param  
     * @return dataArray
     */
    public function getPostNotificationsCount(){

        /*$postArray =  $this->posts
                                  //->where('user_id', '!=',Auth::user()->id)
                                  ->where('post_type', 'PUBLIC')
                                  ->where('is_deleted','0')                              
                                  ->orderBy('posts.created_at','ASC')
                                  ->count();
        return $postArray;*/
        $notificationCount =  $this->notification
                                  ->where('receiver_id', Auth::user()->id)
                                  ->where('status', '0')
                                  ->where('count_status', '0')
                                  ->count();
        return $notificationCount;
        /*$postArray =  $this->tag
                                  //->where('user_id', '!=',Auth::user()->id)
                                  ->where('user_id', Auth::user()->id)
                                  ->where('is_seen','0')                              
                                  ->orderBy('created_at','ASC')
                                  ->count();
        return $postArray;*/
    }

    /**
     * [getPostNotificationsList] we are getiing all the post
     * @param  
     * @param  
     * @return dataArray
     */
    public function getPostNotificationsList(){

        $postArray =  $this->tag
                                  //->where('user_id', '!=',Auth::user()->id)
                                  ->where('user_id', Auth::user()->id)
                                  ->where('is_seen','0')                              
                                  ->orderBy('created_at','ASC')
                                  ->get();
        return $postArray;
    }

    /**
     * [getFollowedPostList] we are getiing all the post
     * @param  
     * @param  
     * @return dataArray
     */
    public function getFollowedPostList(){

        $postArray =  $this->userFollow
                                  //->where('user_id', '!=',Auth::user()->id)
                                  ->where('follower_user_id', Auth::user()->id)
                                  ->where('followed_user_id','!=', Auth::user()->id)
                                  ->where('follower_request_status','0')
                                  ->where('is_deleted','0') 
                                  //->where('created_at', '>=', Carbon::today())                             
                                  ->orderBy('id','ASC')
                                  ->get();
        return $postArray;
    }

    /**
     * [getCommentOnPost] we are getiing all the post
     * @param  
     * @param  
     * @return dataArray
     */
    public function getCommentOnPost(){

        $commentArray =  $this->comment
                                  //->where('user_id', '!=',Auth::user()->id)
                                  ->where('parent_user_id', Auth::user()->id)
                                  ->where('user_id','!=',Auth::user()->id)
                                  ->where('is_deleted','0') 
                                  //->where('created_at', '>=', Carbon::today())                             
                                  ->orderBy('created_at','ASC')
                                  ->get();
        return $commentArray;
    }

    /**
     * [getNotifications] we are getiing all the notification
     * @param  
     * @param  
     * @return dataArray
     */
    public function getNotifications(){

        $notificationArray =  $this->notification
                                  ->where('receiver_id', Auth::user()->id)
                                  ->where('status', '0')                             
                                  ->orderBy('created_at','DESC')
                                  ->get();
        return $notificationArray;
    }

    /**
     * [getNotifications] we are getiing all the notification
     * @param  
     * @param  
     * @return dataArray
     */
    public function getPostDetails($post_id,$notification_id){

        $detailArray =  $this->notification
                                  ->where('id', $notification_id)
                                  ->first();
        return $detailArray;
    }

    /**
     * [saveCommentNotification] we are storing the comment notifications
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function saveCommentNotification($input,&$message=''){
        try{
            $this->notification->post_id = $input['post_id'];
            $this->notification->sender_id = Auth::user()->id;
            $this->notification->receiver_id = $input['parent_user_id'];
            $this->notification->notification_type = 'Comment';
            $this->notification->created_at = Carbon::now();
            $this->notification->updated_at = Carbon::now();
            //dd($this->comments);
            $this->notification->save();
                
        }
        catch (\Exception $e){     
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

    /**
     * [savePostNotification] we are storing the post notifications
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function savePostNotification($post_id){
        try{
            $userArray = $this->getFollowedPostList();
            foreach ($userArray as $key => $value) {
              $notification = new Notification();
              $notification->post_id = $post_id;
              $notification->sender_id = Auth::user()->id;
              $notification->receiver_id = $value['followed_user_id'];
              $notification->notification_type = 'Post';
              $notification->created_at = Carbon::now();
              $notification->updated_at = Carbon::now();
              //dd($this->comments);
              $notification->save();
            }
                
        }
        catch (\Exception $e){     
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

    public function updateNotificationStatus($id='')
    {
      $notification=$this->notification->find($id);
      $notification->status = '1';
      $notification->updated_at = Carbon::now();
      $notification->save();
    }

    public function updateNotificationCountStatus($input)
    {
      $result = Notification::where('receiver_id', Auth::user()->id)->update(['count_status'=>'1','updated_at'=>Carbon::now()]);
      return $result;
    }
}