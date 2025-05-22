<?php

use app\Http\Controllers\Api\LeadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('leads', LeadController::class);
Route::apiResource('managers', \app\Http\Controllers\Api\ManagerController::class);

Route::put('leads/{lead}/change-status', [LeadController::class,'changeStatus']);
