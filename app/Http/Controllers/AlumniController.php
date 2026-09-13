<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\Category;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AlumniController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $posts = Post::where('author_id', $user->id)->latest()->get();

        $stats = [
            'total' => $posts->count(),
            'published' => $posts->where('status', 'published')->count(),
            'pending' => $posts->where('status', 'pending_review')->count(),
            'revision' => $posts->where('status', 'revision_required')->count(),
            'draft' => $posts->where('status', 'draft')->count(),
        ];

        $needRevisionPosts = $posts->where('status', 'revision_required');
        $recentPosts = $posts->take(5);

        return view('alumni.dashboard', compact('user', 'stats', 'needRevisionPosts', 'recentPosts'));
    }

    public function myPosts(Request $request): View
    {
        $user = Auth::user();
        $status = $request->query('status');
        $type = $request->query('type');

        $query = Post::with(['category', 'subCategory'])
            ->where('author_id', $user->id);

        if (! empty($status)) {
            $query->where('status', $status);
        }

        if (! empty($type)) {
            $query->where('post_type', $type);
        }

        $posts = $query->latest()->paginate(10)->withQueryString();

        return view('alumni.my-posts', compact('posts', 'status', 'type'));
    }

    public function createAksi(): View
    {
        $category = Category::where('slug', 'aksi-hatta-muda')->first();
        $subCategories = SubCategory::where('category_id', $category?->id)->get();
        if ($subCategories->isEmpty()) {
            $subCategories = SubCategory::all();
        }

        return view('alumni.create-aksi', compact('category', 'subCategories'));
    }

    public function storeAksi(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'sub_category_id' => ['nullable', 'exists:sub_categories,id'],
            'action_location' => ['required', 'string', 'max:255'],
            'action_date' => ['nullable', 'date'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'action_button' => ['required', 'in:draft,submit'],
        ]);

        $category = Category::where('slug', 'aksi-hatta-muda')->firstOrFail();

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts/images', 'public');
        }

        $status = $validated['action_button'] === 'submit' ? 'pending_review' : 'draft';
        $slug = Str::slug($validated['title']).'-'.Str::random(5);

        Post::create([
            'author_id' => Auth::id(),
            'post_type' => 'aksi_hatta_muda',
            'category_id' => $category->id,
            'sub_category_id' => $validated['sub_category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'action_location' => $validated['action_location'],
            'action_date' => $validated['action_date'] ?? now(),
            'status' => $status,
        ]);

        $msg = $status === 'pending_review'
            ? 'Berita Aksi Hatta Muda berhasil diajukan untuk ditinjau redaksi!'
            : 'Draf Berita Aksi Hatta Muda berhasil disimpan.';

        return redirect()->route('alumni.my-posts')->with('success', $msg);
    }

    public function createArtikel(): View
    {
        $category = Category::where('slug', 'artikel')->first();
        $subCategories = SubCategory::all();

        return view('alumni.create-artikel', compact('category', 'subCategories'));
    }

    public function storeArtikel(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'sub_category_id' => ['nullable', 'exists:sub_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'action_button' => ['required', 'in:draft,submit'],
        ]);

        $category = Category::where('slug', 'artikel')->first();
        if (! $category) {
            $category = Category::firstOrCreate(['slug' => 'artikel'], ['name' => 'Artikel Gagasan', 'type' => 'artikel']);
        }

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts/images', 'public');
        }

        $status = $validated['action_button'] === 'submit' ? 'pending_review' : 'draft';
        $slug = Str::slug($validated['title']).'-'.Str::random(5);

        Post::create([
            'author_id' => Auth::id(),
            'post_type' => 'artikel',
            'category_id' => $category->id,
            'sub_category_id' => $validated['sub_category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'status' => $status,
        ]);

        $msg = $status === 'pending_review'
            ? 'Artikel gagasan berhasil diajukan untuk ditinjau redaksi!'
            : 'Draf artikel gagasan berhasil disimpan.';

        return redirect()->route('alumni.my-posts')->with('success', $msg);
    }

    public function editPost(int $id): View
    {
        $post = Post::where('author_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $subCategories = SubCategory::all();

        return view('alumni.edit-post', compact('post', 'subCategories'));
    }

    public function updatePost(Request $request, int $id): RedirectResponse
    {
        $post = Post::where('author_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'sub_category_id' => ['nullable', 'exists:sub_categories,id'],
            'action_location' => ['nullable', 'string', 'max:255'],
            'action_date' => ['nullable', 'date'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'action_button' => ['required', 'in:draft,submit'],
        ]);

        if ($request->hasFile('featured_image')) {
            $post->featured_image = $request->file('featured_image')->store('posts/images', 'public');
        }

        $post->title = $validated['title'];
        $post->sub_category_id = $validated['sub_category_id'] ?? null;
        $post->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160);
        $post->content = $validated['content'];

        if ($post->post_type === 'aksi_hatta_muda') {
            $post->action_location = $validated['action_location'] ?? null;
            $post->action_date = $validated['action_date'] ?? $post->action_date;
        }

        if ($validated['action_button'] === 'submit') {
            $post->status = 'pending_review';
        } else {
            $post->status = 'draft';
        }

        $post->save();

        return redirect()->route('alumni.my-posts')
            ->with('success', 'Perubahan naskah tulisan berhasil disimpan.');
    }

    public function networking(Request $request): View
    {
        $search = $request->query('q');
        $selectedProvince = $request->query('prov');
        $selectedBatch = $request->query('batch');

        $query = User::with('alumniProfile')
            ->where('role', 'hatta_muda')
            ->where('status', 'approved');

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('alumniProfile', function ($sub) use ($search) {
                        $sub->where('school_origin', 'like', "%{$search}%")
                            ->orWhere('current_institution', 'like', "%{$search}%")
                            ->orWhere('city', 'like', "%{$search}%");
                    });
            });
        }

        if (! empty($selectedProvince)) {
            $query->whereHas('alumniProfile', function ($sub) use ($selectedProvince) {
                $sub->where('province', $selectedProvince);
            });
        }

        if (! empty($selectedBatch)) {
            $query->whereHas('alumniProfile', function ($sub) use ($selectedBatch) {
                $sub->where('islt_batch', $selectedBatch);
            });
        }

        $alumniMembers = $query->paginate(12)->withQueryString();

        $provinces = AlumniProfile::distinct()->pluck('province')->filter();
        $batches = AlumniProfile::distinct()->pluck('islt_batch')->filter();

        return view('alumni.networking', compact('alumniMembers', 'provinces', 'batches', 'search', 'selectedProvince', 'selectedBatch'));
    }

    public function profile(): View
    {
        $user = Auth::user()->load('alumniProfile');

        if (! $user->alumniProfile) {
            $user->setRelation('alumniProfile', new AlumniProfile([
                'user_id' => $user->id,
                'islt_batch' => $user->isAdmin() ? 'Pengurus / Redaksi' : 'Alumni ISLT',
                'school_origin' => $user->isAdmin() ? 'Yayasan Proklamator Bung Hatta' : 'Belum diisi',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta',
                'phone_number' => '08128888000',
                'is_phone_public' => false,
                'bio' => 'Pengurus dan Pembina Ekosistem Hatta Aksara Project.',
            ]));
        }

        return view('alumni.profile', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'current_institution' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:50'],
            'is_phone_public' => ['nullable', 'boolean'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user->update(['name' => $validated['name']]);

        $profile = $user->alumniProfile ?? new AlumniProfile(['user_id' => $user->id]);

        $avatarPath = $profile->avatar_path;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $profile->fill([
            'current_institution' => $validated['current_institution'] ?? null,
            'phone_number' => $validated['phone_number'],
            'is_phone_public' => $request->boolean('is_phone_public'),
            'bio' => $validated['bio'] ?? null,
            'avatar_path' => $avatarPath,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
            'instagram_url' => $validated['instagram_url'] ?? null,
        ]);

        if (! $profile->exists) {
            $profile->islt_batch = $profile->islt_batch ?? 'Pengurus / Redaksi';
            $profile->school_origin = $profile->school_origin ?? 'Yayasan Proklamator Bung Hatta';
            $profile->province = $profile->province ?? 'DKI Jakarta';
            $profile->city = $profile->city ?? 'Jakarta';
        }

        $profile->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
