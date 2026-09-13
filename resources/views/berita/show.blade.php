@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', $post->excerpt)

@push('styles')
<style>
    .article-header {
        background: linear-gradient(135deg, var(--slate-900), #1f0b0e);
        color: white;
        padding: 60px 0 50px;
        border-bottom: 1px solid rgba(115, 0, 255, 0.25);
    }
    .article-container {
        max-width: 860px;
        margin: 0 auto;
    }
    .article-category {
        display: inline-block;
        background: var(--maroon-primary);
        color: white;
        font-weight: 700;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 6px 14px;
        border-radius: 20px;
        margin-bottom: 16px;
    }
    .article-title {
        font-family: var(--font-display);
        font-size: 2.6rem;
        line-height: 1.25;
        color: #ffffff;
        margin-bottom: 20px;
    }
    .article-meta {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 0.88rem;
        color: #d1d5db;
        flex-wrap: wrap;
        padding-top: 14px;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    .article-body {
        background: white;
        border-radius: var(--radius-xl);
        padding: 50px;
        margin-top: -30px;
        position: relative;
        z-index: 5;
        box-shadow: var(--shadow-subtle);
        border: 1px solid var(--border-subtle);
        font-size: 1.05rem;
        line-height: 1.85;
        color: #2c3547;
    }
    .article-body p {
        margin-bottom: 24px;
    }
    .article-body h2, .article-body h3 {
        font-family: var(--font-display);
        color: var(--slate-900);
        margin: 36px 0 16px;
    }
    .article-body blockquote {
        border-left: 4px solid var(--gold-primary);
        padding: 16px 24px;
        background: #fdfaf3;
        font-family: var(--font-serif);
        font-style: italic;
        color: #4b5563;
        margin: 28px 0;
        border-radius: 0 12px 12px 0;
    }
    .author-card {
        background: #f8fafc;
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-top: 50px;
        border: 1px solid #e2e8f0;
        display: flex;
        gap: 20px;
        align-items: center;
    }
    .author-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--maroon-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    @media (max-width: 768px) {
        .article-title {
            font-size: 1.85rem;
        }
        .article-body {
            padding: 24px 20px;
            margin-top: -15px;
        }
        .author-card {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')

<article>
    <header class="article-header">
        <div class="container article-container">
            <div style="margin-bottom: 12px;">
                <a href="{{ route('berita.index') }}" style="color:var(--gold-light); font-size:0.84rem; font-weight:600;">
                    &larr; Kembali ke Berita
                </a>
            </div>
            <span class="article-category">{{ $post->subCategory?->name ?? ucfirst($post->post_type) }}</span>
            <h1 class="article-title">{{ $post->title }}</h1>
            
            <div class="article-meta">
                <span><i class="fa-solid fa-user-pen" style="color:var(--gold-light);"></i> {{ $post->author?->name }}</span>
                <span><i class="fa-regular fa-calendar"></i> {{ $post->published_at?->translatedFormat('l, d F Y') ?? $post->created_at->format('d F Y') }}</span>
                <span><i class="fa-regular fa-eye"></i> {{ $post->views_count }} Kali Dibaca</span>
                @if($post->action_location)
                    <span><i class="fa-solid fa-location-dot" style="color:var(--gold-light);"></i> {{ $post->action_location }}</span>
                @endif
            </div>
        </div>
    </header>

    <div class="container article-container" style="margin-bottom: 80px;">
        <div class="article-body">
            @if($post->featured_image_url)
                <figure style="margin: 0 0 35px 0; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm);">
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" style="width: 100%; max-height: 480px; object-fit: cover; display: block;">
                    <figcaption style="padding: 10px 16px; background: #f8fafc; font-size: 0.82rem; color: #64748b; border-top: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                        <span><i class="fa-solid fa-camera" style="color: var(--maroon-primary); margin-right: 6px;"></i> Dokumentasi Arsip & Publikasi Hatta Aksara</span>
                        <span>{{ $post->action_location ?? 'Hatta Aksara Project' }}</span>
                    </figcaption>
                </figure>
            @endif

            @if($post->action_location || $post->action_date)
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 20px; margin-bottom: 30px; display: flex; align-items: center; gap: 14px;">
                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #22c55e; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                        <i class="fa-solid fa-hands-holding-circle"></i>
                    </div>
                    <div>
                        <strong style="color: #15803d; font-size: 0.92rem; display: block;">Laporan Aksi Nyata Hatta Muda</strong>
                        <span style="font-size: 0.84rem; color: #166534;">
                            Lokasi: {{ $post->action_location ?? 'Indonesia' }} &bull; Tanggal Pelaksanaan: {{ $post->action_date?->format('d F Y') ?? '-' }}
                        </span>
                    </div>
                </div>
            @endif

            {!! $post->content !!}

            <!-- Author Bio Section -->
            <div class="author-card">
                <div class="author-avatar">
                    {{ substr($post->author?->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <h4 style="font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: 4px;">{{ $post->author?->name }}</h4>
                    <span style="font-size: 0.8rem; color: var(--maroon-primary); font-weight: 600; display: block; margin-bottom: 8px;">
                        @if($post->author?->isAdmin())
                            Tim Redaksi Hatta Aksara Project
                        @elseif($post->author?->alumniProfile)
                            Kader Hatta Muda &bull; {{ $post->author->alumniProfile->islt_batch }} &bull; Asal {{ $post->author->alumniProfile->school_origin }}
                        @else
                            Kontributor
                        @endif
                    </span>
                    <p style="font-size: 0.88rem; color: #64748b; line-height: 1.5;">
                        {{ $post->author?->alumniProfile?->bio ?? 'Mendedikasikan pemikiran dan aksinya untuk menyebarkan nilai-nilai kooperatif dan kepemimpinan berkarakter Bung Hatta.' }}
                    </p>
                </div>
            </div>

            <!-- Share Buttons -->
            <div style="margin-top: 36px; padding-top: 24px; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
                <span style="font-weight: 600; font-size: 0.88rem; color: var(--slate-800);"><i class="fa-solid fa-share-nodes"></i> Bagikan Artikel Ini:</span>
                <div style="display: flex; gap: 10px;">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="btn btn-sm" style="background:#25D366; color:white;">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-sm" style="background:#1DA1F2; color:white;">
                        <i class="fa-brands fa-x-twitter"></i> X / Twitter
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-sm" style="background:#0A66C2; color:white;">
                        <i class="fa-brands fa-linkedin-in"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Posts -->
        @if($relatedPosts->isNotEmpty())
            <div style="margin-top: 60px;">
                <h3 style="font-family: var(--font-display); font-size: 1.5rem; margin-bottom: 24px; color: var(--slate-900);">Berita & Kegiatan Terkait</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
                    @foreach($relatedPosts as $related)
                        <div style="background: white; border-radius: 14px; padding: 20px; border: 1px solid var(--border-subtle);">
                            <span style="font-size: 0.75rem; color: var(--maroon-primary); font-weight: 700; text-transform: uppercase;">{{ $related->category?->name }}</span>
                            <h4 style="font-size: 1rem; font-weight: 700; margin: 8px 0; line-height: 1.4;">
                                <a href="{{ route('berita.show', $related->slug) }}" style="color: var(--slate-900);">{{ $related->title }}</a>
                            </h4>
                            <span style="font-size: 0.78rem; color: var(--text-muted);"><i class="fa-regular fa-calendar"></i> {{ $related->published_at?->format('d M Y') ?? $related->created_at->format('d M Y') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>

@endsection
