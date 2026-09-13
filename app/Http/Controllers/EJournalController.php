<?php

namespace App\Http\Controllers;

use App\Models\EJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class EJournalController extends Controller
{
    public function index(Request $request): View
    {
        $searchQuery = $request->query('q');
        $currentCategory = $request->query('cat');

        $query = EJournal::query();

        if (! empty($currentCategory)) {
            $query->where('category', $currentCategory);
        }

        if (! empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('description', 'like', "%{$searchQuery}%")
                    ->orWhere('author_or_curator', 'like', "%{$searchQuery}%");
            });
        }

        $eJournals = $query->latest()->paginate(9)->withQueryString();
        $categories = EJournal::distinct()->pluck('category');

        return view('ejurnal.index', compact('eJournals', 'categories', 'searchQuery', 'currentCategory'));
    }

    public function download(string $slug): Response
    {
        $journal = EJournal::where('slug', $slug)->firstOrFail();
        $journal->increment('download_count');

        // Check if file physically exists in storage/app/public or storage/app
        if (Storage::disk('public')->exists($journal->file_path)) {
            return response()->download(Storage::disk('public')->path($journal->file_path), $journal->title.'.pdf');
        }

        // If it's a seed document or dummy path, generate a graceful response or return fallback PDF
        return response(
            "Dokumen: {$journal->title}\nPenulis: {$journal->author_or_curator}\nTahun: {$journal->publication_year}\nKategori: {$journal->category}\n\nDeskripsi:\n{$journal->description}\n\n(Diterbitkan resmi oleh Yayasan Proklamator Bung Hatta - Hatta Aksara Project)",
            200,
            [
                'Content-Type' => 'text/plain; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="'.$journal->slug.'.txt"',
            ]
        );
    }
}
