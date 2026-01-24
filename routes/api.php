<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::get('companies',[CompanyController::class,'index']);
Route::get('companies/{company}',[CompanyController::class,'show']);

Route::get('jobs',[JobController::class,'index']);
Route::get('jobs/{job}',[JobController::class,'show']);

Route::get('categories',[CategoryController::class,'index']);

Route::get('tags',[TagController::class,'index']);

Route::middleware('auth:sanctum')->group(function (){
    Route::post('logout',[AuthController::class,'logout']);
    Route::apiResource('companies',CompanyController::class)->except(['index','show']);
    Route::apiResource('jobs',JobController::class)->except(['index','show']);
    Route::apiResource('categories',CategoryController::class)->except(['index']);
    Route::apiResource('tags',TagController::class)->except(['index']);
    Route::apiResource('applications',ApplicationController::class);
});
