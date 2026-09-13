<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EJournalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Hatta Aksara Project
|--------------------------------------------------------------------------
*/

// --- PUBLIC / GUEST ROUTES ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::redirect('/tentang-kami', '/tentang');
Route::redirect('/register', '/bergabung-hatta-muda');

// Berita (News, Aksi Hatta Muda, Kegiatan)
Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('berita.show');

// Program (ISLT, Pendaftaran Publik, Media Edukasi)
Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
Route::get('/program/islt', [ProgramController::class, 'islt'])->name('program.islt');
Route::get('/program/islt/daftar', [ProgramController::class, 'showRegisterIslt'])->name('program.islt.daftar');
Route::post('/program/islt/daftar', [ProgramController::class, 'storeRegisterIslt'])->name('program.islt.store');
Route::get('/program/islt/sukses/{code}', [ProgramController::class, 'registrationSuccess'])->name('program.islt.success');
Route::get('/program/media-edukasi', [ProgramController::class, 'mediaEdukasi'])->name('program.media-edukasi');

// Artikel Gagasan
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('artikel.show');

// E-Jurnal & Dokumen
Route::get('/e-jurnal', [EJournalController::class, 'index'])->name('ejurnal.index');
Route::get('/e-jurnal/download/{slug}', [EJournalController::class, 'download'])->name('ejurnal.download');

// Autentikasi & Registrasi Alumni
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/bergabung-hatta-muda', [AuthController::class, 'showRegisterHattaMuda'])->name('register.hatta-muda');
Route::post('/bergabung-hatta-muda', [AuthController::class, 'registerHattaMuda'])->name('register.hatta-muda.store');
Route::get('/alumni/pending-notice', [AuthController::class, 'pendingNotice'])->name('alumni.pending-notice');

// --- HATTA MUDA CONNECTION (PORTAL ALUMNI) ---
Route::middleware(['auth', 'role:hatta_muda'])->prefix('alumni')->name('alumni.')->group(function () {
    Route::get('/dashboard', [AlumniController::class, 'dashboard'])->name('dashboard');
    Route::get('/tulisan-saya', [AlumniController::class, 'myPosts'])->name('my-posts');
    Route::get('/tulis-aksi', [AlumniController::class, 'createAksi'])->name('create-aksi');
    Route::post('/tulis-aksi', [AlumniController::class, 'storeAksi'])->name('store-aksi');
    Route::get('/tulis-artikel', [AlumniController::class, 'createArtikel'])->name('create-artikel');
    Route::post('/tulis-artikel', [AlumniController::class, 'storeArtikel'])->name('store-artikel');
    Route::get('/edit-tulisan/{id}', [AlumniController::class, 'editPost'])->name('edit-post');
    Route::put('/edit-tulisan/{id}', [AlumniController::class, 'updatePost'])->name('update-post');
    Route::get('/jejaring', [AlumniController::class, 'networking'])->name('networking');
    Route::get('/profil', [AlumniController::class, 'profile'])->name('profile');
    Route::put('/profil', [AlumniController::class, 'updateProfile'])->name('update-profile');
});

// --- ADMIN REDAKSI BACKOFFICE ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 1. Verifikasi Akun Hatta Muda
    Route::get('/verifikasi-alumni', [AdminController::class, 'verifyAlumniIndex'])->name('verify-alumni.index');
    Route::post('/verifikasi-alumni/{id}/approve', [AdminController::class, 'approveAlumni'])->name('verify-alumni.approve');
    Route::delete('/verifikasi-alumni/{id}/reject', [AdminController::class, 'rejectAlumni'])->name('verify-alumni.reject');

    // 2. Moderasi Tulisan (Aksi & Artikel)
    Route::get('/moderasi-tulisan', [AdminController::class, 'reviewPostsIndex'])->name('review-posts.index');
    Route::get('/moderasi-tulisan/{id}', [AdminController::class, 'reviewPostDetail'])->name('review-posts.detail');
    Route::post('/moderasi-tulisan/{id}/status', [AdminController::class, 'updatePostStatus'])->name('review-posts.status');

    // 3. Manajemen Peserta ISLT & Ekspor Data
    Route::get('/peserta-islt', [AdminController::class, 'isltApplicantsIndex'])->name('islt.index');
    Route::get('/peserta-islt/export-xlsx', [AdminController::class, 'exportIsltXlsx'])->name('islt.export-xlsx');
    Route::get('/peserta-islt/export-pdf', [AdminController::class, 'exportIsltPdf'])->name('islt.export-pdf');
    Route::post('/peserta-islt/sync-sheets', [AdminController::class, 'syncIsltGoogleSheets'])->name('islt.sync-sheets');

    // 4. Manajemen Berita News & Kegiatan
    Route::get('/berita', [AdminController::class, 'postsIndex'])->name('posts.index');
    Route::get('/berita/tambah', [AdminController::class, 'createPost'])->name('posts.create');
    Route::post('/berita/tambah', [AdminController::class, 'storePost'])->name('posts.store');
    Route::delete('/berita/{id}', [AdminController::class, 'deletePost'])->name('posts.delete');

    // 5. Manajemen Kategori & Sub-Kategori
    Route::get('/kategori', [AdminController::class, 'categoriesIndex'])->name('categories.index');
    Route::post('/kategori/sub-kategori', [AdminController::class, 'storeSubCategory'])->name('categories.store-sub');

    // 6. Manajemen E-Jurnal
    Route::get('/e-jurnal', [AdminController::class, 'eJournalsIndex'])->name('ejournal.index');
    Route::post('/e-jurnal', [AdminController::class, 'storeEJournal'])->name('ejournal.store');
    Route::delete('/e-jurnal/{id}', [AdminController::class, 'deleteEJournal'])->name('ejournal.delete');

    // 7. Pengelolaan Program & Halaman Tentang
    Route::get('/kelola-program', [AdminController::class, 'programsIndex'])->name('programs.index');
    Route::put('/kelola-program/{id}', [AdminController::class, 'updateProgram'])->name('programs.update');
    Route::get('/kelola-tentang', [AdminController::class, 'aboutIndex'])->name('about.index');
    Route::put('/kelola-tentang/{id}', [AdminController::class, 'updateAbout'])->name('about.update');
});
