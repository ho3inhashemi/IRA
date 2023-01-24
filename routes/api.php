<?php

use App\Http\Controllers\ApiLinkController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RedisController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class , 'register']);

Route::group(['middleware' => ['auth:sanctum']] , function() {
    Route::get('/test' , function(){
        return auth()->user()->id;
    });
    Route::get('/lesson' , [SubjectController::class , 'store']);

    Route::get('/insert_link' , [ApiLinkController::class , 'store']);
    Route::get('/all_links' , [ApiLinkController::class , 'index']);
    Route::get('/sort' , [ApiLinkController::class , 'sort']);
});

//sample url to be implemented http://127.0.0.1:8000/api/lesson?subject=math

Route::get('/redis', [RedisController::class , 'index']);
