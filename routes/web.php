<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('task.index')->middleware('auth');
