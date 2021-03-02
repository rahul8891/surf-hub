<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminDashboard;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\WelcomeFeedController;
use App\Http\Controllers\admin\AdminPageController;
use App\Http\Controllers\user\UserPostController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\user\MyHubController;
use App\Http\Controllers\user\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*********************************************************************************************
 *                            Guest User Route
 * ********************************************************************************************/

Route::get('/', [WelcomeFeedController::class, 'welcome'])->name('feed');
Route::get('/privacy-policy', [WelcomeFeedController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [WelcomeFeedController::class, 'terms'])->name('terms');
Route::get('/help-faq', [WelcomeFeedController::class, 'faq'])->name('faq');
Route::get('/contact-us', [WelcomeFeedController::class, 'contact'])->name('contact');
Route::get('/getBeachBreach', [UserController::class, 'getBeachBreach'])->name('getBeachBreach');
Route::get('/getState', [DashboardController::class, 'getState'])->name('getState');
Route::get('/getUsers', [UserController::class, 'getUsers'])->name('getUsers');
Route::post('/checkUsername', [UserController::class, 'checkUsername'])->name('checkUsername');

/*********************************************************************************************
 *                              User Route
 * ********************************************************************************************/

/*Route::middleware(['auth:sanctum', 'verified', 'userAuth'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/

Route::group(['middleware' => ['auth:sanctum', 'verified', 'userAuth']], function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');  
     
    Route::post('/create-post', [UserPostController::class, 'store'])->name('storeVideoImagePost');

    Route::get('/user/change-password', [UserController::class, 'showChangePassword'])->name('showPassword');

    Route::get('/user/profile', [UserController::class, 'showProfile'])->name('profile');

    Route::post('/post/profile', [UserController::class, 'storeProfile'])->name('storeProfile');

   // Route::post('/user/updateProfile', [UserController::class, 'updateProfileImage'])->name('updateProfileImage');   
    
    Route::get('/user/myhub', [MyHubController::class, 'index'])->name('myhub');
    Route::get('/user/myhub/filter', [MyHubController::class, 'filter'])->name('myhubFilterIndex');
    
    Route::get('search',[SearchController::class, 'search'])->name('searchPosts');
    Route::get('search/filter', [SearchController::class, 'filter'])->name('searchFilterIndex');

    Route::post('/delete', [UserPostController::class, 'destroy'])->name('deleteUserPost');
    Route::get('/delete/{id}', [UserPostController::class, 'destroy'])->name('deleteUserPost');

    Route::get('/saveToMyHub/{id}', [UserPostController::class, 'saveToMyHub'])->name('saveToMyHub');

    Route::post('/rating', [UserPostController::class, 'rating'])->name('rating');

    Route::post('/comment', [UserPostController::class, 'comment'])->name('comment');
    Route::post('/report', [UserPostController::class, 'report'])->name('report');
    Route::post('/follow', [UserPostController::class, 'follow'])->name('follow');
   
    
});


/**
 * Common Route
 */

Route::group(['middleware' => ['auth']], function () {
    Route::post('/updateProfile', [UserController::class, 'updateProfileImage'])->name('updateProfileImage');   
});

Route::get('/contact-us/submit',[WelcomeFeedController::class, 'query_submit'])->name('getQuery');


/*********************************************************************************************
 *                              Admin Route
 * ********************************************************************************************/

Route::group(['prefix' => 'admin',  'middleware' => ['auth', 'adminAuth']], function () {

    // Admin Dashboard Route
    Route::get('/dashboard/index', [AdminDashboard::class, 'index'])->name('adminIndex');

    // user Route
    Route::get('/users/index', [AdminUserController::class, 'index'])->name('adminUserListIndex');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('adminUserCreate');
    Route::post('/users/store', [AdminUserController::class, 'store'])->name('adminUserStore');
    Route::get('/users/show/{id}', [AdminUserController::class, 'show'])->name('adminUserDetails');
    Route::get('/users/edit/{id}',  [AdminUserController::class, 'edit'])->name('adminUserEdit');
    Route::post('/users/update/{id}', [AdminUserController::class, 'update'])->name('adminUserUpdate');
    Route::post('/users/updateUserStatus', [AdminUserController::class, 'updateUserStatus'])->name('updateUserStatus');
    Route::post('/users/updateActivateStatus', ['as' => 'users.updateActivateStatus', 'uses' => 'UserController@updateActivateStatus', 'middleware' => ['permission:user_activate']]);

    // pages Route
    Route::get('/pages/index', [AdminPageController::class, 'index'])->name('adminPageIndex');
    Route::get('/pages/edit/{id}',  [AdminPageController::class, 'edit'])->name('adminPageEdit');
    Route::post('/pages/update/{id}', [AdminPageController::class, 'update'])->name('adminPageUpdate');

    // post Route
    Route::get('/post/index', [PostController::class, 'index'])->name('postIndex');
    Route::get('/post/delete', [PostController::class, 'destroy'])->name('deletePost');
    Route::get('/post/show/{id}', [PostController::class, 'show'])->name('postDetail');
    Route::get('/post/create', [PostController::class, 'create'])->name('postCreate');
    Route::post('/post/store', [PostController::class, 'store'])->name('postStore');
    Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('postEdit');
    Route::post('/post/update/{id}', [PostController::class, 'update'])->name('postUpdate');
    Route::get('/post/delete/{id}', [PostController::class, 'destroy'])->name('deletePost');
    
    /************ Report url **********/
    Route::get('/report/index', [ReportController::class, 'index'])->name('reportIndex');

});