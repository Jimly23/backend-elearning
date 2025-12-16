<?php

namespace App\Http\Controllers\Api;

use App\Models\MataPelajaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function store(Request $request)
    {
        // Validasi file
        $request->validate([
            'mata_pelajaran' => 'required|string',
            'teacher_id'     => 'required|exists:users,id', // 🔥 validasi FK
        ]);

        $mata_pelajaran = MataPelajaran::create([
            'mata_pelajaran' => $request->mata_pelajaran,
            'teacher_id'     => $request->teacher_id, // ✅ simpan teacher_id
        ]);

        return response()->json([
            'message'        => 'Mata pelajaran berhasil ditambahkan!',
            'mata_pelajaran' => $mata_pelajaran
        ], 201);
    }

    public function index()
    {
        $data = MataPelajaran::with([
            'teacher:id,name,email,role'
        ])
        ->whereHas('teacher', function ($q) {
            $q->where('role', 'teacher');
        })
        ->get();

        return response()->json([
            'message' => 'List semua mata pelajaran',
            'data' => $data
        ]);
    }

    public function getByTeacher($teacher_id)
    {
        $data = MataPelajaran::where('teacher_id', $teacher_id)->get();

        return response()->json([
            'message' => 'Mata pelajaran berdasarkan teacher',
            'teacher_id' => $teacher_id,
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mata_pelajaran' => 'required|string',
            'teacher_id'     => 'required|exists:users,id', // 🔥 bisa diubah
        ]);

        $mata_pelajaran = MataPelajaran::findOrFail($id);

        $mata_pelajaran->update([
            'mata_pelajaran' => $request->mata_pelajaran,
            'teacher_id'     => $request->teacher_id, // ✅ update teacher_id
        ]);

        return response()->json([
            'message'        => 'Mata pelajaran berhasil diperbarui!',
            'mata_pelajaran' => $mata_pelajaran
        ]);
    }

    public function destroy($id)
    {
        $mata_pelajaran = MataPelajaran::findOrFail($id);
        $mata_pelajaran->delete();

        return response()->json([
            'message' => 'Mata pelajaran berhasil dihapus!'
        ]);
    }
    
}
