<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diskusi;
use App\Models\User;
use App\Events\DiskusiMessageSent;

class DiskusiController extends Controller
{
 public function store(Request $request)
    {
        $request->validate([
            'id_mata_pelajaran' => 'required|integer|exists:mata_pelajarans,id',
            'id_user'           => 'required|integer|exists:users,id',
            'pesan'             => 'required|string',
        ]);

        $diskusi = Diskusi::create([
            'id_mata_pelajaran' => $request->id_mata_pelajaran,
            'id_user'           => $request->id_user,
            'pesan'             => $request->pesan,
        ]);

        // 🔥 BROADCAST REALTIME
        broadcast(new DiskusiMessageSent($diskusi))->toOthers();
        // event(new DiskusiMessageSent($diskusi));


        return response()->json([
            'message' => 'Pesan berhasil dikirim',
            'data'    => $diskusi
        ], 201);
    }

    /**
     * Menampilkan semua pesan berdasarkan mata pelajaran
     */
    public function getByMataPelajaran($id_mata_pelajaran)
    {
        $diskusi = Diskusi::with('user:id,name,role')
            ->where('id_mata_pelajaran', $id_mata_pelajaran)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'id_mata_pelajaran' => $id_mata_pelajaran,
            'total_pesan'       => $diskusi->count(),
            'data'              => $diskusi
        ]);
    }

    

    /**
     * Hapus pesan (berdasarkan id_pesan + id_mata_pelajaran + id_user)
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id_pesan'          => 'required|integer',
            'id_mata_pelajaran' => 'required|integer',
            'id_user'           => 'required|integer',
        ]);

        $diskusi = Diskusi::where('id', $request->id_pesan)
            ->where('id_mata_pelajaran', $request->id_mata_pelajaran)
            ->where('id_user', $request->id_user)
            ->first();

        if (!$diskusi) {
            return response()->json([
                'message' => 'Pesan tidak ditemukan atau Anda tidak berhak menghapus pesan ini'
            ], 403);
        }

        $diskusi->delete();

        return response()->json([
            'message' => 'Pesan berhasil dihapus'
        ]);
    }
}
