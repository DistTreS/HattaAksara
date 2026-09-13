@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
    /* Hero Section */
    .hero {
        position: relative;
        background: linear-gradient(135deg, #0C0022 0%, #160835 45%, #240C4F 100%);
        color: white;
        padding: 95px 0 120px;
        overflow: hidden;
        border-bottom: 1px solid rgba(115, 0, 255, 0.2);
    }
    .hero::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(115, 0, 255, 0.32) 0%, rgba(37, 99, 235, 0.15) 50%, transparent 70%);
        filter: blur(60px);
        pointer-events: none;
    }
    .hero::after {
        content: '';
        position: absolute;
        bottom: -150px;
        left: -100px;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(157, 78, 221, 0.2) 0%, transparent 70%);
        filter: blur(50px);
        pointer-events: none;
    }
    .hero-container {
        display: grid;
        grid-template-columns: 1.18fr 0.82fr;
        gap: 50px;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(115, 0, 255, 0.16);
        color: #D3B0FF;
        border: 1px solid rgba(115, 0, 255, 0.35);
        padding: 7px 18px;
        border-radius: var(--radius-pill);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 22px;
        backdrop-filter: blur(8px);
    }
    .hero-badge i {
        color: #B579FF;
    }
    .hero-title {
        font-family: var(--font-display);
        font-size: 3.2rem;
        line-height: 1.15;
        font-weight: 800;
        margin-bottom: 22px;
        color: #ffffff;
        letter-spacing: -0.02em;
    }
    .hero-title .text-gradient {
        background: linear-gradient(135deg, #FFFFFF 20%, #D8B4FE 60%, #93C5FD 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }
    .hero-subtitle {
        font-size: 1.05rem;
        color: #C8BFDB;
        line-height: 1.75;
        margin-bottom: 36px;
        max-width: 600px;
    }
    .hero-actions {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        align-items: center;
    }
    .hero-actions .btn-outline {
        border-color: rgba(255, 255, 255, 0.3);
        color: #ffffff;
    }
    .hero-actions .btn-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #ffffff;
        box-shadow: none;
    }

    /* Hero Showcase Card */
    .hero-portrait-card {
        position: relative;
        border-radius: var(--radius-xl);
        overflow: hidden;
        border: 1.5px solid rgba(115, 0, 255, 0.35);
        box-shadow: 0 25px 50px -10px rgba(0, 0, 0, 0.6), 0 0 30px rgba(115, 0, 255, 0.2);
        background: #150930;
    }
    .hero-portrait-img {
        width: 100%;
        height: 420px;
        object-fit: cover;
        display: block;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .hero-portrait-card:hover .hero-portrait-img {
        transform: scale(1.03);
    }
    .hero-quote-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(12, 0, 34, 0.85) 35%, rgba(12, 0, 34, 0.98) 100%);
        padding: 30px 24px 22px;
        color: white;
    }
    .hero-quote-pill {
        display: inline-block;
        background: rgba(115, 0, 255, 0.25);
        border: 1px solid rgba(115, 0, 255, 0.4);
        padding: 4px 12px;
        border-radius: var(--radius-pill);
        font-size: 0.74rem;
        font-weight: 600;
        color: #D3B0FF;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .hero-quote-text {
        font-size: 0.95rem;
        font-style: italic;
        line-height: 1.6;
        color: #EDE8F7;
        margin-bottom: 12px;
    }
    .hero-quote-signature {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.82rem;
        border-top: 1px solid rgba(115, 0, 255, 0.25);
        padding-top: 10px;
        color: #A99FC0;
    }

    /* Metric Bar */
    .metrics-bar {
        background: #ffffff;
        border-radius: var(--radius-xl);
        padding: 30px 40px;
        margin-top: -50px;
        position: relative;
        z-index: 10;
        box-shadow: var(--shadow-elevated);
        border: 1px solid var(--border-subtle);
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }
    .metric-item {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .metric-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: var(--violet-subtle);
        color: var(--violet-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }
    .metric-number {
        font-family: var(--font-display);
        font-size: 1.9rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.1;
        letter-spacing: -0.02em;
    }
    .metric-label {
        font-size: 0.84rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-top: 3px;
    }

    /* Section Global */
    .section-py {
        padding: 90px 0;
    }

    /* Program Cards (Figma Service Card inspired) */
    .programs-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 32px;
    }
    .program-card {
        background: #ffffff;
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-subtle);
        overflow: hidden;
        box-shadow: var(--shadow-subtle);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
    }
    .program-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 45px -10px rgba(115, 0, 255, 0.12);
        border-color: rgba(115, 0, 255, 0.35);
    }
    .program-card-img-wrap {
        position: relative;
        height: 250px;
        overflow: hidden;
    }
    .program-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    .program-card:hover .program-card-img {
        transform: scale(1.04);
    }
    .program-card-badge {
        position: absolute;
        top: 18px;
        left: 18px;
        background: rgba(12, 0, 34, 0.75);
        backdrop-filter: blur(10px);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 6px 14px;
        border-radius: var(--radius-pill);
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .program-card-body {
        padding: 32px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .program-card-title {
        font-family: var(--font-display);
        font-size: 1.45rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 12px;
        line-height: 1.3;
    }
    .program-card-desc {
        font-size: 0.94rem;
        color: var(--text-muted);
        line-height: 1.7;
        margin-bottom: 24px;
        flex: 1;
    }
    .program-card-points {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 28px;
    }
    .program-card-points li {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.88rem;
        color: var(--text-main);
        font-weight: 500;
    }
    .program-card-points li i {
        color: var(--violet-primary);
        font-size: 0.95rem;
    }
    .program-card-footer {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-top: 20px;
        border-top: 1px solid var(--border-subtle);
    }

    /* About Section / 3 Pillars (Figma inspired) */
    .about-box {
        background: #ffffff;
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-subtle);
        padding: 50px;
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 50px;
        align-items: center;
    }
    .pillar-item {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        margin-bottom: 24px;
    }
    .pillar-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: var(--violet-subtle);
        border: 1px solid var(--violet-border);
        color: var(--violet-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .pillar-title {
        font-family: var(--font-display);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 4px;
    }
    .pillar-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* News & Article Cards */
    .posts-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }
    .post-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-subtle);
        overflow: hidden;
        box-shadow: var(--shadow-subtle);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 35px -5px rgba(115, 0, 255, 0.1);
        border-color: rgba(115, 0, 255, 0.25);
    }
    .post-img-wrap {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    .post-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .post-card:hover .post-img {
        transform: scale(1.05);
    }
    .post-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: var(--violet-primary);
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: var(--radius-pill);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: 0 4px 12px rgba(115, 0, 255, 0.4);
    }
    .post-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .post-meta {
        font-size: 0.8rem;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }
    .post-title {
        font-family: var(--font-display);
        font-size: 1.12rem;
        font-weight: 700;
        color: var(--text-main);
        line-height: 1.4;
        margin-bottom: 12px;
    }
    .post-title a:hover {
        color: var(--violet-primary);
    }
    .post-excerpt {
        font-size: 0.88rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 20px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .post-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.84rem;
        padding-top: 16px;
        border-top: 1px solid var(--border-subtle);
    }
    .post-footer a {
        color: var(--violet-primary);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .post-footer a:hover {
        gap: 8px;
    }

    /* Video Section */
    .video-hub-card {
        background: #ffffff;
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-subtle);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1.35fr 0.85fr;
    }
    .video-main-col {
        display: flex;
        flex-direction: column;
        border-right: 1px solid var(--border-subtle);
    }
    .video-player-area {
        position: relative;
        background: #0C0022;
        aspect-ratio: 16 / 9;
        width: 100%;
        overflow: hidden;
    }
    .video-detail-panel {
        padding: 28px;
        background: #ffffff;
        flex: 1;
    }
    .video-playlist {
        background: var(--bg-page);
        padding: 24px;
        overflow-y: auto;
        max-height: 720px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .playlist-item {
        background: #ffffff;
        border-radius: var(--radius-md);
        padding: 12px;
        border: 1px solid var(--border-subtle);
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .playlist-item:hover, .playlist-item.active {
        border-color: var(--violet-primary);
        background: #ffffff;
        box-shadow: 0 8px 20px rgba(115, 0, 255, 0.08);
    }
    .playlist-item.active {
        border-left: 4px solid var(--violet-primary);
        background: #FDFCFF;
    }
    .playlist-thumb-wrap {
        position: relative;
        width: 96px;
        height: 58px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        background: #0C0022;
    }
    .playlist-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .playlist-thumb-wrap .thumb-duration {
        position: absolute;
        bottom: 3px;
        right: 4px;
        background: rgba(12, 0, 34, 0.85);
        color: white;
        font-size: 0.68rem;
        font-weight: 600;
        padding: 1px 5px;
        border-radius: 4px;
    }
    .point-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 10px 14px;
        background: #FAF7FC;
        border-radius: 10px;
        border: 1px solid rgba(115,0,255,0.08);
        font-size: 0.88rem;
        line-height: 1.55;
    }
    .point-badge {
        background: var(--violet-primary);
        color: white;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 2px 8px;
        border-radius: 6px;
        white-space: nowrap;
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* Gallery Grid */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }
    .gallery-item {
        position: relative;
        height: 220px;
        border-radius: var(--radius-lg);
        overflow: hidden;
        cursor: pointer;
        border: 1px solid var(--border-subtle);
    }
    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .gallery-item:hover .gallery-img {
        transform: scale(1.08);
    }
    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 40%, rgba(12, 0, 34, 0.85) 100%);
        display: flex;
        align-items: flex-end;
        padding: 16px;
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    /* Lightbox Modal */
    .modal-lightbox {
        position: fixed;
        inset: 0;
        background: rgba(12, 0, 34, 0.9);
        backdrop-filter: blur(8px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .modal-lightbox.active {
        display: flex;
    }
    .modal-content-wrap {
        max-width: 900px;
        width: 100%;
        background: #ffffff;
        border-radius: var(--radius-xl);
        overflow: hidden;
        position: relative;
        border: 1px solid rgba(115, 0, 255, 0.2);
    }
    .modal-close-btn {
        position: absolute;
        top: 14px;
        right: 14px;
        background: rgba(12, 0, 34, 0.6);
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-size: 1.4rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: all 0.2s;
    }
    .modal-close-btn:hover {
        background: var(--violet-primary);
    }

    /* CTA Section */
    .cta-banner {
        background: linear-gradient(135deg, #0C0022 0%, #17073B 50%, #37007A 100%);
        color: white;
        border-radius: var(--radius-xl);
        padding: 70px 50px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(115, 0, 255, 0.3);
        box-shadow: 0 25px 50px -10px rgba(115, 0, 255, 0.25);
    }
    .cta-banner::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(157, 78, 221, 0.35) 0%, transparent 70%);
        filter: blur(40px);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .hero-container {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .hero-actions {
            justify-content: center;
        }
        .hero-subtitle {
            margin-left: auto;
            margin-right: auto;
        }
        .metrics-bar {
            grid-template-columns: repeat(2, 1fr);
            margin-top: -30px;
        }
        .about-box {
            grid-template-columns: 1fr;
        }
        .video-hub-card {
            grid-template-columns: 1fr;
        }
        .posts-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.3rem;
        }
        .metrics-bar {
            grid-template-columns: 1fr;
            padding: 24px;
        }
        .programs-grid {
            grid-template-columns: 1fr;
        }
        .posts-grid {
            grid-template-columns: 1fr;
        }
        .cta-banner {
            padding: 40px 24px;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')

<!-- 1. Hero Section -->
<section class="hero">
    <div class="container hero-container">
        <div>
            <span class="hero-badge">
                <i class="fa-solid fa-landmark"></i> Hatta Aksara Project
            </span>
            <h1 class="hero-title">
                Mencetak Pemimpin Berkarakter, <br>
                <span class="text-gradient">Mengabdi untuk Kedaulatan Bangsa</span>
            </h1>
            <p class="hero-subtitle">
                Ekosistem pembinaan kepemimpinan pemuda nasional berakar pada ajaran integritas Mohammad Hatta, filosofi <em>weltanschauung</em>, serta keadilan ekonomi kerakyatan.
            </p>
            <div class="hero-actions">
                <a href="{{ route('program.islt.daftar') }}" class="btn btn-primary" style="font-size: 0.95rem; padding: 12px 28px;">
                    <i class="fa-solid fa-file-pen"></i> Daftar Peserta ISLT 2026
                </a>
                <a href="{{ route('program.index') }}" class="btn btn-outline" style="font-size: 0.95rem; padding: 12px 26px;">
                    <i class="fa-solid fa-compass"></i> Pelajari Program
                </a>
            </div>
        </div>

        <div>
            <div class="hero-portrait-card">
                <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=1000&auto=format&fit=crop" alt="Kepemimpinan Hatta Muda" class="hero-portrait-img">
                <div class="hero-quote-overlay">
                    <span class="hero-quote-pill">Refleksi Mohammad Hatta</span>
                    <p class="hero-quote-text">
                        "Kurang cerdas dapat diperbaiki dengan belajar. Kurang cakap dapat dihilangkan dengan pengalaman. Namun kejujuran tidak dapat diangsur."
                    </p>
                    <div class="hero-quote-signature">
                        <span style="font-weight:600; color:#ffffff;">Drs. Mohammad Hatta</span>
                        <span style="color:var(--violet-light); font-weight:500;">Proklamator & Bapak Bangsa</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Metrics Bar (Faktual & Terhubung Dinamis ke Basis Data) -->
<div class="container">
    <div class="metrics-bar">
        <div class="metric-item">
            <div class="metric-icon">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div>
                <div class="metric-number">{{ $provincesCount ?? 38 }}</div>
                <div class="metric-label">Provinsi Sasaran ISLT</div>
            </div>
        </div>
        <div class="metric-item">
            <div class="metric-icon">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div>
                <div class="metric-number">{{ number_format($totalAlumni ?? 0, 0, ',', '.') }}</div>
                <div class="metric-label">Alumni Hatta Muda Terdata</div>
            </div>
        </div>
        <div class="metric-item">
            <div class="metric-icon">
                <i class="fa-solid fa-book-open-reader"></i>
            </div>
            <div>
                <div class="metric-number">{{ number_format($totalPublications ?? 0, 0, ',', '.') }}</div>
                <div class="metric-label">Karya & Gagasan Rilis</div>
            </div>
        </div>
        <div class="metric-item">
            <div class="metric-icon">
                <i class="fa-solid fa-id-card-clip"></i>
            </div>
            <div>
                <div class="metric-number">{{ number_format($totalApplicants ?? 0, 0, ',', '.') }}</div>
                <div class="metric-label">Pendaftar Seleksi ISLT</div>
            </div>
        </div>
    </div>
</div>

<!-- 3. Program Unggulan (Figma Service Card Inspired) -->
<section class="section-py" id="program">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Program Unggulan</span>
            <h2 class="section-title">Inisiatif Strategis Kepemimpinan & Intelektual</h2>
            <p class="section-desc">
                Dirancang untuk membekali generasi penerus bangsa dengan wawasan kebangsaan yang utuh, etika kepemimpinan yang kokoh, dan literasi koperasi.
            </p>
        </div>

        <div class="programs-grid">
            <!-- Program 1: ISLT -->
            <div class="program-card">
                <div class="program-card-img-wrap">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop" alt="ISLT Training" class="program-card-img">
                    <span class="program-card-badge">Program Utama</span>
                </div>
                <div class="program-card-body">
                    <h3 class="program-card-title">Indonesian Students Leadership Training (ISLT)</h3>
                    <p class="program-card-desc">
                        Kaderisasi intensif nasional untuk Ketua & Pengurus OSIS SMA/SMK se-Indonesia. Mengombinasikan napak tilas sejarah, kurikulum integritas, dan pemikiran ekonomi kerakyatan Bung Hatta.
                    </p>
                    <ul class="program-card-points">
                        <li><i class="fa-solid fa-circle-check"></i> Pelatihan intensif kepemimpinan nasional berasrama</li>
                        <li><i class="fa-solid fa-circle-check"></i> Napak tilas sejarah di Bukittinggi & Jakarta</li>
                        <li><i class="fa-solid fa-circle-check"></i> Mentorship tokoh bangsa dan jejaring alumni nasional</li>
                    </ul>
                    <div class="program-card-footer">
                        <a href="{{ route('program.islt.daftar') }}" class="btn btn-primary" style="padding: 8px 20px;">
                            Daftar Sekarang <i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                        </a>
                        <a href="{{ route('program.islt') }}" class="btn btn-outline" style="padding: 8px 18px;">
                            Detail Silabus
                        </a>
                    </div>
                </div>
            </div>

            <!-- Program 2: Media Edukasi -->
            <div class="program-card">
                <div class="program-card-img-wrap">
                    <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?q=80&w=800&auto=format&fit=crop" alt="Media Edukasi" class="program-card-img">
                    <span class="program-card-badge">Ekosistem Literasi</span>
                </div>
                <div class="program-card-body">
                    <h3 class="program-card-title">Media Edukasi & Publikasi Ilmiah</h3>
                    <p class="program-card-desc">
                        Ruang publikasi pemikiran kritis, esai kebangsaan, dan arsip digital karya Hatta Muda. Menghubungkan gagasan pemuda dari seluruh penjuru negeri ke panggung diskursus nasional.
                    </p>
                    <ul class="program-card-points">
                        <li><i class="fa-solid fa-circle-check"></i> Publikasi artikel gagasan & opini pemuda terkurasi</li>
                        <li><i class="fa-solid fa-circle-check"></i> Repositori e-jurnal & modul kepemimpinan digital</li>
                        <li><i class="fa-solid fa-circle-check"></i> Forum diskusi berkala & wacana kebangsaan</li>
                    </ul>
                    <div class="program-card-footer">
                        <a href="{{ route('artikel.index') }}" class="btn btn-primary" style="padding: 8px 20px;">
                            Baca Artikel <i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                        </a>
                        <a href="{{ route('program.media-edukasi') }}" class="btn btn-outline" style="padding: 8px 18px;">
                            Pelajari Ekosistem
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. Video Showcase Section -->
<section class="section-py" style="background: var(--bg-page);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 35px; flex-wrap: wrap; gap: 20px;">
            <div>
                <span class="section-tag">Kanal Edukasi & Dokumenter Visual</span>
                <h2 class="section-title" style="margin-bottom: 0;">Dokumenter Resmi & Forum Hatta Aksara</h2>
            </div>
            <a href="https://www.youtube.com/@hattaaksaraproject" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="gap:10px; border-color:rgba(239, 68, 68, 0.4); color:var(--text-main); font-size:0.9rem; padding:10px 20px; background:white;">
                <i class="fa-brands fa-youtube" style="color:#ef4444; font-size:1.2rem;"></i>
                <span>Kanal Resmi <strong>@hattaaksaraproject</strong></span>
                <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.75rem; color:var(--text-muted);"></i>
            </a>
        </div>

        <div class="video-hub-card">
            <!-- Left Main Column: Player + Detail Panel -->
            <div class="video-main-col">
                <div class="video-player-area">
                    <div id="videoPlaceholderCover" style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:30px; text-align:center; background: radial-gradient(circle, rgba(31,13,66,0.7) 0%, rgba(12,0,34,0.92) 100%), url('https://i.ytimg.com/vi/4_arGLyBZqQ/hq720.jpg') center/cover no-repeat; cursor:pointer;" onclick="playCurrentVideo()">
                        <div style="position:absolute; top:20px; left:20px; display:flex; gap:8px; align-items:center;">
                            <span id="coverVideoTag" class="section-tag" style="background:rgba(115,0,255,0.85); color:white; border-color:transparent; margin:0; font-size:0.75rem; padding:4px 12px;">
                                Pidato Kehormatan
                            </span>
                            <span id="coverVideoDuration" style="background:rgba(0,0,0,0.65); color:#ffffff; font-size:0.75rem; font-weight:600; padding:4px 10px; border-radius:20px;">
                                <i class="fa-regular fa-clock"></i> 16:09
                            </span>
                        </div>
                        <button style="width:76px; height:76px; border-radius:50%; background:var(--violet-primary); border:3px solid rgba(255,255,255,0.3); color:white; font-size:1.75rem; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:var(--shadow-violet); transition:transform 0.25s; margin-bottom:18px;">
                            <i class="fa-solid fa-play" style="margin-left:4px;"></i>
                        </button>
                        <h3 id="coverVideoTitle" style="color:white; font-size:clamp(1.1rem, 2.5vw, 1.4rem); font-family:var(--font-display); margin-bottom:8px; font-weight:700; max-width:650px; line-height:1.35; text-shadow:0 2px 10px rgba(0,0,0,0.8);">
                            Inspiring Speech dari Ibu Meutia Farida Hatta, Anak Proklamator Kemerdekaan Indonesia Mohammad Hatta
                        </h3>
                        <p id="coverVideoSubtitle" style="color:#D5CEE8; font-size:0.9rem; max-width:550px; line-height:1.6; text-shadow:0 1px 6px rgba(0,0,0,0.8);">
                            Pidato pembukaan pembekalan kader Indonesian Student Leadership Training (ISLT) 2026.
                        </p>
                    </div>
                    <iframe id="videoIframe" src="" style="width:100%; height:100%; border:none; display:none;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>

                <!-- Video Detail Panel (Interactive Notes & Timestamps) -->
                <div class="video-detail-panel">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:40px; height:40px; border-radius:50%; background:rgba(115,0,255,0.1); color:var(--violet-primary); display:flex; align-items:center; justify-content:center; font-size:1.1rem;">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <div>
                                <h4 id="detailSpeakerName" style="font-size:0.98rem; font-weight:700; color:var(--text-main); margin:0;">Prof. Dr. Meutia Farida Hatta Swasono</h4>
                                <span id="detailSpeakerRole" style="font-size:0.8rem; color:var(--text-muted);">Putri Proklamator Bung Hatta / Guru Besar UI</span>
                            </div>
                        </div>
                        <a id="detailYoutubeBtn" href="https://www.youtube.com/watch?v=4_arGLyBZqQ" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="font-size:0.82rem; padding:6px 14px; gap:6px;">
                            <i class="fa-brands fa-youtube" style="color:#ef4444;"></i> Buka di YouTube
                        </a>
                    </div>

                    <p id="detailDescription" style="font-size:0.92rem; color:var(--text-main); line-height:1.65; margin-bottom:16px;">
                        Pidato inspiratif dan sarat makna dari Ibu Meutia Farida Hatta dalam pembukaan Indonesian Student Leadership Training (ISLT) 2026 yang membakar semangat kepemimpinan generasi muda.
                    </p>

                    <h5 style="font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--text-muted); margin-bottom:12px; display:flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-list-check" style="color:var(--violet-primary);"></i> Poin Kunci & Linimasa Tayangan:
                    </h5>

                    <div id="detailPointsContainer" style="display:flex; flex-direction:column; gap:8px;">
                        <!-- Injected by JS -->
                    </div>
                </div>
            </div>

            <!-- Right Playlist Column -->
            <div class="video-playlist">
                <!-- Channel Sub Mini Card -->
                <div style="background:white; border-radius:12px; padding:14px; border:1px solid var(--border-subtle); display:flex; align-items:center; justify-content:space-between; gap:10px;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <i class="fa-brands fa-youtube" style="font-size:2rem; color:#ef4444;"></i>
                        <div>
                            <strong style="font-size:0.88rem; display:block; color:var(--text-main);">Hatta Aksara Official</strong>
                            <span style="font-size:0.75rem; color:var(--text-muted);">5 Video Pembekalan</span>
                        </div>
                    </div>
                    <a href="https://www.youtube.com/@hattaaksaraproject?sub_confirmation=1" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="font-size:0.75rem; padding:6px 12px; border-radius:18px;">
                        Subscribe
                    </a>
                </div>

                <div style="font-size:0.82rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; margin:6px 0 2px;">
                    Daftar Seri Video ISLT
                </div>

                <!-- Playlist Item 0 -->
                <div class="playlist-item active" onclick="switchVideo(0)">
                    <div class="playlist-thumb-wrap">
                        <img src="https://i.ytimg.com/vi/4_arGLyBZqQ/hqdefault.jpg" alt="Inspiring Speech Ibu Meutia Hatta">
                        <span class="thumb-duration">16:09</span>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <span style="font-size:0.7rem; color:var(--violet-primary); font-weight:700; text-transform:uppercase; display:block;">Pidato Kehormatan</span>
                        <div style="font-size:0.85rem; font-weight:600; color:var(--text-main); line-height:1.3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Inspiring Speech dari Ibu Meutia Farida Hatta</div>
                        <div style="font-size:0.74rem; color:var(--text-muted); margin-top:2px;">Pembukaan ISLT 2026</div>
                    </div>
                </div>

                <!-- Playlist Item 1 -->
                <div class="playlist-item" onclick="switchVideo(1)">
                    <div class="playlist-thumb-wrap">
                        <img src="https://i.ytimg.com/vi/KfYjfXxEnmk/hqdefault.jpg" alt="ISLT 2025 Menuju Masyarakat Kooperatif">
                        <span class="thumb-duration">08:05</span>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <span style="font-size:0.7rem; color:var(--violet-primary); font-weight:700; text-transform:uppercase; display:block;">Visi & Refleksi ISLT</span>
                        <div style="font-size:0.85rem; font-weight:600; color:var(--text-main); line-height:1.3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">ISLT 2025 Menuju Masyarakat Kooperatif</div>
                        <div style="font-size:0.74rem; color:var(--text-muted); margin-top:2px;">Keluarga Besar Bung Hatta</div>
                    </div>
                </div>

                <!-- Playlist Item 2 -->
                <div class="playlist-item" onclick="switchVideo(2)">
                    <div class="playlist-thumb-wrap">
                        <img src="https://i.ytimg.com/vi/FL4FSSxFjCg/hqdefault.jpg" alt="Kepemimpinan Empati Pilar I">
                        <span class="thumb-duration">08:59</span>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <span style="font-size:0.7rem; color:var(--violet-primary); font-weight:700; text-transform:uppercase; display:block;">Pilar I ISLT</span>
                        <div style="font-size:0.85rem; font-weight:600; color:var(--text-main); line-height:1.3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Kepemimpinan Empati — Pilar I ISLT</div>
                        <div style="font-size:0.74rem; color:var(--text-muted); margin-top:2px;">Fauzan Akiar</div>
                    </div>
                </div>

                <!-- Playlist Item 3 -->
                <div class="playlist-item" onclick="switchVideo(3)">
                    <div class="playlist-thumb-wrap">
                        <img src="https://i.ytimg.com/vi/4bcwLaUQONI/hqdefault.jpg" alt="Social Problem Solving Pilar ISLT">
                        <span class="thumb-duration">43:24</span>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <span style="font-size:0.7rem; color:var(--violet-primary); font-weight:700; text-transform:uppercase; display:block;">Pilar II ISLT</span>
                        <div style="font-size:0.85rem; font-weight:600; color:var(--text-main); line-height:1.3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Social Problem Solving | Pilar ISLT</div>
                        <div style="font-size:0.74rem; color:var(--text-muted); margin-top:2px;">Ahmad Hafidz (CEO Witbox)</div>
                    </div>
                </div>

                <!-- Playlist Item 4 -->
                <div class="playlist-item" onclick="switchVideo(4)">
                    <div class="playlist-thumb-wrap">
                        <img src="https://i.ytimg.com/vi/xorTCWOmiZE/hqdefault.jpg" alt="Mengapa Kita Harus Menjadi Bung Hatta">
                        <span class="thumb-duration">20:25</span>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <span style="font-size:0.7rem; color:var(--violet-primary); font-weight:700; text-transform:uppercase; display:block;">Filosofi Gerakan</span>
                        <div style="font-size:0.85rem; font-weight:600; color:var(--text-main); line-height:1.3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Mengapa Kita Harus Menjadi Bung Hatta?</div>
                        <div style="font-size:0.74rem; color:var(--text-muted); margin-top:2px;">Diskursus Intelektual Hatta Muda</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. Nilai & Landasan Filosofis (About Us) -->
<section class="section-py">
    <div class="container">
        <div class="about-box">
            <div>
                <span class="section-tag">Landasan Pergerakan</span>
                <h2 style="font-family:var(--font-display); font-size:2.2rem; font-weight:800; color:var(--text-main); margin-bottom:20px; line-height:1.25;">
                    Meneruskan Api Perjuangan Bung Hatta untuk Masa Depan
                </h2>
                <p style="color:var(--text-muted); font-size:0.98rem; line-height:1.75; margin-bottom:30px;">
                    Hatta Aksara Project memandang bahwa masa depan bangsa terletak pada pemuda yang tidak hanya cerdas secara intelektual, melainkan teguh pendirian, menjunjung tinggi moralitas, dan memiliki jiwa kepedulian sosial yang mandiri.
                </p>

                <div class="pillar-item">
                    <div class="pillar-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h4 class="pillar-title">Integritas & Kejujuran Mutlak</h4>
                        <p class="pillar-desc">Menanamkan keteguhan sikap anti-korupsi, kesederhanaan hidup, dan kesetiaan terhadap janji sumpah pengabdian.</p>
                    </div>
                </div>

                <div class="pillar-item">
                    <div class="pillar-icon">
                        <i class="fa-solid fa-people-roof"></i>
                    </div>
                    <div>
                        <h4 class="pillar-title">Asas Kekeluargaan & Koperasi</h4>
                        <p class="pillar-desc">Mengedepankan ekonomi kerakyatan yang membebaskan masyarakat dari ketimpangan sosial melalui gotong royong.</p>
                    </div>
                </div>

                <div class="pillar-item">
                    <div class="pillar-icon">
                        <i class="fa-solid fa-compass-drafting"></i>
                    </div>
                    <div>
                        <h4 class="pillar-title">Weltanschauung Kebangsaan</h4>
                        <p class="pillar-desc">Pandangan hidup yang bersumber pada kearifan budaya nusantara, keadilan sosial, dan persatuan Indonesia.</p>
                    </div>
                </div>
            </div>

            <div>
                <div style="background: linear-gradient(135deg, #160835, #0C0022); border-radius: var(--radius-xl); padding: 40px; color:white; border:1px solid rgba(115,0,255,0.25); box-shadow: var(--shadow-elevated);">
                    <span style="font-size:0.75rem; color:var(--violet-light); font-weight:700; text-transform:uppercase; letter-spacing:0.1em; display:block; margin-bottom:14px;">Gerakan Mandiri</span>
                    <h3 style="font-family:var(--font-display); font-size:1.6rem; font-weight:700; margin-bottom:16px; line-height:1.3;">
                        Hatta Aksara Project
                    </h3>
                    <p style="color:#C8BFDB; font-size:0.92rem; line-height:1.7; margin-bottom:24px;">
                        Gerakan kaderisasi independen pemuda Indonesia yang berdedikasi menginternalisasi dan merealisasikan api pemikiran Dr. (H.C.) Drs. Mohammad Hatta untuk kemajuan peradaban bangsa.
                    </p>
                    <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:28px;">
                        <div style="display:flex; align-items:center; gap:10px; font-size:0.88rem; color:#E2D9F3;">
                            <i class="fa-solid fa-check" style="color:var(--violet-light);"></i> Struktur Kepengurusan & Program Mandiri
                        </div>
                        <div style="display:flex; align-items:center; gap:10px; font-size:0.88rem; color:#E2D9F3;">
                            <i class="fa-solid fa-check" style="color:var(--violet-light);"></i> Jejaring Ketua OSIS & Pemuda 38 Provinsi
                        </div>
                        <div style="display:flex; align-items:center; gap:10px; font-size:0.88rem; color:#E2D9F3;">
                            <i class="fa-solid fa-check" style="color:var(--violet-light);"></i> Kaderisasi Pemimpin Empati & Karakter Moral
                        </div>
                    </div>
                    <a href="{{ route('about') }}" class="btn btn-primary" style="width:100%; text-align:center;">
                        Selengkapnya Tentang Hatta Aksara &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. Berita & Aksi Terkini -->
<section class="section-py" style="background: var(--bg-page);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 45px; flex-wrap:wrap; gap:20px;">
            <div>
                <span class="section-tag">Kabar & Publikasi</span>
                <h2 class="section-title" style="margin-bottom:0;">Warta Resmi & Aksi Hatta Muda</h2>
            </div>
            <a href="{{ route('berita.index') }}" class="btn btn-outline">
                Lihat Seluruh Berita <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="posts-grid">
            @forelse(($featuredNews ?? $latestNews ?? collect()) as $news)
                <article class="post-card">
                    <div class="post-img-wrap">
                        <img src="{{ $news->featured_image_url ?? $news->cover_image_url ?? 'https://images.unsplash.com/photo-1577495508048-b635879837f1?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $news->title }}" class="post-img">
                        <span class="post-badge">{{ method_exists($news, 'getTypeLabel') ? $news->getTypeLabel() : ($news->subCategory?->name ?? ucfirst($news->post_type ?? 'Berita')) }}</span>
                    </div>
                    <div class="post-body">
                        <div class="post-meta">
                            <span><i class="fa-regular fa-calendar"></i> {{ $news->published_at?->format('d M Y') ?? $news->created_at?->format('d M Y') ?? date('d M Y') }}</span>
                            <span>&bull;</span>
                            <span><i class="fa-regular fa-eye"></i> {{ $news->views_count }} baca</span>
                        </div>
                        <h3 class="post-title">
                            <a href="{{ route('berita.show', $news->slug) }}">{{ $news->title }}</a>
                        </h3>
                        <p class="post-excerpt">{{ $news->excerpt }}</p>
                        <div class="post-footer">
                            <span style="color:var(--text-light);"><i class="fa-solid fa-user-pen" style="color:var(--violet-primary);"></i> {{ $news->author?->name ?? 'Redaksi' }}</span>
                            <a href="{{ route('berita.show', $news->slug) }}">Baca Selengkapnya &rarr;</a>
                        </div>
                    </div>
                </article>
            @empty
                <div style="grid-column: 1 / -1; text-align:center; padding: 40px; color:var(--text-muted);">
                    Belum ada berita yang diterbitkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 7. Galeri Napak Tilas & Kegiatan -->
<section class="section-py">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Dokumentasi Visual</span>
            <h2 class="section-title">Galeri Napak Tilas & Kegiatan</h2>
            <p class="section-desc">
                Rekaman momentum bersejarah pembelajaran, musyawarah, dan aksi nyata kader Hatta Muda.
            </p>
        </div>

        <div class="gallery-grid">
            <div class="gallery-item" onclick="openLightbox('https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=800&auto=format&fit=crop', 'Rumah Kelahiran Bung Hatta, Bukittinggi')">
                <img src="https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=800&auto=format&fit=crop" alt="Kegiatan 1" class="gallery-img">
                <div class="gallery-overlay">
                    <span style="font-size:0.88rem; font-weight:600;">Rumah Kelahiran Bung Hatta</span>
                </div>
            </div>
            <div class="gallery-item" onclick="openLightbox('https://images.unsplash.com/photo-1529070538774-1843cb3265df?q=80&w=800&auto=format&fit=crop', 'Sidang Pleno Musyawarah Pemimpin OSIS')">
                <img src="https://images.unsplash.com/photo-1529070538774-1843cb3265df?q=80&w=800&auto=format&fit=crop" alt="Kegiatan 2" class="gallery-img">
                <div class="gallery-overlay">
                    <span style="font-size:0.88rem; font-weight:600;">Sidang Pleno OSIS Nasional</span>
                </div>
            </div>
            <div class="gallery-item" onclick="openLightbox('https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop', 'Pelatihan Intelektual Kebangsaan')">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop" alt="Kegiatan 3" class="gallery-img">
                <div class="gallery-overlay">
                    <span style="font-size:0.88rem; font-weight:600;">Kelas Wawasan Kebangsaan</span>
                </div>
            </div>
            <div class="gallery-item" onclick="openLightbox('https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=800&auto=format&fit=crop', 'Kolaborasi Aksi Sosial Alumni Hatta Muda')">
                <img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=800&auto=format&fit=crop" alt="Kegiatan 4" class="gallery-img">
                <div class="gallery-overlay">
                    <span style="font-size:0.88rem; font-weight:600;">Jejaring Alumni Hatta Muda</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. Artikel Gagasan Pemuda -->
<section class="section-py" style="background: var(--bg-page);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 45px; flex-wrap:wrap; gap:20px;">
            <div>
                <span class="section-tag">Ruang Opini & Pemikiran</span>
                <h2 class="section-title" style="margin-bottom:0;">Gagasan & Esai Hatta Muda</h2>
            </div>
            <a href="{{ route('artikel.index') }}" class="btn btn-outline">
                Seluruh Artikel Gagasan <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="posts-grid">
            @forelse(($featuredArticles ?? $latestArticles ?? collect()) as $art)
                <article class="post-card">
                    <div class="post-img-wrap">
                        <img src="{{ $art->featured_image_url ?? $art->cover_image_url ?? 'https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $art->title }}" class="post-img">
                        <span class="post-badge" style="background:var(--slate-800);">Artikel Gagasan</span>
                    </div>
                    <div class="post-body">
                        <div class="post-meta">
                            <span><i class="fa-regular fa-calendar"></i> {{ $art->published_at?->format('d M Y') ?? $art->created_at?->format('d M Y') ?? date('d M Y') }}</span>
                            <span>&bull;</span>
                            <span><i class="fa-regular fa-eye"></i> {{ $art->views_count }} baca</span>
                        </div>
                        <h3 class="post-title">
                            <a href="{{ route('artikel.show', $art->slug) }}">{{ $art->title }}</a>
                        </h3>
                        <p class="post-excerpt">{{ $art->excerpt }}</p>
                        <div class="post-footer">
                            <span style="color:var(--text-light);"><i class="fa-solid fa-pen-nib" style="color:var(--violet-primary);"></i> {{ $art->author?->name ?? 'Kader Hatta Muda' }}</span>
                            <a href="{{ route('artikel.show', $art->slug) }}">Baca Gagasan &rarr;</a>
                        </div>
                    </div>
                </article>
            @empty
                <div style="grid-column: 1 / -1; text-align:center; padding: 40px; color:var(--text-muted);">
                    Belum ada artikel gagasan yang diterbitkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 9. Call To Action Banner -->
<section class="section-py" style="padding-top:20px;">
    <div class="container">
        <div class="cta-banner">
            <div style="max-width: 700px; position:relative; z-index:2;">
                <span style="color:var(--violet-light); font-weight:700; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.1em; display:inline-block; margin-bottom:12px;">Panggilan Pengabdian Generasi Pemimpin</span>
                <h2 style="font-family: var(--font-display); font-size: 2.3rem; margin-bottom: 18px; line-height:1.25; font-weight:800;">Apakah Anda Ketua OSIS yang Siap Mengukir Sejarah?</h2>
                <p style="color:#C8BFDB; font-size: 1.02rem; line-height: 1.7; margin-bottom: 32px;">
                    Daftarkan diri Anda untuk mengikuti seleksi Indonesian Students Leadership Training (ISLT) 2026. Ditempa secara intelektual, moral, dan sejarah oleh para tokoh bangsa.
                </p>
                <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                    <a href="{{ route('program.islt.daftar') }}" class="btn btn-primary" style="font-size: 0.95rem; padding: 12px 28px;">
                        <i class="fa-solid fa-pen-to-square"></i> Formulir Pendaftaran ISLT
                    </a>
                    <a href="{{ route('register.hatta-muda') }}" class="btn btn-outline" style="color:white; border-color:rgba(255,255,255,0.4); font-size: 0.95rem; padding: 12px 24px;">
                        <i class="fa-solid fa-id-badge"></i> Registrasi Alumni Hatta Muda
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Interactive Lightbox Modal -->
<div class="modal-lightbox" id="galleryLightbox" onclick="closeLightbox(event)">
    <div class="modal-content-wrap">
        <button class="modal-close-btn" onclick="closeLightbox()">&times;</button>
        <img id="lightboxImg" src="" alt="Pratinjau Foto" style="width:100%; max-height:75vh; object-fit:contain; background:#0C0022;">
        <div style="padding:20px 26px; color:white; background:#0C0022; border-top:1px solid rgba(115,0,255,0.2);">
            <h4 id="lightboxCaption" style="font-size:1.1rem; font-weight:700; color:#ffffff; font-family:var(--font-display); margin-bottom:4px;"></h4>
            <span style="font-size:0.8rem; color:#A99FC0;">Arsip Dokumentasi Kegiatan Hatta Aksara Project</span>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Video Data Store
    const videos = [
        {
            id: "4_arGLyBZqQ",
            tag: "Pidato Kehormatan",
            title: "Inspiring Speech dari Ibu Meutia Farida Hatta, Anak Proklamator Kemerdekaan Indonesia Mohammad Hatta",
            subtitle: "Pidato pembukaan pembekalan kader Indonesian Student Leadership Training (ISLT) 2026.",
            speaker: "Prof. Dr. Meutia Farida Hatta Swasono",
            speakerRole: "Putri Proklamator Bung Hatta / Guru Besar UI",
            duration: "16:09",
            coverImg: "https://i.ytimg.com/vi/4_arGLyBZqQ/hq720.jpg",
            youtubeUrl: "https://www.youtube.com/watch?v=4_arGLyBZqQ",
            embedUrl: "https://www.youtube-nocookie.com/embed/4_arGLyBZqQ?autoplay=1&rel=0",
            desc: "Pidato inspiratif dan sarat makna dari Ibu Meutia Farida Hatta dalam pembukaan Indonesian Student Leadership Training (ISLT) 2026 yang membakar semangat kepemimpinan generasi muda.",
            points: [
                { time: "0:20 - 0:50", label: "Tujuan ISLT 2026", text: "Melatih pemimpin muda agar memiliki empati sosial, kesadaran kebangsaan, kemampuan kolaborasi, dan menginternalisasi keteladanan Bung Hatta." },
                { time: "1:13 - 2:28", label: "Pemikiran Bung Hatta", text: "Bung Hatta sebagai 'the father of the founding fathers' yang berperan sentral merancang dasar hukum dan pasal-pasal UUD 1945." },
                { time: "2:30 - 3:04", label: "Masyarakat Kooperatif", text: "Revitalisasi sistem budaya kolektif seperti gotong-royong, musyawarah, dan solidaritas sosial untuk mewujudkan keadilan sosial." },
                { time: "6:32 - 11:57", label: "Pesan Pemimpin Muda", text: "Menekankan 'persatuan hati' melampaui batas geografis. Jangan sekadar berteori, lakukan aksi nyata yang berdampak langsung bagi rakyat." },
                { time: "13:42 - 15:52", label: "Indonesia Emas 2045", text: "Generasi muda dilarang minder terhadap bangsa luar; manfaatkan anugerah alam dan SDM Indonesia dengan percaya diri sebagai tuan rumah di negeri sendiri." }
            ]
        },
        {
            id: "KfYjfXxEnmk",
            tag: "Visi & Refleksi ISLT",
            title: "ISLT 2025 Menuju Masyarakat Kooperatif",
            subtitle: "Manifesto puitis dan komitmen kebersamaan generasi muda menyambut masa depan bangsa.",
            speaker: "Inisiator Hatta Aksara & Kader Hatta Muda",
            speakerRole: "Manifesto Gerakan Kepemimpinan Nasional",
            duration: "08:05",
            coverImg: "https://i.ytimg.com/vi/KfYjfXxEnmk/hq720.jpg",
            youtubeUrl: "https://www.youtube.com/watch?v=KfYjfXxEnmk",
            embedUrl: "https://www.youtube-nocookie.com/embed/KfYjfXxEnmk?autoplay=1&rel=0",
            desc: "Tayangan artistik dan puitis yang mengangkat tema harapan, keteguhan melangkah di tengah kegelapan, serta semangat kebersamaan menuju masyarakat kooperatif.",
            points: [
                { time: "0:17 - 5:00", label: "Pesan Inspiratif", text: "Narasi puitis tentang mengatasi keputusasaan, mencari harapan di tengah kegelapan, dan melepaskan beban masa lalu untuk melangkah maju." },
                { time: "2:03 - 2:20", label: "Semangat Kolektif", text: "Visi menuju masyarakat kooperatif 2025, di mana kebersamaan dan gotong-royong menjadi kunci menggapai cita-cita luhur kemerdekaan." },
                { time: "6:58 - 8:05", label: "Sentuhan Budaya", text: "Aransemen syahdu lagu nasional Indonesia Pusaka yang menggetarkan rasa cinta tanah air dan meneguhkan komitmen kebangsaan." }
            ]
        },
        {
            id: "FL4FSSxFjCg",
            tag: "Pilar I ISLT",
            title: "Kepemimpinan Empati — Pilar I ISLT",
            subtitle: "Eksplorasi mendalam fondasi kepemimpinan etis berbasis empati dan tanggung jawab moral.",
            speaker: "Fauzan Akiar",
            speakerRole: "Direktur Estafet Kepemimpinan Indonesia",
            duration: "08:59",
            coverImg: "https://i.ytimg.com/vi/FL4FSSxFjCg/hq720.jpg",
            youtubeUrl: "https://www.youtube.com/watch?v=FL4FSSxFjCg",
            embedUrl: "https://www.youtube-nocookie.com/embed/FL4FSSxFjCg?autoplay=1&rel=0",
            desc: "Diskusi mendalam mengenai mengapa empati adalah pilar pertama kepemimpinan dan kunci utama keberhasilan regenerasi bangsa menyambut Indonesia Emas 2045.",
            points: [
                { time: "1:20 - 1:53", label: "Kepemimpinan sebagai Proses", text: "Menjadi pemimpin bukanlah bakat lahir, melainkan keterampilan yang harus dilatih terus-menerus dalam lingkungan yang mendukung." },
                { time: "2:55 - 3:31", label: "Individu vs Sistem", text: "Ketika terjadi penyalahgunaan kekuasaan, bukan sekadar sistem yang disalahkan. Tanggung jawab moral individu adalah kunci utamanya." },
                { time: "6:36 - 7:20", label: "Melampaui Hak dan Kewajiban", text: "Pemimpin yang 'naik level' wajib memiliki empati—kemampuan merasakan apa yang dirasakan orang lain sebagai dasar pengambilan kebijakan." },
                { time: "7:42 - 8:12", label: "Tanggung Jawab Moral", text: "Memandang posisi sebagai amanah moral untuk mendahulukan kepentingan umum di atas kepentingan pribadi, bukan sekadar tugas struktural." },
                { time: "8:25 - 8:56", label: "Harapan Masa Depan", text: "Melalui agenda ISLT, lahir pemimpin masa depan yang berjiwa empati tinggi untuk menyambut Indonesia Emas 2045." }
            ]
        },
        {
            id: "4bcwLaUQONI",
            tag: "Pilar II ISLT",
            title: "Social Problem Solving | Pilar ISLT",
            subtitle: "Bagaimana konsep empati dan pemecahan masalah sosial menjadi fondasi kewirausahaan bermakna.",
            speaker: "Ahmad Hafidz",
            speakerRole: "CEO Witbox",
            duration: "43:24",
            coverImg: "https://i.ytimg.com/vi/4bcwLaUQONI/hq720.jpg",
            youtubeUrl: "https://www.youtube.com/watch?v=4bcwLaUQONI",
            embedUrl: "https://www.youtube-nocookie.com/embed/4bcwLaUQONI?autoplay=1&rel=0",
            desc: "Diskusi komprehensif mengupas penerapan empati dalam menyelesaikan persoalan riil di masyarakat dan menumbuhkan budaya berpikir kritis bagi para ketua OSIS.",
            points: [
                { time: "4:31", label: "Definisi Masalah", text: "Masalah bukan sekadar stres atau beban, melainkan tantangan yang harus diselesaikan sebagai bagian dari rangkaian kehidupan." },
                { time: "10:31 - 11:03", label: "Bisnis vs. Sosial", text: "Tidak ada dikotomi antara berbisnis dan bersosial. Bisnis yang baik seharusnya memberikan benefit dan dampak nyata kepada masyarakat luas." },
                { time: "17:42 - 17:50", label: "Pentingnya Empati", text: "Tahap awal dalam design thinking dan bisnis yang berdaya tahan adalah empati—memahami manusia sebelum memahami pasar." },
                { time: "28:25, 31:12", label: "Beraksi (Take Action)", text: "Anak muda jangan menunggu ide sempurna. Mulailah bertindak menyelesaikan masalah kecil di sekitar agar jaringan dan pengalaman terbentuk." },
                { time: "35:28", label: "Tiga Modal Utama", text: "Modal bukan hanya uang. Ada networking (jaringan), knowledge (ilmu), dan finansial (uang). Mulai dari yang paling mungkin dicapai." },
                { time: "40:28 - 42:45", label: "Budaya Berpikir Kritis", text: "Pesan utama bagi para Ketua OSIS: selalu berpikir mendalam dan berani meragukan status quo untuk melahirkan solusi terbaik." }
            ]
        },
        {
            id: "xorTCWOmiZE",
            tag: "Filosofi Gerakan",
            title: "Mengapa Kita Harus Menjadi Bung Hatta?",
            subtitle: "Latar belakang dan visi Hatta Aksara Project membangun masyarakat kooperatif di Indonesia.",
            speaker: "Inisiator Hatta Aksara Project",
            speakerRole: "Diskursus Kebangsaan & Nilai Gerakan",
            duration: "20:25",
            coverImg: "https://i.ytimg.com/vi/xorTCWOmiZE/hq720.jpg",
            youtubeUrl: "https://www.youtube.com/watch?v=xorTCWOmiZE",
            embedUrl: "https://www.youtube-nocookie.com/embed/xorTCWOmiZE?autoplay=1&rel=0",
            desc: "Refleksi filosofis mengenai urgensi kepekaan sosial, pembentukan lingkungan berkarakter, dan alasan mengapa Bung Hatta adalah figur teladan yang paling relevan bagi generasi muda.",
            points: [
                { time: "0:48 - 2:58", label: "Empati & Kesadaran Sosial", text: "Menyadarkan generasi muda bahwa manusia tidak hidup sendiri; sandang, pangan, hingga akses teknologi melibatkan peran orang lain." },
                { time: "3:50 - 5:36", label: "Menjawab Individualisme", text: "Di era serba gawai, Hatta Aksara hadir sebagai ruang sosial untuk menumbuhkan kembali kepekaan terhadap lingkungan sekitar." },
                { time: "7:50 - 10:23", label: "Lingkungan Pembentuk Karakter", text: "Merujuk pemikiran Buya Hamka dan Eric Weiner ('Geography of Genius'): tokoh besar lahir karena lingkungan dan budaya yang mendukung." },
                { time: "12:07 - 16:06", label: "Mengapa Bung Hatta?", text: "Bung Hatta sangat melekat dengan nilai keadilan, orientasi publik, dan sikap kooperatif. Role model tepat penyeimbang ego pribadi." },
                { time: "17:39 - 18:41", label: "Langkah Konkret ISLT", text: "Melalui ISLT, proyek ini mencetak Hatta-Hatta Muda yang berkarakter kuat, berjiwa sosial tinggi, dan siap berkontribusi bagi negeri." }
            ]
        }
    ];

    let currentVideoIndex = 0;

    function renderVideoDetails(video) {
        document.getElementById('coverVideoTitle').innerText = video.title;
        document.getElementById('coverVideoSubtitle').innerText = video.subtitle;
        document.getElementById('coverVideoTag').innerText = video.tag;
        document.getElementById('coverVideoDuration').innerHTML = '<i class="fa-regular fa-clock"></i> ' + video.duration;
        
        const cover = document.getElementById('videoPlaceholderCover');
        cover.style.background = "radial-gradient(circle, rgba(31,13,66,0.7) 0%, rgba(12,0,34,0.92) 100%), url('" + video.coverImg + "') center/cover no-repeat";

        document.getElementById('detailSpeakerName').innerText = video.speaker;
        document.getElementById('detailSpeakerRole').innerText = video.speakerRole;
        document.getElementById('detailDescription').innerText = video.desc;
        document.getElementById('detailYoutubeBtn').href = video.youtubeUrl;

        const pointsContainer = document.getElementById('detailPointsContainer');
        pointsContainer.innerHTML = '';
        video.points.forEach(pt => {
            const row = document.createElement('div');
            row.className = 'point-item';
            row.innerHTML = '<span class="point-badge">' + pt.time + '</span><div><strong style="color:var(--text-main); margin-right:4px;">' + pt.label + ':</strong><span style="color:var(--text-muted);">' + pt.text + '</span></div>';
            pointsContainer.appendChild(row);
        });
    }

    function switchVideo(index) {
        currentVideoIndex = index;
        const video = videos[index];

        document.querySelectorAll('.playlist-item').forEach((item, idx) => {
            if (idx === index) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        renderVideoDetails(video);

        const iframe = document.getElementById('videoIframe');
        const cover = document.getElementById('videoPlaceholderCover');
        if (iframe.style.display !== 'none') {
            iframe.src = video.embedUrl;
        }
    }

    function playCurrentVideo() {
        const cover = document.getElementById('videoPlaceholderCover');
        const iframe = document.getElementById('videoIframe');
        const video = videos[currentVideoIndex];

        cover.style.display = 'none';
        iframe.style.display = 'block';
        iframe.src = video.embedUrl;
    }

    // Initialize initial video details on page load
    document.addEventListener('DOMContentLoaded', function() {
        if (videos && videos.length > 0) {
            renderVideoDetails(videos[0]);
        }
    });

    // Lightbox Controls
    function openLightbox(imgSrc, caption) {
        document.getElementById('lightboxImg').src = imgSrc;
        document.getElementById('lightboxCaption').innerText = caption;
        document.getElementById('galleryLightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox(e) {
        if (e && e.target !== document.getElementById('galleryLightbox') && !e.target.classList.contains('modal-close-btn')) {
            return;
        }
        document.getElementById('galleryLightbox').classList.remove('active');
        document.body.style.overflow = '';
    }
</script>
@endpush
