<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Post;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use File;
use DB;
use FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Filters\Video\VideoFilters;

class PostService {
    /**
     * Create a new Service instance.
     *
     * @return void
     */
    
    protected $posts;

    protected $uploads;

    public function __construct() {

        // post model object
        $this->posts = new Post();

        // upload model object
        $this->upload = new Upload();
    }

    /**
     * [getPostTotal] we are getiing number of total posts
     * @param  
     * @param  
     * @return dataCount
     */
    public function getPostTotal(){

        $postArray =  $this->posts->whereNull('deleted_at')                               
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
    public function getPostsListing(){

        $postArray =  $this->posts->whereNull('posts.deleted_at')                           
                                  ->orderBy('posts.created_at','ASC')
                                  ->paginate(10);
        return $postArray;
    }

    /**
     * [getMyHubListing] we are getiing all login user post
     * @param  
     * @param  
     * @return dataArray
     */
    public function getMyHubListing(){

        $postArray =  $this->posts->whereNull('posts.deleted_at')   
                                  ->where('user_id',[Auth::user()->id])                        
                                  ->orderBy('posts.created_at','ASC')
                                  ->paginate(10);
        return $postArray;
    }


    /**
     * upload image into directory
     * @param  object  $input
     * @return object array
     */
    public function getPostImage($image){
        
        $destinationPath = 'storage/images/';
        $timeDate = strtotime(Carbon::now()->toDateTimeString());
        $ext = $image->getClientOriginalExtension();
        // $imageNameWithExt = $requestImageName->getClientOriginalName(); 
        $filename = $timeDate.'_'.rand().'.'.$ext;
        $image->move($destinationPath, $filename);
        return $filename;
    }
    
    /**
     * upload video into directory and trim
     * @param  object  $video
     * @return object array
     */
    public function getPostVideo($video){

        $destinationPath = 'public/fullVideos';
        $timeDate = strtotime(Carbon::now()->toDateTimeString());
        $filenameWithExt= $video->getClientOriginalName();
        $extension = $video->getClientOriginalExtension();
        $fileNameToStore = $timeDate.'_'.$filenameWithExt;
        $path = $video->storeAs($destinationPath,$fileNameToStore);


        $start = \FFMpeg\Coordinate\TimeCode::fromSeconds(0);
        $end   = \FFMpeg\Coordinate\TimeCode::fromSeconds(60);
        $clipFilter = new \FFMpeg\Filters\Video\ClipFilter($start,$end);
                
                //**********trimming video********************/
                FFMpeg::open($path)
                    ->addFilter($clipFilter)
                    ->export()
                    ->toDisk('trim')
                    ->inFormat(new FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))
                    ->save($fileNameToStore);

                    
        //****removing untrimmed file******//
        $oldFullVideo = storage_path().'/app/public/fullVideos/'.$fileNameToStore;
        if(File::exists($oldFullVideo)){
            unlink($oldFullVideo);
        }

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
     * [savePost] we are storing the post Details from admin section 
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition 
     * @return dataArray with message
     */
    public function savePost($input,$imageArray,$videoArray,&$message=''){
        try{
            $this->posts->post_type = $input['post_type'];
            $this->posts->user_id = $input['user_id'];
            $this->posts->post_text = $input['post_text'];
            $this->posts->country_id =$input['country_id'];
            $this->posts->surf_start_date = $input['surf_date'];
            $this->posts->wave_size = $input['wave_size'];
            $this->posts->board_type = $input['board_type'];
            $this->posts->state_id = $input['state_id'];
            $this->posts->local_beach_break_id = $input['local_beach_break_id'];
            $this->posts->surfer = $input['surfer'];
            $this->posts->optional_info = (!empty($input['optional_info'])) ? implode(" ",$input['optional_info']) : null;
            $this->posts->created_at = Carbon::now();
            $this->posts->updated_at = Carbon::now();
            
            if($this->posts->save()){
                //for store media into upload table
                $post_id=$this->posts->id;
                $newImageArray = $this->getPostImageArray($imageArray,$post_id);
                $newVideoArray = $this->getPostVideoArray($videoArray,$post_id);
                $this->upload->post_id = $this->posts->id;
                $this->upload->image = ($newImageArray!=[]) ? implode(" ",$newImageArray) : null;
                $this->upload->video = ($newVideoArray!=[]) ? implode(" ",$newVideoArray) : null;
                $this->upload->save();
                
                if($this->upload->save()){
                    $message = 'Post has been created successfully.!';
                    return $message;
                }
                    
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
            $posts->surfer = $input['surfer'];
            $posts->optional_info = (!empty($input['optional_info'])) ? implode(" ",$input['optional_info']) : null;
            $posts->created_at = Carbon::now();
            $posts->updated_at = Carbon::now();
            
            ///for updating media into upload table
                $newImageArray = $this->getPostImageArray($imageArray,$id);
                $newVideoArray = $this->getPostVideoArray($videoArray,$id);
                
                    Upload::where('post_id', $posts->id)
                    ->update([
                        'image'=>($newImageArray!=[]) ? implode(' ', array_filter($newImageArray)) : null,
                        'video'=>($newVideoArray!=[]) ? implode(' ', array_filter($newVideoArray)) : null,
                        ]);
            
            
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
        try{
            $this->posts['post_type'] = $postSave->post_type;
            $this->posts['user_id'] = Auth::user()->id;
            $this->posts['post_text'] = $postSave->post_text;
            $this->posts['country_id'] =$postSave->country_id;
            $this->posts['surf_start_date'] = $postSave->surf_date;
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
                $this->upload->post_id = $this->posts->id;
                $this->upload->image = $postSave->upload->image ? $postSave->upload->image : null;
                $this->upload->video = $postSave->upload->video ? $postSave->upload->video : null;
                $this->upload->save();
                
                if($this->upload->save()){
                    $message = 'Post has been saved successfully.!';
                    return $message;
                }
                
            }
        }
        catch (\Exception $e){     
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }

}