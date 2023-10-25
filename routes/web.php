<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminDashboard;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\BeachBreakController;
use App\Http\Controllers\WelcomeFeedController;
use App\Http\Controllers\admin\AdminPageController;
use App\Http\Controllers\user\UserPostController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\user\MyHubController;
use App\Http\Controllers\user\SearchController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SpotifyAuthController;
use App\Http\Controllers\PayPalController;

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
Route::get('/help-faqs', [WelcomeFeedController::class, 'faq'])->name('faq');
Route::get('/contact-us', [WelcomeFeedController::class, 'contact'])->name('contact');
Route::get('/getBeachBreach', [UserController::class, 'getBeachBreach'])->name('getBeachBreach');
Route::get('/getState', [DashboardController::class, 'getState'])->name('getState');
Route::get('/getUsers', [UserController::class, 'getUsers'])->name('getUsers');
Route::get('/getFilterUsers', [UserController::class, 'getFilterUsers'])->name('getFilterUsers');
Route::post('/getFilterUsernames', [UserController::class, 'getFilterUsernames'])->name('getFilterUsernames');
Route::get('/highlight-post/{post_id}', [MyHubController::class, 'highlightPost'])->name('highlight-post');
Route::get('/getTagUsers', [UserController::class, 'getTagUsers'])->name('getTagUsers');
Route::post('/setTagUsers', [UserController::class, 'setTagUsers'])->name('setTagUsers');
Route::post('/checkUsername', [UserController::class, 'checkUsername'])->name('checkUsername');
Route::get('/follow-counts', [UserController::class, 'followCounts'])->name('follow-counts');

Route::get('search',[SearchController::class, 'search'])->name('searchPosts');
Route::get('search/filter', [SearchController::class, 'filter'])->name('searchFilterIndex');
Route::post('upload/file', [UserPostController::class, 'uploadFiles'])->name('uploadFiles');
Route::get('/getBreak', [DashboardController::class, 'getBreak'])->name('getBreak');
/* Get All Beach name according to user input */
Route::get('/getBeachName', [DashboardController::class, 'getBeachName'])->name('getBeachName');


$router->get('spotify-auth', [SpotifyAuthController::class, 'redirectToProvider'])->name('spotify-auth');
$router->get('spotify-call-back', [SpotifyAuthController::class, 'handleProviderCallback'])->name('spotify-call-back');
Route::get('/surfer-request/{id}', [UserPostController::class, 'surferRequest'])->name('surferRequest');
Route::post('/surfer-request-ajax', [UserPostController::class, 'surferRequestAjax'])->name('surferRequestAjax');
Route::get('/getPostFullScreen/{id}/{type}', [MyHubController::class, 'getPostFullScreen'])->name('getPostFullScreen');

Route::post('/getNewPostFullScreen', [MyHubController::class, 'getNewPostFullScreen'])->name('getNewPostFullScreen');

Route::get('/get-presigned-url', [UserPostController::class, 'getPresignedUrl'])->name('getPresignedUrl');
Route::post('/get-presigned-urls', [UserPostController::class, 'getPresignedUrl'])->name('getPresignedUrls');

/*********************************************************************************************
 *                              User Route
 * ********************************************************************************************/

