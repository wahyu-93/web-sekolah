<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Compilers\ComponentTagCompiler;

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

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function(){
    Route::group(['middleware' => 'auth'], function(){
        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

        // permissions
        Route::resource('/permission', PermissionController::class, [
            'except' => [
                'show', 'create', 'update', 'edit', 'destroy'
            ], 
            'as' => 'admin']);

        // roles
        Route::resource('/role', RoleController::class, [
            'except' => [
                'show'
            ],
            'as' => 'admin'    
        ]);

        // users
        Route::resource('/user', UserController::class, [
            'except' => [
                'show'
            ], 
            'as' => 'admin'
        ]);

        // tags
        Route::resource('/tag', TagController::class,['except' => ['show'], 'as' => 'admin']);

        // categories
        Route::resource('/category', CategoryController::class, ['except' => ['show'], 'as' => 'admin']);

        // posts
        Route::resource('/post', PostController::class, ['except' => ['show'], 'as' => 'admin']);

        // event
        Route::resource('/event', EventController::class, ['except' => ['show'], 'as' => 'admin']);

        // photo
        Route::resource('/photo', PhotoController::class, ['except' => ['show', 'create', 'edit', 'update'], 'as' => 'admin']);

    });
});
