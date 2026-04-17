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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            
            // Kolom untuk tabel Experience (Pengalaman Kerja)
            $table->string('company'); // Nama Perusahaan/Instansi
            $table->string('position'); // Posisi/Jabatan
            $table->date('start_date'); // Tanggal mulai bekerja
            $table->date('end_date')->nullable(); // Tanggal selesai (Kosong = Masih bekerja)
            $table->text('description')->nullable(); // Deskripsi pekerjaan (Opsional)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};