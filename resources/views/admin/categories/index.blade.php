@extends('layouts.admin')

@section('title', 'Manajemen Kategori')
@section('page_title', 'Manajemen Kategori & Sub-Kategori')

@section('content')

<div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 24px;">
    <!-- Kategori List -->
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-tags" style="color:var(--maroon-primary); margin-right:6px;"></i> Struktur Kategori & Sub-Kategori</h3>
            </div>
            <div class="card-body">
                @foreach($categories as $cat)
                    <div style="background: #f8fafc; border-radius: 12px; padding: 18px; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <div>
                                <strong style="font-size: 1.05rem; color: #0f172a;">{{ $cat->name }}</strong>
                                <span style="font-size: 0.74rem; background: #e2e8f0; color: #475569; padding: 2px 8px; border-radius: 6px; font-weight: 700; text-transform: uppercase; margin-left: 8px;">
                                    Tipe: {{ $cat->type }}
                                </span>
                            </div>
                        </div>
                        <p style="font-size: 0.84rem; color: #64748b; margin-bottom: 12px;">{{ $cat->description }}</p>

                        <div style="font-size: 0.82rem; font-weight: 700; color: #475569; margin-bottom: 6px;">Sub-Kategori Tematik:</div>
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            @forelse($cat->subCategories as $sub)
                                <span style="background: white; border: 1px solid #cbd5e1; padding: 4px 10px; border-radius: 8px; font-size: 0.8rem; color: #1e293b;">
                                    {{ $sub->name }}
                                </span>
                            @empty
                                <span style="font-size: 0.78rem; color: #94a3b8; font-style: italic;">Belum ada sub-kategori khusus.</span>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Tambah Sub-Kategori Baru -->
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-plus-circle" style="color:var(--gold-dark); margin-right:6px;"></i> Tambah Sub-Kategori Baru</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store-sub') }}" method="POST">
                    @csrf

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                            Pilih Kategori Induk <span style="color:#ef4444;">*</span>
                        </label>
                        <select name="category_id" class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }} ({{ ucfirst($cat->type) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                            Nama Sub-Kategori <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" name="name" required class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;" placeholder="Contoh: Ekonomi Kerakyatan, Politik, Agama, Budaya">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                            Deskripsi Singkat
                        </label>
                        <textarea name="description" rows="3" class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;" placeholder="Penjelasan singkat ruang lingkup topik..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-plus"></i> Simpan Sub-Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
