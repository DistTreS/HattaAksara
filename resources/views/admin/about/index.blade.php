@extends('layouts.admin')

@section('title', 'Kelola Halaman Tentang')
@section('page_title', 'Kelola Profil & Nilai Halaman Tentang')

@section('content')

<div style="margin-bottom: 24px;">
    <h2 style="font-family: var(--font-display); font-size: 1.4rem; color: #0f172a; margin-bottom: 4px;">
        Profil Yayasan, Sejarah Bung Hatta & Visi Misi
    </h2>
    <p style="color: #64748b; font-size: 0.9rem;">
        Perbarui narasi sejarah, visi, misi, dan nilai-nilai luhur yang tampil pada menu profil publik.
    </p>
</div>

<div style="display: flex; flex-direction: column; gap: 24px;">
    @foreach($sections as $sec)
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">{{ $sec->title }}</h3>
                    <span style="font-size: 0.76rem; color: #64748b;">Key: <code>{{ $sec->section_key }}</code></span>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.about.update', $sec->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">Judul Bagian</label>
                        <input type="text" name="title" value="{{ old('title', $sec->title) }}" required class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;">
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">Konten Narasi</label>
                        <textarea name="content" rows="6" required class="form-control" style="width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-family:var(--font-sans); line-height:1.7;">{{ old('content', $sec->content) }}</textarea>
                    </div>

                    <div style="text-align: right;">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Narasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>

@endsection
