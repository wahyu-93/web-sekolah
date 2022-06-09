<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\VideoController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// posts
Route::get('/post', [PostController::class, 'index']);
Route::get('/post/{id?}', [PostController::class, 'show']);
Route::get('/homepage/post', [PostController::class, 'postHomePage']);

// event
Route::get('/event', [EventController::class, 'index']);
Route::get('/event/{slug?}', [EventController::class, 'show']);
Route::get('/homepage/event', [EventController::class, 'eventHomePage']);

// slider
Route::get('/slider', [SliderController::class, 'index']);  

// tag
Route::get('/tag', [TagController::class, 'index']);
Route::get('/tag/{slug?}', [TagController::class, 'show']);

// category
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{slug?}', [CategoryController::class, 'show']);

// photo
Route::get('/photo', [PhotoController::class, 'index']);
Route::get('/homepage/photo', [PhotoController::class, 'photoHomePage']);

// video
Route::get('/video', [VideoController::class, 'index']);
Route::get('/homepage/video', [VideoController::class, 'videoHomePage']);