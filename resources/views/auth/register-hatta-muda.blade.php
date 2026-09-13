@extends('layouts.app')

@section('title', 'Bergabung Menjadi Hatta Muda')

@push('styles')
<style>
    .reg-hero {
        background: radial-gradient(circle at top right, #240C4C 0%, #0C0022 100%);
        color: white;
        padding: 55px 0;
        border-bottom: 1px solid rgba(115, 0, 255, 0.25);
        text-align: center;
    }
    .form-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 40px;
        box-shadow: var(--shadow-elevated);
        border: 1px solid var(--border-subtle);
        margin-top: -30px;
        position: relative;
        z-index: 5;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--slate-800);
        margin-bottom: 6px;
    }
    .form-control {
        width: 100%;
        padding: 11px 16px;
        border-radius: 8px;
        border: 1px solid var(--border-subtle);
        font-size: 0.92rem;
        background-color: #fafbfc;
    }
    .form-control:focus {
        border-color: var(--maroon-primary);
        background-color: white;
        outline: none;
    }
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 768px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<header class="reg-hero">
    <div class="container" style="max-width: 800px;">
        <span class="section-tag" style="background:rgba(197, 155, 39, 0.2); color:var(--gold-light); border-color:var(--gold-primary);">
            Portal Alumni ISLT
        </span>
        <h1 style="font-family: var(--font-display); font-size: 2.3rem; margin: 12px 0;">
            Bergabung Menjadi Hatta Muda
        </h1>
        <p style="color: #d1d5db; font-size: 0.95rem;">
            Khusus alumni pelatihan Indonesian Students Leadership Training (ISLT). Akun Anda akan ditinjau oleh Admin sebelum diaktifkan untuk menerbitkan naskah dan mengakses direktori jejaring.
        </p>
    </div>
</header>

<div class="container" style="max-width: 850px; margin-bottom: 90px;">
    <div class="form-card">
        @if ($errors->any())
            <div class="alert alert-error" style="margin-bottom: 25px;">
                <div>
                    <strong>Pendaftaran belum dapat diproses:</strong>
                    <ul style="margin-top: 6px; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('register.hatta-muda.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h3 style="font-family: var(--font-display); font-size: 1.2rem; color: var(--maroon-primary); margin-bottom: 18px; padding-bottom: 8px; border-bottom: 2px solid #f1f5f9;">
                1. Kredensial Akun
            </h3>

            <div class="form-group">
                <label class="form-label">Nama Lengkap Alumni <span style="color:#ef4444;">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama Lengkap Beserta Gelar jika ada" required>
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Email <span style="color:#ef4444;">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email.alumni@domain.com" required>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Kata Sandi <span style="color:#ef4444;">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Kata Sandi <span style="color:#ef4444;">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required>
                </div>
            </div>

            <h3 style="font-family: var(--font-display); font-size: 1.2rem; color: var(--maroon-primary); margin: 30px 0 18px; padding-bottom: 8px; border-bottom: 2px solid #f1f5f9;">
                2. Data Kepesertaan ISLT & Daerah
            </h3>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Angkatan / Tahun Pelatihan ISLT <span style="color:#ef4444;">*</span></label>
                    <select name="islt_batch" class="form-control" required>
                        <option value="">-- Pilih Angkatan ISLT --</option>
                        <option value="Angkatan I (2024)" {{ old('islt_batch') === 'Angkatan I (2024)' ? 'selected' : '' }}>Angkatan I (2024)</option>
                        <option value="Angkatan II (2025)" {{ old('islt_batch') === 'Angkatan II (2025)' ? 'selected' : '' }}>Angkatan II (2025)</option>
                        <option value="Angkatan III (2026)" {{ old('islt_batch') === 'Angkatan III (2026)' ? 'selected' : '' }}>Angkatan III (2026)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Asal Sekolah saat Menjadi Ketua OSIS <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="school_origin" class="form-control" value="{{ old('school_origin') }}" placeholder="Contoh: SMAN 1 Bukittinggi" required>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Asal Provinsi <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="province" class="form-control" value="{{ old('province') }}" placeholder="Contoh: Sumatera Barat" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Kota / Kabupaten Domisili <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="Contoh: Bukittinggi" required>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Institusi / Kampus / Pekerjaan Saat Ini</label>
                    <input type="text" name="current_institution" class="form-control" value="{{ old('current_institution') }}" placeholder="Contoh: Universitas Indonesia - Ilmu Ekonomi">
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp Aktif <span style="color:#ef4444;">*</span></label>
                    <input type="tel" name="phone_number" class="form-control" value="{{ old('phone_number') }}" placeholder="Contoh: 081234567890" required>
                </div>
            </div>

            <div class="form-group">
                <label style="display: flex; gap: 8px; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="is_phone_public" value="1" {{ old('is_phone_public') ? 'checked' : '' }}>
                    <span style="font-size: 0.85rem; color: #475569;">Izinkan sesama alumni terverifikasi melihat nomor WhatsApp saya di Direktori Jejaring</span>
                </label>
            </div>

            <div class="form-group">
                <label class="form-label">Bio Singkat / Minat & Aktivitas Saat Ini</label>
                <textarea name="bio" class="form-control" rows="3" placeholder="Ceritakan singkat fokus studi atau kegiatan sosial yang sedang Anda geluti saat ini...">{{ old('bio') }}</textarea>
            </div>

            <h3 style="font-family: var(--font-display); font-size: 1.2rem; color: var(--maroon-primary); margin: 30px 0 18px; padding-bottom: 8px; border-bottom: 2px solid #f1f5f9;">
                3. Verifikasi & Media Sosial
            </h3>

            <div class="form-group">
                <label class="form-label">Unggah Bukti Sertifikat / Surat ISLT (PDF/JPG/PNG, Max 5MB)</label>
                <input type="file" name="proof_document" class="form-control" accept=".pdf,image/*">
                <small style="color:#64748b; font-size:0.78rem;">Mempercepat proses verifikasi oleh tim redaksi.</small>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Tautan Profil LinkedIn</label>
                    <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url') }}" placeholder="https://linkedin.com/in/username">
                </div>
                <div class="form-group">
                    <label class="form-label">Akun Instagram</label>
                    <input type="text" name="instagram_url" class="form-control" value="{{ old('instagram_url') }}" placeholder="@username">
                </div>
            </div>

            <div style="text-align: center; margin-top: 36px;">
                <button type="submit" class="btn btn-gold" style="font-size: 1rem; padding: 13px 40px; border-radius: 30px;">
                    <i class="fa-solid fa-paper-plane"></i> Daftarkan Akun Alumni Hatta Muda
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
