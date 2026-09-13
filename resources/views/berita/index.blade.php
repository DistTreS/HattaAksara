@extends('layouts.app')

@section('title', 'Kanal Berita & Publikasi')

@push('styles')
<style>
    .page-header {
        background: radial-gradient(circle at top right, #240C4C 0%, #0C0022 100%);
        color: white;
        padding: 75px 0 60px;
        border-bottom: 1px solid rgba(115, 0, 255, 0.25);
        margin-bottom: 45px;
        text-align: center;
        position: relative;
    }
    .filter-tabs {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 25px;
        border-bottom: 1px solid var(--border-subtle);
        padding-bottom: 15px;
    }
    .filter-tab {
        padding: 9px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.88rem;
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        color: var(--text-main);
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .filter-tab:hover {
        background: #FAF7FC;
        border-color: var(--violet-primary);
        color: var(--violet-primary);
    }
    .filter-tab.active {
        background: var(--violet-primary);
        color: #ffffff;
        border-color: var(--violet-primary);
        box-shadow: 0 4px 14px rgba(115, 0, 255, 0.3);
    }
    .subcat-pills {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 35px;
    }
    .subcat-pill {
        font-size: 0.82rem;
        padding: 6px 16px;
        border-radius: 20px;
        background: #FAF7FC;
        color: var(--text-muted);
        font-weight: 500;
        border: 1px solid var(--border-subtle);
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .subcat-pill:hover, .subcat-pill.active {
        background: rgba(115, 0, 255, 0.1);
        color: var(--violet-primary);
        border-color: var(--violet-primary);
        font-weight: 700;
    }
    .search-box {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        max-width: 500px;
    }
    .search-input {
        flex: 1;
        padding: 10px 16px;
        border-radius: 25px;
        border: 1px solid var(--border-subtle);
        font-size: 0.9rem;
        outline: none;
    }
    .search-input:focus {
        border-color: var(--maroon-primary);
    }
</style>
@endpush

@section('content')

<header class="page-header">
    <div class="container" style="text-align: center; max-width: 800px; position: relative; z-index: 2;">
        <span class="section-tag">Pemberitaan & Dampak</span>
        <h1 style="font-family: var(--font-display); font-size: clamp(2.2rem, 4.5vw, 2.8rem); font-weight: 800; margin: 14px 0; color: #ffffff;">Media Berita Hatta Aksara</h1>
        <p style="color: #D5CEE8; max-width: 650px; margin: 0 auto; font-size: 1.05rem; line-height: 1.7;">Kanal resmi warta organisasi, liputan napak tilas, dan laporan aksi nyata para kader Hatta Muda di berbagai daerah.</p>
    </div>
</header>

<div class="container" style="margin-bottom: 80px;">
    <!-- Main Category Tabs -->
    <div class="filter-tabs">
        <a href="{{ route('berita.index', ['type' => 'all', 'sub' => request('sub'), 'q' => request('q')]) }}" class="filter-tab {{ $currentType === 'all' ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group"></i> Semua Berita
        </a>
        <a href="{{ route('berita.index', ['type' => 'news', 'sub' => request('sub'), 'q' => request('q')]) }}" class="filter-tab {{ $currentType === 'news' ? 'active' : '' }}">
            <i class="fa-regular fa-newspaper"></i> News Resmi
        </a>
        <a href="{{ route('berita.index', ['type' => 'aksi_hatta_muda', 'sub' => request('sub'), 'q' => request('q')]) }}" class="filter-tab {{ $currentType === 'aksi_hatta_muda' ? 'active' : '' }}">
            <i class="fa-solid fa-hands-holding-circle"></i> Aksi Hatta Muda
        </a>
        <a href="{{ route('berita.index', ['type' => 'kegiatan', 'sub' => request('sub'), 'q' => request('q')]) }}" class="filter-tab {{ $currentType === 'kegiatan' ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-check"></i> Kegiatan & Forum
        </a>
    </div>

    <!-- Search & Sub-category Filter -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div class="subcat-pills">
            <span style="font-size: 0.8rem; font-weight: 700; color: #64748b; margin-top: 4px;">Topik:</span>
            <a href="{{ route('berita.index', ['type' => $currentType, 'q' => request('q')]) }}" class="subcat-pill {{ empty($currentSubCat) ? 'active' : '' }}">Semua Topik</a>
            @foreach($subCategories as $sub)
                <a href="{{ route('berita.index', ['type' => $currentType, 'sub' => $sub->slug, 'q' => request('q')]) }}" class="subcat-pill {{ $currentSubCat === $sub->slug ? 'active' : '' }}">
                    {{ $sub->name }}
                </a>
            @endforeach
        </div>

        <form action="{{ route('berita.index') }}" method="GET" class="search-box">
            <input type="hidden" name="type" value="{{ $currentType }}">
            @if($currentSubCat)
                <input type="hidden" name="sub" value="{{ $currentSubCat }}">
            @endif
            <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Cari berita atau isu..." class="search-input">
            <button type="submit" class="btn btn-primary" style="border-radius: 25px; padding: 0 18px;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <!-- Posts Grid -->
    <div class="posts-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 30px; margin-top: 20px;">
        @forelse($posts as $post)
            <article class="post-card" style="background:white; border-radius:18px; border:1px solid var(--border-subtle); overflow:hidden; display:flex; flex-direction:column;">
                <div class="post-thumb" style="height:210px; background:linear-gradient(135deg, var(--slate-800), var(--maroon-deep)); position:relative; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                    @if($post->featured_image_url)
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" style="width:100%; height:100%; object-fit:cover; transition: transform 0.4s ease;">
                    @else
                        <div style="font-size:3rem; color:rgba(255,255,255,0.25);">
                            @if($post->post_type === 'aksi_hatta_muda')
                                <i class="fa-solid fa-hands-holding-circle"></i>
                            @elseif($post->post_type === 'kegiatan')
                                <i class="fa-solid fa-calendar-day"></i>
                            @else
                                <i class="fa-regular fa-newspaper"></i>
                            @endif
                        </div>
                    @endif
                    <span class="post-category-tag" style="position:absolute; top:12px; left:12px; background:rgba(122, 22, 30, 0.9); color:white; font-size:0.72rem; font-weight:700; padding:4px 12px; border-radius:20px;">
                        {{ $post->subCategory?->name ?? ucfirst($post->post_type) }}
                    </span>
                </div>
                <div class="post-body" style="padding:22px; display:flex; flex-direction:column; flex:1;">
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:8px; display:flex; gap:10px;">
                        <span><i class="fa-regular fa-calendar"></i> {{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</span>
                        @if($post->action_location)
                            <span>&bull;</span>
                            <span><i class="fa-solid fa-location-dot"></i> {{ $post->action_location }}</span>
                        @endif
                    </div>
                    <h3 style="font-size:1.15rem; font-weight:700; line-height:1.4; margin-bottom:10px;">
                        <a href="{{ route('berita.show', $post->slug) }}" style="color:var(--slate-900);">{{ $post->title }}</a>
                    </h3>
                    <p style="font-size:0.88rem; color:var(--text-muted); line-height:1.6; margin-bottom:18px; flex:1;">
                        {{ $post->excerpt }}
                    </p>
                    <div style="padding-top:14px; border-top:1px solid var(--border-subtle); display:flex; justify-content:space-between; align-items:center; font-size:0.84rem;">
                        <span style="font-weight:600; color:var(--slate-800);"><i class="fa-solid fa-user-pen" style="color:var(--maroon-primary); margin-right:4px;"></i> {{ $post->author?->name }}</span>
                        <a href="{{ route('berita.show', $post->slug) }}" style="color:var(--maroon-primary); font-weight:700;">Baca &rarr;</a>
                    </div>
                </div>
            </article>
        @empty
            <div style="grid-column: 1 / -1; text-align:center; padding: 60px 20px; background:white; border-radius:18px; border:1px dashed var(--border-subtle);">
                <i class="fa-solid fa-magnifying-glass" style="font-size:2.5rem; color:#cbd5e1; margin-bottom:14px;"></i>
                <h3 style="font-size:1.2rem; color:#334155; margin-bottom:6px;">Tidak ada berita yang ditemukan</h3>
                <p style="color:#64748b; font-size:0.9rem;">Cobalah menggunakan kata kunci pencarian atau kategori topik lainnya.</p>
                <a href="{{ route('berita.index') }}" class="btn btn-outline" style="margin-top:16px;">Reset Filter</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 45px;">
        {{ $posts->links() }}
    </div>
</div>

@endsection
