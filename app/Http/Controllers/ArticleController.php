<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $searchQuery = $request->query('q');
        $currentSubCat = $request->query('sub');

        $query = Post::with(['author.alumniProfile', 'subCategory'])
            ->published()
            ->artikel();

        if (! empty($currentSubCat)) {
            $query->whereHas('subCategory', function ($q) use ($currentSubCat) {
                $q->where('slug', $currentSubCat);
            });
        }

        if (! empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('content', 'like', "%{$searchQuery}%")
                    ->orWhere('excerpt', 'like', "%{$searchQuery}%");
            });
        }

        $articles = $query->latest('published_at')->paginate(9)->withQueryString();
        $subCategories = SubCategory::orderBy('name')->get();

        return view('artikel.index', compact('articles', 'subCategories', 'searchQuery', 'currentSubCat'));
    }

    public function show(string $slug): View
    {
        $article = Post::with(['author.alumniProfile', 'subCategory'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('post_type', 'artikel')
            ->firstOrFail();

        $article->increment('views_count');

        $relatedArticles = Post::with(['author.alumniProfile'])
            ->published()
            ->artikel()
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('artikel.show', compact('article', 'relatedArticles'));
    }
}
