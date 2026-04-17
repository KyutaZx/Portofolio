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
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            
            // Kolom untuk tabel Certifications (Sertifikasi)
            $table->string('name'); // Nama Sertifikasi
            $table->string('issuer'); // Penerbit (Contoh: Google, Dicoding)
            $table->date('issued_at'); // Tanggal Terbit
            $table->string('credential_url')->nullable(); // Link ke sertifikat online (Opsional)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};