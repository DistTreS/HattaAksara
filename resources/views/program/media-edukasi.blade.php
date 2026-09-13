@extends('layouts.app')

@section('title', 'Media Edukasi & Repositori Video Hatta Aksara')

@push('styles')
<style>
    .media-hero {
        background: radial-gradient(circle at top right, #1F0D42 0%, #0C0022 100%);
        color: white;
        padding: 85px 0 70px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(115,0,255,0.25);
    }
    .media-hero::before {
        content: '';
        position: absolute;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(115,0,255,0.22) 0%, transparent 70%);
        top: -120px;
        left: 50%;
        transform: translateX(-50%);
        pointer-events: none;
    }
    .channel-banner-card {
        background: #ffffff;
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-subtle);
        box-shadow: 0 12px 36px rgba(115,0,255,0.06);
        padding: 32px 36px;
        margin-top: -45px;
        position: relative;
        z-index: 5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 24px;
    }
    .video-card-full {
        background: #ffffff;
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-subtle);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1.1fr 1.4fr;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .video-card-full:hover {
        transform: translateY(-4px);
        border-color: var(--violet-primary);
        box-shadow: 0 16px 40px rgba(115,0,255,0.12);
    }
    .video-thumb-container {
        position: relative;
        aspect-ratio: 16 / 9;
        background: #0C0022;
        overflow: hidden;
        cursor: pointer;
    }
    .video-thumb-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .video-card-full:hover .video-thumb-container img {
        transform: scale(1.04);
    }
    .video-thumb-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(12,0,34,0.2) 0%, rgba(12,0,34,0.75) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .play-circle-btn {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--violet-primary);
        color: white;
        border: 3px solid rgba(255,255,255,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: var(--shadow-violet);
        transition: transform 0.25s ease, background 0.25s ease;
    }
    .video-thumb-container:hover .play-circle-btn {
        transform: scale(1.12);
        background: var(--violet-light);
    }
    .timestamp-badge {
        background: rgba(115,0,255,0.1);
        color: var(--violet-primary);
        font-weight: 700;
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 6px;
        border: 1px solid rgba(115,0,255,0.2);
        flex-shrink: 0;
        white-space: nowrap;
    }
    .timestamp-row {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        padding: 8px 12px;
        border-radius: 8px;
        background: #faf7fc;
        font-size: 0.85rem;
        line-height: 1.5;
    }
    /* Modal Video Player */
    .video-modal {
        position: fixed;
        inset: 0;
        background: rgba(12, 0, 34, 0.92);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .video-modal.active {
        display: flex;
    }
    .video-modal-wrap {
        width: 100%;
        max-width: 920px;
        background: #0C0022;
        border-radius: var(--radius-xl);
        overflow: hidden;
        border: 1px solid rgba(115,0,255,0.3);
        box-shadow: 0 25px 60px rgba(0,0,0,0.6);
        position: relative;
    }
    .video-modal-close {
        position: absolute;
        top: 14px;
        right: 18px;
        background: rgba(255,255,255,0.15);
        color: white;
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        font-size: 1.2rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: background 0.2s;
    }
    .video-modal-close:hover {
        background: var(--violet-primary);
    }
    @media (max-width: 900px) {
        .video-card-full {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<!-- Header Section -->
<header class="media-hero text-center">
    <div class="container" style="max-width: 860px; position:relative; z-index:2;">
        <span class="section-tag" style="background:rgba(115,0,255,0.35); color:#ffffff; border-color:var(--violet-light);">
            Ekosistem Audio-Visual Resmi
        </span>
        <h1 style="font-family: var(--font-display); font-size: clamp(2.2rem, 4.5vw, 3.2rem); margin: 16px 0; line-height: 1.2; font-weight:800;">
            Media Edukasi & Repositori Video Bung Hatta
        </h1>
        <p style="font-size: 1.1rem; color: #D5CEE8; line-height: 1.7; max-width: 720px; margin: 0 auto;">
            Menyajikan rekaman pidato kebangsaan, materi pembekalan pilar Indonesian Students Leadership Training (ISLT), dan narasi filosofis menuju masyarakat kooperatif.
        </p>
    </div>
</header>

<div class="container" style="padding-bottom: 90px;">
    <!-- YouTube Official Channel Card -->
    <div class="channel-banner-card">
        <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
            <div style="width: 68px; height: 68px; border-radius: 50%; background: #0C0022; border: 2px solid var(--violet-primary); display: flex; align-items: center; justify-content: center; color: #ef4444; font-size: 2.3rem; box-shadow: 0 8px 24px rgba(239,68,68,0.2);">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <h3 style="font-family: var(--font-display); font-size: 1.35rem; font-weight: 700; color: var(--slate-900); margin: 0;">
                        Hatta Aksara Project Official Channel
                    </h3>
                    <i class="fa-solid fa-circle-check" style="color:var(--violet-primary); font-size:1.1rem;" title="Terverifikasi"></i>
                </div>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin: 4px 0 0;">
                    Kanal dokumentasi, materi kepemimpinan, dan arsip intelektual Hatta Aksara Project.
                </p>
            </div>
        </div>

        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <a href="https://www.youtube.com/@hattaaksaraproject" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="border-color: rgba(239,68,68,0.4); color: var(--text-main);">
                <i class="fa-brands fa-youtube" style="color:#ef4444;"></i> Buka @hattaaksaraproject
            </a>
            <a href="https://www.youtube.com/@hattaaksaraproject?sub_confirmation=1" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="padding: 10px 24px;">
                <i class="fa-solid fa-bell"></i> Subscribe Kanal
            </a>
        </div>
    </div>

    <!-- Video Showcase Header -->
    <div style="margin: 65px 0 35px; text-align: center;">
        <span class="section-tag">Kurikulum & Wacana</span>
        <h2 class="section-title">5 Seri Tayangan Pembekalan Utama</h2>
        <p class="section-desc">
            Pelajari setiap materi secara mendalam melalui tayangan video lengkap berikut panduan linimasa pokok pikiran.
        </p>
    </div>

    <!-- List of 5 Full Video Cards -->
    <div style="display: flex; flex-direction: column; gap: 40px;">

        <!-- Video 1: Inspiring Speech Ibu Meutia Farida Hatta -->
        <article class="video-card-full">
            <div class="video-thumb-container" onclick="openVideoModal('4_arGLyBZqQ', 'Inspiring Speech dari Ibu Meutia Farida Hatta')">
                <img src="https://i.ytimg.com/vi/4_arGLyBZqQ/hq720.jpg" alt="Inspiring Speech dari Ibu Meutia Farida Hatta">
                <div class="video-thumb-overlay">
                    <div class="play-circle-btn"><i class="fa-solid fa-play" style="margin-left:4px;"></i></div>
                </div>
                <div style="position: absolute; bottom: 12px; left: 12px; display: flex; gap: 8px;">
                    <span style="background: rgba(12,0,34,0.85); color: white; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 15px;">
                        <i class="fa-regular fa-clock"></i> 16:09
                    </span>
                    <span style="background: var(--violet-primary); color: white; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 15px;">
                        Pidato Kehormatan
                    </span>
                </div>
            </div>
            <div style="padding: 30px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom: 8px;">
                        <span style="font-size:0.8rem; font-weight:700; color:var(--violet-primary); text-transform:uppercase; letter-spacing:0.06em;">Pembukaan ISLT 2026</span>
                    </div>
                    <h3 style="font-family: var(--font-display); font-size: 1.35rem; font-weight: 700; line-height: 1.35; margin-bottom: 10px; color: var(--slate-900);">
                        Inspiring Speech dari Ibu Meutia Farida Hatta, Anak Proklamator Kemerdekaan Indonesia Mohammad Hatta
                    </h3>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                        <i class="fa-solid fa-user-pen" style="color:var(--violet-primary);"></i>
                        <span style="font-size: 0.88rem; font-weight: 600; color: var(--text-main);">Prof. Dr. Meutia Farida Hatta Swasono</span>
                        <span style="color: var(--text-muted);">&bull;</span>
                        <span style="font-size: 0.82rem; color: var(--text-muted);">Putri Proklamator Bung Hatta / Guru Besar UI</span>
                    </div>
                    <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 18px;">
                        Pidato inspiratif mengenai mandat moral kepemimpinan pemuda, peneguhan Bung Hatta sebagai perancang konstitusi berjiwa kooperatif, dan panggilan persatuan hati melampaui sekat wilayah.
                    </p>

                    <!-- Timestamp Highlights -->
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                        <div class="timestamp-row">
                            <span class="timestamp-badge">0:20 - 0:50</span>
                            <div><strong>Tujuan ISLT 2026:</strong> Melatih pemimpin berempati sosial, berkesadaran kebangsaan, dan berkarakter keteladanan Bung Hatta.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">1:13 - 2:28</span>
                            <div><strong>Pemikiran Bung Hatta:</strong> "The father of the founding fathers" yang merancang sendi hukum dasar UUD 1945.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">2:30 - 3:04</span>
                            <div><strong>Masyarakat Kooperatif:</strong> Mengokohkan kembali gotong-royong, musyawarah, dan solidaritas sosial.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">6:32 - 11:57</span>
                            <div><strong>Pesan Pemimpin Muda:</strong> Pentingnya persatuan hati serta tindakan nyata yang bermanfaat bagi masyarakat sekitar.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">13:42 - 15:52</span>
                            <div><strong>Indonesia Emas 2045:</strong> Percaya diri mengelola anugerah alam dan SDM tanpa rasa rendah diri terhadap bangsa asing.</div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <button onclick="openVideoModal('4_arGLyBZqQ', 'Inspiring Speech Ibu Meutia Farida Hatta')" class="btn btn-primary" style="padding: 9px 20px; font-size: 0.88rem;">
                        <i class="fa-solid fa-play"></i> Putar Video di Sini
                    </button>
                    <a href="https://www.youtube.com/watch?v=4_arGLyBZqQ" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="padding: 9px 18px; font-size: 0.88rem;">
                        <i class="fa-brands fa-youtube" style="color:#ef4444;"></i> Buka di YouTube
                    </a>
                </div>
            </div>
        </article>

        <!-- Video 2: ISLT 2025 Menuju Masyarakat Kooperatif -->
        <article class="video-card-full">
            <div class="video-thumb-container" onclick="openVideoModal('KfYjfXxEnmk', 'ISLT 2025 Menuju Masyarakat Kooperatif')">
                <img src="https://i.ytimg.com/vi/KfYjfXxEnmk/hq720.jpg" alt="ISLT 2025 Menuju Masyarakat Kooperatif">
                <div class="video-thumb-overlay">
                    <div class="play-circle-btn"><i class="fa-solid fa-play" style="margin-left:4px;"></i></div>
                </div>
                <div style="position: absolute; bottom: 12px; left: 12px; display: flex; gap: 8px;">
                    <span style="background: rgba(12,0,34,0.85); color: white; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 15px;">
                        <i class="fa-regular fa-clock"></i> 08:05
                    </span>
                    <span style="background: var(--violet-primary); color: white; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 15px;">
                        Visi & Refleksi ISLT
                    </span>
                </div>
            </div>
            <div style="padding: 30px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom: 8px;">
                        <span style="font-size:0.8rem; font-weight:700; color:var(--violet-primary); text-transform:uppercase; letter-spacing:0.06em;">Manifesto Gerakan Kepemimpinan</span>
                    </div>
                    <h3 style="font-family: var(--font-display); font-size: 1.35rem; font-weight: 700; line-height: 1.35; margin-bottom: 10px; color: var(--slate-900);">
                        ISLT 2025 Menuju Masyarakat Kooperatif
                    </h3>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                        <i class="fa-solid fa-users" style="color:var(--violet-primary);"></i>
                        <span style="font-size: 0.88rem; font-weight: 600; color: var(--text-main);">Keluarga Besar Hatta Aksara & Kader Hatta Muda</span>
                    </div>
                    <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 18px;">
                        Tayangan artistik dan puitis yang menyalakan kembali harapan di tengah kegelapan, merajut kebersamaan, dan menegaskan komitmen menuju masyarakat kooperatif berfondasikan lagu kebangsaan Indonesia Pusaka.
                    </p>

                    <!-- Timestamp Highlights -->
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                        <div class="timestamp-row">
                            <span class="timestamp-badge">0:17 - 5:00</span>
                            <div><strong>Pesan Inspiratif:</strong> Narasi puitis mengatasi kesulitan dan melepaskan beban masa lalu untuk melangkah maju menuju harapan.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">2:03 - 2:20</span>
                            <div><strong>Semangat Kolektif:</strong> Menjadikan kebersamaan dan musyawarah gotong-royong sebagai kunci menggapai masa depan.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">6:58 - 8:05</span>
                            <div><strong>Sentuhan Budaya:</strong> Penutup lagu Indonesia Pusaka yang menggetarkan rasa cinta tanah air sebagai fondasi bangsa.</div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <button onclick="openVideoModal('KfYjfXxEnmk', 'ISLT 2025 Menuju Masyarakat Kooperatif')" class="btn btn-primary" style="padding: 9px 20px; font-size: 0.88rem;">
                        <i class="fa-solid fa-play"></i> Putar Video di Sini
                    </button>
                    <a href="https://www.youtube.com/watch?v=KfYjfXxEnmk" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="padding: 9px 18px; font-size: 0.88rem;">
                        <i class="fa-brands fa-youtube" style="color:#ef4444;"></i> Buka di YouTube
                    </a>
                </div>
            </div>
        </article>

        <!-- Video 3: Kepemimpinan Empati — Pilar I ISLT -->
        <article class="video-card-full">
            <div class="video-thumb-container" onclick="openVideoModal('FL4FSSxFjCg', 'Kepemimpinan Empati — Pilar I ISLT')">
                <img src="https://i.ytimg.com/vi/FL4FSSxFjCg/hq720.jpg" alt="Kepemimpinan Empati — Pilar I ISLT">
                <div class="video-thumb-overlay">
                    <div class="play-circle-btn"><i class="fa-solid fa-play" style="margin-left:4px;"></i></div>
                </div>
                <div style="position: absolute; bottom: 12px; left: 12px; display: flex; gap: 8px;">
                    <span style="background: rgba(12,0,34,0.85); color: white; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 15px;">
                        <i class="fa-regular fa-clock"></i> 08:59
                    </span>
                    <span style="background: var(--violet-primary); color: white; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 15px;">
                        Pilar I ISLT
                    </span>
                </div>
            </div>
            <div style="padding: 30px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom: 8px;">
                        <span style="font-size:0.8rem; font-weight:700; color:var(--violet-primary); text-transform:uppercase; letter-spacing:0.06em;">Kurikulum Kepemimpinan Moral</span>
                    </div>
                    <h3 style="font-family: var(--font-display); font-size: 1.35rem; font-weight: 700; line-height: 1.35; margin-bottom: 10px; color: var(--slate-900);">
                        Kepemimpinan Empati — Pilar I ISLT
                    </h3>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                        <i class="fa-solid fa-chalkboard-user" style="color:var(--violet-primary);"></i>
                        <span style="font-size: 0.88rem; font-weight: 600; color: var(--text-main);">Fauzan Akiar</span>
                        <span style="color: var(--text-muted);">&bull;</span>
                        <span style="font-size: 0.82rem; color: var(--text-muted);">Direktur Estafet Kepemimpinan Indonesia</span>
                    </div>
                    <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 18px;">
                        Membedah mengapa empati adalah pilar fundamental yang membedakan pemimpin biasa dengan negarawan sejati. Tanggung jawab moral individu adalah benteng penangkal korupsi dan penyalahgunaan wewenang.
                    </p>

                    <!-- Timestamp Highlights -->
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                        <div class="timestamp-row">
                            <span class="timestamp-badge">1:20 - 1:53</span>
                            <div><strong>Kepemimpinan sebagai Proses:</strong> Pemimpin bukanlah bakat lahir, melainkan keterampilan yang dilatih berkesinambungan.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">2:55 - 3:31</span>
                            <div><strong>Individu vs Sistem:</strong> Menyikapi penyimpangan kekuasaan melalui kompas tanggung jawab moral individu.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">6:36 - 7:20</span>
                            <div><strong>Melampaui Hak & Kewajiban:</strong> Membangun kepekaan merasakan penderitaan sesama sebagai acuan kebijakan.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">7:42 - 8:12</span>
                            <div><strong>Tanggung Jawab Moral:</strong> Mendahulukan kepentingan umum di atas kepentingan pribadi dan kelompok.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">8:25 - 8:56</span>
                            <div><strong>Menyongsong Indonesia Emas 2045:</strong> Harapan lahirnya pemimpin masa depan berintegritas lewat kawah candradimuka ISLT.</div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <button onclick="openVideoModal('FL4FSSxFjCg', 'Kepemimpinan Empati — Pilar I ISLT')" class="btn btn-primary" style="padding: 9px 20px; font-size: 0.88rem;">
                        <i class="fa-solid fa-play"></i> Putar Video di Sini
                    </button>
                    <a href="https://www.youtube.com/watch?v=FL4FSSxFjCg" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="padding: 9px 18px; font-size: 0.88rem;">
                        <i class="fa-brands fa-youtube" style="color:#ef4444;"></i> Buka di YouTube
                    </a>
                </div>
            </div>
        </article>

        <!-- Video 4: Social Problem Solving | Pilar ISLT -->
        <article class="video-card-full">
            <div class="video-thumb-container" onclick="openVideoModal('4bcwLaUQONI', 'Social Problem Solving | Pilar ISLT')">
                <img src="https://i.ytimg.com/vi/4bcwLaUQONI/hq720.jpg" alt="Social Problem Solving | Pilar ISLT">
                <div class="video-thumb-overlay">
                    <div class="play-circle-btn"><i class="fa-solid fa-play" style="margin-left:4px;"></i></div>
                </div>
                <div style="position: absolute; bottom: 12px; left: 12px; display: flex; gap: 8px;">
                    <span style="background: rgba(12,0,34,0.85); color: white; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 15px;">
                        <i class="fa-regular fa-clock"></i> 43:24
                    </span>
                    <span style="background: var(--violet-primary); color: white; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 15px;">
                        Pilar II ISLT
                    </span>
                </div>
            </div>
            <div style="padding: 30px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom: 8px;">
                        <span style="font-size:0.8rem; font-weight:700; color:var(--violet-primary); text-transform:uppercase; letter-spacing:0.06em;">Kewirausahaan Berdampak Sosial</span>
                    </div>
                    <h3 style="font-family: var(--font-display); font-size: 1.35rem; font-weight: 700; line-height: 1.35; margin-bottom: 10px; color: var(--slate-900);">
                        Social Problem Solving | Pilar ISLT
                    </h3>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                        <i class="fa-solid fa-lightbulb" style="color:var(--violet-primary);"></i>
                        <span style="font-size: 0.88rem; font-weight: 600; color: var(--text-main);">Ahmad Hafidz</span>
                        <span style="color: var(--text-muted);">&bull;</span>
                        <span style="font-size: 0.82rem; color: var(--text-muted);">CEO Witbox</span>
                    </div>
                    <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 18px;">
                        Diskusi menyeluruh yang menjembatani empati dengan penyelesaian masalah nyata di masyarakat. Membuka cakrawala bisnis berkelanjutan yang berfokus memberi manfaat nyata, bukan semata laba materiil.
                    </p>

                    <!-- Timestamp Highlights -->
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                        <div class="timestamp-row">
                            <span class="timestamp-badge">4:31</span>
                            <div><strong>Definisi Masalah:</strong> Masalah adalah panggilan untuk diselesaikan, bagian wajar dari pertumbuhan kehidupan.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">10:31 - 11:03</span>
                            <div><strong>Bisnis vs Sosial:</strong> Tidak ada dikotomi; bisnis berkualitas wajib membawa benefit sosial bagi masyarakat.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">17:42 - 17:50</span>
                            <div><strong>Pentingnya Empati:</strong> Memahami manusia sebelum merancang pasar sebagai inti dari konsep design thinking.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">28:25 & 31:12</span>
                            <div><strong>Take Action (Beraksi):</strong> Jangan tunggu ide sempurna; selesaikan problem kecil di lingkungan sekitar Anda.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">35:28</span>
                            <div><strong>3 Modal Utama:</strong> Jaringan (Networking), Ilmu (Knowledge), dan Finansial. Mulailah dari modal yang Anda punya.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">40:28 - 42:45</span>
                            <div><strong>Budaya Berpikir Ketua OSIS:</strong> Kualitas hidup dan kepemimpinan ditentukan dari kemampuan meragukan status quo.</div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <button onclick="openVideoModal('4bcwLaUQONI', 'Social Problem Solving | Pilar ISLT')" class="btn btn-primary" style="padding: 9px 20px; font-size: 0.88rem;">
                        <i class="fa-solid fa-play"></i> Putar Video di Sini
                    </button>
                    <a href="https://www.youtube.com/watch?v=4bcwLaUQONI" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="padding: 9px 18px; font-size: 0.88rem;">
                        <i class="fa-brands fa-youtube" style="color:#ef4444;"></i> Buka di YouTube
                    </a>
                </div>
            </div>
        </article>

        <!-- Video 5: Mengapa Kita Harus Menjadi Bung Hatta? -->
        <article class="video-card-full">
            <div class="video-thumb-container" onclick="openVideoModal('xorTCWOmiZE', 'Mengapa Kita Harus Menjadi Bung Hatta?')">
                <img src="https://i.ytimg.com/vi/xorTCWOmiZE/hq720.jpg" alt="Mengapa Kita Harus Menjadi Bung Hatta?">
                <div class="video-thumb-overlay">
                    <div class="play-circle-btn"><i class="fa-solid fa-play" style="margin-left:4px;"></i></div>
                </div>
                <div style="position: absolute; bottom: 12px; left: 12px; display: flex; gap: 8px;">
                    <span style="background: rgba(12,0,34,0.85); color: white; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 15px;">
                        <i class="fa-regular fa-clock"></i> 20:25
                    </span>
                    <span style="background: var(--violet-primary); color: white; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 15px;">
                        Filosofi Gerakan
                    </span>
                </div>
            </div>
            <div style="padding: 30px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom: 8px;">
                        <span style="font-size:0.8rem; font-weight:700; color:var(--violet-primary); text-transform:uppercase; letter-spacing:0.06em;">Refleksi Historis Kebangsaan</span>
                    </div>
                    <h3 style="font-family: var(--font-display); font-size: 1.35rem; font-weight: 700; line-height: 1.35; margin-bottom: 10px; color: var(--slate-900);">
                        Mengapa Kita Harus Menjadi Bung Hatta?
                    </h3>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                        <i class="fa-solid fa-book-open-reader" style="color:var(--violet-primary);"></i>
                        <span style="font-size: 0.88rem; font-weight: 600; color: var(--text-main);">Inisiator Hatta Aksara Project</span>
                    </div>
                    <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 18px;">
                        Telaah mendalam latar belakang berdirinya Hatta Aksara Project. Menjawab tantangan individualisme di era digital serta menelusuri bagaimana lingkungan dan karakter Mohammad Hatta mampu menyeimbangkan ego demi kepentingan bangsa.
                    </p>

                    <!-- Timestamp Highlights -->
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                        <div class="timestamp-row">
                            <span class="timestamp-badge">0:48 - 2:58</span>
                            <div><strong>Empati & Kesadaran Sosial:</strong> Menyadarkan bahwa hidup kita senantiasa melibatkan peran jutaan orang lain.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">3:50 - 5:36</span>
                            <div><strong>Menjawab Individualisme:</strong> Penawar ketergantungan gawai digital untuk menumbuhkan kembali kepekaan lingkungan.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">7:50 - 10:23</span>
                            <div><strong>Lingkungan Pembentuk Karakter:</strong> Merujuk Buya Hamka & Eric Weiner: tokoh besar lahir dari ekosistem yang kondusif.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">12:07 - 16:06</span>
                            <div><strong>Mengapa Bung Hatta?:</strong> Figur teladan paling lekat dengan keadilan, integritas, dan orientasi publik tanpa pamrih.</div>
                        </div>
                        <div class="timestamp-row">
                            <span class="timestamp-badge">17:39 - 18:41</span>
                            <div><strong>Mencetak Hatta Muda:</strong> Ikhtiar ISLT dalam membekali calon pemimpin muda berkarakter tangguh untuk Indonesia.</div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <button onclick="openVideoModal('xorTCWOmiZE', 'Mengapa Kita Harus Menjadi Bung Hatta?')" class="btn btn-primary" style="padding: 9px 20px; font-size: 0.88rem;">
                        <i class="fa-solid fa-play"></i> Putar Video di Sini
                    </button>
                    <a href="https://www.youtube.com/watch?v=xorTCWOmiZE" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="padding: 9px 18px; font-size: 0.88rem;">
                        <i class="fa-brands fa-youtube" style="color:#ef4444;"></i> Buka di YouTube
                    </a>
                </div>
            </div>
        </article>

    </div>

    <!-- Ecosystem Vision Pillars -->
    <div style="background: white; border-radius: 20px; padding: 45px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-subtle); margin: 70px 0 50px;">
        <h2 style="font-family: var(--font-display); font-size: 1.9rem; color: var(--slate-900); margin-bottom: 14px; font-weight:800;">
            Tridharma Ekosistem Hatta Aksara Project
        </h2>
        <p style="color: var(--text-muted); font-size: 1.02rem; line-height: 1.8; margin-bottom: 24px;">
            Selain kanal video edukasi, portal digital <strong>Hatta Aksara Project</strong> mengintegrasikan tiga instrumen pengkaderan dan publikasi pemikiran:
        </p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div style="background:#FAF7FC; padding:24px; border-radius:14px; border-left:4px solid var(--violet-primary);">
                <strong style="color:var(--slate-900); font-size:1.05rem; display:block; margin-bottom:8px;">1. Publikasi Esai & Gagasan</strong>
                <p style="font-size:0.88rem; color:var(--text-muted); line-height:1.65; margin-bottom:12px;">Menampung analisis kritis ketua OSIS dan alumni Hatta Muda mengenai isu koperasi, kemandirian pemuda, dan kebangsaan.</p>
                <a href="{{ route('artikel.index') }}" style="color:var(--violet-primary); font-weight:700; font-size:0.85rem;">Jelajahi Artikel &rarr;</a>
            </div>
            <div style="background:#FAF7FC; padding:24px; border-radius:14px; border-left:4px solid #10b981;">
                <strong style="color:var(--slate-900); font-size:1.05rem; display:block; margin-bottom:8px;">2. Pelaporan Aksi Nyata</strong>
                <p style="font-size:0.88rem; color:var(--text-muted); line-height:1.65; margin-bottom:12px;">Dokumentasi inisiatif pengabdian masyarakat, kepengurusan OSIS berintegritas, dan aksi sosial di 38 provinsi.</p>
                <a href="{{ route('berita.index', ['type' => 'aksi_hatta_muda']) }}" style="color:#10b981; font-weight:700; font-size:0.85rem;">Lihat Berita Aksi &rarr;</a>
            </div>
            <div style="background:#FAF7FC; padding:24px; border-radius:14px; border-left:4px solid #f59e0b;">
                <strong style="color:var(--slate-900); font-size:1.05rem; display:block; margin-bottom:8px;">3. Perpustakaan Terbuka (E-Jurnal)</strong>
                <p style="font-size:0.88rem; color:var(--text-muted); line-height:1.65; margin-bottom:12px;">Akses unduh terbuka terhadap naskah risalah Mohammad Hatta, silabus kepemimpinan ISLT, dan materi modul pelatihan.</p>
                <a href="{{ route('ejurnal.index') }}" style="color:#d97706; font-weight:700; font-size:0.85rem;">Kunjungi E-Jurnal &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Alumni Call to Action -->
    <div style="background: radial-gradient(circle at top right, #240C4C 0%, #0C0022 100%); border-radius: 24px; padding: 55px 40px; color: white; border: 1px solid rgba(115,0,255,0.3); text-align: center; box-shadow:0 16px 40px rgba(12,0,34,0.4);">
        <span class="section-tag" style="background:rgba(115,0,255,0.3); color:white; border-color:var(--violet-light);">
            Jejaring Kepemimpinan Pemuda
        </span>
        <h2 style="font-family: var(--font-display); font-size: clamp(1.8rem, 3.5vw, 2.3rem); margin: 14px 0 16px; font-weight:800;">
            Apakah Anda Alumni Pelatihan ISLT?
        </h2>
        <p style="color: #C8BFDB; font-size: 1.02rem; max-width: 680px; margin: 0 auto 32px; line-height: 1.7;">
            <strong>Hatta Muda</strong> adalah sebutan kehormatan bagi alumni Indonesian Students Leadership Training. Daftarkan akun alumni Anda untuk mempublikasikan artikel opini, membagikan laporan aksi kepemimpinan, dan terhubung dengan jejaring pemimpin muda 38 provinsi.
        </p>
        <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap;">
            <a href="{{ route('register.hatta-muda') }}" class="btn btn-primary" style="font-size: 1rem; padding: 13px 32px;">
                <i class="fa-solid fa-user-plus"></i> Registrasi Alumni Hatta Muda
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline" style="color:white; border-color:rgba(255,255,255,0.4);">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Akun
            </a>
        </div>
    </div>
</div>

<!-- Interactive Video Modal -->
<div class="video-modal" id="globalVideoModal" onclick="handleModalBackdropClick(event)">
    <div class="video-modal-wrap">
        <button class="video-modal-close" onclick="closeVideoModal()">&times;</button>
        <div style="position:relative; aspect-ratio:16/9; width:100%; background:#000;">
            <iframe id="modalVideoIframe" src="" style="width:100%; height:100%; border:none;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div style="padding:20px 26px; background:#0C0022; border-top:1px solid rgba(115,0,255,0.2); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
            <div>
                <h4 id="modalVideoTitle" style="color:white; font-family:var(--font-display); font-size:1.15rem; margin:0 0 4px; font-weight:700;"></h4>
                <span style="font-size:0.82rem; color:#A99FC0;">Kanal YouTube Resmi @hattaaksaraproject</span>
            </div>
            <a id="modalExternalLink" href="" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="color:white; border-color:rgba(255,255,255,0.3); font-size:0.82rem; padding:6px 14px;">
                <i class="fa-brands fa-youtube" style="color:#ef4444;"></i> Buka di YouTube
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openVideoModal(videoId, title) {
        const modal = document.getElementById('globalVideoModal');
        const iframe = document.getElementById('modalVideoIframe');
        const titleEl = document.getElementById('modalVideoTitle');
        const linkEl = document.getElementById('modalExternalLink');

        iframe.src = "https://www.youtube-nocookie.com/embed/" + videoId + "?autoplay=1&rel=0";
        titleEl.innerText = title;
        linkEl.href = "https://www.youtube.com/watch?v=" + videoId;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeVideoModal() {
        const modal = document.getElementById('globalVideoModal');
        const iframe = document.getElementById('modalVideoIframe');
        iframe.src = "";
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function handleModalBackdropClick(e) {
        if (e.target === document.getElementById('globalVideoModal')) {
            closeVideoModal();
        }
    }

    // Keyboard ESC to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeVideoModal();
        }
    });
</script>
@endpush
