<?php

namespace App\Http\Controllers;

use App\Models\RequestLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RequestLogController extends Controller
{
    // GUEST: POST /api/requests/submit
    public function submitGuestRequest(Request $request)
    {
        $request->validate([
            'sender_name' => 'required|string|max:50',
            'request_type' => 'required|string|max:50', 
            'request_content' => 'required|string|max:500',
            // Tambahkan validasi untuk kontak (email/WA)
        ]);

        $log = RequestLog::create([
            'user_id' => null, 
            'sender_name' => $request->sender_name,
            'request_type' => $request->request_type,
            'request_content' => $request->request_content,
            'status' => 'New',
            'sent_time' => now(),
        ]);

        return response()->json(['message' => 'Permintaan berhasil dikirim.'], 201);
    }
    
    // OWNER: POST /api/owner/requests
    public function submitOwnerRequest(Request $request)
    {
        $request->validate([
            'request_type' => 'required|string|max:50', 
            'request_content' => 'required|string|max:500',
        ]);

        $user = $request->user();
        
        $log = RequestLog::create([
            'user_id' => $user->user_id,
            'sender_name' => $user->name,
            'request_type' => $request->request_type,
            'request_content' => $request->request_content,
            'status' => 'New',
            'sent_time' => now(),
        ]);

        return response()->json(['message' => 'Permintaan Anda berhasil diajukan kepada Admin.'], 201);
    }

    // ADMIN: GET /api/admin/requests
    public function index()
    {
        $requests = RequestLog::orderBy('sent_time', 'desc')->get();
        return response()->json($requests);
    }
    
    // ADMIN: PUT /api/admin/requests/{request_id}
    public function update(Request $request, $request_id)
    {
        $log = RequestLog::findOrFail($request_id);
        
        $request->validate([
            'status' => ['required', Rule::in(['New', 'Processing', 'Completed', 'Rejected'])],
        ]);
        
        $log->update(['status' => $request->status]);

        return response()->json(['message' => 'Status permintaan berhasil diperbarui.', 'log' => $log]);
    }
    // ... implementasikan show()
}