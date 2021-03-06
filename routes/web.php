<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/getAuthStatus', [App\Http\Controllers\HomeController::class, 'getAuthStatus'])->name('getAuthStatus');
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
Route::post('logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
Route::post('/addComment', [App\Http\Controllers\HomeController::class, 'addComment'])->name('addComment');
Route::get('/getAllComments', [App\Http\Controllers\HomeController::class, 'getAllComments'])->name('getAllComments');
Route::post('/saveReceipt', [App\Http\Controllers\HomeController::class, 'saveReceipt'])->name('saveReceipt');
Route::get('/getSavedById', [App\Http\Controllers\HomeController::class, 'getSavedById'])->name('getSavedById');
Route::post('/removeFromSaved', [App\Http\Controllers\HomeController::class, 'removeFromSaved'])->name('removeFromSaved');
Route::get('/getAllSaved', [App\Http\Controllers\HomeController::class, 'getAllSaved'])->name('getAllSaved');
Route::get('/getTopReceipts', [App\Http\Controllers\HomeController::class, 'getTopReceipts'])->name('getTopReceipts');
Route::get('/getTopIdeas', [App\Http\Controllers\IdeaController::class, 'getTopIdeas'])->name('getTopIdeas');
Route::post('/findReceipt', [App\Http\Controllers\HomeController::class, 'findReceipt'])->name('findReceipt');
Route::get('/findProduct', [App\Http\Controllers\HomeController::class, 'findProduct'])->name('findProduct');
Route::get('/getLikesById', [App\Http\Controllers\LikesController::class, 'getLikesById'])->name('getLikesById');
Route::get('/getSavedsById', [App\Http\Controllers\LikesController::class, 'getSavedsById'])->name('getSavedsById');
Route::post('/setLike', [App\Http\Controllers\LikesController::class, 'setLike'])->name('setLike');
Route::post('/setDislike', [App\Http\Controllers\LikesController::class, 'setDislike'])->name('setDislike');
Route::post('/createIdea', [App\Http\Controllers\IdeaController::class, 'createIdea'])->name('createIdea');
Route::get('/getIdea/{id}', [App\Http\Controllers\IdeaController::class, 'getIdea'])->name('getIdea');



//Admin
Route::get('/getChartInfo',[App\Http\Controllers\AdminController::class, 'getChartInfo'])->name('getChartInfo');
Route::get('/getChartInfoKitchens', [App\Http\Controllers\AdminController::class, 'getChartInfoKitchens'])->name('getChartInfoKitchens');
Route::post('/createCategory', [App\Http\Controllers\AdminController::class, 'createCategory'])->name('createCategory');
Route::post('/createKitchen', [App\Http\Controllers\AdminController::class, 'createKitchen'])->name('createKitchen');
Route::post('/editReceipt', [App\Http\Controllers\AdminController::class, 'editReceipt'])->name('editReceipt');
Route::post('/findAdminReceipt', [App\Http\Controllers\AdminController::class, 'findAdminReceipt'])->name('findAdminReceipt');


//KPZ
Route::get('/receiptExport',[App\Http\Controllers\AdminController::class, 'receiptExport'])->name('receiptExport');

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
