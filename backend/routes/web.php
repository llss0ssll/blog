<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'],function(){

    Route::get('/',[PostController::class,'index'])->name('index');

    // group prefix post mean / post/create = /create inside the group
    // same for name instead of post.create = create

    // group prefix post mean /post/create = /create inside the group
    // same for name instead of post.create = create

    //  not anymore
    // Route::get('/post/create',[PostController::class,'create'])->name('post.create');
    // Route::get('/post/index',[PostController::class,'index'])->name('post.index');
    // Route::get('/post/store',[PostController::class,'store'])->name('post.store');

    Route::group(['prefix'=>'post', 'as' =>'post.'], function(){

        Route::get('/create',[PostController::class,'create'])->name('create');
        // storing the from to the db
        Route::post('/store',[PostController::class,'store'])->name('store');
        // showing the post we click
        Route::get('/{id}/show',[PostController::class,'show'])->name('show');
        // going to edit page
        Route::get('/{id}/edit',[PostController::class,'edit'])->name('edit');
        // going to update mathod
        Route::patch('/{id}/update',[PostController::class,'update'])->name('update');
        // going to delete post
        Route::delete('/{id}/destroy',[PostController::class,'destroy'])->name('destroy');

    });

    // group comment
    Route::group(['prefix'=>'comment', 'as' =>'comment.'], function(){

        // adding comment to db
        Route::post('/{post_id}/store',[CommentController::class , 'store'])->name('store');

        // dalete comment to db
        Route::delete('/{post_id}/destroy',[CommentController::class,'destroy'])->name('destroy');

        Route::patch('/{comment_id}/update',[CommentController::class,'update'])->name('update');
    });

    // profile group

    Route::group(['prefix'=>'profile', 'as' => 'profile.'], function(){

        // goin to profile page
        Route::get('/{id}',[UserController::class,'show'])->name('show');
        // going to edit page
        Route::get('/{id}/edit',[UserController::class,'edit'])->name('edit');
        // update profile
        Route::patch('/update',[UserController::class,'update'])->name('update');
        // going to change password
        Route::get('/{id}/change_password',[UserController::class,'change_password'])->name('change_password');
        // update password
        Route::patch('/update_password',[UserController::class,'update_password'])->name('update_password');
    });

});
