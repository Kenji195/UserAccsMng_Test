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


Route::middleware('auth:api')->post('/refresh', [UserRegistryController::class, 'refresh']);
//Route::post('refresh', [UserRegistryController::class, 'refresh']);


Route::middleware('auth:api')->post('/logout', [UserRegistryController::class, 'logout']);
//Route::post('logout', [UserRegistryController::class, 'logout']);

//------------------------------------------------------------


Route::middleware('auth:api')->post('allUsers', [UserRegistryController::class, 'allUsers']);
//Route::get('allUsers', [UserRegistryController::class, 'allUsers']);


Route::middleware('auth:api')->post('/getUser/{id}', [UserRegistryController::class, 'getUser']);
//Route::get('getUser/{id}', [UserRegistryController::class, 'getUser']);


Route::middleware('auth:api')->post('/insertUser', [UserRegistryController::class, 'insertUser']);
//Route::post('insertUser', [UserRegistryController::class, 'insertUser']);


Route::middleware('auth:api')->post('/editUser/{id}', [UserRegistryController::class, 'editUser']);
//Route::post('editUser/{id}', [UserRegistryController::class, 'editUser']);


Route::middleware('auth:api')->post('/deleteUser/{id}', [UserRegistryController::class, 'deleteUser']);
//Route::delete('deleteUser/{id}', [UserRegistryController::class, 'deleteUser']);


