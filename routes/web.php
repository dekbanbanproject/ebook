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

    
        Route::match(['get','post'],'main_hospital',[App\Http\Controllers\HomeController::class, 'main_hospital'])->name('u.main_hospital');//
        Route::match(['get','post'],'main_hospital_update',[App\Http\Controllers\HomeController::class, 'main_hospital_update'])->name('u.main_hospital_update');//
        Route::match(['get','post'],'main_hospital_all',[App\Http\Controllers\HomeController::class, 'main_hospital_all'])->name('u.main_hospital_all');//
        Route::match(['get','post'],'main_hospital_alladd',[App\Http\Controllers\HomeController::class, 'main_hospital_alladd'])->name('u.main_hospital_alladd');//
        Route::match(['get','post'],'main_hospital_allsave',[App\Http\Controllers\HomeController::class, 'main_hospital_allsave'])->name('u.main_hospital_allsave');//
        Route::match(['get','post'],'main_hospital_alledit/{id}',[App\Http\Controllers\HomeController::class, 'main_hospital_alledit'])->name('u.main_hospital_alledit');//
        Route::match(['get','post'],'main_hospital_allupdate',[App\Http\Controllers\HomeController::class, 'main_hospital_allupdate'])->name('u.main_hospital_allupdate');//

        Route::match(['get','post'],'user_editprofile/{id}',[App\Http\Controllers\HomeController::class, 'user_editprofile'])->name('u.user_editprofile');//
        Route::match(['get','post'],'user_profile_update',[App\Http\Controllers\HomeController::class, 'user_profile_update'])->name('u.user_profile_update');//

        Route::match(['get','post'],'user_train',[App\Http\Controllers\TrainController::class, 'user_train'])->name('u.user_train');//
        Route::match(['get','post'],'user_train_add',[App\Http\Controllers\TrainController::class, 'user_train_add'])->name('u.user_train_add');//
        Route::match(['get','post'],'user_train_save',[App\Http\Controllers\TrainController::class, 'user_train_save'])->name('u.user_train_save');//
        Route::match(['get','post'],'user_train_edit/{id}',[App\Http\Controllers\TrainController::class, 'user_train_edit'])->name('u.user_train_edit');//
        Route::match(['get','post'],'user_train_update',[App\Http\Controllers\TrainController::class, 'user_train_update'])->name('u.user_train_update');//
        Route::match(['get','post'],'user_train_print/{id}',[App\Http\Controllers\TrainController::class, 'user_train_print'])->name('u.user_train_print');//

        Route::match(['get','post'],'addlocation',[App\Http\Controllers\TrainController::class, 'addlocation'])->name('u.addlocation');//

        //หัวหน้า
        Route::match(['get','post'],'user_train_hn',[App\Http\Controllers\TrainController::class, 'user_train_hn'])->name('u.user_train_hn');//

        //ผอ
        Route::match(['get','post'],'user_train_po',[App\Http\Controllers\PoController::class, 'user_train_po'])->name('u.user_train_po');//
        Route::match(['get','post'],'user_train_poedit/{id}',[App\Http\Controllers\PoController::class, 'user_train_poedit'])->name('u.user_train_poedit');//
        Route::match(['get','post'],'user_train_poupdate',[App\Http\Controllers\PoController::class, 'user_train_poupdate'])->name('u.user_train_poupdate');//
        Route::match(['get','post'],'user_train_poupdate_no',[App\Http\Controllers\PoController::class, 'user_train_poupdate_no'])->name('u.user_train_poupdate_no');//

        //สสอ.
        Route::match(['get','post'],'user_train_sso',[App\Http\Controllers\SSOController::class, 'user_train_sso'])->name('u.user_train_sso');//
        Route::match(['get','post'],'user_train_sso_approve',[App\Http\Controllers\SSOController::class, 'user_train_sso_approve'])->name('u.user_train_sso_approve');//
        Route::match(['get','post'],'user_train_sso_noapprove',[App\Http\Controllers\SSOController::class, 'user_train_sso_noapprove'])->name('u.user_train_sso_noapprove');//

        //ผู้ดูแลระบบ
        Route::match(['get','post'],'main_staff',[App\Http\Controllers\AdminController::class, 'main_staff'])->name('a.main_staff');//
        Route::match(['get','post'],'main_staff_add',[App\Http\Controllers\AdminController::class, 'main_staff_add'])->name('a.main_staff_add');//
        Route::match(['get','post'],'main_staff_save',[App\Http\Controllers\AdminController::class, 'main_staff_save'])->name('a.main_staff_save');//
        Route::match(['get','post'],'main_staff_edit/{id}',[App\Http\Controllers\AdminController::class, 'main_staff_edit'])->name('a.main_staff_edit');//
        Route::match(['get','post'],'main_staff_update',[App\Http\Controllers\AdminController::class, 'main_staff_update'])->name('a.main_staff_update');//

});

