<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRedirect;
use App\Http\Controllers\admin\AdminDashboard;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\WelcomeFeedController;
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

/*Route::get('/', function () {
     return view('welcome');
});*/

Route::get('/', [WelcomeFeedController::class, 'welcome'])->name('feed');



 Route::middleware(['auth:sanctum', 'verified','userAuth'])->get('/dashboard', function () {     
      return view('dashboard');
 })->name('dashboard');

/*Route::prefix('admin')->group(function () {
    Route::get('/dashboard/index', [AdminDashboard::class, 'index'])->middleware(['auth'])->name('admin');
});*/

Route::group(['prefix' => 'admin',  'middleware' => ['auth','adminAuth']], function()
{
    // Admin Dashboard Route
    Route::get('/dashboard/index', [AdminDashboard::class, 'index'])->name('adminIndex');


    /*********************************************************************************************
     *                              Admin User Listing/Adding/Details/Edit Route
     * ********************************************************************************************/
    Route::get('/users/index', [AdminUserController::class, 'index'])->name('adminUserListIndex');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('adminUserCreate');
    Route::post('/users/store', [AdminUserController::class, 'store'])->name('adminUserStore');  
    Route::get('/users/show/{id}', [AdminUserController::class, 'show'])->name('adminUserDetails');
    Route::get('/users/edit/{id}',  [AdminUserController::class, 'edit'])->name('adminUserEdit');
    Route::post('/users/update/{id}', [AdminUserController::class, 'update'])->name('adminUserUpdate');
    Route::post('/users/updateUserStatus', [AdminUserController::class, 'updateUserStatus'])->name('updateUserStatus');
    Route::post('/users/updateActivateStatus', ['as' => 'users.updateActivateStatus', 'uses' => 'UserController@updateActivateStatus','middleware' => ['permission:user_activate']]);


});
