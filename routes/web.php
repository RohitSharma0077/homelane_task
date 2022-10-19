<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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


Route::get('/clear-cache', function() {

    $exitCode = \Artisan::call('cache:clear');

    $exitCode1 = \Artisan::call('config:cache');

    $exitCode2 = \Artisan::call('view:clear');

	echo $exitCode;

	echo '<br>';

	echo $exitCode1;

	echo '<br>';

	echo $exitCode2;

	die;

    // return what you want

});

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('users/listing', [App\Http\Controllers\HomeController::class, 'users_view'])->name('users_view');
Route::get('users/ajax/list', [App\Http\Controllers\HomeController::class, 'users_ajax_list'])->name('users_ajax_list');
Route::get('users/edit/{id?}', [App\Http\Controllers\HomeController::class, 'edit_user_master_view'])->name('edit_user_master_view');
Route::post('/admin/delete/user', [App\Http\Controllers\HomeController::class, 'delete_user'])->name('delete_user');

Auth::routes();

Route::middleware(['auth', 'role_super:superadmin'])->group(function () {
    // User is authentication and has super admin role
    Route::get('/super', [App\Http\Controllers\HomeController::class, 'index'])->name('home_super');
   
});


Route::middleware(['auth', 'role_admin:admin'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('home_admin');
   
});


Route::middleware(['auth', 'role_sales:sales'])->group(function () {
    Route::get('/sales', [App\Http\Controllers\HomeController::class, 'index'])->name('home_sales');
});