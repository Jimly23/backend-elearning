<?php

namespace App\Http\Controllers\Api;

use App\Models\JawabanSoal;
use App\Models\SoalKuis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class JawabanSoalController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_soal'       => 'required|integer',
            'id_siswa'      => 'required|integer',
            'jawaban_siswa' => 'required|string',
        ]);

        // Ambil data soal kuis
        $soal = SoalKuis::findOrFail($request->id_soal);

        // Cek apakah benar
        $isCorrect = strtolower($request->jawaban_siswa) == strtolower($soal->jawaban_benar);
        $skor = $isCorrect ? $soal->skor_soal : 0;

        $jawaban = JawabanSoal::create([
            'id_soal'        => $request->id_soal,
            'id_siswa'       => $request->id_siswa,
            'jawaban_siswa'  => $request->jawaban_siswa,
            'apakah_benar'   => $isCorrect ? 'benar' : 'salah',
            'skor_jawaban'   => $skor,
        ]);

        return response()->json([
            'message' => 'Jawaban berhasil disimpan!',
            'jawaban' => $jawaban,
        ], 201);
    }

    /**
     * Update jawaban berdasarkan id_soal & id_siswa
     */
    public function update(Request $request)
    {
        $request->validate([
            'id_soal'       => 'required|integer',
            'id_siswa'      => 'required|integer',
            'jawaban_siswa' => 'required|string',
        ]);

        // Cari jawaban berdasarkan soal + siswa
        $jawaban = JawabanSoal::where('id_soal', $request->id_soal)
            ->where('id_siswa', $request->id_siswa)
            ->firstOrFail();

        // Ambil soal untuk mengecek jawaban
        $soal = SoalKuis::findOrFail($request->id_soal);

        $isCorrect = strtolower($request->jawaban_siswa) == strtolower($soal->jawaban_benar);
        $skor = $isCorrect ? $soal->skor_soal : 0;

        // Update jawaban siswa
        $jawaban->update([
            'jawaban_siswa' => $request->jawaban_siswa,
            'apakah_benar'  => $isCorrect ? 'benar' : 'salah',
            'skor_jawaban'  => $skor,
        ]);

        return response()->json([
            'message' => 'Jawaban berhasil diperbarui!',
            'jawaban' => $jawaban
        ]);
    }

    /**
     * Menampilkan jawaban berdasarkan id_siswa
     */
    public function getBySiswa($id_siswa)
    {
        // Ambil semua jawaban siswa
        $jawaban = JawabanSoal::where('id_siswa', $id_siswa)->get();

        // Hitung total skor
        $totalSkor = $jawaban->sum('skor_jawaban');

        return response()->json([
            'id_siswa'   => $id_siswa,
            'total_skor' => $totalSkor,
            'jawaban'    => $jawaban
        ]);
    }



    /**
     * Menampilkan jawaban berdasarkan id_soal
     */
    public function getBySoal($id_soal)
    {
        $jawaban = JawabanSoal::where('id_soal', $id_soal)->get();

        return response()->json($jawaban);
    }

    /**
     * Delete jawaban berdasarkan id
     */
    public function destroy($id)
    {
        $jawaban = JawabanSoal::findOrFail($id);
        $jawaban->delete();

        return response()->json(['message' => 'Jawaban berhasil dihapus!']);
    }

    public function studentsAlreadyDoQuiz($id_kuis)
    {
        // Ambil semua soal dari kuis
        $soalIds = SoalKuis::where('id_kuis', $id_kuis)->pluck('id');

        // Ambil jawaban siswa (distinct supaya tidak dobel)
        $students = User::whereIn('id', function ($query) use ($soalIds) {
            $query->select('id_siswa')
                ->from('jawaban_soals')
                ->whereIn('id_soal', $soalIds);
        })
        ->where('role', 'student')
        ->get();

        return response()->json([
            'id_kuis' => $id_kuis,
            'total_students' => $students->count(),
            'students' => $students
        ]);
    }

}
