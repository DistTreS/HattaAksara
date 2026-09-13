@extends('layouts.app')

@section('title', 'Menunggu Verifikasi Akun')

@section('content')

<div class="container" style="max-width: 650px; padding: 80px 20px 110px;">
    <div style="background: white; border-radius: 24px; padding: 45px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-elevated); text-align: center;">
        
        <div style="width: 75px; height: 75px; border-radius: 50%; background: #fffbeb; border: 2px solid #f59e0b; color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin: 0 auto 24px;">
            <i class="fa-solid fa-hourglass-half"></i>
        </div>

        <span class="section-tag" style="background:#fffbeb; color:#92400e; border-color:#f59e0b;">Menunggu Verifikasi</span>

        <h1 style="font-family: var(--font-display); font-size: 2rem; color: var(--slate-900); margin: 14px 0 10px;">
            Akun Alumni Sedang Ditinjau Admin
        </h1>
        <p style="color: var(--text-muted); font-size: 0.98rem; line-height: 1.7; margin-bottom: 25px;">
            Halo <strong>{{ auth()->user()?->name ?? 'Kader Hatta Muda' }}</strong>, terima kasih telah mendaftar di ekosistem Hatta Muda Connection. Data kepesertaan ISLT Anda saat ini sedang diverifikasi oleh Tim Redaksi Yayasan Proklamator Bung Hatta.
        </p>

        <div style="background: #f8fafc; border-radius: 14px; padding: 20px; text-align: left; font-size: 0.88rem; color: #475569; margin-bottom: 30px; border-left: 4px solid var(--gold-primary);">
            <strong style="color: var(--slate-900); display: block; margin-bottom: 4px;">Setelah Akun Disetujui, Anda Dapat:</strong>
            <ul style="padding-left: 20px; line-height: 1.6;">
                <li>Menulis dan menerbitkan berita dampak sosial di daerah Anda (Aksi Hatta Muda).</li>
                <li>Menulis artikel opini dan gagasan pemikiran yang tayang di portal publik.</li>
                <li>Mengakses Direktori Jejaring Hatta Muda se-Indonesia.</li>
            </ul>
        </div>

        <div style="display: flex; justify-content: center; gap: 14px;">
            <a href="{{ route('home') }}" class="btn btn-outline">
                <i class="fa-solid fa-house"></i> Kembali ke Beranda
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar Sementara
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
