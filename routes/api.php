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

// Auth
Route::post('/login', [AuthController::class, 'login']);

// Guest Request/Contact Form (Bisa diakses dari Landing Page)
// Sesuai dengan halaman LandingPage.jsx Anda
Route::post('/requests/submit', [RequestLogController::class, 'submitGuestRequest']);


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Semua route di bawah ini memerlukan otentikasi)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    // Shared: Profile Update & Logout (Dapat diakses semua Role)
    Route::post('/logout', [AuthController::class, 'logout']);
    // Profile (Digunakan oleh ProfileOwner.jsx dan ProfileFarm.jsx)
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::get('/user/profile', [UserController::class, 'showProfile']); // Ambil data user yang sedang login
    
    
    // --- ADMIN GROUP --- (Middleware 'role:admin')
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Users Management (ManajemenPengguna.jsx)
        Route::apiResource('users', UserController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
        
        // Farms Management (DashboardAdmin.jsx)
        Route::apiResource('farms', FarmController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::put('/farms/{farm}/assign-peternak', [FarmController::class, 'assignPeternak']); 
        
        // Config Management (KonfigurasiKandang.jsx)
        Route::apiResource('config', FarmConfigController::class)->only(['index', 'store', 'update']);
        
        // Request Log (RiwayatLaporan.jsx/Admin)
        Route::apiResource('requests', RequestLogController::class)->only(['index', 'show', 'update']);
    });
    
    
    // --- OWNER GROUP --- (Middleware 'role:owner')
    Route::middleware('role:owner')->prefix('owner')->group(function () {
        // Dashboard / Monitoring (DashboardOwner.jsx)
        Route::get('/dashboard', [FarmController::class, 'ownerDashboard']);
        
        // Monitoring Realtime (Monitoring.jsx)
        Route::get('/monitoring/iot-data/{farm_id}', [IotDataController::class, 'getLatestIotData']);
        Route::get('/monitoring/manual-data/{farm_id}', [ManualDataController::class, 'getLatestManualData']);
        
        // Analysis / History (DiagramAnalisis.jsx)
        Route::get('/analysis/history/iot/{farm_id}', [IotDataController::class, 'getFarmHistory']);
        Route::get('/analysis/history/manual/{farm_id}', [ManualDataController::class, 'getFarmHistory']);
        
        // Request: Submit new request to Admin
        Route::post('/requests', [RequestLogController::class, 'submitOwnerRequest']);
    });
    
    
    // --- PETERNAK GROUP --- (Middleware 'role:peternak')
    Route::middleware('role:peternak')->prefix('peternak')->group(function () {
        // Dashboard / Status Kandang (DashboardFarm.jsx)
        Route::get('/dashboard', [FarmController::class, 'peternakDashboard']);
        Route::get('/status-kandang/{farm_id}', [IotDataController::class, 'getLatestStatus']); 
        
        // Input Laporan Harian (InputKerjaFarm.jsx)
        Route::post('/input/manual-data', [ManualDataController::class, 'store']);
        Route::put('/input/manual-data/{id}', [ManualDataController::class, 'update']); // Update data hari ini
        Route::get('/input/manual-data/{farm_id}/{date}', [ManualDataController::class, 'showDailyInput']); // Cek input harian
        
        // View Graphs (Opsional, mungkin digabung ke Dashboard/Monitoring)
        Route::get('/grafik/iot/{farm_id}', [IotDataController::class, 'getFarmHistory']);
        Route::get('/grafik/manual/{farm_id}', [ManualDataController::class, 'getFarmHistory']);
    });
    
    // IoT Device Data Injection Endpoint 
    // Route::post('/iot/webhook', [IotDataController::class, 'receiveIotData']); 
});