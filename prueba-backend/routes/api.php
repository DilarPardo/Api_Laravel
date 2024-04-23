<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\AuthController;




//Login
Route::post('login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::post('logout', [AuthController::class, 'logout']);

    //Controller Routas Students

//Consult
Route::get('students', [StudentController::class, 'IndexApi']);

//Show
Route::get('students/{student}', [StudentController::class, 'ShowApi']);

//Update
Route::put('students/{student}', [StudentController::class, 'UpdateApi']);

//Destroy
Route::delete('students/{student}', [StudentController::class, 'DestroyApi']);

//Store
Route::post('students', [StudentController::class, 'StoreApi']);


//Controller Routas Teachers

//Consult
Route::get('teachers', [TeacherController::class, 'IndexApi']);

//Show
Route::get('teachers/{teacher}', [TeacherController::class, 'ShowApi']);

//Update
Route::put('teachers/{teacher}', [TeacherController::class, 'UpdateApi']);

//Destroy
Route::delete('teachers/{teacher}', [TeacherController::class, 'DestroyApi']);

//Store
Route::post('teachers', [TeacherController::class, 'StoreApi']);


//Controller Routas Course

//Consult
Route::get('courses', [CourseController::class, 'IndexApi']);

//Show
Route::get('courses/{course}', [CourseController::class, 'ShowApi']);

//Update
Route::put('courses/{course}', [CourseController::class, 'UpdateApi']);

//Destroy
Route::delete('courses/{course}', [CourseController::class, 'DestroyApi']);

//Store
Route::post('courses', [CourseController::class, 'StoreApi']);


//Controller Routas Qualification

//Consult
Route::get('qualifications', [QualificationController::class, 'IndexApi']);

//Show
Route::get('qualifications/{qualification}', [QualificationController::class, 'ShowApi']);

//Update
Route::put('qualifications/{qualification}', [QualificationController::class, 'UpdateApi']);

//Destroy
Route::delete('qualifications/{qualification}', [QualificationController::class, 'DestroyApi']);

//Store
Route::post('qualifications', [QualificationController::class, 'StoreApi']);

});

Route::get('users', [AuthController::class, 'allUsers']);
