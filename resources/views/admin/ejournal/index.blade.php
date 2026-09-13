@extends('layouts.admin')

@section('title', 'Manajemen E-Jurnal')
@section('page_title', 'Kelola E-Jurnal & Perpustakaan Digital')

@section('content')

<div style="display: grid; grid-template-columns: 1.3fr 0.7fr; gap: 24px;">
    <!-- E-Journal List -->
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-book-bookmark" style="color:var(--gold-dark); margin-right:6px;"></i> Arsip Dokumen Digital</h3>
            </div>
            <div class="card-body" style="padding: 0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Judul & Penulis</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th>Diunduh</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eJournals as $doc)
                            <tr>
                                <td>
                                    <strong style="color: #0f172a; display: block;">{{ $doc->title }}</strong>
                                    <span style="font-size: 0.78rem; color: #64748b;">{{ $doc->author_or_curator }}</span>
                                </td>
                                <td>
                                    <span style="font-size: 0.74rem; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; font-weight: 600;">
                                        {{ $doc->category }}
                                    </span>
                                </td>
                                <td>{{ $doc->publication_year }}</td>
                                <td><i class="fa-solid fa-download"></i> {{ $doc->download_count }}</td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.ejournal.delete', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini dari perpustakaan digital?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Dokumen">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px; color: #64748b;">
                                    Belum ada dokumen yang diunggah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div style="margin-top: 20px;">
            {{ $eJournals->links() }}
        </div>
    </div>

    <!-- Upload Form -->
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-upload" style="color:var(--maroon-primary); margin-right:6px;"></i> Unggah Dokumen Baru</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-error" style="margin-bottom: 16px;">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.ejournal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                            Judul Dokumen / Jurnal <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;" placeholder="Contoh: Modul Kurikulum ISLT 2026">
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                            Penyusun / Penulis <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" name="author_or_curator" value="{{ old('author_or_curator', 'Yayasan Proklamator Bung Hatta') }}" required class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                        <div>
                            <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                                Tahun Terbit <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="number" name="publication_year" value="{{ old('publication_year', date('Y')) }}" required class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                                Kategori <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="text" name="category" value="{{ old('category') }}" required class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;" placeholder="Contoh: Kurikulum ISLT">
                        </div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                            Deskripsi Singkat Dokumen
                        </label>
                        <textarea name="description" rows="3" class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;">{{ old('description') }}</textarea>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                            Berkas File Dokumen (PDF, Max 20MB) <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="file" name="document_file" required accept=".pdf,.docx" class="form-control" style="width:100%; padding:8px 12px; border:1px solid #cbd5e1; border-radius:6px;">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Unggah Dokumen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
