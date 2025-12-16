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
        Schema::create('kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_guru') 
                  ->constrained('users') // Berelasi dengan tabel 'users'
                  ->onDelete('cascade'); // Menghapus material jika teacher (user) dihapus
            $table->foreignId('id_matapelajaran') 
                  ->constrained('mata_pelajarans') // Berelasi dengan tabel 'users'
                  ->onDelete('cascade'); // Menghapus material jika teacher (user) dihapus
            $table->string('judul_kuis', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuis');
    }
};
