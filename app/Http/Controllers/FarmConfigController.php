<?php

namespace App\Http\Controllers;

use App\Models\FarmConfig;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FarmConfigController extends Controller
{
    // ADMIN: POST /api/admin/config
    public function store(Request $request)
    {
        $request->validate([
            'farm_id' => 'required|exists:farms,farm_id',
            'parameter_name' => ['required', 'string', 'max:50', Rule::unique('farm_config')->where(function ($query) use ($request) {
                return $query->where('farm_id', $request->farm_id);
            })],
            'value' => 'required|numeric',
        ]);
        
        $config = FarmConfig::create($request->all());

        return response()->json(['message' => 'Konfigurasi batas berhasil ditambahkan.', 'config' => $config], 201);
    }
    
    // ADMIN: PUT /api/admin/config/{config_id}
    public function update(Request $request, $config_id)
    {
        $config = FarmConfig::findOrFail($config_id);
        
        $request->validate([
            'value' => 'required|numeric',
        ]);
        
        $config->update(['value' => $request->value]);

        return response()->json(['message' => 'Konfigurasi batas berhasil diperbarui.', 'config' => $config]);
    }
    
    // ... implementasikan index() dan show()
}