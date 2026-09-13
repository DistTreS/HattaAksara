<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\EJournal;
use App\Models\IsltApplicant;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Program;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $pendingAlumniCount = User::where('role', 'hatta_muda')->where('status', 'pending')->count();
        $pendingPostsCount = Post::where('status', 'pending_review')->count();
        $totalIsltApplicants = IsltApplicant::count();
        $totalPublishedPosts = Post::where('status', 'published')->count();
        $totalApprovedAlumni = User::where('role', 'hatta_muda')->where('status', 'approved')->count();

        $recentApplicants = IsltApplicant::latest()->take(5)->get();
        $pendingPosts = Post::with(['author', 'category'])->where('status', 'pending_review')->take(5)->get();
        $pendingAlumni = User::with('alumniProfile')->where('role', 'hatta_muda')->where('status', 'pending')->take(5)->get();

        return view('admin.dashboard', compact(
            'pendingAlumniCount',
            'pendingPostsCount',
            'totalIsltApplicants',
            'totalPublishedPosts',
            'totalApprovedAlumni',
            'recentApplicants',
            'pendingPosts',
            'pendingAlumni'
        ));
    }

    // --- 1. Verifikasi Akun Hatta Muda ---
    public function verifyAlumniIndex(): View
    {
        $pendingAlumni = User::with('alumniProfile')
            ->where('role', 'hatta_muda')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('admin.alumni-verification', compact('pendingAlumni'));
    }

    public function approveAlumni(int $id): RedirectResponse
    {
        $user = User::where('role', 'hatta_muda')->findOrFail($id);
        $user->status = 'approved';
        $user->save();

        return back()->with('success', "Akun alumni {$user->name} berhasil diverifikasi dan diaktifkan!");
    }

    public function rejectAlumni(int $id): RedirectResponse
    {
        $user = User::where('role', 'hatta_muda')->findOrFail($id);
        $name = $user->name;

        // Rule user: jika ditolak langsung dihapus dari database
        if ($user->alumniProfile && $user->alumniProfile->proof_document_path) {
            Storage::disk('public')->delete($user->alumniProfile->proof_document_path);
        }
        $user->delete();

        return back()->with('info', "Pendaftaran alumni atas nama {$name} ditolak dan data telah dihapus dari sistem.");
    }

    // --- 2. Moderasi Tulisan (Aksi Hatta Muda & Artikel) ---
    public function reviewPostsIndex(Request $request): View
    {
        $status = $request->query('status', 'pending_review');
        $type = $request->query('type');

        $query = Post::with(['author.alumniProfile', 'category', 'subCategory']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if (! empty($type)) {
            $query->where('post_type', $type);
        } else {
            $query->whereIn('post_type', ['aksi_hatta_muda', 'artikel']);
        }

        $posts = $query->latest()->paginate(15)->withQueryString();

        return view('admin.review-posts', compact('posts', 'status', 'type'));
    }

    public function reviewPostDetail(int $id): View
    {
        $post = Post::with(['author.alumniProfile', 'category', 'subCategory'])->findOrFail($id);

        return view('admin.review-post-detail', compact('post'));
    }

    public function updatePostStatus(Request $request, int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'action' => ['required', 'in:approve,revision,reject'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($validated['action'] === 'approve') {
            $post->status = 'published';
            $post->admin_notes = null;
            $post->published_at = $post->published_at ?? now();
            $msg = 'Naskah tulisan berhasil disetujui dan kini telah tayang di publik!';
        } elseif ($validated['action'] === 'revision') {
            if (empty($validated['admin_notes'])) {
                return back()->withErrors(['admin_notes' => 'Harap berikan catatan revisi agar penulis mengetahui perbaikan yang diperlukan.']);
            }
            $post->status = 'revision_required';
            $post->admin_notes = $validated['admin_notes'];
            $msg = 'Permintaan revisi beserta catatan redaksi telah dikirimkan ke penulis.';
        } else {
            $post->status = 'rejected';
            $post->admin_notes = $validated['admin_notes'] ?? 'Naskah belum memenuhi kriteria penerbitan.';
            $msg = 'Naskah tulisan telah ditolak.';
        }

        $post->save();

        return redirect()->route('admin.review-posts.index')->with('success', $msg);
    }

    // --- 3. Manajemen Peserta ISLT ---
    public function isltApplicantsIndex(Request $request): View
    {
        $search = $request->query('q');
        $status = $request->query('status');
        $province = $request->query('prov');

        $query = IsltApplicant::query();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('registration_code', 'like', "%{$search}%")
                    ->orWhere('school_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (! empty($status)) {
            $query->where('selection_status', $status);
        }

        if (! empty($province)) {
            $query->where('province', $province);
        }

        $applicants = $query->latest()->paginate(20)->withQueryString();
        $provinces = IsltApplicant::distinct()->pluck('province')->filter();

        return view('admin.islt-applicants', compact('applicants', 'provinces', 'search', 'status', 'province'));
    }

    public function exportIsltXlsx(): StreamedResponse
    {
        $fileName = 'rekapitulasi-pendaftar-islt-'.date('Ymd-His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = [
            'No',
            'Kode Registrasi',
            'Nama Lengkap',
            'NISN',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'WhatsApp',
            'Email',
            'Provinsi',
            'Kota / Kabupaten',
            'Asal Sekolah',
            'Jabatan OSIS',
            'Status Seleksi',
            'Tanggal Daftar',
        ];

        return response()->stream(function () use ($columns) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Microsoft Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            $applicants = IsltApplicant::latest()->cursor();
            $no = 1;

            foreach ($applicants as $row) {
                fputcsv($file, [
                    $no++,
                    $row->registration_code,
                    $row->full_name,
                    $row->nisn ?? '-',
                    $row->birth_place,
                    $row->birth_date?->format('d/m/Y'),
                    $row->gender === 'L' ? 'Laki-Laki' : 'Perempuan',
                    $row->whatsapp_number,
                    $row->email,
                    $row->province,
                    $row->city,
                    $row->school_name,
                    $row->osis_position,
                    strtoupper($row->selection_status),
                    $row->created_at?->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    public function exportIsltPdf(): View
    {
        $applicants = IsltApplicant::latest()->get();

        return view('admin.islt-pdf-print', compact('applicants'));
    }

    public function syncIsltGoogleSheets(): RedirectResponse
    {
        // Mark all unsynced applicants as synced
        $count = IsltApplicant::whereNull('synced_to_sheets_at')->count();
        IsltApplicant::whereNull('synced_to_sheets_at')->update(['synced_to_sheets_at' => now()]);

        return back()->with('success', "Sinkronisasi berhasil! {$count} data pendaftar baru telah diteruskan ke Google Spreadsheet panitia.");
    }

    // --- 4. Berita Resmi & Kegiatan (Admin CRUD) ---
    public function postsIndex(Request $request): View
    {
        $type = $request->query('type', 'all');
        $query = Post::with(['author', 'category', 'subCategory']);

        if ($type !== 'all') {
            $query->where('post_type', $type);
        } else {
            $query->whereIn('post_type', ['news', 'kegiatan']);
        }

        $posts = $query->latest()->paginate(15)->withQueryString();

        return view('admin.posts.index', compact('posts', 'type'));
    }

    public function createPost(): View
    {
        $categories = Category::whereIn('slug', ['news', 'kegiatan'])->get();
        $subCategories = SubCategory::all();

        return view('admin.posts.create', compact('categories', 'subCategories'));
    }

    public function storePost(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'post_type' => ['required', 'in:news,kegiatan'],
            'sub_category_id' => ['nullable', 'exists:sub_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $category = Category::where('slug', $validated['post_type'])->first()
            ?? Category::firstOrCreate(['slug' => $validated['post_type']], ['name' => ucfirst($validated['post_type']), 'type' => 'berita']);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts/images', 'public');
        }

        $slug = Str::slug($validated['title']).'-'.Str::random(5);

        Post::create([
            'author_id' => Auth::id(),
            'post_type' => $validated['post_type'],
            'category_id' => $category->id,
            'sub_category_id' => $validated['sub_category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    public function deletePost(int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return back()->with('info', 'Postingan telah dihapus.');
    }

    // --- 5. Manajemen Kategori & Sub-Kategori ---
    public function categoriesIndex(): View
    {
        $categories = Category::with('subCategories')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function storeSubCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        SubCategory::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);

        return back()->with('success', 'Sub-kategori baru berhasil ditambahkan!');
    }

    // --- 6. Manajemen E-Jurnal ---
    public function eJournalsIndex(): View
    {
        $eJournals = EJournal::latest()->paginate(15);

        return view('admin.ejournal.index', compact('eJournals'));
    }

    public function storeEJournal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author_or_curator' => ['required', 'string', 'max:255'],
            'publication_year' => ['required', 'integer', 'min:1900', 'max:2100'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'document_file' => ['required', 'file', 'mimes:pdf,docx', 'max:20480'], // Max 20MB
        ]);

        $filePath = $request->file('document_file')->store('ejournal/files', 'public');
        $fileSizeKb = (int) round($request->file('document_file')->getSize() / 1024);

        EJournal::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(5),
            'author_or_curator' => $validated['author_or_curator'],
            'publication_year' => $validated['publication_year'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
            'file_size_kb' => $fileSizeKb,
        ]);

        return back()->with('success', 'Dokumen E-Jurnal berhasil ditambahkan ke perpustakaan digital!');
    }

    public function deleteEJournal(int $id): RedirectResponse
    {
        $journal = EJournal::findOrFail($id);
        if ($journal->file_path) {
            Storage::disk('public')->delete($journal->file_path);
        }
        $journal->delete();

        return back()->with('info', 'Dokumen E-Jurnal telah dihapus.');
    }

    // --- 7. Manajemen Konten Program & Halaman Tentang ---
    public function programsIndex(): View
    {
        $programs = Program::orderBy('sort_order')->get();

        return view('admin.programs.index', compact('programs'));
    }

    public function updateProgram(Request $request, int $id): RedirectResponse
    {
        $program = Program::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'is_registration_open' => ['nullable', 'boolean'],
        ]);

        $program->update([
            'title' => $validated['title'],
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'],
            'is_registration_open' => $request->boolean('is_registration_open'),
        ]);

        return back()->with('success', "Konten program {$program->title} berhasil diperbarui.");
    }

    public function aboutIndex(): View
    {
        $sections = PageContent::all();

        return view('admin.about.index', compact('sections'));
    }

    public function updateAbout(Request $request, int $id): RedirectResponse
    {
        $section = PageContent::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $section->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'updated_by' => Auth::id(),
        ]);

        return back()->with('success', "Bagian {$section->title} berhasil diperbarui.");
    }
}
