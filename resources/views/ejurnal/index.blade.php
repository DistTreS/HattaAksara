@extends('layouts.app')

@section('title', 'E-Jurnal & Perpustakaan Digital')

@section('content')

<header class="page-header">
    <div class="container" style="max-width: 820px;">
        <span class="section-tag" style="background:rgba(255,255,255,0.15); color:var(--gold-light); border-color:var(--gold-primary);">
            Repositori Dokumen Resmi
        </span>
        <h1 style="font-family: var(--font-display); font-size: 2.6rem; margin: 12px 0;">
            E-Jurnal & Perpustakaan Digital
        </h1>
        <p style="color: #D5CEE8; font-size: 1.05rem;">
            Pusat publikasi dokumen kurikulum kepemimpinan ISLT, modul ekonomi kerakyatan, buku saku, dan risalah pemikiran Bung Hatta yang dapat diakses dan diunduh secara bebas.
        </p>
    </div>
</header>

<div class="container" style="padding: 60px 0 90px;">
    <!-- Search & Filter -->
    <div style="max-width: 600px; margin: 0 auto 40px;">
        <form action="{{ route('ejurnal.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Cari judul kurikulum atau dokumen..." class="form-control" style="border-radius: 25px; padding: 11px 20px;">
            <button type="submit" class="btn btn-primary" style="border-radius: 25px; padding: 0 22px;">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
        </form>
    </div>

    <!-- Category Pills -->
    <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-bottom: 40px;">
        <a href="{{ route('ejurnal.index') }}" class="btn btn-sm {{ empty($currentCategory) ? 'btn-primary' : 'btn-outline' }}">
            Semua Dokumen
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('ejurnal.index', ['cat' => $cat]) }}" class="btn btn-sm {{ $currentCategory === $cat ? 'btn-primary' : 'btn-outline' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <!-- Documents Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
        @forelse($eJournals as $doc)
            <div style="background: white; border-radius: 18px; border: 1px solid var(--border-subtle); padding: 28px; box-shadow: var(--shadow-subtle); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <span style="font-size: 0.74rem; font-weight: 700; color: var(--gold-dark); background: rgba(197, 155, 39, 0.15); padding: 4px 10px; border-radius: 12px;">
                            {{ $doc->category }}
                        </span>
                        <span style="font-size: 0.8rem; color: #64748b; font-weight: 600;">
                            Tahun {{ $doc->publication_year }}
                        </span>
                    </div>

                    <h3 style="font-family: var(--font-display); font-size: 1.25rem; color: var(--slate-900); margin-bottom: 10px; line-height: 1.4;">
                        {{ $doc->title }}
                    </h3>

                    <p style="font-size: 0.84rem; color: var(--maroon-primary); font-weight: 600; margin-bottom: 12px;">
                        <i class="fa-solid fa-landmark"></i> {{ $doc->author_or_curator }}
                    </p>

                    <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 24px;">
                        {{ $doc->description }}
                    </p>
                </div>

                <div style="padding-top: 18px; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.8rem; color: #64748b;">
                        <i class="fa-solid fa-download"></i> {{ $doc->download_count }} kali diunduh
                    </span>
                    <a href="{{ route('ejurnal.download', $doc->slug) }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-file-pdf"></i> Unduh Dokumen
                    </a>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align:center; padding: 60px 20px; background: white; border-radius: 18px; border: 1px dashed var(--border-subtle);">
                <i class="fa-solid fa-book-bookmark" style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 12px;"></i>
                <h3 style="color: #334155; margin-bottom: 6px;">Tidak ada dokumen yang sesuai</h3>
                <p style="color: #64748b; font-size: 0.9rem;">Coba cari dengan kata kunci lain.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 45px;">
        {{ $eJournals->links() }}
    </div>
</div>

@endsection
