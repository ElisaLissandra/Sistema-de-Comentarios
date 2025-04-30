<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');



Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', [AuthController::class, 'user'])->name('user');
    
    Route::prefix('/posts')->group(function(){
        Route::get('/', [PostController::class, 'index']);
        Route::post('/', [PostController::class, 'store']);
        Route::get('/{post}', [PostController::class, 'show']);
        Route::put('/{post}', [PostController::class, 'update']);
        Route::delete('/{post}', [PostController::class, 'destroy']);
        Route::post('/{id}/restore', [PostController::class, 'restore']);
        Route::delete('/{id}/force-delete', [PostController::class, 'forceDelete']);
    });

    Route::prefix('/products')->group(function(){
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/{product}', [ProductController::class, 'show']);
        Route::put('/{product}', [ProductController::class, 'update']);
        Route::delete('/{product}', [ProductController::class, 'destroy']);
        Route::post('/{id}/restore', [ProductController::class, 'restore']);
        Route::delete('/{id}/force-delete', [ProductController::class, 'forceDelete']);
    });

    Route::post('/products/{product}/comments', [CommentController::class, 'storeProduct']);
    Route::post('/posts/{post}/comments', [CommentController::class, 'storePost']);

    Route::delete('/posts/comments/{comment}', [CommentController::class, 'destroyPost']);
    Route::delete('/products/comments/{comment}', [CommentController::class, 'destroyProduct']);

    Route::post('/posts/comments/{id}/restore', [CommentController::class, 'restorePost']);
    Route::post('/products/comments/{id}/restore', [CommentController::class, 'restoreProduct']);

    Route::delete('/posts/comments/{id}/force-delete', [CommentController::class, 'forceDeleteProduct']);
    Route::delete('/products/comments/{id}/force-delete', [CommentController::class, 'forceDeletePost']);

    Route::get('/products/{product}/comments', [CommentController::class, 'showProductComments']);
    Route::get('/posts/{post}/comments', [CommentController::class, 'showPostComments']);

});