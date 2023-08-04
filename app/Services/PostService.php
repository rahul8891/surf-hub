<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Post;
use App\Models\Upload;
use App\Models\AdvertPost;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Report;
use App\Models\UserFollow;
use App\Models\Notification;
use App\Models\SurferRequest;
use App\Models\AdminAd;
use App\Models\BeachBreak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendReportMail;
use File;
use DB, Log;
use FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Filters\Video\VideoFilters;
use willvincent\Rateable\Tests\models\Rating;
use App\Services\UserService;

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

    protected $surferRequest;

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

        // SurferRequest model object
        $this->surferRequest = new SurferRequest();
    }

    /**
     * [getPostTotal] we are getting number of total posts
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
     * [getPostTotal] we are getting number of total posts of a user
     * @param
     * @param
     * @return dataCount
     */
    public function getPostByUserId($user_id){

        $postArray =  $this->posts->where('user_id',$user_id)
                                  ->where('post_type', 'PUBLIC')
                                  ->where('is_deleted','0')
                                  ->orderBy('created_at','ASC')
                                  ->get()
                                  ->toArray();
        return $postArray;
    }
    public function getPostUnknownByUserId(){

        $postArray =  $this->posts->where('user_id',Auth::user()->id)
                                  ->where('is_deleted','0')
                                  ->where("surfer", 'Unknown')
                                  ->orderBy('created_at','ASC')
                                  ->get()
                                  ->toArray();
        return $postArray;
    }
    /**
     * [getPostListing] we are getting all the post
     * @param
     * @param
     * @return dataArray
     */
    public function getPostsListing() {
        $postArray =  $this->posts->whereNull('deleted_at')
                                ->where('post_type', 'PUBLIC')
                                ->where('is_deleted','0')
                                ->orderBy('created_at','DESC')
                                ->paginate(10);

        return $postArray;
    }

    /**
     * [getPostListing] we are getting all the post
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
                ->join('beach_breaks', 'posts.local_beach_id', '=', 'beach_breaks.id')
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

        if (isset($params['username_id']) && !empty($params['username_id'])){
            $postArray->where('surfer', $username);
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
        if (isset($params['local_beach_id']) && !empty($params['local_beach_id'])) {
            $postArray->where('local_beach_id',$params['local_beach_id']);
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
    public function getFilteredData($params, $for, $type = null, $page = null) {
        if ($for=='search'){
            $postArray =  $this->posts
                        ->join('beach_breaks', 'beach_breaks.id', '=', 'posts.local_beach_id')
                        ->leftJoin('ratings', 'posts.id', '=', 'ratings.rateable_id')
                        ->leftJoin('user_profiles', 'posts.user_id', '=', 'user_profiles.user_id')
                        ->leftJoin('users', 'posts.user_id', '=', 'users.id')
                        ->select(DB::raw('avg(ratings.rating) as average, posts.*'))
                        ->whereNull('posts.deleted_at')
                        ->groupBy('posts.id');
        }

        if ($for=='myhub'){
            $postArray =  $this->posts
                        ->join('beach_breaks', 'beach_breaks.id', '=', 'posts.local_beach_id')
                        ->leftJoin('ratings', 'posts.id', '=', 'ratings.rateable_id')
                        ->select(DB::raw('avg(ratings.rating) as average, posts.*'))
                        ->whereNull('posts.deleted_at')
                        ->where('posts.user_id', Auth::user()->id)
                        ->groupBy('posts.id');
        }

        if (($for == 'myhub') && ($type == 'posts')) {
            $postArray->where('posts.post_type', 'PUBLIC');
        } elseif (($for == 'myhub') && ($type == 'saved')) {
            $postArray->where('posts.post_type', 'PRIVATE');
            $postArray->where('posts.parent_id','>=', 0);
        } elseif (($for == 'myhub') && ($type == 'upload')) {
            $postArray->where('posts.post_type', 'PRIVATE');
            $postArray->where('posts.parent_id','=', 0);
        } elseif (($for == 'myhub') && ($type == 'tags')) {
            $postArray =  $this->posts
                        ->join('tags', 'posts.id', "=", 'tags.post_id')
                        ->join('beach_breaks', 'beach_breaks.id', '=', 'posts.local_beach_id')
                        ->leftJoin('ratings', 'posts.id', '=', 'ratings.rateable_id')
                        ->select(DB::raw('avg(ratings.rating) as average, posts.*'))
                        ->where('tags.is_deleted', '0')
                        ->where('tags.user_id', Auth::user()->id)
                        ->groupBy('posts.id');
        } elseif (($for == 'myhub') && ($type == 'reels')) {
            $postArray->where('posts.is_highlight', '1');
        }
        // dd($postArray->toSql());
        //************* applying conditions *****************/
        if (isset($params['username_id']) && !empty($params['username_id'])) {
            $postArray->where('posts.user_id', $params['username_id']);
            $postArray->where('posts.parent_id', 0);
        }

        if (isset($params['filterUser']) && ($params['filterUser'] == 'me')) {
            $username = Auth::user()->user_name;
            $postArray->where('surfer', $username);
        } elseif (isset($params['filterUser']) && ($params['filterUser'] == 'others') && isset($params['other_surfer']) && !empty($params['other_surfer'])) {
            $postArray->where('surfer', $params['other_surfer']);
        } elseif (isset($params['filterUser']) && ($params['filterUser'] == 'unknown')) {
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
        if(isset($params['additional_info']) && !empty($params['additional_info'])) {
            $postArray->where(function($q) use($params){

            foreach ($params['additional_info'] as $val) {
            $q->orWhere('additional_info', 'LIKE',  '%' . $val .'%');
            }

            });
        }

        if (isset($params['surf_date']) && !empty($params['surf_date'])) {
           $postArray->whereDate('surf_start_date','>=',$params['surf_date']);
        }
        if (isset($params['end_date']) && !empty($params['end_date'])) {
           $postArray->whereDate('surf_start_date','<=',$params['end_date']);
        }

        if (isset($params['country_id']) && !empty($params['country_id'])) {
            $postArray->where('posts.country_id',$params['country_id']);
        }
        if (isset($params['break']) && !empty($params['break'])) {
            $postArray->where('local_break_id', $params['break']);
        }elseif (isset($params['local_beach_id']) && !empty($params['local_beach_id'])) {
            $postArray->where('local_beach_id', $params['local_beach_id']);
        }
        if (isset($params['board_type']) && !empty($params['board_type'])) {
            $postArray->where('board_type',$params['board_type']);
        }
        if (isset($params['wave_size']) && !empty($params['wave_size'])) {
            $postArray->where('wave_size',$params['wave_size']);
        }

        if (isset($params['state_id'])) {
            $postArray->where('posts.state_id',$params['state_id']);
        }

        if (isset($params["user_type"])) {
            $postArray->whereIn('user_type', $params["user_type"]);
        }

        if (isset($params["gender"])) {
            $postArray->where('gender', '=', $params["gender"]);
        }
        if (isset($params["from_age"]) && !isset($params["to_age"])) {
            $from_age = date('Y-m-d', strtotime('-'.$params["from_age"].' year'));
            $postArray->where('dob', '<=', $from_age);
        }
        if (!isset($params["from_age"]) && isset($params["to_age"])) {
            $to_age = date('Y-m-d', strtotime('-'.$params["to_age"].' year'));
            $postArray->where('dob', '>=', $to_age);
        }
        if (isset($params["from_age"]) && isset($params["to_age"])) {
            $from_age = date('Y-m-d', strtotime('-'.$params["from_age"].' year'));
            $to_age = date('Y-m-d', strtotime('-'.$params["to_age"].' year'));
            $postArray->where('dob', '<=', $from_age);
            $postArray->where('dob', '>=', $to_age);
        }

        if (isset($params['rating']) && $params['rating']>0) {
            $postArray->havingRaw('round(avg(ratings.rating)) = '. $params['rating']);
            // $postArray->where('avg(ratings.rating)', $params['rating']);
        }

        /*if (isset($params['break']) && !empty($params['break'])) {
            $beachBreak = BeachBreak::where('id', $params['break'])->get()->toArray();
            $beachName = $beachBreak[0]['beach_name'];
            $postArray->where('beach_breaks.beach_name',$beachName);
        }elseif (isset($params['beach']) && ($params['beach'] > 0)) {
            $beachBreak = BeachBreak::where('id', $params['beach'])->get()->toArray();
            $beachName = $beachBreak[0]['beach_name'];
            $postArray->where('beach_breaks.beach_name',$beachName);
        }

        if (isset($params['break']) && $params['break']>0) {
            $postArray->where('beach_breaks.id',$params['break']);
        } */
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

        //dd($postArray->toSql());
        if(isset($page) && !empty($page)) {
            return $postArray->get();
        } else {
            return $postArray->paginate(10);
        }
    }

    /**
     * [getAdminFiltered] we are getiing all login user post with filter
     * @param
     * @param
     * @return dataArray
     */
    public function getAdminFilteredData($params, $for, $type = null, $page = null) {
        if ($for=='search'){
            $postArray =  $this->posts
                        ->join('beach_breaks', 'beach_breaks.id', '=', 'posts.local_beach_id')
                        ->leftJoin('ratings', 'posts.id', '=', 'ratings.rateable_id')
                        ->leftJoin('user_profiles', 'posts.user_id', '=', 'user_profiles.user_id')
                        ->leftJoin('users', 'posts.user_id', '=', 'users.id')
                        ->select(DB::raw('avg(ratings.rating) as average, posts.*'))
                        ->whereNull('posts.deleted_at')
                        ->groupBy('posts.id');
        }

        if ($for=='myhub'){
            $postArray =  $this->posts
                        ->join('beach_breaks', 'beach_breaks.id', '=', 'posts.local_beach_id')
                        ->leftJoin('ratings', 'posts.id', '=', 'ratings.rateable_id')
                        ->select(DB::raw('avg(ratings.rating) as average, posts.*'))
                        ->whereNull('posts.deleted_at')
                        ->where('parent_id', '0')
                        ->groupBy('posts.id');
        }

        if (($for == 'myhub') && ($type == 'posts')) {
            $postArray->where('posts.post_type', 'PUBLIC');
        } elseif (($for == 'myhub') && ($type == 'saved')) {
            $postArray->where('posts.post_type', 'PRIVATE');
            $postArray->where('posts.parent_id','>=', 0);
        } elseif (($for == 'myhub') && ($type == 'upload')) {
            $postArray->where('posts.post_type', 'PRIVATE');
            $postArray->where('posts.parent_id','=', 0);
        } elseif (($for == 'myhub') && ($type == 'tags')) {
            $postArray =  $this->posts
                        ->join('tags', 'posts.id', "=", 'tags.post_id')
                        ->join('beach_breaks', 'beach_breaks.id', '=', 'posts.local_beach_id')
                        ->leftJoin('ratings', 'posts.id', '=', 'ratings.rateable_id')
                        ->select(DB::raw('avg(ratings.rating) as average, posts.*'))
                        ->where('tags.is_deleted', '0')
                        ->groupBy('posts.id');
        } elseif (($for == 'myhub') && ($type == 'reels')) {
            $postArray->where('posts.is_highlight', '1');
        }
        // dd($postArray->toSql());
        //************* applying conditions *****************/
        if (isset($params['username_id']) && !empty($params['username_id'])) {
            $postArray->where('posts.user_id', $params['username_id']);
            $postArray->where('posts.parent_id', 0);
        }

        if (isset($params['filterUser']) && ($params['filterUser'] == 'me')) {
            $username = Auth::user()->user_name;
            $postArray->where('surfer', $username);
        } elseif (isset($params['filterUser']) && ($params['filterUser'] == 'others') && isset($params['other_surfer']) && !empty($params['other_surfer'])) {
            $postArray->where('surfer', $params['other_surfer']);
        } elseif (isset($params['filterUser']) && ($params['filterUser'] == 'unknown')) {
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
        if(isset($params['additional_info']) && !empty($params['additional_info'])) {
            $postArray->where(function($q) use($params){

            foreach ($params['additional_info'] as $val) {
            $q->orWhere('additional_info', 'LIKE',  '%' . $val .'%');
            }

            });
        }

        if (isset($params['surf_date']) && !empty($params['surf_date'])) {
           $postArray->whereDate('surf_start_date','>=',$params['surf_date']);
        }
        if (isset($params['end_date']) && !empty($params['end_date'])) {
           $postArray->whereDate('surf_start_date','<=',$params['end_date']);
        }

        if (isset($params['country_id']) && !empty($params['country_id'])) {
            $postArray->where('posts.country_id',$params['country_id']);
        }
        if (isset($params['break']) && !empty($params['break'])) {
            $postArray->where('local_break_id', $params['break']);
        }elseif (isset($params['local_beach_id']) && !empty($params['local_beach_id'])) {
            $postArray->where('local_beach_id', $params['local_beach_id']);
        }
        if (isset($params['board_type']) && !empty($params['board_type'])) {
            $postArray->where('board_type',$params['board_type']);
        }
        if (isset($params['wave_size']) && !empty($params['wave_size'])) {
            $postArray->where('wave_size',$params['wave_size']);
        }

        if (isset($params['state_id'])) {
            $postArray->where('posts.state_id',$params['state_id']);
        }

        if (isset($params["user_type"])) {
            $postArray->whereIn('user_type', $params["user_type"]);
        }

        if (isset($params["gender"])) {
            $postArray->where('gender', '=', $params["gender"]);
        }
        if (isset($params["from_age"]) && !isset($params["to_age"])) {
            $from_age = date('Y-m-d', strtotime('-'.$params["from_age"].' year'));
            $postArray->where('dob', '<=', $from_age);
        }
        if (!isset($params["from_age"]) && isset($params["to_age"])) {
            $to_age = date('Y-m-d', strtotime('-'.$params["to_age"].' year'));
            $postArray->where('dob', '>=', $to_age);
        }
        if (isset($params["from_age"]) && isset($params["to_age"])) {
            $from_age = date('Y-m-d', strtotime('-'.$params["from_age"].' year'));
            $to_age = date('Y-m-d', strtotime('-'.$params["to_age"].' year'));
            $postArray->where('dob', '<=', $from_age);
            $postArray->where('dob', '>=', $to_age);
        }

        if (isset($params['rating']) && $params['rating']>0) {
            $postArray->havingRaw('round(avg(ratings.rating)) = '. $params['rating']);
            // $postArray->where('avg(ratings.rating)', $params['rating']);
        }

        /*if (isset($params['break']) && !empty($params['break'])) {
            $beachBreak = BeachBreak::where('id', $params['break'])->get()->toArray();
            $beachName = $beachBreak[0]['beach_name'];
            $postArray->where('beach_breaks.beach_name',$beachName);
        }elseif (isset($params['beach']) && ($params['beach'] > 0)) {
            $beachBreak = BeachBreak::where('id', $params['beach'])->get()->toArray();
            $beachName = $beachBreak[0]['beach_name'];
            $postArray->where('beach_breaks.beach_name',$beachName);
        }

        if (isset($params['break']) && $params['break']>0) {
            $postArray->where('beach_breaks.id',$params['break']);
        } */
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

        //dd($postArray->toSql());
        if(isset($page) && !empty($page)) {
            return $postArray->get();
        } else {
            return $postArray->paginate(10);
        }
    }

    /**
     * [getFeedFilteredList] we are getiing all login user post with filter
     * @param
     * @param
     * @return dataArray
     */
    public function getFeedFilteredList($data, $page = null) {
        $postsList =  $this->posts
            ->join('beach_breaks', 'beach_breaks.id', '=', 'posts.local_beach_id')
            ->leftJoin('ratings', 'posts.id', '=', 'ratings.rateable_id')
            ->leftJoin('user_profiles', 'posts.user_id', '=', 'user_profiles.user_id')
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->select(DB::raw('avg(ratings.rating) as average, posts.*'))
            ->whereNull('posts.deleted_at')
            ->where('posts.parent_id', '0')
            ->where(function ($query) {
                $query->where('posts.post_type', 'PUBLIC')
                ->orWhere('posts.is_feed', '1');
            })
            ->groupBy('posts.id');

        if (isset($data['sort'])) {
            if($data['sort'] == "dateAsc"){
                $postsList->orderBy('posts.created_at','ASC');
            }
            else if($data['sort'] == "dateDesc"){
                $postsList->orderBy('posts.created_at','DESC');
            }
            else if($data['sort'] == "surfDateAsc"){
                $postsList->orderBy('posts.surf_start_date','ASC');
            }
            else if($data['sort'] == "surfDateDesc"){
                $postsList->orderBy('posts.surf_start_date','DESC');
            }
            else if($data['sort'] == "beach"){
                $postsList->orderBy('beach_breaks.beach_name','ASC');
            }
            else if($data['sort'] == "star"){
                $postsList->orderBy('average','DESC');
            }
            else{
                $postsList->orderBy('posts.created_at','DESC');
            }
        } else {
            $postsList->orderBy('posts.id','DESC');
        }

        if(isset($page) && !empty($page)) {
            return $postsList->get();
        } else {
            return $postsList->paginate(10);
        }
    }

    /**
     * [getFilteredList] we are getiing all login user post with filter
     * @param
     * @param
     * @return dataArray
     */
    public function getSurferPostData($user_id) {
        $postArray =  $this->posts
                    ->join('beach_breaks', 'beach_breaks.id', '=', 'posts.local_beach_id')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.rateable_id')
                    ->select(DB::raw('avg(ratings.rating) as average, posts.*'))
                    ->whereNull('posts.deleted_at')
                    ->where('posts.user_id', $user_id)
                    ->groupBy('posts.id');

        $postArray->where('posts.post_type', 'PUBLIC');


        $postArray->orderBy('posts.id','DESC');

        // dd($postArray->toSql());
        return $postArray->get();
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
        $posts->local_beach_id = $input['local_beach_break_id'];
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
            $posts->local_beach_id = $input['local_beach_break_id'];
            $posts->local_break_id = $input['break_id'];
            $posts->surfer = $input['surfer'];
            $posts->optional_info = (!empty($input['optional_info'])) ? implode(" ",$input['optional_info']) : null;
            $posts->additional_info = (!empty($input['additional_info'])) ? implode(" ",$input['additional_info']) : null;
            $posts->stance = (!empty($input['stance'])) ? $input['stance'] : null;
            $posts->fin_set_up = (!empty($input['fin_set_up'])) ? $input['fin_set_up'] : null;
            $posts->created_at = Carbon::now();
            $posts->updated_at = Carbon::now();

            if($posts->save()){
                if(isset($input['other_surfer']) && !empty($input['other_surfer'])) {
                    $userID = User::where('user_name', $input['surfer'])->first('id');
                    if(isset($userID->id) && ($input['user_id'] != $userID->id)) {
                        $data['user_id'] = $userID->id;
                        $data['post_id'] = $posts->id;

                        $userService = New UserService();
                        $userService->tagUserOnPost($data);
                    }
                }

                if(isset($filename) && !empty($filename)) {
                    $upload = new Upload();

                    if (isset($fileType) && ($fileType == 'image')) {
                        $upload->image = $filename;
                    } elseif (isset($fileType) && ($fileType == 'video')) {
                        $upload->video = $filename;
                    }
//                    $handle = fopen($file, "r") or die("Couldn't get handle");
//                    while (!feof($handle)) {
//                        $upload->file_body = fgets($handle, 4096);
//                        // Process buffer here..
//                    }
//                    $upload->file_body = file_get_contents($file);
                    $upload->post_id = $posts->id;
                    $upload->save();
                }
            }

            $message = 'Post has been updated successfully.!';
            return $message;
        }
        catch (\Exception $e){
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message = '"'.$e->getMessage().'"';
            return $message;
        }
    }


    public function saveAdminAds($input, $fileType = '', $filename = '', &$message=''){
        try{
//            $lines = [];
//            $handle = fopen($file, "r");
//            $content = file($file);
//            echo '<pre>';            print_r($input);die;

            $adminAd = new AdminAd();
            $adminAd->ad_position = (!empty($input['position'])) ? implode(" ",$input['position']) : null;
            $adminAd->user_id = Auth::user()->id;
            $adminAd->page_id = $input['page_id'];
            $adminAd->image = $filename;
            $adminAd->created_at = Carbon::now();
            $adminAd->updated_at = Carbon::now();
            $adminAd->save();

            $message = 'Ad has been updated successfully.!';
            return $message;
        }
        catch (\Exception $e){
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message = '"'.$e->getMessage().'"';
            return $message;
        }
    }


    public function saveAdvertPost($input, $fileType = '', $filename = '', &$message=''){
        try{
//            $lines = [];
//            $handle = fopen($file, "r");
//            $content = file($file);
//            echo '<pre>';  dump($input);die;
            $posts = new Post();
            $posts->post_type = 'PRIVATE';
            $posts->user_id = Auth::user()->id;
            $posts->country_id =$input['search_country_id'];
            $posts->post_text =$input['post_text'];
            $posts->board_type = $input['search_board_type'];
            $posts->state_id = $input['search_state_id'];
            $posts->local_beach_id = $input['local_beach_break_id'];
            $posts->local_break_id = $input['break_id'];
            $posts->surfer = $input['other_surfer'];
            $posts->fin_set_up = (!empty($input['fin_set_up'])) ? $input['fin_set_up'] : null;
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
//                    $handle = fopen($file, "r") or die("Couldn't get handle");
//                    while (!feof($handle)) {
//                        $upload->file_body = fgets($handle, 4096);
//                        // Process buffer here..
//                    }
//                    $upload->file_body = file_get_contents($file);
                    $upload->post_id = $posts->id;
                    $upload->save();

                }

                $advertPost = new AdvertPost();
                $advertPost->post_id = $posts->id;
                $advertPost->ad_link = $input['ad_link'];
                $advertPost->surfhub_target = isset($input['surfHub'])?$input['surfHub']:0;
                $advertPost->profile_target = isset($input['profile'])?$input['profile']:0;
                $advertPost->search_target = isset($input['search'])?$input['search']:0;
                $advertPost->gender = $input['gender'];
                $advertPost->optional_user_type = $input['userType'];
                $advertPost->optional_country_id = $input['country_id'];
                $advertPost->optional_state_id = $input['state_id'];
                $advertPost->optional_postcode = $input['postcode'];
                $advertPost->optional_beach_id = $input['local_beach_id'];
                $advertPost->optional_board_type = $input['board_type'];
                $advertPost->optional_camera_brand = $input['camera_brand'];
                $advertPost->optional_surf_resort = $input['resort'];
                $advertPost->search_user_type = $input['search_user_type'];
                $advertPost->search_surf_resort = $input['search_resort'];
                $advertPost->currency_type = $input['currency_type'];
                $advertPost->your_budget = $input['budget'];
                $advertPost->per_view = $input['per_view'];
                $advertPost->start_date = $input['start_date'];
                $advertPost->end_date = $input['end_date'];
                $advertPost->preview_ad = isset($input['preview'])?$input['preview']:0;
                $advertPost->save();



            }
            $result = array(
                'post_id' => $posts->id,
                'message' => 'Post has been updated successfully.!'
            );
            $message = 'Post has been updated successfully.!';
            return $result;
        }
        catch (\Exception $e){
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message = '"'.$e->getMessage().'"';
//            echo '<pre>';dump($message);die;
            return $message;
        }
    }


    public function updateAdvertPost($input, $fileType = '', $filename = '', &$message=''){
        try{
//            $lines = [];
//            $handle = fopen($file, "r");
//            $content = file($file);
//            echo '<pre>';  dump($input);die;
            $posts = Post::findOrFail($input['post_id']);
            $posts->post_type = 'PRIVATE';
            $posts->user_id = Auth::user()->id;
            $posts->post_text =$input['post_text'];
            $posts->country_id =$input['search_country_id'];
            $posts->board_type = $input['search_board_type'];
            $posts->state_id = $input['search_state_id'];
            $posts->local_beach_id = $input['local_beach_break_id'];
            $posts->local_break_id = $input['break_id'];
            $posts->surfer = $input['other_surfer'];
            $posts->fin_set_up = (!empty($input['fin_set_up'])) ? $input['fin_set_up'] : null;
            $posts->created_at = Carbon::now();
            $posts->updated_at = Carbon::now();

            if($posts->save()){
                if(isset($filename) && !empty($filename)) {
                    $upload = Upload::where('post_id', $posts->id)->first();


                    if (isset($fileType) && ($fileType == 'image')) {
                        $upload->image = $filename;
                        $upload->video = null;
                    } elseif (isset($fileType) && ($fileType == 'video')) {
                        $upload->image = null;
                        $upload->video = $filename;
                    }
                    $upload->post_id = $posts->id;
                    $upload->save();

                }
                $advertPost = AdvertPost::where('post_id', $posts->id)->first();
                $advertPost->post_id = $posts->id;
                $advertPost->ad_link = $input['ad_link'];
                $advertPost->surfhub_target = isset($input['surfHub'])?$input['surfHub']:0;
                $advertPost->profile_target = isset($input['profile'])?$input['profile']:0;
                $advertPost->search_target = isset($input['search'])?$input['search']:0;
                $advertPost->gender = $input['gender'];
                $advertPost->optional_user_type = $input['userType'];
                $advertPost->optional_country_id = $input['country_id'];
                $advertPost->optional_state_id = $input['state_id'];
                $advertPost->optional_postcode = $input['postcode'];
                $advertPost->optional_beach_id = $input['local_beach_id'];
                $advertPost->optional_board_type = $input['board_type'];
                $advertPost->optional_camera_brand = $input['camera_brand'];
                $advertPost->optional_surf_resort = $input['resort'];
                $advertPost->search_user_type = $input['search_user_type'];
                $advertPost->search_surf_resort = $input['search_resort'];
                $advertPost->currency_type = $input['currency_type'];
                $advertPost->your_budget = $input['budget'];
                $advertPost->per_view = $input['per_view'];
                $advertPost->start_date = $input['start_date'];
                $advertPost->end_date = $input['end_date'];
                $advertPost->preview_ad = !empty($input['preview'])?$input['preview']:0;
                $advertPost->save();



            }
            $result = array(
                'post_id' => $posts->id,
                'message' => 'Post has been updated successfully.!'
            );
            $message = 'Post has been updated successfully.!';
            return $result;
        }
        catch (\Exception $e){
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message = '"'.$e->getMessage().'"';
//            echo '<pre>';dump($message);die;
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
        // $posts->user_id = $input['user_id'];
        $posts->post_text = $input['post_text'];
        $posts->country_id =$input['country_id'];
        $posts->surf_start_date = $input['surf_date'];
        $posts->wave_size = $input['wave_size'];
        $posts->board_type = $input['board_type'];
        $posts->state_id = $input['state_id'];
        $posts->local_beach_id = $input['local_beach_break_id'];
        $posts->surfer = (isset($input['surfer']) && ($input['surfer'] == 'Me'))?Auth::user()->user_name:$input['surfer'];
        $posts->optional_info = (!empty($input['optional_info'])) ? implode(" ",$input['optional_info']) : null;
        $posts->additional_info = (!empty($input['additional_info'])) ? implode(" ",$input['additional_info']) : null;
        $posts->stance = (!empty($input['stance'])) ? $input['stance'] : null;
        $posts->fin_set_up = (!empty($input['fin_set_up'])) ? $input['fin_set_up'] : null;
        $posts->created_at = Carbon::now();
        $posts->updated_at = Carbon::now();
        if($posts->save()){
            //for store media into upload table
            if (isset($filename) && !empty($filename)) {
                $upload = Upload::where('post_id', $posts->id)->first();

                if($upload) {
                    if (isset($type) && ($type == 'image')) {
                        $upload->image = $filename;
                    } elseif (isset($type) && ($type == 'video')) {
                        $upload->video = $filename;
                    }

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
     * [updatePostM] we are updating the post Details after media uploaded by dropzone
     * @param  requestInput get all the requested input data
     * @param  message return message based on the condition
     * @return dataArray with message
     */
    public function updatePostM($input, &$message = '') {

        try {
            $postIdArr = explode(',', $input['post_id']);

            foreach ($postIdArr as $id) {

                $posts = $this->posts->find($id);

//            echo '<pre>';            print_r($posts);die;

                $posts->post_type = $input['post_type'];
                $posts->user_id = $input['user_id'];
                $posts->post_text = $input['post_text'];
                $posts->country_id = $input['country_id'];
                $posts->surf_start_date = $input['surf_date'];
                $posts->wave_size = $input['wave_size'];
                $posts->board_type = $input['board_type'];
                $posts->state_id = $input['state_id'];
                $posts->local_beach_id = $input['local_beach_break_id'];
                $posts->local_break_id = $input['break_id'];
                $posts->surfer = (isset($input['surfer']) && ($input['surfer'] == 'Me')) ? Auth::user()->user_name : $input['surfer'];
                $posts->optional_info = (!empty($input['optional_info'])) ? implode(" ", $input['optional_info']) : null;
                $posts->created_at = Carbon::now();
                $posts->updated_at = Carbon::now();
                $posts->save();

            }
            $message = 'Post has been updated successfully.!';
            return $message;
        } catch (\Exception $e) {
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message = '"' . $e->getMessage() . '"';
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
            $posts->local_beach_id = $input['local_beach_break_id'];
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
        // dd($posts->rateOnce($value));
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
    public function saveToMyHub($id, &$message=''){
        if ($this->posts->where('parent_post_id', $id)->where('user_id', Auth::user()->id)->exists()) {
            $message = 'Post already saved.';
        } else {
            $postSave=$this->posts->find($id);
            $postMedia = Upload::select('*')->where('post_id',$id)->get();

            try{
                $this->posts['post_type'] = 'PRIVATE';
                $this->posts['user_id'] = Auth::user()->id;
                $this->posts['post_text'] = $postSave->post_text;
                $this->posts['country_id'] =$postSave->country_id;
                $this->posts['surf_start_date'] = $postSave->surf_start_date;
                $this->posts['wave_size'] = $postSave->wave_size;
                $this->posts['board_type'] = $postSave->board_type;
                $this->posts['state_id'] = $postSave->state_id;
                $this->posts['local_beach_id'] = $postSave->local_beach_id;
                $this->posts['surfer'] = $postSave->surfer;
                $this->posts['optional_info'] = $postSave->optional_info;

                if (isset($postSave->parent_id) && ($postSave->parent_id > 0)) {
                    $this->posts['parent_id'] = $postSave->parent_id;
                } else {
                    $this->posts['parent_id'] = $postSave->user_id;
                }

                if (isset($postSave->parent_post_id) && ($postSave->parent_post_id > 0)) {
                    $this->posts['parent_post_id'] = $postSave->parent_post_id;
                } else {
                    $this->posts['parent_post_id'] = $postSave->id;
                }

                $this->posts['local_break_id'] = $postSave->local_break_id;
                $this->posts['additional_info'] = $postSave->additional_info;
                $this->posts['fin_set_up'] = $postSave->fin_set_up;
                $this->posts['stance'] = $postSave->stance;
                $this->posts['created_at'] = Carbon::now();
                $this->posts['updated_at'] = Carbon::now();

                if($this->posts->save()){
                    $post_id = $this->posts->id;
                    foreach($postMedia as $media){
                        $upload = new Upload();
                        $upload->post_id = $post_id;
                        $upload->image = $media->image;
                        $upload->video = $media->video;

                        if (isset($media->parent_media_id) && ($media->parent_media_id > 0)) {
                            $upload->parent_media_id = $media->parent_media_id;
                        } else {
                            $upload->parent_media_id = $media->id;
                        }

                        $upload->save();
                    }

                    $message = 'Post has been saved successfully.!';
                }
            }
            catch (\Exception $e){
                $message='"'.$e->getMessage().'"';
            }
        }

        return $message;
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
        $data = [];
        try{
            $this->report->post_id = $input['post_id'];
            $this->report->user_id = Auth::user()->id;
            if(isset($input['incorrect'])){
                $data['type']['incorrect'] = 'Incorrect';
                $this->report->incorrect = $input['incorrect'];
            }
            if(isset($input['inappropriate'])){
                $data['type']['inappropriate'] = 'Inappropriate';
                $this->report->inappropriate = $input['inappropriate'];
            }
            if(isset($input['tolls'])){
                $data['type']['tolls'] = 'Tolls';
                $this->report->tolls = $input['tolls'];
            }
            $this->report->comments = $input['comments'];
            $this->report->created_at = Carbon::now();
            $this->report->updated_at = Carbon::now();
            //dd($this->comments);
            if($this->report->save()) {
                $data['from'] = config('customarray.report_email');
                $data['mail'] = 'report';
                $data['name'] = Auth::user()->user_name;
                $data['email'] = Auth::user()->email;
                $data['date'] = $this->report->created_at;
                $data['template'] = 'static-pages.report_mail';
                $data['subject'] = 'Post has been reported as '.implode(', ', $data['type']).' by '.$data['name'].' on '.date('d-m-Y', strtotime($data['date']));
                $data['comment'] = $this->report->comments;
                $data['post_id'] = $this->report->post_id;

                Mail::to($data['from'])
                    ->send(new sendReportMail($data));

                //for store media into upload table
                $message = 'Post has been reported successfully.!';
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
    public function saveFollow($input,&$message='') {
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
        $notificationCount =  $this->notification
                                  ->where('receiver_id', Auth::user()->id)
                                  ->where('status', '0')
                                  ->where('count_status', '0')
                                  ->count();
        return $notificationCount;
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

    public function updateAllNotification()
    {
      return $this->notification->where('receiver_id', Auth::user()->id)->update(['status' => '1']);
    }

    public function updateNotificationCountStatus($input)
    {
      $result = Notification::where('receiver_id', Auth::user()->id)->update(['count_status'=>'1','updated_at'=>Carbon::now()]);
      return $result;
    }

    public function updateNotificationCount($id)
    {
      $result = Notification::where('id', $id)->update(['count_status'=>'1', 'status'=>'1', 'updated_at'=>Carbon::now()]);
      return $result;
    }

    /**
     * [surferRequest] we are requesting as surfer for a post
     * @param  message return message based on the condition
     * @return dataArray with message
     */
    public function surferRequest($id,&$message=''){

        try{
            $this->surferRequest->post_id = $id;
            $this->surferRequest->user_id = Auth::user()->id;
            $this->surferRequest->status = 0;
            $this->surferRequest->created_at = Carbon::now();

            if($this->surferRequest->save()) {
                $post = Post::where('id', $id)->first();
                $notification = New Notification();

                $notification->post_id = $post->id;
                $notification->sender_id =  Auth::user()->id;
                $notification->receiver_id = $post->user_id;
                $notification->notification_type = 'Surfer Request';
                $notification->created_at = Carbon::now();

                $notification->save();
            }

            return 'Surfer request has been made successfully!';
        }
        catch (\Exception $e){
            // throw ValidationException::withMessages([$e->getPrevious()->getMessage()]);
            $message='"'.$e->getMessage().'"';
            return $message;
        }
    }
    /**
     * [surferRequest] we are getting surfer request
     * @param  message return message based on the condition
     * @return dataArray with message
     */
    public function getSurferRequest($ids,$status){


        $surferRequest =  $this->surferRequest
                                  ->whereIn('post_id', $ids)
                                  ->where('status',$status)
                                  ->orderBy('id','ASC')
                                  ->get()
                                  ->toArray();
        return $surferRequest;

    }
    public function getReportsCount() {
        $reports = $this->report
                ->orderBy('id', 'ASC')
                ->get()
                ->count();
        return $reports;
    }
    public function getCommentsCount() {
        $comments = $this->comment
                ->orderBy('id', 'ASC')
                ->get()
                ->count();
        return $comments;
    }

    public function getUploads($user_id = null){
        $postArray =  $this->posts
                    ->join('beach_breaks', 'beach_breaks.id', '=', 'posts.local_beach_id')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.rateable_id')
                    ->select(DB::raw('avg(ratings.rating) as average, posts.*'))
                    ->whereNull('posts.deleted_at')
                    ->where('posts.user_id', $user_id)
                    ->where('posts.parent_id', 0)
                    ->groupBy('posts.id')
                    ->orderBy('posts.created_at','DESC');

        return $postArray->get();
    }
}
