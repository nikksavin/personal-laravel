<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
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

//Route::get('/', \App\Http\Controllers\HomePageController::class);

//Route::get('/projects', [ProjectController::class, 'index']);
//
//Route::get('/projects', function () {
//    return view('welcome');
//});

Route::get('/', function()
{
    return View::make('pages.home');
});


Route::get('/projects',[ProjectController::class, 'index']);






