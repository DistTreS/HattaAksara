@extends('layouts.alumni')

@section('title', 'Dashboard Hatta Muda')
@section('page_title', 'Dashboard Alumni Hatta Muda Connection')

@section('content')

<!-- Welcome Banner -->
<div style="background: linear-gradient(135deg, var(--slate-900), var(--maroon-deep)); border-radius: 16px; padding: 28px 32px; color: white; margin-bottom: 28px; border-left: 5px solid var(--gold-primary); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
    <div>
        <span style="font-size: 0.78rem; font-weight: 700; color: var(--gold-light); text-transform: uppercase; letter-spacing: 0.08em;">
            Selamat Datang Kembali
        </span>
        <h2 style="font-family: var(--font-display); font-size: 1.6rem; margin: 4px 0 6px;">
            {{ $user->name }}
        </h2>
        <p style="color: #cbd5e1; font-size: 0.88rem;">
            {{ $user->alumniProfile?->islt_batch }} &bull; {{ $user->alumniProfile?->school_origin }} &bull; Provinsi {{ $user->alumniProfile?->province }}
        </p>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('alumni.create-aksi') }}" class="btn btn-primary" style="background: var(--maroon-primary); border: 1px solid rgba(255,255,255,0.2);">
            <i class="fa-solid fa-hands-holding-circle"></i> Tulis Berita Aksi
        </a>
        <a href="{{ route('alumni.create-artikel') }}" class="btn" style="background: var(--gold-primary); color: #111827; font-weight: 700;">
            <i class="fa-solid fa-lightbulb"></i> Tulis Gagasan
        </a>
    </div>
</div>

<!-- Stats Counter -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 18px; margin-bottom: 30px;">
    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid var(--border-color);">
        <span style="font-size: 0.76rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Tulisan</span>
        <div style="font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-top: 4px;">{{ $stats['total'] }}</div>
    </div>
    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid var(--border-color); border-top: 3px solid #10b981;">
        <span style="font-size: 0.76rem; font-weight: 700; color: #065f46; text-transform: uppercase;">Telah Terbit</span>
        <div style="font-size: 1.8rem; font-weight: 800; color: #10b981; margin-top: 4px;">{{ $stats['published'] }}</div>
    </div>
    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid var(--border-color); border-top: 3px solid #f59e0b;">
        <span style="font-size: 0.76rem; font-weight: 700; color: #92400e; text-transform: uppercase;">Sedang Ditinjau</span>
        <div style="font-size: 1.8rem; font-weight: 800; color: #f59e0b; margin-top: 4px;">{{ $stats['pending'] }}</div>
    </div>
    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid var(--border-color); border-top: 3px solid #ef4444;">
        <span style="font-size: 0.76rem; font-weight: 700; color: #991b1b; text-transform: uppercase;">Perlu Revisi</span>
        <div style="font-size: 1.8rem; font-weight: 800; color: #ef4444; margin-top: 4px;">{{ $stats['revision'] }}</div>
    </div>
    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid var(--border-color); border-top: 3px solid #64748b;">
        <span style="font-size: 0.76rem; font-weight: 700; color: #475569; text-transform: uppercase;">Draf Pribadi</span>
        <div style="font-size: 1.8rem; font-weight: 800; color: #475569; margin-top: 4px;">{{ $stats['draft'] }}</div>
    </div>
</div>

<!-- Special Alert if Revision Needed -->
@if($needRevisionPosts->isNotEmpty())
    <div style="background: #fef2f2; border: 1px solid #fecaca; border-left: 5px solid #ef4444; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
        <h3 style="color: #991b1b; font-size: 1rem; font-weight: 700; margin-bottom: 6px;">
            <i class="fa-solid fa-triangle-exclamation"></i> Terdapat Tulisan yang Memerlukan Revisi Redaksi
        </h3>
        <p style="color: #7f1d1d; font-size: 0.88rem; margin-bottom: 14px;">
            Tim redaksi telah memberikan catatan perbaikan untuk naskah berikut. Silakan baca catatannya, lakukan perbaikan, dan kirimkan kembali:
        </p>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            @foreach($needRevisionPosts as $revPost)
                <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 10px 16px; border-radius: 8px; border: 1px solid #fee2e2;">
                    <div>
                        <strong style="color: #1e293b; font-size: 0.9rem;">{{ $revPost->title }}</strong>
                        <span style="font-size: 0.78rem; color: #64748b; margin-left: 8px;">({{ ucfirst(str_replace('_', ' ', $revPost->post_type)) }})</span>
                    </div>
                    <a href="{{ route('alumni.edit-post', $revPost->id) }}" class="btn btn-primary" style="padding: 5px 14px; font-size: 0.78rem;">
                        <i class="fa-solid fa-pen-to-square"></i> Perbaiki Naskah
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Recent Posts Table -->
<div style="background: white; border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);">
    <div style="padding: 18px 24px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 1.05rem; font-weight: 700; color: #0f172a;">Aktivitas Tulisan Terkini</h3>
        <a href="{{ route('alumni.my-posts') }}" style="font-size: 0.84rem; color: var(--maroon-primary); font-weight: 600;">Lihat Semua Tulisan &rarr;</a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid var(--border-color);">
                    <th style="padding: 12px 20px; font-weight: 700; color: #475569;">Judul Naskah</th>
                    <th style="padding: 12px 20px; font-weight: 700; color: #475569;">Jenis</th>
                    <th style="padding: 12px 20px; font-weight: 700; color: #475569;">Status</th>
                    <th style="padding: 12px 20px; font-weight: 700; color: #475569;">Tanggal</th>
                    <th style="padding: 12px 20px; font-weight: 700; color: #475569; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPosts as $post)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 14px 20px; font-weight: 600; color: #1e293b;">
                            {{ $post->title }}
                        </td>
                        <td style="padding: 14px 20px;">
                            <span style="font-size: 0.75rem; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-weight: 600; color: #475569;">
                                {{ $post->post_type === 'aksi_hatta_muda' ? 'Aksi Hatta Muda' : 'Artikel Gagasan' }}
                            </span>
                        </td>
                        <td style="padding: 14px 20px;">
                            @if($post->status === 'published')
                                <span style="background: #ecfdf5; color: #065f46; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Disetujui / Terbit</span>
                            @elseif($post->status === 'pending_review')
                                <span style="background: #fffbeb; color: #92400e; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Menunggu Review</span>
                            @elseif($post->status === 'revision_required')
                                <span style="background: #fef2f2; color: #991b1b; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Perlu Revisi</span>
                            @elseif($post->status === 'rejected')
                                <span style="background: #f1f5f9; color: #475569; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Ditolak</span>
                            @else
                                <span style="background: #f8fafc; color: #64748b; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Draf</span>
                            @endif
                        </td>
                        <td style="padding: 14px 20px; color: #64748b;">
                            {{ $post->updated_at->format('d/m/Y') }}
                        </td>
                        <td style="padding: 14px 20px; text-align: right;">
                            <a href="{{ route('alumni.edit-post', $post->id) }}" class="btn btn-outline" style="padding: 4px 10px; font-size: 0.78rem;">
                                <i class="fa-solid fa-pen"></i> Edit
                            </a>
                            @if($post->status === 'published')
                                <a href="{{ $post->post_type === 'artikel' ? route('artikel.show', $post->slug) : route('berita.show', $post->slug) }}" target="_blank" class="btn btn-outline" style="padding: 4px 10px; font-size: 0.78rem;">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: #64748b;">
                            Belum ada tulisan yang Anda buat. Silakan tulis Aksi Hatta Muda atau Artikel Gagasan Anda!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
