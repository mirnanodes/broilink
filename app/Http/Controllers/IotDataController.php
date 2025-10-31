<?php

namespace App\Http\Controllers;

use App\Models\IotData;
use App\Models\Farm;
use App\Models\FarmConfig;
use Illuminate\Http\Request;

class IotDataController extends Controller
{
    // PETERNAK: GET /api/peternak/status-kandang/{farm_id}
    public function getLatestStatus(Request $request, $farm_id)
    {
        // Pengecekan akses di sini (hanya Admin/Peternak yang berhak)
        $farm = Farm::findOrFail($farm_id);
        if ($request->user()->role->name === 'Peternak' && $farm->peternak_id !== $request->user()->user_id) {
             return response()->json(['message' => 'Forbidden: Akses ditolak.'], 403);
        }
        
        $latestData = IotData::where('farm_id', $farm_id)
                              ->orderBy('timestamp', 'desc')
                              ->first();
                              
        $config = FarmConfig::where('farm_id', $farm_id)->pluck('value', 'parameter_name');

        if (!$latestData) {
            return response()->json(['message' => 'Data IoT belum tersedia.', 'status' => 'Unknown']);
        }
        
        // Komparasi & Logika Status (Sesuai brief)
        $status = 'Normal';
        $warning = [];
        $tempThreshold = $config['Suhu_Maks'] ?? 30.00;
        
        if ($latestData->temperature > $tempThreshold) {
            $status = 'Waspada';
            $warning[] = "Suhu (${latestData->temperature}°C) melebihi batas (${tempThreshold}°C).";
        }
        // ... Tambahkan logika untuk Ammonia, Humidity, dll.

        return response()->json([
            'latest_data' => $latestData,
            'config' => $config,
            'status' => $status,
            'warnings' => $warning,
        ]);
    }

    // OWNER/PETERNAK: GET /api/{role}/grafik/iot/{farm_id}
    public function getFarmHistory(Request $request, $farm_id)
    {
        // Pastikan akses (Owner/Peternak) sudah diverifikasi di middleware sebelum logic ini
        $data = IotData::where('farm_id', $farm_id)
                           ->orderBy('timestamp', 'asc')
                           ->get();
                           
        return response()->json($data);
    }
    
    // ... implementasi receiveIotData() untuk perangkat IoT
}