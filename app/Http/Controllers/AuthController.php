<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    // POST /api/login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username atau email
        $user = User::where('username', $request->username)
                    ->orWhere('email', $request->username) 
                    ->first();

        // Cek user, password, dan status
        if (!$user || !Hash::check($request->password, $user->password) || $user->status !== 'active') {
            throw ValidationException::withMessages([
                'username' => ['Kredensial yang diberikan tidak cocok atau akun tidak aktif.'],
            ]);
        }
        
        // Pastikan relasi 'role' tersedia di Model User
        $roleName = $user->role->name ?? 'Guest'; 
        
        // Update last_login
        $user->last_login = Carbon::now();
        $user->save();
        
        // Hapus token lama dan buat token Sanctum baru dengan kemampuan (ability) role
        $user->tokens()->delete();
        $token = $user->createToken('auth_token', [$roleName])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'user_id' => $user->user_id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $roleName,
                'role_id' => $user->role_id,
            ],
            'message' => 'Login berhasil.',
            'redirect' => strtolower($roleName) // Bisa digunakan FE untuk redirect ke /admin, /owner, /peternak
        ], Response::HTTP_OK);
    }

    // POST /api/logout
    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }
}