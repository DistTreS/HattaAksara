<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $currentType = $request->query('type', 'all');
        $currentSubCat = $request->query('sub');
        $searchQuery = $request->query('q');

        $query = Post::with(['author.alumniProfile', 'category', 'subCategory'])
            ->published()
            ->whereIn('post_type', ['news', 'aksi_hatta_muda', 'kegiatan']);

        if ($currentType !== 'all' && in_array($currentType, ['news', 'aksi_hatta_muda', 'kegiatan'])) {
            $query->where('post_type', $currentType);
        }

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

        $posts = $query->latest('published_at')->paginate(9)->withQueryString();
        $subCategories = SubCategory::orderBy('name')->get();

        return view('berita.index', compact('posts', 'subCategories', 'currentType', 'currentSubCat', 'searchQuery'));
    }

    public function show(string $slug): View
    {
        $post = Post::with(['author.alumniProfile', 'category', 'subCategory'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views count safely
        $post->increment('views_count');

        $relatedPosts = Post::with(['author', 'category'])
            ->published()
            ->where('id', '!=', $post->id)
            ->where(function ($q) use ($post) {
                $q->where('post_type', $post->post_type)
                    ->orWhere('category_id', $post->category_id);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('berita.show', compact('post', 'relatedPosts'));
    }
}
