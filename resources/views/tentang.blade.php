@extends('layouts.app')

@section('title', 'Tentang Hatta Aksara Project')

@push('styles')
<style>
    .about-hero {
        background: radial-gradient(circle at top right, #240C4C 0%, #0C0022 100%);
        color: white;
        padding: 80px 0 70px;
        border-bottom: 1px solid rgba(115, 0, 255, 0.25);
        text-align: center;
    }
    .about-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 45px;
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-subtle);
        margin-bottom: 40px;
    }
    .about-card h2 {
        font-family: var(--font-display);
        font-size: 2rem;
        color: var(--slate-900);
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 12px;
    }
    .about-card h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--gold-primary);
        border-radius: 2px;
    }
    .about-card p {
        font-size: 1.05rem;
        line-height: 1.85;
        color: #334155;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')

<header class="about-hero">
    <div class="container" style="max-width: 850px;">
        <span class="section-tag">Gerakan Kepemimpinan Generasi Muda</span>
        <h1 style="font-family: var(--font-display); font-size: 3rem; margin: 16px 0; line-height: 1.2;">
            Profil Hatta Aksara Project
        </h1>
        <p style="font-size: 1.15rem; color: #d1d5db; line-height: 1.7;">
            Menyiapkan masyarakat kooperatif melalui pembinaan dan pelatihan kepemimpinan generasi muda berintegritas tanpa cela.
        </p>
    </div>
</header>

<div class="container" style="max-width: 960px; padding: 70px 20px 100px;">
    <!-- 1. Sejarah & Latar Belakang -->
    <section class="about-card">
        <h2>{{ $history?->title ?? 'Sejarah & Fondasi Berdirinya' }}</h2>
        <p>
            {{ $history?->content ?? 'Hatta Aksara Project adalah inisiatif dan wadah kepemimpinan pemuda yang bergerak secara independen dan otonom, lahir dari tekad para cendekiawan muda dan alumni kepemimpinan nasional untuk mewujudkan masyarakat kooperatif berlandaskan nilai-nilai luhur Bung Hatta. Mohammad Hatta, Sang Proklamator dan Bapak Koperasi Indonesia, meyakini bahwa kemerdekaan sejati hanya dapat dijaga oleh masyarakat yang berpendidikan, mandiri secara ekonomi melalui asas gotong royong, dan memiliki kompas moral yang kokoh.' }}
        </p>
    </section>

    <!-- 2. Visi & Misi -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px;">
        <div class="about-card" style="margin-bottom: 0;">
            <h2 style="font-size: 1.6rem;">{{ $vision?->title ?? 'Visi Kami' }}</h2>
            <p style="font-size: 1rem;">
                {{ $vision?->content ?? 'Menjadi pusat pembinaan kepemimpinan pemuda terdepan di Indonesia yang melahirkan generasi pemimpin berkarakter, berpegang teguh pada jati diri bangsa (weltanschauung), serta aktif memajukan keadilan sosial melalui prinsip ekonomi kerakyatan dan kebudayaan.' }}
            </p>
        </div>

        <div class="about-card" style="margin-bottom: 0;">
            <h2 style="font-size: 1.6rem;">{{ $mission?->title ?? 'Misi Kami' }}</h2>
            <div style="font-size: 0.95rem; line-height: 1.75; color: #334155; white-space: pre-line;">
                {{ $mission?->content ?? "1. Menyelenggarakan pelatihan kepemimpinan berstandar tinggi (ISLT) bagi ketua OSIS pilihan dari seluruh provinsi di Indonesia.\n2. Mengembangkan ekosistem literasi dan ruang diskusi terbuka mengenai pemikiran ekonomi koperasi Bung Hatta dan SDGs.\n3. Membangun jejaring alumni (Hatta Muda Connection) yang solid dan berdampak nyata." }}
            </div>
        </div>
    </div>

    <!-- 3. Nilai-Nilai Luhur -->
    <section class="about-card">
        <h2>{{ $values?->title ?? 'Nilai-Nilai Luhur' }}</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 25px;">
            <div style="background:#faf8f5; padding:22px; border-radius:14px; border-top:3px solid var(--maroon-primary);">
                <i class="fa-solid fa-scale-balanced" style="font-size:1.8rem; color:var(--maroon-primary); margin-bottom:12px;"></i>
                <h4 style="font-size:1.05rem; font-weight:700; color:var(--slate-900); margin-bottom:6px;">Integritas</h4>
                <p style="font-size:0.86rem; color:var(--text-muted); line-height:1.5;">Ketulusan, kejujuran, dan konsistensi kata dengan perbuatan demi bangsa.</p>
            </div>
            <div style="background:#faf8f5; padding:22px; border-radius:14px; border-top:3px solid var(--gold-primary);">
                <i class="fa-solid fa-hands-holding-child" style="font-size:1.8rem; color:var(--gold-dark); margin-bottom:12px;"></i>
                <h4 style="font-size:1.05rem; font-weight:700; color:var(--slate-900); margin-bottom:6px;">Kooperatif</h4>
                <p style="font-size:0.86rem; color:var(--text-muted); line-height:1.5;">Asas kekeluargaan dan gotong royong sebagai sokoguru kehidupan bersama.</p>
            </div>
            <div style="background:#faf8f5; padding:22px; border-radius:14px; border-top:3px solid #0284c7;">
                <i class="fa-solid fa-compass" style="font-size:1.8rem; color:#0284c7; margin-bottom:12px;"></i>
                <h4 style="font-size:1.05rem; font-weight:700; color:var(--slate-900); margin-bottom:6px;">Weltanschauung</h4>
                <p style="font-size:0.86rem; color:var(--text-muted); line-height:1.5;">Memahami pandangan hidup dan filosofi jati diri bangsa Indonesia.</p>
            </div>
            <div style="background:#faf8f5; padding:22px; border-radius:14px; border-top:3px solid #16a34a;">
                <i class="fa-solid fa-book-open-reader" style="font-size:1.8rem; color:#16a34a; margin-bottom:12px;"></i>
                <h4 style="font-size:1.05rem; font-weight:700; color:var(--slate-900); margin-bottom:6px;">Cinta Ilmu</h4>
                <p style="font-size:0.86rem; color:var(--text-muted); line-height:1.5;">Menghidupkan budaya membaca mendalam dan berpikir kritis yang rasional.</p>
            </div>
        </div>
    </section>

    <!-- 4. Tim & Inisiator -->
    <section class="about-card">
        <h2>Inisiator & Pembina Program</h2>
        <p>
            Hatta Aksara Project dikelola secara otonom dengan struktur kepengurusan mandiri, didukung oleh dewan pakar, cendekiawan muda, serta jejaring alumni Hatta Muda se-Indonesia yang berdedikasi menjaga warisan api keteladanan Bung Hatta tetap relevan dan berdaya guna bagi generasi penerus.
        </p>
    </section>
</div>

@endsection
