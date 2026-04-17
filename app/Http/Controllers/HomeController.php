<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Certification;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Identity;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman Landing Page Portfolio.
     */
    public function index()
    {
        // Mengambil data identitas (paling penting untuk Hero Section)
        $identity = Identity::first();

        // Mengambil data pendukung lainnya
        $about = About::first();
        $projects = Project::latest()->get();
        $skills = Skill::all();
        $experiences = Experience::orderBy('start_date', 'desc')->get();
        $educations = Education::orderBy('start_date', 'desc')->get();
        $certifications = Certification::latest()->get();

        // Mengirimkan semua variabel ke view 'welcome'
        return view('welcome', compact(
            'identity', 
            'about', 
            'projects', 
            'skills', 
            'experiences', 
            'educations', 
            'certifications'
        ));
    }
}