<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;


Auth::routes();

Route::get('/', function (){
    return view('auth.login');
});

Route::group(['middleware' => ['auth', 'role:admin']], function() {
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
});
Route::group(['middleware' => ['auth']], function() {
    Route::resource('album', AlbumController::class);
});
