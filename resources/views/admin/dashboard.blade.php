@extends('layouts.admin')

@section('title', 'Dashboard Redaksi')
@section('page_title', 'Dashboard Redaksi & Manajemen Hatta Aksara')

@section('content')

<!-- Metric Cards Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <!-- ISLT Applicants -->
    <div class="card" style="margin-bottom: 0; border-top: 4px solid #0284c7;">
        <div class="card-body" style="padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Pendaftar ISLT</span>
                <i class="fa-solid fa-graduation-cap" style="color: #0284c7; font-size: 1.2rem;"></i>
            </div>
            <div style="font-size: 2rem; font-weight: 800; color: #0f172a; margin: 8px 0 4px;">{{ $totalIsltApplicants }}</div>
            <a href="{{ route('admin.islt.index') }}" style="font-size: 0.78rem; color: #0284c7; font-weight: 600;">Lihat & Ekspor Data &rarr;</a>
        </div>
    </div>

    <!-- Pending Alumni -->
    <div class="card" style="margin-bottom: 0; border-top: 4px solid #f59e0b;">
        <div class="card-body" style="padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.78rem; font-weight: 700; color: #92400e; text-transform: uppercase;">Verifikasi Alumni</span>
                <i class="fa-solid fa-user-clock" style="color: #f59e0b; font-size: 1.2rem;"></i>
            </div>
            <div style="font-size: 2rem; font-weight: 800; color: #b45309; margin: 8px 0 4px;">{{ $pendingAlumniCount }}</div>
            <a href="{{ route('admin.verify-alumni.index') }}" style="font-size: 0.78rem; color: #b45309; font-weight: 600;">Tinjau Pendaftar &rarr;</a>
        </div>
    </div>

    <!-- Pending Posts -->
    <div class="card" style="margin-bottom: 0; border-top: 4px solid #ef4444;">
        <div class="card-body" style="padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.78rem; font-weight: 700; color: #991b1b; text-transform: uppercase;">Tulisan Menunggu</span>
                <i class="fa-solid fa-newspaper" style="color: #ef4444; font-size: 1.2rem;"></i>
            </div>
            <div style="font-size: 2rem; font-weight: 800; color: #dc2626; margin: 8px 0 4px;">{{ $pendingPostsCount }}</div>
            <a href="{{ route('admin.review-posts.index') }}" style="font-size: 0.78rem; color: #dc2626; font-weight: 600;">Kurasi & Review &rarr;</a>
        </div>
    </div>

    <!-- Published Posts -->
    <div class="card" style="margin-bottom: 0; border-top: 4px solid #10b981;">
        <div class="card-body" style="padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.78rem; font-weight: 700; color: #065f46; text-transform: uppercase;">Publikasi Aktif</span>
                <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 1.2rem;"></i>
            </div>
            <div style="font-size: 2rem; font-weight: 800; color: #059669; margin: 8px 0 4px;">{{ $totalPublishedPosts }}</div>
            <a href="{{ route('admin.posts.index') }}" style="font-size: 0.78rem; color: #059669; font-weight: 600;">Kelola Berita &rarr;</a>
        </div>
    </div>
</div>

<!-- Two Columns: Pending Posts & Pending Alumni -->
<div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 24px; margin-bottom: 30px;">
    
    <!-- 1. Naskah Perlu Ditinjau -->
    <div class="card" style="margin-bottom: 0;">
        <div class="card-header">
            <h3 class="card-title"><i class="fa-solid fa-pen-nib" style="color:var(--maroon-primary); margin-right:8px;"></i> Naskah Masuk Perlu Kurasi</h3>
            <a href="{{ route('admin.review-posts.index') }}" style="font-size: 0.8rem; color: var(--maroon-primary); font-weight: 600;">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul & Tipe</th>
                        <th>Penulis</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingPosts as $post)
                        <tr>
                            <td>
                                <strong style="color: #0f172a; display: block;">{{ $post->title }}</strong>
                                <span style="font-size: 0.75rem; color: #64748b;">
                                    {{ $post->post_type === 'aksi_hatta_muda' ? 'Aksi Hatta Muda' : 'Artikel Gagasan' }}
                                </span>
                            </td>
                            <td>{{ $post->author?->name }}</td>
                            <td style="text-align: right;">
                                <a href="{{ route('admin.review-posts.detail', $post->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-magnifying-glass"></i> Tinjau
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 25px; color: #64748b;">
                                Tidak ada naskah yang menunggu moderasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Alumni Perlu Verifikasi -->
    <div class="card" style="margin-bottom: 0;">
        <div class="card-header">
            <h3 class="card-title"><i class="fa-solid fa-user-check" style="color:#f59e0b; margin-right:8px;"></i> Registrasi Alumni Baru</h3>
            <a href="{{ route('admin.verify-alumni.index') }}" style="font-size: 0.8rem; color: #b45309; font-weight: 600;">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama & Angkatan</th>
                        <th>Asal Sekolah</th>
                        <th style="text-align: right;">Keputusan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingAlumni as $alm)
                        <tr>
                            <td>
                                <strong style="color: #0f172a; display: block;">{{ $alm->name }}</strong>
                                <span style="font-size: 0.75rem; color: #b45309; font-weight: 600;">
                                    {{ $alm->alumniProfile?->islt_batch }}
                                </span>
                            </td>
                            <td style="font-size: 0.82rem;">{{ $alm->alumniProfile?->school_origin }}</td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                    <form action="{{ route('admin.verify-alumni.approve', $alm->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Setujui Akun">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.verify-alumni.reject', $alm->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menolak dan menghapus akun ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Tolak & Hapus">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 25px; color: #64748b;">
                                Tidak ada pendaftar alumni baru yang pending.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 3. Pendaftar ISLT Terkini & Quick Sync -->
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title"><i class="fa-solid fa-graduation-cap" style="color:#0284c7; margin-right:8px;"></i> Pendaftar Seleksi ISLT Terkini</h3>
            <span style="font-size: 0.78rem; color: #64748b;">Daftar ketua OSIS yang telah mengirimkan formulir publik</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.islt.export-xlsx') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-file-excel" style="color: #10b981;"></i> Ekspor XLSX
            </a>
            <a href="{{ route('admin.islt.export-pdf') }}" target="_blank" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-file-pdf" style="color: #ef4444;"></i> Ekspor PDF
            </a>
            <form action="{{ route('admin.islt.sync-sheets') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-arrows-rotate"></i> Sinkron Google Sheets
                </button>
            </form>
        </div>
    </div>
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Calon Peserta</th>
                    <th>Sekolah & OSIS</th>
                    <th>Wilayah</th>
                    <th>Kontak</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentApplicants as $app)
                    <tr>
                        <td><code style="background:#f1f5f9; padding:2px 6px; border-radius:4px; font-weight:700;">{{ $app->registration_code }}</code></td>
                        <td><strong style="color: #0f172a;">{{ $app->full_name }}</strong></td>
                        <td>{{ $app->school_name }} ({{ $app->osis_position }})</td>
                        <td>{{ $app->province }}</td>
                        <td>{{ $app->whatsapp_number }}</td>
                        <td>
                            <span style="background: #e0f2fe; color: #0369a1; font-size: 0.74rem; font-weight: 700; padding: 3px 8px; border-radius: 10px; text-transform: uppercase;">
                                {{ $app->selection_status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
