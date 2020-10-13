<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRedirect;
use App\Http\Controllers\admin\AdminDashboard;
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

Route::get('/', function () {
    return view('welcome');
});

 Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {     
      return view('dashboard');
 })->name('dashboard');

/*Route::prefix('admin')->group(function () {
    Route::get('/dashboard/index', [AdminDashboard::class, 'index'])->middleware(['auth'])->name('admin');
});*/

Route::group(['prefix' => 'admin',  'middleware' => ['auth']], function()
{
    Route::get('/dashboard/index', [AdminDashboard::class, 'index'])->name('admin');
});
