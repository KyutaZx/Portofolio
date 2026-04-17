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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            
            // Deskripsi panjang 'About Me'
            $table->text('description'); 
            
            // File resume/CV (biasanya path ke file PDF)
            $table->string('resume')->nullable(); 
            
            // Kontak & Lokasi
            $table->string('email');
            $table->string('location');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};