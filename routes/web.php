<?php

use App\Http\Controllers\ControllerPDF;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login.login');
});

Route::get('grupos/', function () {
    return view('home.home');
});

Route::post('grupos/',[ControllerPDF::class,'extractText']);


Route::get('instrumentacion/', function () { 
    return view('home.formatos.instrumentacion');
});
