<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\AuthController;
use App\http\Controllers\AdminController;
use App\http\Controllers\ExamController;

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
      Route::get('/get-exam-detail/{id}',[AdminController::class,'getExamDetail'])->name('getExamDetail');
      Route::post('/delete-exam',[AdminController::class,'deleteExam'])->name('deleteExam');
      Route::post('/update-exam',[AdminController::class,'updateExam'])->name('updateExam');

      //question
      Route::get('/admin/qna-ans',[AdminController::class,'qnaDashboard']);
      Route::post('/add-qna-ans',[AdminController::class,'addQna'])->name('addQna');
      Route::get('/get-qna-details',[AdminController::class,'getQnaDetails'])->name('getQnaDetails');
      Route::get('/delete-ans',[AdminController::class,'deleteAns'])->name('deleteAns');
      Route::post('/update-qna-ans',[AdminController::class,'updateQna'])->name('updateQna');
      Route::post('/delete-qna-ans',[AdminController::class,'deleteQna'])->name('deleteQna');



      //qna exam routing
      Route::get('/get-questions',[AdminController::class,'getQuestions'])->name('getQuestions');
      Route::post('/addQuestions',[AdminController::class,'addQuestions'])->name('addQuestions');
      Route::get('/get-exam-questions',[AdminController::class,'getExamQuestions'])->name('getExamQuestions');
      Route::get('/delete-exam-questions',[AdminController::class,'deleteExamQuestions'])->name('deleteExamQuestions');
      //exam marks route
      Route::get('/admin/marks',[AdminController::class,'loadMarks']);
      Route::post('/update-marks',[AdminController::class,'updateMarks'])->name('updateMarks');

      //exam review
      Route::get('/admin/review-exams',[AdminController::class,'reviewExams'])->name('reviewExams');
      Route::get('/get-reviewed-qna',[AdminController::class,'reviewQna'])->name('reviewQna');

      //approve
      Route::post('/approved-qna',[AdminController::class,'approvedQna'])->name('approvedQna');




});
Route::group(['middleware'=>['web','checkStudent']],function(){
    Route::get('/dashboard',[AuthController::class,'loadDashboard']);
    Route::get('/exam/{id}',[ExamController::class,'loadExamDashboard']);

    Route::post('/exam-submit',[ExamController::class,'examSubmit'])->name('examSubmit');

    Route::get('/results',[ExamController::class,'resultDashboard'])->name('resultDashboard');
    Route::get('/review-student-qna',[ExamController::class,'reviewQna'])->name('resultStudentQna');


});







