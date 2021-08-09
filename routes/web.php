<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacheraController;
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

Route::get('/teacher',[TeacheraController::class,'addTeacher']);

Route::get('/all/teacher',[TeacheraController::class,'allTeacher']);

Route::post('/teacher/store',[TeacheraController::class,'storeTeacher']);

Route::get('/teacher/edit/{id}',[TeacheraController::class,'editTeacher']);

Route::post('/teacher/update/{id}',[TeacheraController::class,'updateTeacher']);

Route::get('/teacher/delete/{id}',[TeacheraController::class,'deleteTeacher']);

Route::get('/view-search',[\App\Http\Controllers\SearchController::class,'index']);

Route::get('search',[\App\Http\Controllers\SearchController::class,'search']);
