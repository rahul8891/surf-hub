<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRedirect;
use App\Http\Controllers\admin\AdminDashboard;
use App\Http\Controllers\admin\AdminUserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth:sanctum', 'verified','userAuth'])->get('/', function () {     
    return view('welcome');
})->name('welcome');

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

    // Admin User Listing Route
    Route::get('/users/index', [AdminUserController::class, 'index'])->name('adminUserListIndex');
});
