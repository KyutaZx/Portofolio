<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    /**
     * Izinkan kolom-kolom ini diisi secara massal (Mass Assignment).
     * Sesuai dengan form yang kita buat di dashboard admin tadi.
     */
    protected $fillable = [
        'name',           // Nama Sertifikasi
        'issuer',         // Lembaga Penerbit
        'issued_at',      // Tanggal Terbit
        'credential_url', // Link Verifikasi
    ];

    /**
     * Casting issued_at menjadi format tanggal (date) agar 
     * mudah dimanipulasi di tampilan depan.
     */
    protected $casts = [
        'issued_at' => 'date',
    ];
}