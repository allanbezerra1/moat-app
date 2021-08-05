<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;


//.. Other routes

Auth::routes();

Route::resource('user', UserController::class);
Route::resource('role', RoleController::class);
Route::resource('album', AlbumController::class);
