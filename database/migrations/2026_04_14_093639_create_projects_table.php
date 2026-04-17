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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Proyek
            $table->text('description'); // Deskripsi lengkap proyek
            $table->string('thumbnail'); // Nama file gambar/thumbnail
            $table->string('tech_stack'); // Daftar teknologi (contoh: Laravel, React, Tailwind)
            $table->string('github_link')->nullable(); // Link GitHub (opsional)
            $table->string('demo_link')->nullable(); // Link Demo/Live (opsional)
            $table->integer('order')->default(0); // Untuk mengatur urutan tampilan proyek
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};