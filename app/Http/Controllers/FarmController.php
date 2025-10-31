<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\User;
use App\Models\IotData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FarmController extends Controller
{
    // ADMIN: GET /api/admin/farms (Dashboard Admin)
    public function index()
    {
        // Mengambil semua farm beserta nama Owner dan Peternak
        $farms = Farm::with([
            'owner:user_id,name,phone_number', 
            'peternak:user_id,name,phone_number',
            'latestIotData' // Data IoT terbaru
        ])
        ->orderBy('farm_id', 'desc')
        ->get();

        // Anda dapat menambahkan statistik global di sini jika diperlukan
        
        return response()->json($farms);
    }

    // OWNER: GET /api/owner/dashboard
    public function ownerDashboard(Request $request)
    {
        $ownerId = $request->user()->user_id;
        
        // Ambil Farm milik Owner, beserta Peternak, Config, dan Data IoT terbaru
        $farms = Farm::where('owner_id', $ownerId)
                      ->with([
                          'peternak:user_id,name,phone_number', 
                          'config', 
                          'latestIotData'
                      ]) 
                      ->get();
                      
        // Ringkasan Statistik Owner
        $stats = [
            'total_farms' => $farms->count(),
            'total_breeder' => $farms->whereNotNull('peternak_id')->pluck('peternak_id')->unique()->count(),
            // ... Tambahkan stat lain (misal: Rata-rata Suhu terbaru)
        ];

        return response()->json([
            'stats' => $stats,
            'farms' => $farms
        ]);
    }
    
    // PETERNAK: GET /api/peternak/dashboard
    public function peternakDashboard(Request $request)
    {
        $peternakId = $request->user()->user_id;
        
        // Ambil Farm yang diurus oleh Peternak
        $farms = Farm::where('peternak_id', $peternakId)
                      ->with([
                          'owner:user_id,name,phone_number', 
                          'config', 
                          'latestIotData'
                      ]) 
                      ->get();
                      
        if ($farms->isEmpty()) {
             return response()->json(['message' => 'Anda belum ditugaskan ke kandang manapun.'], 200);
        }

        // Jika Peternak hanya mengurus 1 Farm (asumsi umum)
        $farm = $farms->first();
        
        // Status Laporan Manual Hari Ini (Untuk komponen di DashboardFarm.jsx)
        $todayReport = $farm->manualData()
                            ->whereDate('report_date', now()->toDateString())
                            ->first();

        return response()->json([
            'farm' => $farm, // Kirimkan data farm yang sedang diurus
            'today_report_status' => $todayReport ? 'Completed' : 'Pending',
            'today_report_data' => $todayReport
        ]);
    }
    
    // ... implementasikan store, update, destroy, assignPeternak (Admin), dll.
}