<?php

namespace App\Http\Controllers\Api;

use App\Models\Materi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    // CREATE (Menyimpan materi)
    public function store(Request $request)
    {
        // Validasi file
        $request->validate([
            'mata_pelajaran_id' => 'required|integer',
            'teacher_id' => 'required|integer',
            'title'      => 'required|string',
            'description'=> 'nullable|string',
            'file'       => 'required|file|mimes:pdf,ppt,pptx,mp4,mov,avi|max:51200' // 50MB
        ]);

        // Upload file
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Simpan ke storage/app/public/materi_files
        $file->storeAs('materi_files', $fileName, 'public');

        // Simpan ke database
        $materi = Materi::create([
            'mata_pelajaran_id'  => $request->mata_pelajaran_id,
            'teacher_id'  => $request->teacher_id,
            'title'       => $request->title,
            'description' => $request->description,
            'file_url'    => 'storage/materi_files/' . $fileName,
            'file_type'   => $file->getClientOriginalExtension(),
        ]);

        return response()->json([
            'message' => 'Materi berhasil diupload!',
            'materi'  => $materi
        ], 201);
    }


    // READ - Menampilkan semua materi
    public function index()
    {
        $materis = Materi::all();

        return response()->json([
            'message' => 'Data semua materi berhasil diambil!',
            'materis' => $materis
        ]);
    }

    // READ - Menampilkan satu materi berdasarkan ID
    public function show($id)
    {
        $materi = Materi::find($id);

        if (!$materi) {
            return response()->json(['message' => 'Materi tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Data materi berhasil ditemukan!',
            'materi' => $materi
        ]);
    }

    // GET - Menampilkan materi berdasarkan mata pelajaran
    public function getByMataPelajaran($mata_pelajaran_id)
    {
        // Ambil materi berdasarkan mata_pelajaran_id
        $materi = Materi::where('mata_pelajaran_id', $mata_pelajaran_id)->get();

        // Jika tidak ada materi
        if ($materi->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada materi untuk mata pelajaran ini.',
                'materi' => []
            ], 404);
        }

        return response()->json([
            'message' => 'Materi berhasil diambil berdasarkan mata pelajaran!',
            'materi' => $materi
        ], 200);
    }

    // Menampilkan materi berdasarkan guru
    public function getByTeacher($teacher_id)
    {
        // Ambil materi berdasarkan teacher_id
        $materi = Materi::where('teacher_id', $teacher_id)->get();

        // Jika tidak ada materi
        if ($materi->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada materi yang diupload oleh guru ini.',
                'materi' => []
            ], 404);
        }

        return response()->json([
            'message' => 'Materi berhasil diambil berdasarkan teacher_id!',
            'materi' => $materi
        ], 200);
    }

    // Menampilkan materi berdasarkan guru dan mata pelajaran
    public function getByTeacherAndMapel($teacher_id, $mata_pelajaran_id)
    {
        $materi = Materi::where('teacher_id', $teacher_id)
                        ->where('mata_pelajaran_id', $mata_pelajaran_id)
                        ->get();

        if ($materi->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada materi untuk guru dan mata pelajaran ini.',
                'materi' => []
            ], 404);
        }

        return response()->json([
            'message' => 'Materi berhasil diambil berdasarkan teacher_id dan mata_pelajaran_id!',
            'materi' => $materi
        ], 200);
    }



    // UPDATE - Mengubah materi
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'sometimes|file|mimes:pdf,ppt,pptx,mp4,mov,avi|max:51200' // 50MB
        ]);

        $materi = Materi::findOrFail($id);

        if ($request->hasFile('file')) {
            // Hapus file lama
            if (file_exists(public_path($materi->file_url))) {
                unlink(public_path($materi->file_url));
            }

            // Upload file baru
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('materi_files', $fileName, 'public');

            $materi->file_url = 'storage/materi_files/' . $fileName;
            $materi->file_type = $file->getClientOriginalExtension();
        }

        // Update hanya field yang dikirim
        if ($request->has('title')) {
            $materi->title = $request->title;
        }
        if ($request->has('description')) {
            $materi->description = $request->description;
        }

        $materi->save();

        return response()->json([
            'message' => 'Materi berhasil diperbarui!',
            'materi' => $materi
        ]);
    }


    // DELETE - Menghapus materi
    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        // Hapus file dari folder
        if (file_exists(public_path($materi->file_url))) {
            unlink(public_path($materi->file_url));
        }

        $materi->delete();

        return response()->json(['message' => 'Materi berhasil dihapus!']);
    }

}
