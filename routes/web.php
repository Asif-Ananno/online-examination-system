<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\AuthController;
use App\http\Controllers\AdminController;

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
    return view('welcome');
});


Route::get('/register',[AuthController::class,'loadRegister']);
Route::post('/register',[AuthController::class,'studentRegister'])->name('studentRegister');

Route::get('/login',function(){
    return redirect('/');
});

Route::get('/',[AuthController::class,'loadlogin']);
Route::post('/login',[AuthController::class,'userlogin'])->name('userlogin');

Route::get('/logout',[AuthController::class,'logout']);

Route::group(['middleware'=>['web','checkadmin']],function(){
    Route::get('/admin/dashboard',[AuthController::class,'adminDashboard']);

    //subject routes
    Route::post('/add-subject',[AdminController::class,'addSubject'])->name('addSubject');

    //edit routes
     Route::post('/edit-subject',[AdminController::class,'editSubject'])->name('editSubject');

      //delete routes
      Route::post('/delete-subject',[AdminController::class,'deleteSubject'])->name('deleteSubject');

      //exam routes
      Route::get('/admin/exam',[AdminController::class,'examDashboard']);
      Route::post('/add-exam',[AdminController::class,'addExam'])->name('addExam');

      //question
      Route::get('/admin/qna-ans',[AdminController::class,'qnaDashboard']);
      Route::post('/add-qna-ans',[AdminController::class,'addQna'])->name('addQna');



});
Route::group(['middleware'=>['web','checkStudent']],function(){
    Route::get('/dashboard',[AuthController::class,'loadDashboard']);
});







