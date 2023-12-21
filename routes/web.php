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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('main_admin', [App\Http\Controllers\HomeController::class, 'main_admin'])->name('main_admin')->middleware('type');
Route::get('main_staff', [App\Http\Controllers\HomeController::class, 'main_staff'])->name('main_staff')->middleware('type');
Route::get('main_user', [App\Http\Controllers\HomeController::class, 'main_user'])->name('main_user')->middleware('type');
Route::get('main_manage', [App\Http\Controllers\HomeController::class, 'main_manage'])->name('main_manage')->middleware('type');

Route::middleware(['type'])->group(function(){

Route::match(['get','post'],'admin_profile_edit/{id}',[App\Http\Controllers\HomeController::class, 'admin_profile_edit'])->name('pro.admin_profile_edit');//

});
