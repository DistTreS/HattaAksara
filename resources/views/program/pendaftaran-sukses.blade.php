@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil')

@section('content')

<div class="container" style="max-width: 720px; padding: 70px 20px 100px;">
    <div style="background: white; border-radius: 24px; padding: 45px; border: 2px solid var(--border-subtle); box-shadow: var(--shadow-elevated); text-align: center;">
        
        <div style="width: 80px; height: 80px; border-radius: 50%; background: #ecfdf5; border: 2px solid #10b981; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin: 0 auto 24px;">
            <i class="fa-solid fa-check"></i>
        </div>

        <span class="section-tag" style="background:#ecfdf5; color:#065f46; border-color:#10b981;">Pendaftaran Terkirim</span>

        <h1 style="font-family: var(--font-display); font-size: 2.2rem; color: var(--slate-900); margin: 14px 0 10px;">
            Selamat, Pendaftaran Anda Telah Diterima!
        </h1>
        <p style="color: var(--text-muted); font-size: 0.98rem; line-height: 1.6; margin-bottom: 30px;">
            Terima kasih telah mendaftar sebagai calon peserta <strong>Indonesian Students Leadership Training (ISLT)</strong>. Simpan bukti kode pendaftaran berikut sebagai referensi Anda.
        </p>

        <!-- Kode Registrasi Highlight Box -->
        <div style="background: #faf8f5; border: 2px dashed var(--gold-primary); border-radius: 16px; padding: 24px; margin-bottom: 32px;">
            <span style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.08em; display: block; margin-bottom: 6px;">
                Kode Registrasi Peserta Anda:
            </span>
            <div style="font-family: var(--font-display); font-size: 1.9rem; font-weight: 800; color: var(--maroon-primary); letter-spacing: 0.05em;">
                {{ $applicant->registration_code }}
            </div>
            <span style="font-size: 0.8rem; color: var(--gold-dark); font-weight: 600; margin-top: 6px; display: block;">
                Status Saat Ini: <span style="text-transform: uppercase; color:#0284c7;">{{ $applicant->selection_status }}</span>
            </span>
        </div>

        <!-- Summary Table -->
        <div style="text-align: left; background: #f8fafc; border-radius: 14px; padding: 20px 24px; margin-bottom: 32px; border: 1px solid #e2e8f0; font-size: 0.9rem;">
            <div style="display: grid; grid-template-columns: 140px 1fr; row-gap: 10px;">
                <span style="color: #64748b; font-weight: 600;">Nama Lengkap:</span>
                <span style="color: #0f172a; font-weight: 700;">{{ $applicant->full_name }}</span>

                <span style="color: #64748b; font-weight: 600;">Asal Sekolah:</span>
                <span style="color: #0f172a;">{{ $applicant->school_name }}</span>

                <span style="color: #64748b; font-weight: 600;">Jabatan OSIS:</span>
                <span style="color: #0f172a;">{{ $applicant->osis_position }}</span>

                <span style="color: #64748b; font-weight: 600;">Provinsi:</span>
                <span style="color: #0f172a;">{{ $applicant->province }}</span>

                <span style="color: #64748b; font-weight: 600;">WhatsApp:</span>
                <span style="color: #0f172a;">{{ $applicant->whatsapp_number }}</span>
            </div>
        </div>

        <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
            <button onclick="window.print()" class="btn btn-outline">
                <i class="fa-solid fa-print"></i> Cetak Tanda Bukti
            </button>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fa-solid fa-house"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

@endsection
