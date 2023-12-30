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

Route::match(['get','post'],'user_editprofile/{id}',[App\Http\Controllers\HomeController::class, 'user_editprofile'])->name('u.user_editprofile');//
Route::match(['get','post'],'user_profile_update',[App\Http\Controllers\HomeController::class, 'user_profile_update'])->name('u.user_profile_update');//

Route::match(['get','post'],'user_train',[App\Http\Controllers\TrainController::class, 'user_train'])->name('u.user_train');//
Route::match(['get','post'],'user_train_add',[App\Http\Controllers\TrainController::class, 'user_train_add'])->name('u.user_train_add');//
Route::match(['get','post'],'user_train_save',[App\Http\Controllers\TrainController::class, 'user_train_save'])->name('u.user_train_save');//
Route::match(['get','post'],'user_train_edit/{id}',[App\Http\Controllers\TrainController::class, 'user_train_edit'])->name('u.user_train_edit');//
Route::match(['get','post'],'user_train_update',[App\Http\Controllers\TrainController::class, 'user_train_update'])->name('u.user_train_update');//

Route::match(['get','post'],'addlocation',[App\Http\Controllers\TrainController::class, 'addlocation'])->name('u.addlocation');//

});

