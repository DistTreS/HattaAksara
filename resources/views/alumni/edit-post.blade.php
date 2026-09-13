@extends('layouts.alumni')

@section('title', 'Perbarui Naskah Tulisan')
@section('page_title', 'Perbarui Naskah Tulisan')

@section('content')

<div style="background: white; border-radius: 16px; border: 1px solid var(--border-color); padding: 36px; max-width: 900px;">
    
    <!-- Revision Callout Banner -->
    @if($post->status === 'revision_required')
        <div style="background: #fef2f2; border: 2px solid #f87171; border-radius: 12px; padding: 22px; margin-bottom: 30px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                <i class="fa-solid fa-triangle-exclamation" style="color:#dc2626; font-size:1.2rem;"></i>
                <h3 style="font-size: 1.05rem; font-weight: 700; color: #991b1b; margin:0;">
                    Catatan Perbaikan dari Tim Redaksi:
                </h3>
            </div>
            <div style="font-size: 0.95rem; color: #7f1d1d; background: white; padding: 14px 18px; border-radius: 8px; border: 1px solid #fecaca; line-height: 1.6;">
                {{ $post->admin_notes ?? 'Harap tinjau kembali kelengkapan naskah dan sumber rujukan.' }}
            </div>
            <p style="font-size: 0.82rem; color: #991b1b; margin-top: 10px;">
                Silakan lakukan revisi naskah pada formulir di bawah ini, lalu klik tombol <strong>"Kirim Ulang Naskah Revisi"</strong>.
            </p>
        </div>
    @endif

    <div style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h2 style="font-family: var(--font-display); font-size: 1.35rem; color: #0f172a; margin-bottom: 4px;">
                Mengedit {{ $post->post_type === 'aksi_hatta_muda' ? 'Berita Aksi Hatta Muda' : 'Artikel Gagasan' }}
            </h2>
            <span style="font-size: 0.82rem; color: #64748b;">
                Status Saat Ini: <strong>{{ strtoupper(str_replace('_', ' ', $post->status)) }}</strong>
            </span>
        </div>
        <a href="{{ route('alumni.my-posts') }}" class="btn btn-outline btn-sm">
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

    <form action="{{ route('alumni.update-post', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Judul Naskah <span style="color:#ef4444;">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required class="form-control" style="width:100%; padding:12px 16px; border-radius:8px; border:1px solid #cbd5e1; font-size:1rem;">
        </div>

        @if($post->post_type === 'aksi_hatta_muda')
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                        Lokasi Aksi <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="action_location" value="{{ old('action_location', $post->action_location) }}" required class="form-control" style="width:100%; padding:11px 16px; border-radius:8px; border:1px solid #cbd5e1;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                        Tanggal Aksi
                    </label>
                    <input type="date" name="action_date" value="{{ old('action_date', $post->action_date?->format('Y-m-d')) }}" class="form-control" style="width:100%; padding:11px 16px; border-radius:8px; border:1px solid #cbd5e1;">
                </div>
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Sub-Kategori
                </label>
                <select name="sub_category_id" class="form-control" style="width:100%; padding:11px 16px; border-radius:8px; border:1px solid #cbd5e1;">
                    <option value="">-- Pilih Topik --</option>
                    @foreach($subCategories as $sub)
                        <option value="{{ $sub->id }}" {{ old('sub_category_id', $post->sub_category_id) == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Ganti Foto Sampul (Opsional)
                </label>
                <input type="file" name="featured_image" accept="image/*" class="form-control" style="width:100%; padding:9px 14px; border-radius:8px; border:1px solid #cbd5e1;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Ringkasan / Sinopsis Singkat
            </label>
            <textarea name="excerpt" rows="2" class="form-control" style="width:100%; padding:11px 16px; border-radius:8px; border:1px solid #cbd5e1; font-family:var(--font-sans);">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Isi Naskah Tulisan <span style="color:#ef4444;">*</span>
            </label>
            <textarea name="content" rows="14" required class="form-control" style="width:100%; padding:14px 16px; border-radius:8px; border:1px solid #cbd5e1; font-family:var(--font-sans); line-height:1.8;">{{ old('content', $post->content) }}</textarea>
        </div>

        <div style="display: flex; gap: 14px; justify-content: flex-end; border-top: 1px solid var(--border-color); padding-top: 20px;">
            <button type="submit" name="action_button" value="draft" class="btn btn-outline">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Draf Saja
            </button>
            <button type="submit" name="action_button" value="submit" class="btn btn-primary">
                <i class="fa-solid fa-paper-plane"></i>
                {{ $post->status === 'revision_required' ? 'Kirim Ulang Naskah Revisi' : 'Ajukan untuk Ditinjau Redaksi' }}
            </button>
        </div>
    </form>
</div>

@endsection
