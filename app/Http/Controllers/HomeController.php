<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\EJournal;
use App\Models\IsltApplicant;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Program;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // 1. Highlight News & Kegiatan
        $featuredNews = Post::with(['author', 'category', 'subCategory'])
            ->published()
            ->whereIn('post_type', ['news', 'kegiatan'])
            ->latest('published_at')
            ->take(3)
            ->get();

        // 2. Highlight Aksi Hatta Muda
        $featuredAksi = Post::with(['author.alumniProfile', 'category', 'subCategory'])
            ->published()
            ->aksiHattaMuda()
            ->latest('published_at')
            ->take(3)
            ->get();

        // 3. Highlight Artikel Gagasan
        $featuredArticles = Post::with(['author.alumniProfile', 'category', 'subCategory'])
            ->published()
            ->artikel()
            ->latest('published_at')
            ->take(3)
            ->get();

        // 4. Programs
        $programs = Program::orderBy('sort_order')->take(2)->get();

        // 5. Impact Metrics (Faktual & Dinamis dari Basis Data Tanpa Overclaim)
        $totalAlumni = User::where('role', 'hatta_muda')->where('status', 'approved')->count();
        $totalApplicants = IsltApplicant::count();
        $totalPublications = Post::published()->count();
        $totalJournals = EJournal::count();
        $provincesCount = 38; // Sasaran cakupan nasional 38 provinsi

        return view('home', compact(
            'featuredNews',
            'featuredAksi',
            'featuredArticles',
            'programs',
            'totalAlumni',
            'totalApplicants',
            'totalPublications',
            'totalJournals',
            'provincesCount'
        ));
    }

    public function about(): View
    {
        $history = PageContent::where('section_key', 'about_history')->first();
        $vision = PageContent::where('section_key', 'about_vision')->first();
        $mission = PageContent::where('section_key', 'about_mission')->first();
        $values = PageContent::where('section_key', 'about_values')->first();

        return view('tentang', compact('history', 'vision', 'mission', 'values'));
    }
}
