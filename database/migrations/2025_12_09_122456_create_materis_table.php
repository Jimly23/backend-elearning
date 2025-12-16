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
        Schema::create('materis', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('mata_pelajaran_id') 
                  ->constrained('mata_pelajarans') // Berelasi dengan tabel 'users'
                  ->onDelete('cascade'); // Menghapus material jika teacher (user) dihapus
            $table->foreignId('teacher_id') 
                  ->constrained('users') // Berelasi dengan tabel 'users'
                  ->onDelete('cascade'); // Menghapus material jika teacher (user) dihapus
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('file_url', 255);
            $table->string('file_type', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
