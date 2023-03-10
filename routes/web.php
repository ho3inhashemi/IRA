<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\RedisController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;


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


Route::get('/book' , [BookController::class , 'reserve']);

Route::get('/links/{link:encoded_url}' , [LinkController::class , 'show']);

