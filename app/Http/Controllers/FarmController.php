<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\User;
use App\Models\IotData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FarmController extends Controller
{
    public function index()
    {
        $farms = Farm::with([
            'owner:user_id,name,phone_number', 
            'peternak:user_id,name,phone_number',
            'latestIotData'
        ])
        ->orderBy('farm_id', 'desc')
        ->get();

        return response()->json($farms);
    }

    public function ownerDashboard(Request $request)
    {
        $ownerId = $request->user()->user_id;
        
        $farms = Farm::where('owner_id', $ownerId)
                      ->with([
                          'peternak:user_id,name,phone_number', 
                          'config', 
                          'latestIotData'
                      ]) 
                      ->get();
                      
        $stats = [
            'total_farms' => $farms->count(),
            'total_breeder' => $farms->whereNotNull('peternak_id')->pluck('peternak_id')->unique()->count(),
        ];

        return response()->json([
            'stats' => $stats,
            'farms' => $farms
        ]);
    }
    
    public function peternakDashboard(Request $request)
    {
        $peternakId = $request->user()->user_id;
        
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

        $farm = $farms->first();
        
        $todayReport = $farm->manualData()
                            ->whereDate('report_date', now()->toDateString())
                            ->first();

        return response()->json([
            'farm' => $farm,
            'today_report_status' => $todayReport ? 'Completed' : 'Pending',
            'today_report_data' => $todayReport
        ]);
    }
    
}