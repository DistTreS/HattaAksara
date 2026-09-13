@extends('layouts.app')

@section('title', 'Artikel Gagasan & Pemikiran Hatta Muda')

@push('styles')
<style>
    .artikel-header {
        background: radial-gradient(circle at top right, #240C4C 0%, #0C0022 100%);
        color: white;
        padding: 60px 0;
        border-bottom: 1px solid rgba(115, 0, 255, 0.25);
        text-align: center;
    }
    .search-box {
        display: flex;
        gap: 10px;
        max-width: 480px;
        margin: 0 auto 30px;
    }
    .search-input {
        flex: 1;
        padding: 10px 18px;
        border-radius: 25px;
        border: 1px solid var(--border-subtle);
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')

<header class="artikel-header">
    <div class="container" style="max-width: 800px; position: relative; z-index: 2;">
        <span class="section-tag">Pemikiran Pemuda</span>
        <h1 style="font-family: var(--font-display); font-size: clamp(2.2rem, 4.5vw, 2.8rem); font-weight: 800; margin: 14px 0; color: #ffffff;">
            Artikel Gagasan & Refleksi
        </h1>
        <p style="color: #D5CEE8; font-size: 1.05rem; line-height: 1.7;">
            Ruang dialektika dan pemikiran kritis para kader alumni Hatta Muda mengenai koperasi, weltanschauung, kebudayaan, dan masa depan Indonesia.
        </p>
    </div>
</header>

<div class="container" style="padding: 60px 0 90px;">
    <!-- Search & Filters -->
    <form action="{{ route('artikel.index') }}" method="GET" class="search-box">
        <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Cari judul gagasan atau topik..." class="search-input">
        <button type="submit" class="btn btn-primary" style="border-radius: 25px; padding: 0 20px;">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>

    <div style="display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; margin-bottom: 40px;">
        <a href="{{ route('artikel.index') }}" class="subcat-pill" style="padding: 6px 16px; border-radius: 20px; font-size: 0.82rem; background: {{ empty($currentSubCat) ? 'var(--maroon-primary)' : '#f1f5f9' }}; color: {{ empty($currentSubCat) ? 'white' : '#475569' }}; text-decoration:none; font-weight:600;">
            Semua Gagasan
        </a>
        @foreach($subCategories as $sub)
            <a href="{{ route('artikel.index', ['sub' => $sub->slug]) }}" style="padding: 6px 16px; border-radius: 20px; font-size: 0.82rem; background: {{ $currentSubCat === $sub->slug ? 'var(--maroon-primary)' : '#f1f5f9' }}; color: {{ $currentSubCat === $sub->slug ? 'white' : '#475569' }}; text-decoration:none; font-weight:600;">
                {{ $sub->name }}
            </a>
        @endforeach
    </div>

    <!-- Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
        @forelse($articles as $art)
            <article style="background: white; border-radius: 18px; border: 1px solid var(--border-subtle); overflow: hidden; display: flex; flex-direction: column; box-shadow: var(--shadow-subtle); transition: transform 0.2s;">
                <div style="padding: 28px; display: flex; flex-direction: column; flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                        <span style="font-size: 0.74rem; font-weight: 700; color: var(--gold-dark); background: rgba(197, 155, 39, 0.15); padding: 4px 10px; border-radius: 12px; text-transform: uppercase;">
                            {{ $art->subCategory?->name ?? 'Gagasan' }}
                        </span>
                        <span style="font-size: 0.78rem; color: var(--text-muted);"><i class="fa-regular fa-eye"></i> {{ $art->views_count }} baca</span>
                    </div>

                    <h3 style="font-size: 1.25rem; font-weight: 700; line-height: 1.4; color: var(--slate-900); margin-bottom: 12px;">
                        <a href="{{ route('artikel.show', $art->slug) }}" style="color:inherit;">{{ $art->title }}</a>
                    </h3>

                    <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 24px; flex: 1;">
                        {{ $art->excerpt }}
                    </p>

                    <div style="padding-top: 18px; border-top: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 34px; height: 34px; border-radius: 50%; background: var(--maroon-primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.82rem;">
                                {{ substr($art->author?->name ?? 'A', 0, 1) }}
                            </div>
                            <div>
                                <strong style="font-size: 0.84rem; color: var(--slate-900); display: block;">{{ $art->author?->name }}</strong>
                                <span style="font-size: 0.72rem; color: var(--text-muted);">{{ $art->published_at?->format('d M Y') ?? $art->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('artikel.show', $art->slug) }}" style="color: var(--maroon-primary); font-weight: 700; font-size: 0.88rem;">
                            Baca &rarr;
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div style="grid-column: 1 / -1; text-align:center; padding: 60px 20px; background: white; border-radius: 18px; border: 1px dashed var(--border-subtle);">
                <i class="fa-solid fa-feather" style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 12px;"></i>
                <h3 style="color: #334155; margin-bottom: 6px;">Belum ada artikel gagasan yang sesuai</h3>
                <p style="color: #64748b; font-size: 0.9rem;">Kader Hatta Muda dapat menulis artikel gagasan melalui ruang kontributor alumni.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 45px;">
        {{ $articles->links() }}
    </div>
</div>

@endsection
