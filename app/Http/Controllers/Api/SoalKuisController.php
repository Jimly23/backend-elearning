<?php

namespace App\Http\Controllers\Api;

use App\Models\SoalKuis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SoalKuisController extends Controller
{
    // ======================================
    // CREATE – Tambah Soal Baru
    // ======================================
    public function store(Request $request)
    {
        $request->validate([
            'id_kuis'        => 'required|integer|exists:kuis,id',
            'pertanyaan'     => 'required|string',
            'opsi_a'         => 'required|string|max:255',
            'opsi_b'         => 'required|string|max:255',
            'opsi_c'         => 'required|string|max:255',
            'opsi_d'         => 'required|string|max:255',
            'jawaban_benar'  => 'required|string',
            'skor_soal'      => 'required|integer|min:1',
        ]);

        $soal = SoalKuis::create($request->all());

        return response()->json([
            'message' => 'Soal kuis berhasil ditambahkan!',
            'data' => $soal
        ], 201);
    }

    // ======================================
    // READ – Ambil semua soal kuis
    // ======================================
    public function index()
    {
        $soal = SoalKuis::all();

        return response()->json([
            'message' => 'Daftar semua soal kuis',
            'data' => $soal
        ]);
    }

    // ======================================
    // READ – Ambil soal berdasarkan ID soal
    // ======================================
    public function show($id)
    {
        $soal = SoalKuis::findOrFail($id);

        return response()->json([
            'message' => 'Detail soal kuis',
            'data' => $soal
        ]);
    }

    // ===================================================
    // READ – Ambil semua soal berdasarkan ID KUIS
    // ===================================================
    public function getByKuis($id_kuis)
    {
        $soal = SoalKuis::where('id_kuis', $id_kuis)->get();

        return response()->json([
            'message' => 'Daftar soal berdasarkan ID kuis',
            'data' => $soal
        ]);
    }

    // ======================================
    // UPDATE – Ubah soal
    // ======================================
    public function update(Request $request, $id)
    {
        $soal = SoalKuis::findOrFail($id);

        $request->validate([
            'id_kuis'        => 'nullable|integer|exists:kuis,id',
            'pertanyaan'     => 'nullable|string',
            'opsi_a'         => 'nullable|string|max:255',
            'opsi_b'         => 'nullable|string|max:255',
            'opsi_c'         => 'nullable|string|max:255',
            'opsi_d'         => 'nullable|string|max:255',
            'jawaban_benar'  => 'nullable|string',
            'skor_soal'      => 'nullable|integer|min:1',
        ]);

        $soal->update($request->all());

        return response()->json([
            'message' => 'Soal kuis berhasil diperbarui!',
            'data' => $soal
        ]);
    }

    // ======================================
    // DELETE – Hapus soal
    // ======================================
    public function destroy($id)
    {
        $soal = SoalKuis::findOrFail($id);
        $soal->delete();

        return response()->json([
            'message' => 'Soal kuis berhasil dihapus!'
        ]);
    }
}
