<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $profile = PortfolioProfile::firstOrCreate(['id' => 1], [
            'full_name' => 'Shan Favian Efendy',
            'class_name' => 'XII A',
            'competency' => 'PPLG (Pengembangan Perangkat Lunak dan Gim)',
            'summary' => 'UI/UX Designer yang berfokus merancang antarmuka digital yang intuitif, menarik, dan berpusat pada pengguna.',
            'bio' => 'Siswa SMK Negeri 2 Banjarmasin dan UI/UX Designer.',
            'education' => "SD Muhammadiyah Al-Furqan (2015–2021)\nMTs Muhammadiyah Al-Furqan (2021–2024)\nSMK Negeri 2 Banjarmasin — PPLG (2024–2027)",
            'career_goal' => 'Terus mengembangkan kemampuan di bidang UI/UX Design.',
            'email' => 'shanfavianeffendy@gmail.com',
            'github_url' => 'https://github.com/Mitsu-Shan16',
            'instagram_url' => 'https://www.instagram.com/shan_aja7/',
        ]);

        $projects = Project::latest()->get();
        $skills = Skill::orderBy('sort_order')->orderBy('id')->get()->groupBy('category');
        $certificates = Certificate::orderByDesc('date')->orderByDesc('id')->get();
        $experiences = Experience::orderByDesc('start_date')->orderByDesc('id')->get()->groupBy('category');

        return view('welcome', compact('profile', 'projects', 'skills', 'certificates', 'experiences'));
    }
}
