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
        Schema::create('identities', function (Blueprint $table) {
            $table->id();
            
            // Profil Utama
            $table->string('name'); // Nama lengkap
            $table->string('title'); // Peran/Title (misal: Junior Backend Engineer)
            $table->string('avatar')->nullable(); // Foto profil
            $table->string('bio'); // Bio singkat (Gunakan string karena "singkat")
            
            // Link Sosial Media
            $table->string('github_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('instagram_link')->nullable(); // Tambahan sosmed
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identities');
    }
};