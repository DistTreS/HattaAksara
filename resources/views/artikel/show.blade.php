@extends('layouts.app')

@section('title', $article->title)
@section('meta_description', $article->excerpt)

@push('styles')
<style>
    .article-header {
        background: linear-gradient(135deg, var(--slate-900), #1c080b);
        color: white;
        padding: 65px 0 55px;
        border-bottom: 1px solid rgba(115, 0, 255, 0.25);
    }
    .article-container {
        max-width: 820px;
        margin: 0 auto;
    }
    .article-content {
        background: white;
        border-radius: var(--radius-xl);
        padding: 50px 60px;
        margin-top: -35px;
        position: relative;
        z-index: 5;
        box-shadow: var(--shadow-subtle);
        border: 1px solid var(--border-subtle);
        font-size: 1.08rem;
        line-height: 1.9;
        color: #242c3d;
    }
    .article-content p {
        margin-bottom: 24px;
    }
    .article-content blockquote {
        border-left: 4px solid var(--gold-primary);
        padding: 18px 26px;
        background: #fdfaf3;
        font-family: var(--font-serif);
        font-style: italic;
        color: #4b5563;
        margin: 30px 0;
        border-radius: 0 12px 12px 0;
    }
    @media (max-width: 768px) {
        .article-content {
            padding: 26px 20px;
        }
    }
</style>
@endpush

@section('content')

<article>
    <header class="article-header">
        <div class="container article-container">
            <div style="margin-bottom: 12px;">
                <a href="{{ route('artikel.index') }}" style="color:var(--gold-light); font-size:0.84rem; font-weight:600;">
                    &larr; Kembali ke Daftar Artikel Gagasan
                </a>
            </div>
            <span class="section-tag" style="background:rgba(255,255,255,0.15); color:var(--gold-light); border-color:var(--gold-primary);">
                {{ $article->subCategory?->name ?? 'Gagasan & Opini' }}
            </span>
            <h1 style="font-family: var(--font-display); font-size: 2.5rem; line-height: 1.25; margin: 16px 0 20px; color:white;">
                {{ $article->title }}
            </h1>
            <div style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap; font-size: 0.88rem; color: #d1d5db; padding-top: 14px; border-top: 1px solid rgba(255,255,255,0.1);">
                <span><i class="fa-solid fa-feather-pointed" style="color:var(--gold-light);"></i> Oleh: <strong>{{ $article->author?->name }}</strong></span>
                <span><i class="fa-regular fa-calendar"></i> {{ $article->published_at?->format('d F Y') ?? $article->created_at->format('d F Y') }}</span>
                <span><i class="fa-regular fa-eye"></i> {{ $article->views_count }} Kali Dibaca</span>
            </div>
        </div>
    </header>

    <div class="container article-container" style="margin-bottom: 80px;">
        <div class="article-content">
            <div style="font-family: var(--font-serif); font-size: 1.15rem; font-style: italic; color: #475569; margin-bottom: 30px; line-height: 1.7; padding-bottom: 20px; border-bottom: 1px solid var(--border-subtle);">
                "{{ $article->excerpt }}"
            </div>

            {!! $article->content !!}

            <!-- Author Box -->
            <div style="background: #f8fafc; border-radius: 16px; padding: 24px; margin-top: 50px; border: 1px solid #e2e8f0; display: flex; gap: 18px; align-items: center;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--maroon-primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 700; flex-shrink: 0;">
                    {{ substr($article->author?->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <h4 style="font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: 4px;">{{ $article->author?->name }}</h4>
                    <span style="font-size: 0.8rem; color: var(--gold-dark); font-weight: 700; display: block; margin-bottom: 6px;">
                        Kader Hatta Muda &bull; {{ $article->author?->alumniProfile?->islt_batch ?? 'Alumni ISLT' }}
                    </span>
                    <p style="font-size: 0.86rem; color: #64748b; line-height: 1.5;">
                        {{ $article->author?->alumniProfile?->bio ?? 'Mendedikasikan pemikirannya untuk kemajuan peradaban dan koperasi kepemudaan.' }}
                    </p>
                </div>
            </div>

            <!-- Share Buttons -->
            <div style="margin-top: 36px; padding-top: 24px; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
                <span style="font-weight: 600; font-size: 0.88rem; color: var(--slate-800);"><i class="fa-solid fa-share-nodes"></i> Bagikan Tulisan Ini:</span>
                <div style="display: flex; gap: 10px;">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" class="btn btn-sm" style="background:#25D366; color:white;">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-sm" style="background:#1DA1F2; color:white;">
                        <i class="fa-brands fa-x-twitter"></i> X / Twitter
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-sm" style="background:#0A66C2; color:white;">
                        <i class="fa-brands fa-linkedin-in"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>
</article>

@endsection
