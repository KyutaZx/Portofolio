<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    use HasFactory;

    /**
     * VERSI FINAL:
     * Mendaftarkan semua kolom agar sinkron dengan IdentityResource
     * dan mencegah error MassAssignmentException.
     */
    protected $fillable = [
        'name',
        'title',         // Wajib ada agar tidak error SQL lagi
        'avatar',
        'bio',
        'email',
        'github_link',
        'linkedin_link',
    ];

    /**
     * Catatan: 
     * Gunakan $fillable (Whitelist) seperti di atas untuk keamanan yang lebih baik
     * daripada menggunakan $guarded = [] (Blacklist).
     */
}