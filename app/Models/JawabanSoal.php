<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_soal',
        'id_siswa',
        'jawaban_siswa',
        'apakah_benar',
        'skor_jawaban',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'id_siswa');
    }

}
