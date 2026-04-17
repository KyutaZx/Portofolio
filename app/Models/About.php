<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    // Tambahkan baris di bawah ini agar data bisa disimpan
    protected $fillable = [
        'description',
        'email',
        'location',
        'resume',
    ];
}