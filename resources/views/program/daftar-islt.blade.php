@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Peserta ISLT')

@push('styles')
<style>
    .form-hero {
        background: radial-gradient(circle at top right, #240C4C 0%, #0C0022 100%);
        color: white;
        padding: 50px 0;
        border-bottom: 1px solid rgba(115, 0, 255, 0.25);
        text-align: center;
    }
    .form-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 45px;
        box-shadow: var(--shadow-elevated);
        border: 1px solid var(--border-subtle);
        margin-top: -30px;
        position: relative;
        z-index: 5;
    }
    .form-section-title {
        font-family: var(--font-display);
        font-size: 1.25rem;
        color: var(--maroon-primary);
        margin: 25px 0 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--slate-800);
        margin-bottom: 8px;
    }
    .form-label span.req {
        color: #ef4444;
    }
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border-radius: 8px;
        border: 1px solid var(--border-subtle);
        font-size: 0.92rem;
        font-family: var(--font-sans);
        transition: border-color 0.2s;
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
        .form-card {
            padding: 24px;
        }
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<header class="form-hero">
    <div class="container" style="max-width: 800px;">
        <span class="section-tag" style="background:rgba(197, 155, 39, 0.2); color:var(--gold-light); border-color:var(--gold-primary);">
            Pendaftaran Terbuka &bull; Tanpa Biaya
        </span>
        <h1 style="font-family: var(--font-display); font-size: 2.4rem; margin: 12px 0;">
            Formulir Calon Peserta ISLT 2026
        </h1>
        <p style="color: #d1d5db; font-size: 0.95rem;">
            Isi data diri lengkap Anda di bawah ini tanpa perlu membuat akun. Data akan diverifikasi secara langsung oleh Tim Seleksi Hatta Aksara Project.
        </p>
    </div>
</header>

<div class="container" style="max-width: 850px; margin-bottom: 90px;">
    <div class="form-card">
        @if ($errors->any())
            <div class="alert alert-error" style="margin-bottom: 25px;">
                <div>
                    <strong>Mohon periksa kembali formulir Anda:</strong>
                    <ul style="margin-top: 6px; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('program.islt.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. DATA PRIBADI -->
            <div class="form-section-title">
                <i class="fa-solid fa-user-circle"></i> 1. Identitas Pribadi Calon Peserta
            </div>

            <div class="form-group">
                <label class="form-label">Nama Lengkap Siswa <span class="req">*</span></label>
                <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" placeholder="Contoh: Muhammad Rifqi Al-Ghifari" required>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">NISN (Nomor Induk Siswa Nasional)</label>
                    <input type="text" name="nisn" class="form-control" value="{{ old('nisn') }}" placeholder="10 Digit NISN">
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Kelamin <span class="req">*</span></label>
                    <select name="gender" class="form-control" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Tempat Lahir <span class="req">*</span></label>
                    <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place') }}" placeholder="Contoh: Padang" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Lahir <span class="req">*</span></label>
                    <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}" required>
                </div>
            </div>

            <!-- 2. KONTAK & DOMISILI -->
            <div class="form-section-title">
                <i class="fa-solid fa-address-book"></i> 2. Informasi Kontak & Wilayah
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp Aktif <span class="req">*</span></label>
                    <input type="tel" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number') }}" placeholder="Contoh: 081234567890" required>
                    <small style="color: #64748b; font-size: 0.78rem;">Digunakan untuk pengumuman kelulusan berkas.</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Email Aktif <span class="req">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email.anda@gmail.com" required>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Asal Provinsi <span class="req">*</span></label>
                    <input type="text" name="province" class="form-control" value="{{ old('province') }}" placeholder="Contoh: Sumatera Barat" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Kota / Kabupaten <span class="req">*</span></label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="Contoh: Kota Bukittinggi" required>
                </div>
            </div>

            <!-- 3. INFORMASI SEKOLAH & OSIS -->
            <div class="form-section-title">
                <i class="fa-solid fa-school"></i> 3. Sekolah & Kepemimpinan OSIS
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Nama Asal Sekolah (SMA/SMK/MA) <span class="req">*</span></label>
                    <input type="text" name="school_name" class="form-control" value="{{ old('school_name') }}" placeholder="Contoh: SMAN 1 Bukittinggi" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jabatan di OSIS Saat Ini <span class="req">*</span></label>
                    <input type="text" name="osis_position" class="form-control" value="{{ old('osis_position') }}" placeholder="Contoh: Ketua OSIS / Wakil Ketua" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Riwayat Pengalaman Organisasi & Prestasi <span class="req">*</span></label>
                <textarea name="organization_experience" class="form-control" rows="4" placeholder="Tuliskan pengalaman organisasi, kepanitiaan, atau prestasi yang pernah Anda raih..." required>{{ old('organization_experience') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Esai Singkat Motivasi <span class="req">*</span></label>
                <textarea name="motivation_essay" class="form-control" rows="5" placeholder="Mengapa Anda tertarik mengikuti pelatihan kepemimpinan ISLT dan bagaimana Anda berencana mengamalkan nilai ekonomi koperasi serta integritas Bung Hatta di sekolah Anda?" required>{{ old('motivation_essay') }}</textarea>
            </div>

            <!-- 4. BERKAS PENDUKUNG -->
            <div class="form-section-title">
                <i class="fa-solid fa-file-arrow-up"></i> 4. Berkas Pendukung (Opsional)
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Pas Foto Siswa (JPG/PNG, Max 3MB)</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label class="form-label">Surat Rekomendasi / Kartu Pelajar (PDF/JPG, Max 5MB)</label>
                    <input type="file" name="recommendation_letter" class="form-control" accept=".pdf,image/*">
                </div>
            </div>

            <div style="background: #f8fafc; border-radius: 12px; padding: 20px; margin: 30px 0; border: 1px solid #e2e8f0;">
                <label style="display: flex; gap: 12px; align-items: flex-start; cursor: pointer;">
                    <input type="checkbox" required style="margin-top: 4px; width: 18px; height: 18px;">
                    <span style="font-size: 0.88rem; color: #475569; line-height: 1.5;">
                        Saya menyatakan dengan penuh kejujuran dan tanggung jawab bahwa seluruh data yang diisikan dalam formulir pendaftaran ini adalah benar, sah, dan sesuai dengan keadaan sebenarnya.
                    </span>
                </label>
            </div>

            <div style="text-align: center;">
                <button type="submit" class="btn btn-primary" style="font-size: 1.05rem; padding: 14px 45px; border-radius: 30px;">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Formulir Pendaftaran
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
