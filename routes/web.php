<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminDashboard;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\WelcomeFeedController;
use App\Http\Controllers\admin\AdminPageController;
use App\Http\Controllers\user\PostController;
use App\Http\Controllers\DashboardController;

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


/*********************************************************************************************
 *                              User Route
 * ********************************************************************************************/

/*Route::middleware(['auth:sanctum', 'verified', 'userAuth'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/

Route::group(['middleware' => ['auth:sanctum', 'verified', 'userAuth']], function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');  
     
    Route::post('/post/store', [PostController::class, 'store'])->name('storeVedioImagePost');
});


// Route::group(['middleware' => ['auth', 'userAuth']], function () {
    
//     // Route::get('/post/index', [PostController::class, 'index'])->name('postindex');
//     Route::post('/post/savepost', [PostController::class, 'storePost'])->name('storeVedioImagePost');
    
// });


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
});