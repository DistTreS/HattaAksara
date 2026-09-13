@extends('layouts.app')

@section('title', 'Indonesian Students Leadership Training (ISLT)')

@push('styles')
<style>
    .islt-hero {
        background: radial-gradient(circle at top right, #240C4C 0%, #0C0022 100%);
        color: white;
        padding: 85px 0;
        border-bottom: 1px solid rgba(115, 0, 255, 0.25);
        text-align: center;
        position: relative;
    }
    .pillar-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 30px;
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-subtle);
        transition: all 0.3s;
    }
    .pillar-card:hover {
        transform: translateY(-5px);
        border-color: var(--gold-primary);
        box-shadow: var(--shadow-elevated);
    }
    .pillar-icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        background: rgba(122, 22, 30, 0.1);
        color: var(--maroon-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 20px;
    }
    .islt-video-card {
        background: #0f172a;
        border-radius: var(--radius-xl);
        overflow: hidden;
        border: 2px solid rgba(197, 155, 39, 0.3);
        box-shadow: var(--shadow-elevated);
        margin: 50px 0;
    }
    .islt-video-responsive {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
    }
    .islt-video-responsive iframe,
    .islt-video-responsive .video-cover-trigger {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
    .video-cover-trigger {
        background: linear-gradient(180deg, rgba(13,19,31,0.5) 0%, rgba(13,19,31,0.95) 100%), url('{{ asset("images/heritage/bukittinggi-napak-tilas.jpg") }}') center/cover;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        text-align: center;
        padding: 20px;
    }
    .islt-play-circle {
        width: 76px;
        height: 76px;
        border-radius: 50%;
        background: var(--gold-primary);
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 16px;
        box-shadow: 0 10px 30px rgba(197, 155, 39, 0.5);
        border: 3px solid white;
        transition: transform 0.3s ease;
    }
    .video-cover-trigger:hover .islt-play-circle {
        transform: scale(1.1);
        background: var(--gold-light);
    }

    @media (max-width: 992px) {
        .islt-overview-grid {
            grid-template-columns: 1fr !important;
            gap: 32px !important;
        }
        .islt-pillars-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@section('content')

<section class="islt-hero">
    <div class="container" style="max-width: 900px;">
        <span class="section-tag" >
            Program Unggulan Nasional
        </span>
        <h1 style="font-family: var(--font-display); font-size: clamp(2.2rem, 5vw, 3.2rem); line-height: 1.2; margin: 16px 0;">
            Indonesian Students Leadership Training (ISLT)
        </h1>
        <p style="font-size: 1.1rem; color: #d1d5db; line-height: 1.7; margin-bottom: 35px;">
            Kawah candradimuka kepemimpinan pemuda bagi ketua-ketua OSIS pilihan dari 38 provinsi di Indonesia. Mempersiapkan generasi pemimpin berkarakter, berintegritas tinggi, dan berjiwa gotong royong.
        </p>
        <div style="display:flex; justify-content:center; gap: 16px; flex-wrap:wrap;">
            <a href="{{ route('program.islt.daftar') }}" class="btn btn-gold" style="font-size: 1rem; padding: 13px 32px;">
                <i class="fa-solid fa-file-signature"></i> Formulir Pendaftaran Peserta ISLT
            </a>
            <a href="{{ route('ejurnal.index') }}" class="btn btn-outline" style="color:white; border-color:rgba(255,255,255,0.4);">
                <i class="fa-solid fa-book"></i> Unduh Silabus ISLT
            </a>
        </div>
    </div>
</section>

<div class="container" style="padding: 70px 0 100px;">
    <!-- Program Summary & Purpose -->
    <div class="islt-overview-grid" style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 45px; align-items: center; margin-bottom: 70px;">
        <div>
            <span class="section-tag">Filosofi Program</span>
            <h2 style="font-family: var(--font-display); font-size: 2.2rem; color: var(--slate-900); margin-bottom: 18px; line-height: 1.3;">
                Mengapa ISLT Diselenggarakan?
            </h2>
            <p style="color: var(--text-muted); font-size: 1.02rem; line-height: 1.8; margin-bottom: 18px;">
                Indonesia membutuhkan regenerasi kepemimpinan yang berakar kuat pada nilai-nilai jati diri bangsa (<em>weltanschauung</em>). Ketua OSIS adalah simpul pemimpin generasi muda yang setiap harinya memimpin ribuan rekan sebayanya di sekolah.
            </p>
            <p style="color: var(--text-muted); font-size: 1.02rem; line-height: 1.8; margin-bottom: 24px;">
                Melalui program ISLT yang diselenggarakan secara independen oleh <strong>Hatta Aksara Project</strong>, para ketua OSIS terpilih dikumpulkan secara nasional untuk menerima pembinaan komprehensif yang tidak hanya mengasah kecakapan organisasi, namun menanamkan kejujuran, kecintaan pada koperasi, dan etika berbangsa ala Bung Hatta.
            </p>
            <div style="border-radius:var(--radius-lg); overflow:hidden; border:1px solid var(--border-subtle); box-shadow:var(--shadow-subtle);">
                <img src="{{ asset('images/heritage/islt-training.jpg') }}" alt="Suasana Pelatihan Kepemimpinan Siswa Nasional" style="width:100%; height:260px; object-fit:cover; display:block;">
                <div style="padding:12px 18px; background:#faf8f5; font-size:0.8rem; color:var(--text-muted); border-top:1px solid var(--border-subtle);">
                    <i class="fa-solid fa-camera" style="color:var(--maroon-primary); margin-right:6px;"></i> Dokumentasi: Sidang Pleno & Musyawarah Ketua OSIS Nusantara
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 20px; padding: 36px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-subtle);">
            <h3 style="font-family: var(--font-display); font-size: 1.35rem; color: var(--maroon-primary); margin-bottom: 20px; border-bottom: 2px solid var(--border-subtle); padding-bottom: 12px;">
                Fokus & Dimensi Pelatihan
            </h3>
            <ul style="list-style: none; display: flex; flex-direction: column; gap: 18px;">
                <li style="display: flex; gap: 14px; align-items: flex-start;">
                    <i class="fa-solid fa-circle-check" style="color: var(--gold-dark); margin-top: 4px; font-size: 1.15rem;"></i>
                    <div>
                        <strong style="color: var(--slate-900);">Weltanschauung & Jati Diri Bangsa:</strong>
                        <p style="font-size: 0.9rem; color: var(--text-muted); line-height:1.6;">Memahami landasan falsafah Pancasila dan keteladanan pendiri bangsa secara mendalam.</p>
                    </div>
                </li>
                <li style="display: flex; gap: 14px; align-items: flex-start;">
                    <i class="fa-solid fa-circle-check" style="color: var(--gold-dark); margin-top: 4px; font-size: 1.15rem;"></i>
                    <div>
                        <strong style="color: var(--slate-900);">Ekonomi Kerakyatan & Koperasi:</strong>
                        <p style="font-size: 0.9rem; color: var(--text-muted); line-height:1.6;">Membangun kebiasaan kooperatif, adil, dan berdaya bersama di lingkungan sekolah.</p>
                    </div>
                </li>
                <li style="display: flex; gap: 14px; align-items: flex-start;">
                    <i class="fa-solid fa-circle-check" style="color: var(--gold-dark); margin-top: 4px; font-size: 1.15rem;"></i>
                    <div>
                        <strong style="color: var(--slate-900);">Napak Tilas Sejarah Perjuangan:</strong>
                        <p style="font-size: 0.9rem; color: var(--text-muted); line-height:1.6;">Mengunjungi situs sejarah kelahiran dan tempat perenungan Bung Hatta di Bukittinggi.</p>
                    </div>
                </li>
                <li style="display: flex; gap: 14px; align-items: flex-start;">
                    <i class="fa-solid fa-circle-check" style="color: var(--gold-dark); margin-top: 4px; font-size: 1.15rem;"></i>
                    <div>
                        <strong style="color: var(--slate-900);">Jejaring Alumni Hatta Muda Connection:</strong>
                        <p style="font-size: 0.9rem; color: var(--text-muted); line-height:1.6;">Tergabung ke wadah persaudaraan alumni se-Indonesia setelah lulus pelatihan.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Interactive YouTube Video Section -->
    <div style="margin: 50px 0 70px;">
        <div class="section-header" style="text-align:center; margin-bottom: 25px;">
            <span class="section-tag">Dokumenter & Kurikulum Video</span>
            <h2 class="section-title">Tayangan Resmi & Pilar Pembelajaran ISLT</h2>
            <p class="section-desc">
                Pelajari materi kepemimpinan empati, problem solving, dan pidato kehormatan dari para tokoh bangsa.
            </p>
        </div>

        <div class="islt-video-card" style="border-color: rgba(115,0,255,0.3); box-shadow: 0 16px 40px rgba(12,0,34,0.35);">
            <div class="islt-video-responsive" id="isltVideoContainer" style="aspect-ratio: 16/9; height: auto; padding-bottom: 0;">
                <div class="video-cover-trigger" id="isltVideoCover" onclick="playIsltVideo()" style="background: linear-gradient(180deg, rgba(12,0,34,0.4) 0%, rgba(12,0,34,0.85) 100%), url('https://i.ytimg.com/vi/KfYjfXxEnmk/hq720.jpg') center/cover; padding: 40px 20px;">
                    <div class="islt-play-circle" style="background: var(--violet-primary); color: white; box-shadow: 0 10px 30px rgba(115,0,255,0.5);">
                        <i class="fa-solid fa-play" style="margin-left: 4px;"></i>
                    </div>
                    <span id="isltVideoTagBadge" style="background: rgba(115,0,255,0.85); color:white; font-size:0.75rem; font-weight:700; padding:4px 14px; border-radius:20px; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:10px;">
                        Visi & Manifesto ISLT
                    </span>
                    <h3 id="isltVideoTitle" style="font-size: clamp(1.2rem, 3vw, 1.6rem); font-family: var(--font-display); font-weight:700; margin-bottom:8px; text-shadow:0 2px 10px rgba(0,0,0,0.8); max-width:700px;">
                        ISLT 2025 Menuju Masyarakat Kooperatif
                    </h3>
                    <p id="isltVideoDesc" style="font-size:0.92rem; color:#cbd5e1; max-width:580px; line-height:1.6; text-shadow:0 1px 6px rgba(0,0,0,0.8);">
                        Tayangan artistik dan puitis yang mengangkat tema harapan, kebersamaan, dan cita-cita luhur menuju Indonesia kooperatif.
                    </p>
                    <span id="isltVideoDuration" style="display:inline-block; margin-top:14px; font-size:0.8rem; background:rgba(0,0,0,0.6); padding:5px 14px; border-radius:20px; border:1px solid rgba(255,255,255,0.3);">
                        <i class="fa-brands fa-youtube" style="color:#ef4444; margin-right:6px;"></i> Putar Video Resmi (08 Menit 05 Detik)
                    </span>
                </div>
                <iframe id="isltVideoIframe" src="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="display:none; width:100%; height:100%; border:none; aspect-ratio:16/9;"></iframe>
            </div>

            <!-- Video Quick Switcher Bar -->
            <div style="background: #0C0022; padding: 18px 24px; border-top: 1px solid rgba(115,0,255,0.2); display: flex; gap: 12px; overflow-x: auto; align-items: center; justify-content: flex-start;">
                <span style="color:#A99FC0; font-size:0.8rem; font-weight:700; text-transform:uppercase; white-space:nowrap; margin-right:6px;">Pilih Tayangan:</span>
                
                <button onclick="switchIsltVideo(0)" id="btnIsltVid0" class="btn islt-vid-pill active" style="font-size:0.8rem; padding:6px 14px; border-radius:20px; background:var(--violet-primary); color:white; border:none; white-space:nowrap; cursor:pointer;">
                    1. Visi ISLT 2025 (08:05)
                </button>
                <button onclick="switchIsltVideo(1)" id="btnIsltVid1" class="btn islt-vid-pill" style="font-size:0.8rem; padding:6px 14px; border-radius:20px; background:rgba(255,255,255,0.1); color:#D5CEE8; border:1px solid rgba(255,255,255,0.15); white-space:nowrap; cursor:pointer;">
                    2. Kepemimpinan Empati — Pilar I (08:59)
                </button>
                <button onclick="switchIsltVideo(2)" id="btnIsltVid2" class="btn islt-vid-pill" style="font-size:0.8rem; padding:6px 14px; border-radius:20px; background:rgba(255,255,255,0.1); color:#D5CEE8; border:1px solid rgba(255,255,255,0.15); white-space:nowrap; cursor:pointer;">
                    3. Social Problem Solving — Pilar II (43:24)
                </button>
                <button onclick="switchIsltVideo(3)" id="btnIsltVid3" class="btn islt-vid-pill" style="font-size:0.8rem; padding:6px 14px; border-radius:20px; background:rgba(255,255,255,0.1); color:#D5CEE8; border:1px solid rgba(255,255,255,0.15); white-space:nowrap; cursor:pointer;">
                    4. Pidato Ibu Meutia Hatta (16:09)
                </button>
            </div>
        </div>
    </div>

    <!-- 3 Core Activities -->
    <div style="margin-bottom: 70px;">
        <div class="section-header">
            <span class="section-tag">Metode Pembelajaran</span>
            <h2 class="section-title">Aktivitas Utama Selama Program</h2>
            <p class="section-desc">Pengalaman pelatihan yang intensif, reflektif, dan kolaboratif bagi para pemimpin muda.</p>
        </div>

        <div class="islt-pillars-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
            <div class="pillar-card">
                <div class="pillar-icon"><i class="fa-solid fa-users-gear"></i></div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 12px; color: var(--slate-900);">Pelatihan Kepemimpinan</h3>
                <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.65;">
                    Simulasi kepemimpinan etis, manajemen konflik organisasi siswa, teknik diplomasi publik, dan penyusunan program kerja OSIS berbasis nilai integritas.
                </p>
            </div>
            <div class="pillar-card">
                <div class="pillar-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 12px; color: var(--slate-900);">Diskusi Ekonomi Kerakyatan</h3>
                <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.65;">
                    Mengkaji pemikiran Mohammad Hatta mengenai sistem koperasi, keadilan ekonomi, dan merancang inisiatif koperasi pelajar digital di sekolah.
                </p>
            </div>
            <div class="pillar-card">
                <div class="pillar-icon"><i class="fa-solid fa-monument"></i></div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 12px; color: var(--slate-900);">Napak Tilas Pahlawan</h3>
                <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.65;">
                    Ekspedisi sejarah mengunjungi rumah kelahiran Bung Hatta di Bukittinggi, berdialog dengan tokoh bangsa, dan merenungkan janji kebangsaan.
                </p>
            </div>
        </div>
    </div>

    <!-- Registration Banner -->
    <div style="background: linear-gradient(135deg, var(--maroon-primary), var(--maroon-deep)); border-radius: 24px; padding: 50px 40px; color: white; text-align: center; border: 2px solid var(--gold-primary); box-shadow: var(--shadow-elevated);">
        <h2 style="font-family: var(--font-display); font-size: 2.2rem; margin-bottom: 16px;">
            Siap Menjadi Utusan Terbaik dari Provinsi Anda?
        </h2>
        <p style="color: #f1f5f9; font-size: 1.05rem; max-width: 650px; margin: 0 auto 32px; line-height: 1.7;">
            Pendaftaran peserta ISLT terbuka untuk seluruh Ketua dan Pengurus OSIS SMA/SMK/MA sederajat di Indonesia. Tidak dipungut biaya pendaftaran.
        </p>
        <a href="{{ route('program.islt.daftar') }}" class="btn btn-gold" style="font-size: 1.05rem; padding: 14px 36px;">
            <i class="fa-solid fa-pen-to-square"></i> Mengisi Formulir Pendaftaran Peserta
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const isltVideos = [
        {
            id: 'KfYjfXxEnmk',
            tag: 'Visi & Manifesto ISLT',
            title: 'ISLT 2025 Menuju Masyarakat Kooperatif',
            desc: 'Tayangan artistik dan puitis yang mengangkat tema harapan, kebersamaan, dan cita-cita luhur menuju Indonesia kooperatif.',
            durationText: 'Putar Video Resmi (08 Menit 05 Detik)',
            cover: 'https://i.ytimg.com/vi/KfYjfXxEnmk/hq720.jpg'
        },
        {
            id: 'FL4FSSxFjCg',
            tag: 'Pilar I Kurikulum ISLT',
            title: 'Kepemimpinan Empati — Pilar I ISLT (Fauzan Akiar)',
            desc: 'Keterampilan kepemimpinan yang diasah melalui rasa peka, tanggung jawab moral individu, dan mendahulukan kepentingan umum.',
            durationText: 'Putar Pilar I (08 Menit 59 Detik)',
            cover: 'https://i.ytimg.com/vi/FL4FSSxFjCg/hq720.jpg'
        },
        {
            id: '4bcwLaUQONI',
            tag: 'Pilar II Kurikulum ISLT',
            title: 'Social Problem Solving | Pilar ISLT (Ahmad Hafidz)',
            desc: 'Membangun bisnis dan inisiatif berorientasi dampak nyata bagi masyarakat melalui empati, tindakan nyata, dan daya pikir kritis.',
            durationText: 'Putar Pilar II (43 Menit 24 Detik)',
            cover: 'https://i.ytimg.com/vi/4bcwLaUQONI/hq720.jpg'
        },
        {
            id: '4_arGLyBZqQ',
            tag: 'Pidato Kehormatan Pembukaan',
            title: 'Inspiring Speech dari Ibu Meutia Farida Hatta',
            desc: 'Amanat kebangsaan dari putri proklamator Bung Hatta mengenai perancangan dasar konstitusi dan persatuan hati seluruh pemimpin muda.',
            durationText: 'Putar Pidato Kehormatan (16 Menit 09 Detik)',
            cover: 'https://i.ytimg.com/vi/4_arGLyBZqQ/hq720.jpg'
        }
    ];

    let currentIsltVidIndex = 0;

    function switchIsltVideo(idx) {
        currentIsltVidIndex = idx;
        const v = isltVideos[idx];

        // Update pills
        for (let i = 0; i < isltVideos.length; i++) {
            const btn = document.getElementById('btnIsltVid' + i);
            if (btn) {
                if (i === idx) {
                    btn.style.background = 'var(--violet-primary)';
                    btn.style.color = 'white';
                    btn.style.borderColor = 'transparent';
                } else {
                    btn.style.background = 'rgba(255,255,255,0.1)';
                    btn.style.color = '#D5CEE8';
                    btn.style.borderColor = 'rgba(255,255,255,0.15)';
                }
            }
        }

        // Update cover
        document.getElementById('isltVideoTagBadge').innerText = v.tag;
        document.getElementById('isltVideoTitle').innerText = v.title;
        document.getElementById('isltVideoDesc').innerText = v.desc;
        document.getElementById('isltVideoDuration').innerHTML = '<i class="fa-brands fa-youtube" style="color:#ef4444; margin-right:6px;"></i> ' + v.durationText;
        document.getElementById('isltVideoCover').style.background = "linear-gradient(180deg, rgba(12,0,34,0.4) 0%, rgba(12,0,34,0.85) 100%), url('" + v.cover + "') center/cover";

        // If iframe is visible, switch stream
        const iframe = document.getElementById('isltVideoIframe');
        if (iframe.style.display !== 'none') {
            iframe.src = 'https://www.youtube-nocookie.com/embed/' + v.id + '?autoplay=1&rel=0';
        }
    }

    function playIsltVideo() {
        const cover = document.getElementById('isltVideoCover');
        const iframe = document.getElementById('isltVideoIframe');
        const v = isltVideos[currentIsltVidIndex];
        cover.style.display = 'none';
        iframe.style.display = 'block';
        iframe.src = 'https://www.youtube-nocookie.com/embed/' + v.id + '?autoplay=1&rel=0';
    }
</script>
@endpush
