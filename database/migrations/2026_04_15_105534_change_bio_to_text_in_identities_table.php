<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('identities', function (Blueprint $table) {
            // Kita ubah 'bio' dari string biasa menjadi 'text' (lebih lega)
            $table->text('bio')->change();
        });
    }

    public function down(): void
    {
        Schema::table('identities', function (Blueprint $table) {
            // Jika di-rollback, balikkan ke string (maks 255)
            $table->string('bio', 255)->change();
        });
    }
};
