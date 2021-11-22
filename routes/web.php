<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/currentId', [App\Http\Controllers\HomeController::class, 'getId'])->name('getId');
Route::get('/currentUserId', [App\Http\Controllers\HomeController::class, 'getUserId'])->name('getUserId');
Route::post('/receiptSearch', [App\Http\Controllers\HomeController::class, 'receiptSearch'])->name('receiptSearch');
Route::get('is-auth', function () {
    $auth = Auth::check();
    if(Auth::check()){
        $name = Auth::user()->name;
        return [
            "login" => $auth,
            "name" => $name
        ];
    }
    return [
        "login" => $auth
    ];
});




Auth::routes();

Route::get('/{any}', function() {
    return view('index');
})->where('any', '.*');




//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//
//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
