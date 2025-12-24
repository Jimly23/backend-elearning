<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MateriController;
use App\Http\Controllers\Api\MataPelajaranController;
use App\Http\Controllers\Api\KuisController;
use App\Http\Controllers\Api\SoalKuisController;
use App\Http\Controllers\Api\JawabanSoalController;
use App\Http\Controllers\Api\DiskusiController;


Route::get('/users', [UserController::class, 'index']);
Route::post('/users/register', [UserController::class, 'store']);
Route::post('/users/login', [UserController::class, 'login']);
Route::get('/users/students', [UserController::class, 'students']);
Route::get('/users/teachers', [UserController::class, 'teachers']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::get('/materi', [MateriController::class, 'index']);          // Menampilkan semua materi
Route::get('/materi/{id}', [MateriController::class, 'show']);      // Menampilkan detail materi
Route::post('/materi', [MateriController::class, 'store']);         // Menambah materi
Route::put('/materi/{id}', [MateriController::class, 'update']);    // Mengubah materi
Route::delete('/materi/{id}', [MateriController::class, 'destroy']); // Menghapus materi
Route::get('/materi/mata-pelajaran/{mata_pelajaran_id}', [MateriController::class, 'getByMataPelajaran']);
Route::get('/materi/teacher/{teacher_id}', [MateriController::class, 'getByTeacher']);
Route::get('/materi/teacher/{teacher_id}/mapel/{mata_pelajaran_id}', [MateriController::class, 'getByTeacherAndMapel']);

Route::post('/mata-pelajaran', [MataPelajaranController::class, 'store']);
Route::get('/mata-pelajaran', [MataPelajaranController::class, 'index']);
Route::put('/mata-pelajaran/{id}', [MataPelajaranController::class, 'update']);
Route::delete('/mata-pelajaran/{id}', [MataPelajaranController::class, 'destroy']);
Route::get(
    '/mata-pelajaran/teacher/{teacher_id}',
    [MataPelajaranController::class, 'getByTeacher']
);

Route::post('/kuis', [KuisController::class, 'store']);
Route::get('/kuis', [KuisController::class, 'index']);
Route::get('/kuis/{id}', [KuisController::class, 'show']);
Route::get('/kuis/guru/{id_guru}', [KuisController::class, 'getByGuru']);
Route::get('/kuis/matapelajaran/{id_matapelajaran}', [KuisController::class, 'getByMataPelajaran']);
Route::put('/kuis/{id}', [KuisController::class, 'update']);
Route::delete('/kuis/{id}', [KuisController::class, 'destroy']);

Route::post('/soal-kuis', [SoalKuisController::class, 'store']);
Route::get('/soal-kuis', [SoalKuisController::class, 'index']);
Route::get('/soal-kuis/{id}', [SoalKuisController::class, 'show']);
Route::get('/soal-kuis/kuis/{id_kuis}', [SoalKuisController::class, 'getByKuis']);
Route::put('/soal-kuis/{id}', [SoalKuisController::class, 'update']);
Route::delete('/soal-kuis/{id}', [SoalKuisController::class, 'destroy']);

Route::post('/jawaban', [JawabanSoalController::class, 'store']);
Route::put('/jawaban/update', [JawabanSoalController::class, 'update']);
Route::get('/jawaban/siswa/{id_siswa}', [JawabanSoalController::class, 'getBySiswa']);
Route::get('/jawaban/soal/{id_soal}', [JawabanSoalController::class, 'getBySoal']);
Route::delete('/jawaban/{id}', [JawabanSoalController::class, 'destroy']);
Route::get('/kuis/{id_kuis}/students-done',[JawabanSoalController::class, 'studentsAlreadyDoQuiz']);

// Kirim pesan
Route::post('/diskusi', [DiskusiController::class, 'store']);
Route::get('/diskusi/mata-pelajaran/{id}', [DiskusiController::class, 'getByMataPelajaran']);
Route::delete('/diskusi', [DiskusiController::class, 'destroy']);

use App\Http\Controllers\Auth\PasswordResetController;
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);