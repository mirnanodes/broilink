<?php

namespace App\Http\Controllers;

use App\Models\ManualData;
use App\Models\Farm;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManualDataController extends Controller
{
    public function store(Request $request)
    {
        $peternakId = $request->user()->user_id;

        $request->validate([
            'farm_id' => [
                'required', 
                Rule::exists('farms', 'farm_id')->where(fn ($query) => $query->where('peternak_id', $peternakId))
            ],
            'report_date' => [
                'required', 
                'date_format:Y-m-d',
                Rule::unique('manual_data')->where(fn ($query) => $query->where('farm_id', $request->farm_id))
            ],
            'konsumsi_pakan' => 'nullable|numeric|min:0',
            'konsumsi_air' => 'nullable|numeric|min:0',
            'jumlah_kematian' => 'nullable|integer|min:0',
        ]);

        $manualData = ManualData::create([
            'farm_id' => $request->farm_id,
            'user_id_input' => $peternakId,
            'report_date' => $request->report_date,
            'konsumsi_pakan' => $request->konsumsi_pakan,
            'konsumsi_air' => $request->konsumsi_air,
            'jumlah_kematian' => $request->jumlah_kematian,
        ]);

        return response()->json(['message' => 'Laporan harian berhasil diinput.', 'data' => $manualData], 201);
    }
    
    public function getFarmHistory(Request $request, $farm_id)
    {
        $data = ManualData::where('farm_id', $farm_id)
                           ->orderBy('report_date', 'asc')
                           ->get();
                           
        return response()->json($data);
    }
    
}