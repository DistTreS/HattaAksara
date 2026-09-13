@extends('layouts.alumni')

@section('title', 'Tulisan Saya')
@section('page_title', 'Manajemen Tulisan Saya')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <!-- Filter Tabs -->
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a href="{{ route('alumni.my-posts') }}" class="btn btn-sm {{ empty($status) ? 'btn-primary' : 'btn-outline' }}">
            Semua ({{ $posts->total() }})
        </a>
        <a href="{{ route('alumni.my-posts', ['status' => 'published']) }}" class="btn btn-sm {{ $status === 'published' ? 'btn-primary' : 'btn-outline' }}">
            Terbit
        </a>
        <a href="{{ route('alumni.my-posts', ['status' => 'pending_review']) }}" class="btn btn-sm {{ $status === 'pending_review' ? 'btn-primary' : 'btn-outline' }}">
            Sedang Ditinjau
        </a>
        <a href="{{ route('alumni.my-posts', ['status' => 'revision_required']) }}" class="btn btn-sm {{ $status === 'revision_required' ? 'btn-danger' : 'btn-outline' }}">
            Perlu Revisi
        </a>
        <a href="{{ route('alumni.my-posts', ['status' => 'draft']) }}" class="btn btn-sm {{ $status === 'draft' ? 'btn-primary' : 'btn-outline' }}">
            Draf
        </a>
    </div>

    <!-- Create Actions -->
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('alumni.create-aksi') }}" class="btn btn-primary" style="font-size: 0.82rem;">
            <i class="fa-solid fa-hands-holding-circle"></i> Tulis Berita Aksi
        </a>
        <a href="{{ route('alumni.create-artikel') }}" class="btn btn-outline" style="font-size: 0.82rem;">
            <i class="fa-solid fa-lightbulb"></i> Tulis Artikel
        </a>
    </div>
</div>

<div style="background: white; border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid var(--border-color);">
                <th style="padding: 14px 20px; font-weight: 700; color: #475569;">Judul</th>
                <th style="padding: 14px 20px; font-weight: 700; color: #475569;">Kategori / Tipe</th>
                <th style="padding: 14px 20px; font-weight: 700; color: #475569;">Status Moderasi</th>
                <th style="padding: 14px 20px; font-weight: 700; color: #475569;">Pembaruan</th>
                <th style="padding: 14px 20px; font-weight: 700; color: #475569; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $p)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 16px 20px;">
                        <strong style="color: #0f172a; font-size: 0.95rem; display: block;">{{ $p->title }}</strong>
                        @if($p->status === 'revision_required' && $p->admin_notes)
                            <div style="margin-top: 6px; font-size: 0.8rem; background: #fef2f2; color: #991b1b; padding: 6px 12px; border-radius: 6px; border-left: 3px solid #ef4444;">
                                <strong>Catatan Redaksi:</strong> {{ $p->admin_notes }}
                            </div>
                        @endif
                    </td>
                    <td style="padding: 16px 20px;">
                        <span style="font-size: 0.76rem; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-weight: 600; color: #334155;">
                            {{ $p->post_type === 'aksi_hatta_muda' ? 'Aksi Hatta Muda' : 'Artikel Gagasan' }}
                        </span>
                    </td>
                    <td style="padding: 16px 20px;">
                        @if($p->status === 'published')
                            <span style="background: #ecfdf5; color: #065f46; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Disetujui / Terbit</span>
                        @elseif($p->status === 'pending_review')
                            <span style="background: #fffbeb; color: #92400e; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Menunggu Verifikasi</span>
                        @elseif($p->status === 'revision_required')
                            <span style="background: #fef2f2; color: #991b1b; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Perlu Revisi</span>
                        @elseif($p->status === 'rejected')
                            <span style="background: #f1f5f9; color: #475569; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Ditolak</span>
                        @else
                            <span style="background: #f8fafc; color: #64748b; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Draf</span>
                        @endif
                    </td>
                    <td style="padding: 16px 20px; color: #64748b; font-size: 0.82rem;">
                        {{ $p->updated_at->format('d/m/Y H:i') }}
                    </td>
                    <td style="padding: 16px 20px; text-align: right;">
                        <a href="{{ route('alumni.edit-post', $p->id) }}" class="btn btn-outline btn-sm">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        @if($p->status === 'published')
                            <a href="{{ $p->post_type === 'artikel' ? route('artikel.show', $p->slug) : route('berita.show', $p->slug) }}" target="_blank" class="btn btn-outline btn-sm">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">
                        Tidak ada naskah tulisan dalam kategori ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 30px;">
    {{ $posts->links() }}
</div>

@endsection
