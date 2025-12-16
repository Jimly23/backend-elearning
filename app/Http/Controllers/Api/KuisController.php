<?php

namespace App\Http\Controllers\Api;

use App\Models\Kuis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KuisController extends Controller
{
    // =====================================
    // CREATE – Tambah kuis
    // =====================================
    public function store(Request $request)
    {
        $request->validate([
            'id_guru'          => 'required|integer|exists:users,id',
            'id_matapelajaran' => 'required|integer|exists:mata_pelajarans,id',
            'judul_kuis'       => 'required|string|max:255',
        ]);

        $kuis = Kuis::create([
            'id_guru'          => $request->id_guru,
            'id_matapelajaran' => $request->id_matapelajaran,
            'judul_kuis'       => $request->judul_kuis,
        ]);

        return response()->json([
            'message' => 'Kuis berhasil ditambahkan!',
            'kuis' => $kuis
        ], 201);
    }

    // =====================================
    // READ – Tampilkan semua kuis
    // =====================================
    public function index()
    {
        $kuis = Kuis::all();

        return response()->json([
            'message' => 'List semua kuis',
            'data' => $kuis
        ]);
    }

    // =====================================
    // READ – Tampilkan kuis berdasarkan ID
    // =====================================
    public function show($id)
    {
        $kuis = Kuis::findOrFail($id);

        return response()->json([
            'message' => 'Detail kuis',
            'data' => $kuis
        ]);
    }

    // ============================================
    // READ – Tampilkan kuis berdasarkan ID Guru
    // ============================================
    public function getByGuru($id_guru)
    {
        $kuis = Kuis::where('id_guru', $id_guru)->get();

        return response()->json([
            'message' => 'Daftar kuis berdasarkan guru',
            'data' => $kuis
        ]);
    }

    // ================================================
    // READ – Tampilkan kuis berdasarkan ID Mata Pelajaran
    // ================================================
    public function getByMataPelajaran($id_matapelajaran)
    {
        $kuis = Kuis::where('id_matapelajaran', $id_matapelajaran)->get();

        return response()->json([
            'message' => 'Daftar kuis berdasarkan mata pelajaran',
            'data' => $kuis
        ]);
    }

    // =====================================
    // UPDATE – Ubah kuis
    // =====================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_guru'          => 'nullable|integer|exists:users,id',
            'id_matapelajaran' => 'nullable|integer|exists:mata_pelajarans,id',
            'judul_kuis'       => 'nullable|string|max:255',
        ]);

        $kuis = Kuis::findOrFail($id);

        $kuis->update([
            'id_guru'          => $request->id_guru ?? $kuis->id_guru,
            'id_matapelajaran' => $request->id_matapelajaran ?? $kuis->id_matapelajaran,
            'judul_kuis'       => $request->judul_kuis ?? $kuis->judul_kuis,
        ]);

        return response()->json([
            'message' => 'Kuis berhasil diperbarui!',
            'kuis' => $kuis
        ]);
    }

    // =====================================
    // DELETE – Hapus kuis
    // =====================================
    public function destroy($id)
    {
        $kuis = Kuis::findOrFail($id);
        $kuis->delete();

        return response()->json([
            'message' => 'Kuis berhasil dihapus!'
        ]);
    }
}
