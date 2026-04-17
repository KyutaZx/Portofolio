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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            
            // Kolom untuk tabel Education (Riwayat Pendidikan)
            $table->string('institution'); // Nama Kampus/Sekolah
            $table->string('degree'); // Gelar atau Jenjang (Misal: S1, SMK)
            $table->string('major')->nullable(); // Jurusan (Misal: Teknik Informatika)
            $table->date('start_date'); // Tanggal masuk
            $table->date('end_date')->nullable(); // Tanggal lulus (Kosong = Belum lulus)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};