/*Route::middleware(['auth:sanctum', 'verified', 'userAuth'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/

Route::group(['middleware' => ['auth:sanctum', 'verified', 'userAuth']], function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::post('/create-post', [UserPostController::class, 'store'])->name('storeVideoImagePost');

    Route::post('/create-advert-post', [UserPostController::class, 'storeAdvert'])->name('storeAdvert');

    Route::get('/upload', [UserPostController::class, 'upload'])->name('upload');

    Route::post('/upload-large-files', [UserPostController::class, 'uploadLargeFiles'])->name('files.upload.large');

    Route::get('/user/change-password', [UserController::class, 'showChangePassword'])->name('showPassword');

    Route::get('/user/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('/user/edit-profile', [UserController::class, 'editProfile'])->name('edit-profile');

    Route::post('/post/profile', [UserController::class, 'storeProfile'])->name('storeProfile');

   // Route::post('/user/updateProfile', [UserController::class, 'updateProfileImage'])->name('updateProfileImage');

    Route::get('/user/myhub', [MyHubController::class, 'newIndex'])->name('myhub');
    Route::get('/user/myhub/{post_type?}', [MyHubController::class, 'index'])->name('myhubs');

    // Route::get('/getPostData/{id}/{type}', [MyHubController::class, 'edit'])->name('getPostData');
    Route::post('/updatePostData', [MyHubController::class, 'update'])->name('updatePostData');
    Route::get('/getPostData/{id}', [MyHubController::class, 'edit'])->name('getPostData');
    Route::get('/user/myhub/filter', [MyHubController::class, 'filter'])->name('myhubFilterIndex');

//    Route::get('search',[SearchController::class, 'search'])->name('searchPosts');
//    Route::get('search/filter', [SearchController::class, 'filter'])->name('searchFilterIndex');

    Route::post('/delete', [UserPostController::class, 'destroy'])->name('deleteUserPost');
    Route::get('/delete/{id}', [UserPostController::class, 'destroy'])->name('deleteUserPost');
    // Delete MyHub post by ajax
    Route::post('/deletepost', [UserPostController::class, 'destroyPost'])->name('deleteUserPostByAjax');

    Route::get('/saveToMyHub/{id}', [UserPostController::class, 'saveToMyHub'])->name('saveToMyHub');

    Route::post('/rating', [UserPostController::class, 'rating'])->name('rating');

    Route::post('/comment', [UserPostController::class, 'comment'])->name('comment');

    Route::get('/followRequests', [UserController::class, 'followRequests'])->name('followRequests');
    Route::get('/followers', [UserController::class, 'followers'])->name('followers');
    Route::get('/surfer-followers/{id}', [UserController::class, 'surferFollowers'])->name('surferFollowers');
    Route::get('/surfer-following/{id}', [UserController::class, 'surferFollowing'])->name('surferFollowing');
    Route::get('/surfer-post/{id}', [UserController::class, 'surferPost'])->name('surferPost');
    Route::get('/surfer-upload/{id}', [UserController::class, 'surferUpload'])->name('surferUpload');
    Route::get('/following', [UserController::class, 'following'])->name('following');
    Route::post('/unfollow', [UserController::class, 'unfollow'])->name('unfollow');
    Route::post('/accept', [UserController::class, 'accept'])->name('accept');
    Route::get('/searchFollwers/{id}', [UserController::class, 'searchFollwers'])->name('searchFollwers');
    Route::get('/surfer-profile/{id}', [UserController::class, 'surferProfile'])->name('surfer-profile');
    Route::get('/surfer-notification-request/{request_type}/{id}/{post_id?}', [UserController::class, 'surferRequestData'])->name('surfer-request');
    Route::get('/searchFollowing/{id}', [UserController::class, 'searchFollowing'])->name('searchFollowing');
    Route::get('/searchFollowRequest', [UserController::class, 'searchFollowRequest'])->name('searchFollowRequest');
    Route::post('/reject', [UserController::class, 'reject'])->name('reject');
    Route::post('/remove', [UserController::class, 'remove'])->name('remove');
    Route::post('/follow', [UserController::class, 'follow'])->name('follow');
    Route::post('/report', [UserPostController::class, 'report'])->name('report');
    Route::get('/posts/{post_id}/{notification_id}/{notification_type}', [UserPostController::class, 'posts'])->name('posts');
    Route::post('/user/updateNotificationCountStatus', [UserPostController::class, 'updateNotificationCountStatus'])->name('updateNotificationCountStatus');
    Route::get('/user/updateAllNotification', [UserPostController::class, 'updateAllNotification'])->name('updateAllNotification');
    Route::post('updateNotificationCount', [UserPostController::class, 'updateNotificationCount'])->name('updateNotificationCount');
    Route::get('notifications', [UserPostController::class, 'notifications'])->name('notifications');
    Route::get('surfer-follow-request/{id}', [UserPostController::class, 'surferFollowRequest'])->name('surferFollowRequest');

    Route::get('/surfer-request-list', [UserPostController::class, 'surferRequestList'])->name('surferRequestList');
    Route::get('/accept-reject-request/{id}/{type}', [UserPostController::class, 'acceptRejectRequest'])->name('acceptRejectRequest');
    Route::get('/accept-reject-follow-request/{id}/{type}', [UserPostController::class, 'acceptRejectFollowRequest'])->name('acceptRejectFollowRequest');

    Route::post('/upload-media', [UserPostController::class, 'uploadMedia'])->name('uploadMedia');

    Route::get('/get-additional-board-info', [UserController::class, 'getAdditionalBoardTypeInfo'])->name('getAdditionalBoardTypeInfo');

    Route::get('/resort-profile/{id}', [UserController::class, 'resortProfile'])->name('resort-profile');
    Route::get('/photographer-profile/{id}', [UserController::class, 'photographerProfile'])->name('photographer-profile');

    Route::get('/upload-advertisment/{id?}', [UserController::class, 'uploadAdvertisment'])->name('uploadAdvertisment');
    Route::get('/upload-preview/{id}', [UserController::class, 'uploadPreview'])->name('uploadPreview');
    Route::get('/my-ads', [UserController::class, 'myAds'])->name('myAds');
    Route::post('/publish-preview-advert-post', [UserPostController::class, 'publishAdvert'])->name('publishAdvert');
    Route::get('/delete-advert-post/{id}', [UserPostController::class, 'deleteAdvert'])->name('deleteAdvert');
    Route::get('payment-index/{id}', [PayPalController::class, 'paymentIndex'])->name('payment');

});

/*********************************************************************************************
 *                              photograher Route
 * ********************************************************************************************/


