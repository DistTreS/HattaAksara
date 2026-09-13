@extends('layouts.alumni')

@section('title', 'Profil Personal Alumni')
@section('page_title', 'Profil Saya & Pengaturan Privasi')

@section('content')

<div style="background: white; border-radius: 16px; border: 1px solid var(--border-color); padding: 36px; max-width: 800px;">
    
    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 30px; padding-bottom: 24px; border-bottom: 1px solid var(--border-color);">
        <div style="width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, var(--maroon-primary), var(--maroon-deep)); border: 3px solid var(--gold-primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 700;">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #0f172a; margin-bottom: 4px;">{{ $user->name }}</h2>
            <span style="font-size: 0.84rem; color: var(--gold-dark); font-weight: 700;">
                {{ $user->alumniProfile?->islt_batch }} &bull; {{ $user->alumniProfile?->school_origin }}
            </span>
            <div style="font-size: 0.78rem; color: #64748b; margin-top: 2px;">
                Status Akun: <span style="color:#10b981; font-weight:700;">Terverifikasi Aktif</span>
            </div>
        </div>
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

    <form action="{{ route('alumni.update-profile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Nama Lengkap
            </label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-control" style="width:100%; padding:11px 16px; border:1px solid #cbd5e1; border-radius:8px;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Alamat Email (Akun)
                </label>
                <input type="email" value="{{ $user->email }}" disabled class="form-control" style="width:100%; padding:11px 16px; border:1px solid #e2e8f0; border-radius:8px; background:#f8fafc; color:#64748b;">
            </div>

            <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Nomor WhatsApp / Telepon <span style="color:#ef4444;">*</span>
                </label>
                <input type="tel" name="phone_number" value="{{ old('phone_number', $user->alumniProfile?->phone_number) }}" required class="form-control" style="width:100%; padding:11px 16px; border:1px solid #cbd5e1; border-radius:8px;">
            </div>
        </div>

        <div style="background: #f8fafc; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; border: 1px solid #e2e8f0;">
            <label style="display: flex; gap: 10px; align-items: center; cursor: pointer;">
                <input type="checkbox" name="is_phone_public" value="1" {{ old('is_phone_public', $user->alumniProfile?->is_phone_public) ? 'checked' : '' }} style="width:18px; height:18px;">
                <span style="font-size: 0.88rem; color: #334155; font-weight: 600;">
                    Tampilkan nomor WhatsApp saya di Direktori Jejaring Alumni
                </span>
            </label>
            <span style="display: block; font-size: 0.78rem; color: #64748b; margin-left: 28px; margin-top: 2px;">
                Jika dinonaktifkan, rekan alumni hanya dapat menghubungi Anda melalui tautan LinkedIn atau Instagram.
            </span>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Institusi / Kampus / Pekerjaan Saat Ini
            </label>
            <input type="text" name="current_institution" value="{{ old('current_institution', $user->alumniProfile?->current_institution) }}" class="form-control" style="width:100%; padding:11px 16px; border:1px solid #cbd5e1; border-radius:8px;" placeholder="Contoh: Universitas Indonesia - Ilmu Ekonomi">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                Bio Singkat
            </label>
            <textarea name="bio" rows="3" class="form-control" style="width:100%; padding:11px 16px; border:1px solid #cbd5e1; border-radius:8px; font-family:var(--font-sans);">{{ old('bio', $user->alumniProfile?->bio) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Tautan LinkedIn
                </label>
                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->alumniProfile?->linkedin_url) }}" class="form-control" style="width:100%; padding:11px 16px; border:1px solid #cbd5e1; border-radius:8px;" placeholder="https://linkedin.com/in/username">
            </div>

            <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    Akun Instagram
                </label>
                <input type="text" name="instagram_url" value="{{ old('instagram_url', $user->alumniProfile?->instagram_url) }}" class="form-control" style="width:100%; padding:11px 16px; border:1px solid #cbd5e1; border-radius:8px;" placeholder="@username">
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 28px;">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Profil
            </button>
        </div>
    </form>
</div>

@endsection
