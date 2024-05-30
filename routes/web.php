<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageForm;


Route::get('/', function () {
    return view('welcome');
});


Route::get('image', function () {
    return view('image');
});


Route::post('image-save', [ImageForm::class, 'store'])->name('image.store');