//Route::group(['middleware' => ['auth:sanctum', 'verified', 'photographerAuth']], function () {
//
//    Route::get('/photographer/dashboard', [DashboardController::class, 'photographerDashboard'])->name('dashboard');
//
//
//
//});
//
///*********************************************************************************************
// *                              Advertise Route
// * ********************************************************************************************/
//
//
//Route::group(['middleware' => ['auth:sanctum', 'verified', 'advertiseAuth']], function () {
//
//    Route::get('/advertiser/dashboard', [DashboardController::class, 'advertiserDashboard'])->name('dashboard');
//
//
//
//});
//
//
//
///*********************************************************************************************
// *                              Surfer camp Route
// * ********************************************************************************************/
//
//Route::group(['middleware' => ['auth:sanctum', 'verified', 'surfercampAuth']], function () {
//
//    Route::get('/surfercamp/dashboard', [DashboardController::class, 'surfercampDashboard'])->name('dashboard');
//
//
//
//});




Route::get('/postData/{post_id}', [UserPostController::class, 'getPostData'])->name('getPostData');
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

    Route::get('/feed', [AdminDashboard::class, 'feed'])->name('adminFeed');
    Route::get('/left-side-counts', [AdminDashboard::class, 'leftSideCounts'])->name('leftSideCounts');
    Route::get('/myhub/{post_type?}', [AdminDashboard::class, 'myHub'])->name('adminMyHub');
    Route::get('/search',[AdminDashboard::class, 'search'])->name('adminSearchPosts');

    // user Route
    Route::get('/users/index', [AdminUserController::class, 'index'])->name('adminUserListIndex');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('adminUserCreate');
    Route::post('/users/store', [AdminUserController::class, 'store'])->name('adminUserStore');
    Route::get('/users/show/{id}', [AdminUserController::class, 'show'])->name('adminUserDetails');
    Route::get('/users/edit/{id}',  [AdminUserController::class, 'edit'])->name('adminUserEdit');
    Route::get('/users/delete/{id}',  [AdminUserController::class, 'destroy'])->name('adminUserDelete');
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
    Route::post('/post/ads', [PostController::class, 'storeAdminAds'])->name('storeAdminAds');
    Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('postEdit');
    Route::post('/post/update/{id}', [PostController::class, 'update'])->name('postUpdate');
    Route::get('/post/delete/{id}', [PostController::class, 'destroy'])->name('deletePost');
    Route::get('/post/status', [PostController::class, 'statusUpdate'])->name('statusUpdate');
    Route::post('/post/status', [PostController::class, 'statusUpdate'])->name('statusUpdate');
    Route::get('/post/feed-post', [PostController::class, 'statusFeed'])->name('statusFeed');

    /************ Report url **********/
    Route::get('/report/index', [ReportController::class, 'index'])->name('reportIndex');
    Route::get('/report/search', [ReportController::class, 'searchReport'])->name('searchReport');



    /*********** Beach break ******/
    Route::get('/breachbreak/index', [BeachBreakController::class, 'index'])->name('beachBreakListIndex');
    Route::post('/breachbreak/store', [BeachBreakController::class, 'store'])->name('beachBreakStore');
    Route::post('/breachbreak/update', [BeachBreakController::class, 'update'])->name('beachBreakUpdate');
    Route::post('/breachbreak/import-excel', [BeachBreakController::class, 'importBeachBreak'])->name('importBeachBreak');
    Route::get('/deleteBeachBreak/{id}', [BeachBreakController::class, 'destroy'])->name('deleteBeachBreak');
    Route::get('/get-beach-break-detail/{id}', [BeachBreakController::class, 'getBeachBreakDetail'])->name('getBeachBreakDetail');
});

/***************** S3 Bucket *************/
Route::get('image-upload', [ImageController::class, 'index' ])->name('image.index');
Route::post('image-upload', [ImageController::class, 'upload' ])->name('image.upload');
