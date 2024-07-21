<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 
[App\Http\Controllers\UserRegistryController::class, 'login']);


Route::get('allUsers', 
[App\Http\Controllers\UserRegistryController::class, 'allUsers']);


Route::get('getUser/{id}', 
[App\Http\Controllers\UserRegistryController::class, 'getUser']);


Route::post('insertUser', 
[App\Http\Controllers\UserRegistryController::class, 'insertUser']);


Route::post('editUser/{id}', 
[App\Http\Controllers\UserRegistryController::class, 'editUser']);


Route::delete('deleteUser/{id}', 
[App\Http\Controllers\UserRegistryController::class, 'deleteUser']);


