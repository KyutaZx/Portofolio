<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mengizinkan penyimpanan data dari Filament
    protected $guarded = [];
}