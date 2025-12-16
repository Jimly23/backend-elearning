<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jawaban_soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_soal') 
                  ->constrained('soal_kuis')
                  ->onDelete('cascade'); 
            $table->foreignId('id_siswa') 
                  ->constrained('users')
                  ->onDelete('cascade'); 
            $table->string('jawaban_siswa', 255);
            $table->string('apakah_benar', 255);
            $table->integer('skor_jawaban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_soals');
    }
};
