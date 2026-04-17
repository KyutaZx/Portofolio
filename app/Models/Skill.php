<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    /**
     * Menonaktifkan pengamanan mass assignment agar Filament 
     * bisa menyimpan data ke semua kolom di tabel skills.
     */
    protected $guarded = [];
}