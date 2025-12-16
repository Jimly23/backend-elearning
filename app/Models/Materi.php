<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'mata_pelajaran_id',
        'teacher_id',
        'title',
        'description',
        'file_url',
        'file_type',
    ];
}