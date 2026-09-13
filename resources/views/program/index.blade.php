@extends('layouts.app')

@section('title', 'Program Hatta Aksara')

@section('content')

<header class="page-header">
    <div class="container">
        <span class="section-tag" style="background:rgba(255,255,255,0.15); color:var(--gold-light); border-color:var(--gold-primary);">Inisiatif Strategis</span>
        <h1 style="font-family: var(--font-display); font-size: 2.6rem; margin-top: 10px;">Program Hatta Aksara Project</h1>
        <p style="color: #D5CEE8; max-width:650px; margin: 12px auto 0;">Menyiapkan kader-kader pemimpin muda bangsa yang memahami weltanschauung Indonesia dan prinsip ekonomi gotong royong.</p>
    </div>
</header>

<div class="container" style="padding: 70px 0 90px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 36px;">
        @foreach($programs as $prog)
            <div style="background: white; border-radius: 20px; border: 2px solid var(--border-subtle); padding: 40px; box-shadow: var(--shadow-subtle); display:flex; flex-direction:column; justify-content:space-between;">
                <div>
                    <span style="display:inline-block; font-size:0.78rem; font-weight:700; color:var(--gold-dark); background:rgba(197, 155, 39, 0.15); padding:5px 14px; border-radius:20px; margin-bottom:16px;">
                        {{ $prog->slug === 'islt' ? 'Program Pelatihan Unggulan' : 'Ekosistem Literasi & Jaringan' }}
                    </span>
                    <h2 style="font-family: var(--font-display); font-size: 1.8rem; color: var(--slate-900); margin-bottom: 12px; line-height: 1.3;">
                        {{ $prog->title }}
                    </h2>
                    <h4 style="font-size: 0.95rem; color: var(--maroon-primary); font-weight: 600; margin-bottom: 18px;">
                        {{ $prog->tagline }}
                    </h4>
                    <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.7; margin-bottom: 30px;">
                        {{ $prog->description }}
                    </p>
                </div>

                <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                    @if($prog->slug === 'islt')
                        <a href="{{ route('program.islt.daftar') }}" class="btn btn-primary">
                            <i class="fa-solid fa-file-pen"></i> Daftar Peserta ISLT
                        </a>
                        <a href="{{ route('program.islt') }}" class="btn btn-outline">
                            Selengkapnya &rarr;
                        </a>
                    @else
                        <a href="{{ route('register.hatta-muda') }}" class="btn btn-gold">
                            <i class="fa-solid fa-user-plus"></i> Gabung Hatta Muda
                        </a>
                        <a href="{{ route('program.media-edukasi') }}" class="btn btn-outline">
                            Selengkapnya &rarr;
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
