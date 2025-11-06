<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\FarmConfigController;
use App\Http\Controllers\IotDataController;
use App\Http\Controllers\ManualDataController;
use App\Http\Controllers\RequestLogController;
use App\Http\Controllers\AuthController; 

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------

*/

Route::post('/login', [AuthController::class, 'login']);

Route::post('/requests/submit', [RequestLogController::class, 'submitGuestRequest']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Semua route di bawah ini memerlukan otentikasi)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::get('/user/profile', [UserController::class, 'showProfile']);
    
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::apiResource('users', UserController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
        
        Route::apiResource('farms', FarmController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::put('/farms/{farm}/assign-peternak', [FarmController::class, 'assignPeternak']); 
        
        Route::apiResource('config', FarmConfigController::class)->only(['index', 'store', 'update']);
        
        Route::apiResource('requests', RequestLogController::class)->only(['index', 'show', 'update']);
    });
    
    Route::middleware('role:owner')->prefix('owner')->group(function () {
        Route::get('/dashboard', [FarmController::class, 'ownerDashboard']);
        
        Route::get('/monitoring/iot-data/{farm_id}', [IotDataController::class, 'getLatestIotData']);
        Route::get('/monitoring/manual-data/{farm_id}', [ManualDataController::class, 'getLatestManualData']);
        
        Route::get('/analysis/history/iot/{farm_id}', [IotDataController::class, 'getFarmHistory']);
        Route::get('/analysis/history/manual/{farm_id}', [ManualDataController::class, 'getFarmHistory']);
        
        Route::post('/requests', [RequestLogController::class, 'submitOwnerRequest']);
    });
    
    Route::middleware('role:peternak')->prefix('peternak')->group(function () {
        Route::get('/dashboard', [FarmController::class, 'peternakDashboard']);
        Route::get('/status-kandang/{farm_id}', [IotDataController::class, 'getLatestStatus']); 
        
        Route::post('/input/manual-data', [ManualDataController::class, 'store']);
        Route::put('/input/manual-data/{id}', [ManualDataController::class, 'update']);
        Route::get('/input/manual-data/{farm_id}/{date}', [ManualDataController::class, 'showDailyInput']);
        
        Route::get('/grafik/iot/{farm_id}', [IotDataController::class, 'getFarmHistory']);
        Route::get('/grafik/manual/{farm_id}', [ManualDataController::class, 'getFarmHistory']);
    });
    
});