<?php

use Illuminate\Support\Facades\Route;


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
/**
 * built in routes
 */

/**
 * custom routes
 */

/* New Added Routes */

// Route::get('dashboard', [AuthController::class, 'dashboard'])->middleware(['auth', 'is_verify_email']); 
Route::get('account/verify/{token}', [App\Http\Controllers\AuthenticationController::class, 'verifyAccount'])->middleware('throttle:6,1')->name('user.verify'); 
// Route::middleware('guest')->group(function () {

    //social signup/login
Route::get('/login/{provider}', [App\Http\Controllers\AuthenticationController::class, 'redirect']);
Route::get('/login/{provider}/callback',[App\Http\Controllers\AuthenticationController::class, 'callback']);

// });

// resetting password view
// Route::view('forgot-password',function(){

//     $content = require resource_path('js/componenets/Authentication/ResetPassword.vue'); 
//     return $content;

// })->name('password.reset');

// Auth::routes();  

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('{path}', [App\Http\Controllers\HomeController::class, 'index'])->where('path', '.*');
