<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration dengan pengecekan eksistensi kolom.
     */
    public function up(): void
    {
        Schema::table('identities', function (Blueprint $table) {
            if (!Schema::hasColumn('identities', 'title')) {
                $table->string('title')->after('name')->nullable();
            }
            if (!Schema::hasColumn('identities', 'bio')) {
                $table->text('bio')->after('avatar')->nullable();
            }
            if (!Schema::hasColumn('identities', 'email')) {
                $table->string('email')->after('bio')->nullable();
            }
            if (!Schema::hasColumn('identities', 'github_link')) {
                $table->string('github_link')->after('email')->nullable();
            }
            if (!Schema::hasColumn('identities', 'linkedin_link')) {
                $table->string('linkedin_link')->after('github_link')->nullable();
            }
        });
    }

    /**
     * Batalkan migration dengan pengecekan agar tidak eror saat rollback.
     */
    public function down(): void
    {
        Schema::table('identities', function (Blueprint $table) {
            $columns = ['title', 'bio', 'email', 'github_link', 'linkedin_link'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('identities', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};