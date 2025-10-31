<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // GET /api/admin/users
    public function index()
    {
        $users = User::with('role')
                      ->whereHas('role', function ($query) {
                          $query->whereIn('name', ['Owner', 'Peternak']);
                      })
                      ->orderBy('user_id', 'desc')
                      ->get();

        return response()->json($users);
    }

    // POST /api/admin/users
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => ['required', Rule::in(['Owner', 'Peternak'])],
            'username' => 'required|string|unique:users,username|max:50',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => 'required|min:8',
            'name' => 'required|string|max:100',
            'phone_number' => 'nullable|string|max:20',
        ]);
        
        $role = Role::where('name', $request->role_name)->firstOrFail();

        $user = User::create([
            'role_id' => $role->id,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'status' => 'active',
            'date_joined' => now()->toDateString(),
        ]);

        return response()->json([
            'message' => "User {$user->name} berhasil ditambahkan sebagai {$role->name}.", 
            'user' => $user->load('role')
        ], 201);
    }

    // SHARED: GET /api/user/profile
    public function showProfile(Request $request)
    {
        return response()->json($request->user()->load('role'));
    }

    // SHARED: PUT /api/user/profile
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
            'phone_number' => 'nullable|string|max:20',
            'profile_pic' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'profile_pic' => $request->profile_pic,
        ]);

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user' => $user->load('role')
        ]);
    }
    
    // ... implementasikan show(), update(), destroy() untuk Admin
}