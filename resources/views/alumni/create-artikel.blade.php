@extends('layouts.alumni')

@section('title', 'Tulis Artikel Gagasan')
@section('page_title', 'Tulis Artikel Gagasan & Refleksi')

@section('content')

<div style="background: white; border-radius: 16px; border: 1px solid var(--border-color); padding: 36px; max-width: 900px;">
    <div style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
        <h2 style="font-family: var(--font-display); font-size: 1.4rem; color: #0f172a; margin-bottom: 6px;">
            Suarakan Pemikiran & Gagasan Intelektual Anda
        </h2>
        <p style="color: #64748b; font-size: 0.9rem;">
            Tulis esai, opini, atau analisis kritis mengenai nilai kebangsaan, ekonomi koperasi, kebudayaan, atau kepemimpinan pemuda.
        </p>
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

    <form action="{{ route('alumni.store-artikel') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Judul Artikel Gagasan <span style="color:#ef4444;">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title') }}" required class="form-control" style="width:100%; padding:12px 16px; border-radius:8px; border:1px solid #cbd5e1; font-size:1rem;" placeholder="Contoh: Relevansi Koperasi Bung Hatta di Era Ekonomi Platform">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Bidang Sub-Kategori Tematik
                </label>
                <select name="sub_category_id" class="form-control" style="width:100%; padding:11px 16px; border-radius:8px; border:1px solid #cbd5e1;">
                    <option value="">-- Pilih Bidang Topik --</option>
                    @foreach($subCategories as $sub)
                        <option value="{{ $sub->id }}" {{ old('sub_category_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Gambar Ilustrasi / Sampul (Opsional)
                </label>
                <input type="file" name="featured_image" accept="image/*" class="form-control" style="width:100%; padding:9px 14px; border-radius:8px; border:1px solid #cbd5e1;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Intisari / Tesis Utama Gagasan (1-2 Paragraf Ringkas)
            </label>
            <textarea name="excerpt" rows="2" class="form-control" style="width:100%; padding:11px 16px; border-radius:8px; border:1px solid #cbd5e1; font-family:var(--font-sans);" placeholder="Apa inti pemikiran atau argumen utama yang ingin Anda sampaikan?">{{ old('excerpt') }}</textarea>
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Isi Lengkap Naskah Esai / Artikel <span style="color:#ef4444;">*</span>
            </label>
            <textarea name="content" rows="14" required class="form-control" style="width:100%; padding:14px 16px; border-radius:8px; border:1px solid #cbd5e1; font-family:var(--font-sans); line-height:1.8;" placeholder="Tuangkan pemikiran Anda secara runut: pengantar masalah, landasan nilai pahlawan/koperasi/kebangsaan, analisis kondisi generasi muda saat ini, serta kesimpulan gagasan solusi...">{{ old('content') }}</textarea>
        </div>

        <div style="display: flex; gap: 14px; justify-content: flex-end; border-top: 1px solid var(--border-color); padding-top: 20px;">
            <button type="submit" name="action_button" value="draft" class="btn btn-outline">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Draf
            </button>
            <button type="submit" name="action_button" value="submit" class="btn btn-primary">
                <i class="fa-solid fa-paper-plane"></i> Ajukan untuk Ditinjau Redaksi
            </button>
        </div>
    </form>
</div>

@endsection
