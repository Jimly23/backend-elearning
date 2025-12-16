<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Diskusi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_mata_pelajaran',
        'id_user',
        'pesan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
