@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')
@section('page_title', 'Tulis Berita Resmi / Kegiatan')

@section('content')

<div style="background: white; border-radius: 16px; border: 1px solid var(--border-color); padding: 36px; max-width: 900px;">
    
    <div style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h2 style="font-family: var(--font-display); font-size: 1.35rem; color: #0f172a; margin-bottom: 4px;">
                Tulis dan Terbitkan Berita Resmi
            </h2>
            <span style="font-size: 0.84rem; color: #64748b;">
                Berita yang ditulis oleh Admin akan langsung terbit secara publik.
            </span>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline btn-sm">
            &larr; Batal & Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-error" style="margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Judul Berita <span style="color:#ef4444;">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title') }}" required class="form-control" style="width:100%; padding:12px 16px; border-radius:8px; border:1px solid #cbd5e1; font-size:1rem;" placeholder="Contoh: Yayasan Proklamator Bung Hatta Menggelar Forum...">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Jenis Berita <span style="color:#ef4444;">*</span>
                </label>
                <select name="post_type" class="form-control" style="width:100%; padding:11px 16px; border-radius:8px; border:1px solid #cbd5e1;" required>
                    <option value="news" {{ old('post_type') === 'news' ? 'selected' : '' }}>News (Berita Resmi Organisasi)</option>
                    <option value="kegiatan" {{ old('post_type') === 'kegiatan' ? 'selected' : '' }}>Kegiatan (Liputan Acara & Forum)</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Sub-Kategori Tematik
                </label>
                <select name="sub_category_id" class="form-control" style="width:100%; padding:11px 16px; border-radius:8px; border:1px solid #cbd5e1;">
                    <option value="">-- Pilih Sub-Kategori --</option>
                    @foreach($subCategories as $sub)
                        <option value="{{ $sub->id }}" {{ old('sub_category_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Foto Sampul Berita (Opsional)
            </label>
            <input type="file" name="featured_image" accept="image/*" class="form-control" style="width:100%; padding:9px 14px; border-radius:8px; border:1px solid #cbd5e1;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Ringkasan Berita (Excerpt)
            </label>
            <textarea name="excerpt" rows="2" class="form-control" style="width:100%; padding:11px 16px; border-radius:8px; border:1px solid #cbd5e1; font-family:var(--font-sans);">{{ old('excerpt') }}</textarea>
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Isi Berita Lengkap <span style="color:#ef4444;">*</span>
            </label>
            <textarea name="content" rows="14" required class="form-control" style="width:100%; padding:14px 16px; border-radius:8px; border:1px solid #cbd5e1; font-family:var(--font-sans); line-height:1.8;" placeholder="Tuliskan isi berita di sini (dapat menggunakan tag paragraf <p> atau teks polos)...">{{ old('content') }}</textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; border-top: 1px solid var(--border-color); padding-top: 20px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">
                <i class="fa-solid fa-paper-plane"></i> Terbitkan Berita Sekarang
            </button>
        </div>
    </form>
</div>

@endsection
