<?php

namespace App\Http\Controllers;

use DB;
use Redirect;
use App\Models\Post;
use App\Models\UserFollow;
use Illuminate\Http\Request;
use App\Models\SurferRequest;
use App\Services\PostService;
use App\Services\UserService;
use App\Services\MasterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @param  AdminUserService  $users
     * @return void
     */
    public function __construct(MasterService $masterService, UserService $userService, PostService $postService) {
        $this->masterService = $masterService;
        $this->customArray = config('customarray');
        $this->userService = $userService;
        $this->postService = $postService;

        // post model object
        $this->posts = new Post();
    }

    public function dashboard(Request $request) {
        $urlData = (!empty($request->getQueryString()))?$request->getQueryString():"";

        $param = $request->all();
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $beaches = $this->masterService->getBeaches();
        $customArray = $this->customArray;

        $postsList = $this->postService->getFeedFilteredList($param);

        $requestSurfer = array();
        foreach ($postsList as $val) {
            $surferRequest = SurferRequest::where("post_id", "=", $val['id'])
                    ->where("user_id", "=", Auth::user()->id)
                    ->get();
            foreach ($surferRequest as $res) {
                $requestSurfer[$res->post_id] = $res->user_id;
            }
        }

        $url = url()->current();
        $usersList = $this->masterService->getAllUsers();

        if ($request->ajax()) {
            $page = (isset($param['page']) && !empty($param['page']))?$param['page']:1;
            $view = view('elements/homedata', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer','beaches','page', 'urlData'))->render();
            return response()->json(['html' => $view]);
        }

        return view('user.feed', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer','beaches', 'urlData'));
    }

    public function photographerDashboard(Request $request) {
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $postsList = Post::with('followPost')->where('is_deleted', '0')
                ->where('parent_id', '0')
                ->where(function ($query) {
                    $query->where('post_type', 'PUBLIC')
                    ->orWhere('is_feed', '1');
                })
                ->orderBy('posts.created_at', 'DESC')
                ->paginate(10);
        $requestSurfer = array();
        foreach ($postsList as $val) {
            $surferRequest = SurferRequest::join('user_profiles', 'surfer_requests.user_id', '=', 'user_profiles.user_id')
                    ->where("surfer_requests.post_id", "=", $val['id'])
                    ->where("surfer_requests.status", "=", 0)
                    ->get(['surfer_requests.id', 'user_profiles.first_name', 'user_profiles.last_name']);

            foreach ($surferRequest as $res) {
                $requestSurfer[$val['id']]['id'] = $res['id'];
                $requestSurfer[$val['id']]['name'] = $res['first_name'] . ' ' . $res['last_name'];
            }
        }
        $url = url()->current();
        $usersList = $this->masterService->getAllUsers();

        if ($request->ajax()) {
            $view = view('elements/homedata', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url'))->render();
            return response()->json(['html' => $view]);
        }

        return view('photographer-dashboard', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer'));
    }

    public function advertiserDashboard(Request $request) {
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $postsList = Post::with('followPost')->where('is_deleted', '0')
                ->where('parent_id', '0')
                ->where(function ($query) {
                    $query->where('post_type', 'PUBLIC')
                    ->orWhere('is_feed', '1');
                })
                ->orderBy('posts.created_at', 'DESC')
                ->paginate(10);
        $requestSurfer = array();
        foreach ($postsList as $val) {
            $surferRequest = SurferRequest::join('user_profiles', 'surfer_requests.user_id', '=', 'user_profiles.user_id')
                    ->where("surfer_requests.post_id", "=", $val['id'])
                    ->where("surfer_requests.status", "=", 0)
                    ->get(['surfer_requests.id', 'user_profiles.first_name', 'user_profiles.last_name']);

            foreach ($surferRequest as $res) {
                $requestSurfer[$val['id']]['id'] = $res['id'];
                $requestSurfer[$val['id']]['name'] = $res['first_name'] . ' ' . $res['last_name'];
            }
        }
        $url = url()->current();
        $usersList = $this->masterService->getAllUsers();

        if ($request->ajax()) {
            $view = view('elements/homedata', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url'))->render();
            return response()->json(['html' => $view]);
        }

        return view('advertiser-dashboard', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer'));
    }

    public function surfercampDashboard(Request $request) {
        $currentUserCountryId = Auth::user()->user_profiles->country_id;
        $countries = $this->masterService->getCountries();
        $states = $this->masterService->getStateByCountryId($currentUserCountryId);
        $customArray = $this->customArray;
        $postsList = Post::with('followPost')->where('is_deleted', '0')
                ->where('parent_id', '0')
                ->where(function ($query) {
                    $query->where('post_type', 'PUBLIC')
                    ->orWhere('is_feed', '1');
                })
                ->orderBy('posts.created_at', 'DESC')
                ->paginate(10);
        $requestSurfer = array();
        foreach ($postsList as $val) {
            $surferRequest = SurferRequest::join('user_profiles', 'surfer_requests.user_id', '=', 'user_profiles.user_id')
                    ->where("surfer_requests.post_id", "=", $val['id'])
                    ->where("surfer_requests.status", "=", 0)
                    ->get(['surfer_requests.id', 'user_profiles.first_name', 'user_profiles.last_name']);

            foreach ($surferRequest as $res) {
                $requestSurfer[$val['id']]['id'] = $res['id'];
                $requestSurfer[$val['id']]['name'] = $res['first_name'] . ' ' . $res['last_name'];
            }
        }
        $url = url()->current();
        $usersList = $this->masterService->getAllUsers();

        if ($request->ajax()) {
            $view = view('elements/homedata', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url'))->render();
            return response()->json(['html' => $view]);
        }

        return view('surfercamp-dashboard', compact('customArray', 'countries', 'states', 'currentUserCountryId', 'postsList', 'url', 'requestSurfer'));
    }

    public function getState(Request $request) {
        $data = $request->all();

        $getStateArray = $this->masterService->getStateByCountryId($data['country_id']);
        if ($getStateArray) {
            echo json_encode(array('status' => 'success', 'message' => 'true', 'data' => $getStateArray));
        } else {
            echo json_encode(array('status' => 'failure', 'message' => 'false', 'data' => null));
        }
        die;
    }

    public function getBreak(Request $request) {
        $data = $request->all();

        $getBeachArray = $this->masterService->getBeachById($data['beach_id']);
        $beachName = $getBeachArray[0]['beach_name'];
        $getBreakArray = $this->masterService->getBreakByBeachName($beachName);
        if ($getBreakArray) {
            echo json_encode(array('status' => 'success', 'message' => 'true', 'data' => $getBreakArray));
        } else {
            echo json_encode(array('status' => 'failure', 'message' => 'false', 'data' => null));
        }
        die;
    }

    /**
     * Check the user first time login
     *
     * @return \Illuminate\Http\Response
     */
    public function checkLoginAttempt() {
        dd(Auth::user()->first_time_login);
        if (Auth::user()->first_time_login) {
            $first_time_login = true;
            Auth::user()->first_time_login = false;
            Auth::user()->save();
        } else {
            $first_time_login = false;
        }

        return $first_time_login;
    }

    /**
     * Get all Beach name which is similar to given input by User.
     *
     * @param  beach_name
     * @return Custom Html with data
     */
    public function getBeachName(Request $request) {
        $data = $request->all();

        $beachLists = $this->masterService->getBeachNameLike($data['beach_name']);
        if ($beachLists) {
            echo json_encode(array('status' => 'success', 'message' => 'true', 'data' => $beachLists));
        } else {
            echo json_encode(array('status' => 'failure', 'message' => 'false', 'data' => null));
        }
        die;
    }

}
