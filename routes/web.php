<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


//.. Other routes

Auth::routes();

Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
Route::get('home', [HomeController::class, 'index'])->name('home');
