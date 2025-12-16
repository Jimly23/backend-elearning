<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'message' => 'User baru berhasil dibuat!',
            'user' => $user
        ], 201);
    }

    // LOGIN
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah!'
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil!',
            'user' => $user
        ]);
    }

    // GET ALL USERS
    public function index()
    {
        $users = User::all();

        return response()->json([
            'message' => 'Data semua user berhasil diambil!',
            'users' => $users
        ]);
    }

    // GET USER BY ID
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'message' => 'Detail user',
            'user' => $user
        ]);
    }

    // GET USERS WHERE ROLE = STUDENT
    public function students()
    {
        $students = User::where('role', 'student')->get();

        return response()->json([
            'message' => 'Data user student berhasil diambil!',
            'students' => $students
        ]);
    }
    
    public function teachers()
    {
        $teachers = User::where('role', 'teacher')->get();

        return response()->json([
            'message' => 'Data user student berhasil diambil!',
            'teachers' => $teachers
        ]);
    }

    // UPDATE USER

    public function update(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'name'     => 'nullable|string',
            'email'    => 'nullable|email',
            'password' => 'nullable|string|min:6',
            'role'     => 'nullable|string'
        ]);

        // Cari user
        $user = User::findOrFail($id);

        // Update data
        $user->update([
            'name'     => $request->name ?? $user->name,
            'email'    => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role'     => $request->role ?? $user->role,
        ]);

        return response()->json([
            'message' => 'User berhasil diperbarui!',
            'user'    => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User berhasil dihapus!'
        ]);
    }

}
