@extends('layouts.admin')

@section('title', 'Kelola Program')
@section('page_title', 'Kelola Konten Program (ISLT & Media Edukasi)')

@section('content')

<div style="margin-bottom: 24px;">
    <h2 style="font-family: var(--font-display); font-size: 1.4rem; color: #0f172a; margin-bottom: 4px;">
        Manajemen Informasi Program
    </h2>
    <p style="color: #64748b; font-size: 0.9rem;">
        Perbarui judul, deskripsi, serta status pendaftaran untuk program yang ditampilkan pada menu publik.
    </p>
</div>

<div style="display: flex; flex-direction: column; gap: 30px;">
    @foreach($programs as $prog)
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">{{ $prog->title }}</h3>
                    <span style="font-size: 0.78rem; color: #64748b;">Slug: <code>{{ $prog->slug }}</code></span>
                </div>
                <div>
                    @if($prog->is_registration_open)
                        <span style="background: #ecfdf5; color: #065f46; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Pendaftaran Dibuka</span>
                    @else
                        <span style="background: #f1f5f9; color: #64748b; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Pendaftaran Ditutup</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.programs.update', $prog->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">Judul Program</label>
                        <input type="text" name="title" value="{{ old('title', $prog->title) }}" required class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;">
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">Tagline Singkat</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $prog->tagline) }}" class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;">
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">Deskripsi Lengkap Program</label>
                        <textarea name="description" rows="5" required class="form-control" style="width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-family:var(--font-sans); line-height:1.6;">{{ old('description', $prog->description) }}</textarea>
                    </div>

                    @if($prog->slug === 'islt')
                        <div style="margin-bottom: 20px;">
                            <label style="display: flex; gap: 8px; align-items: center; cursor: pointer;">
                                <input type="checkbox" name="is_registration_open" value="1" {{ $prog->is_registration_open ? 'checked' : '' }} style="width:18px; height:18px;">
                                <span style="font-size: 0.88rem; font-weight: 600; color: #1e293b;">Buka Formulir Pendaftaran Publik Calon Peserta</span>
                            </label>
                        </div>
                    @endif

                    <div style="text-align: right;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Program
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>

@endsection
