<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageForm;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;

Route::get('image', function () {
    return view('image');
});

Route::post('image-save', [ImageForm::class, 'store'])->name('image.store');

Route::post('/comments', [CommentController::class, 'store'])->name('user.comment.create');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('user.comment.delete');
Route::post('/submit', [CommentController::class, 'store'])->name('submit');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');



