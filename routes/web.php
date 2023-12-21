<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
 
    if (Auth::check()) {
        return view('main.main_index');
    }else{
        return view('auth.login');
        // return view('main.main_index');
    }
})->name('index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home')->middleware('type');
Route::get('staff/home', [App\Http\Controllers\HomeController::class, 'staffHome'])->name('staff.home')->middleware('type');
Route::get('user/home', [App\Http\Controllers\UserController::class, 'user_index'])->name('user.home')->middleware('type');
Route::get('manage/home', [App\Http\Controllers\HomeController::class, 'manageHome'])->name('manage.home')->middleware('type');

Route::middleware(['type'])->group(function(){



});

