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
        Schema::create('soal_kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kuis') 
                  ->constrained('kuis') // Berelasi dengan tabel 'users'
                  ->onDelete('cascade'); 
            $table->text('pertanyaan');
            $table->string('opsi_a', 255);
            $table->string('opsi_b', 255);
            $table->string('opsi_c', 255);
            $table->string('opsi_d', 255);
            $table->string('jawaban_benar', 255);
            $table->integer('skor_soal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_kuis');
    }
};
