<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRegistryController;

Route::post('register', 
[UserRegistryController::class, 'register']);


Route::post('login', 
[UserRegistryController::class, 'login']);


Route::middleware('auth:api')->post('/me', [UserRegistryController::class, 'me']);
//Route::post('me', [UserRegistryController::class, 'me']);


Route::post('refresh', [UserRegistryController::class, 'refresh']);


Route::middleware('auth:api')->post('/logout', [UserRegistryController::class, 'logout']);
//Route::post('logout', [UserRegistryController::class, 'logout']);

//------------------------------------------------------------


Route::get('allUsers', 
[UserRegistryController::class, 'allUsers']);


Route::get('getUser/{id}', 
[UserRegistryController::class, 'getUser']);


Route::post('insertUser', 
[UserRegistryController::class, 'insertUser']);


Route::post('editUser/{id}', 
[UserRegistryController::class, 'editUser']);


Route::delete('deleteUser/{id}', 
[UserRegistryController::class, 'deleteUser']);


