@extends('layouts.admin')

@section('title', 'Moderasi Tulisan')
@section('page_title', 'Moderasi Tulisan (Aksi Hatta Muda & Artikel)')

@section('content')

<!-- Filter Tabs -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a href="{{ route('admin.review-posts.index', ['status' => 'pending_review', 'type' => $type]) }}" class="btn btn-sm {{ $status === 'pending_review' ? 'btn-primary' : 'btn-outline' }}">
            Menunggu Review
        </a>
        <a href="{{ route('admin.review-posts.index', ['status' => 'revision_required', 'type' => $type]) }}" class="btn btn-sm {{ $status === 'revision_required' ? 'btn-danger' : 'btn-outline' }}">
            Sedang Direvisi
        </a>
        <a href="{{ route('admin.review-posts.index', ['status' => 'published', 'type' => $type]) }}" class="btn btn-sm {{ $status === 'published' ? 'btn-success' : 'btn-outline' }}">
            Telah Disetujui
        </a>
        <a href="{{ route('admin.review-posts.index', ['status' => 'all', 'type' => $type]) }}" class="btn btn-sm {{ $status === 'all' ? 'btn-primary' : 'btn-outline' }}">
            Semua Status
        </a>
    </div>

    <div style="display: flex; gap: 10px;">
        <a href="{{ route('admin.review-posts.index', ['status' => $status, 'type' => 'aksi_hatta_muda']) }}" class="btn btn-outline btn-sm {{ $type === 'aksi_hatta_muda' ? 'btn-primary' : '' }}">
            <i class="fa-solid fa-hands-holding-circle"></i> Hanya Aksi
        </a>
        <a href="{{ route('admin.review-posts.index', ['status' => $status, 'type' => 'artikel']) }}" class="btn btn-outline btn-sm {{ $type === 'artikel' ? 'btn-primary' : '' }}">
            <i class="fa-solid fa-lightbulb"></i> Hanya Artikel
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Judul Naskah</th>
                    <th>Tipe Tulisan</th>
                    <th>Penulis</th>
                    <th>Status Saat Ini</th>
                    <th>Tanggal Masuk</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>
                            <strong style="color: #0f172a; font-size: 0.95rem; display: block;">{{ $post->title }}</strong>
                            <span style="font-size: 0.78rem; color: #64748b;">{{ $post->subCategory?->name ?? 'Umum' }}</span>
                            @if($post->status === 'revision_required' && $post->admin_notes)
                                <div style="font-size: 0.78rem; color: #991b1b; margin-top: 4px;">
                                    <strong>Catatan:</strong> {{ Str::limit($post->admin_notes, 60) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 0.76rem; background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-weight: 600;">
                                {{ $post->post_type === 'aksi_hatta_muda' ? 'Aksi Hatta Muda' : 'Artikel Gagasan' }}
                            </span>
                        </td>
                        <td>
                            <strong style="color: #334155; display: block;">{{ $post->author?->name }}</strong>
                            <span style="font-size: 0.74rem; color: var(--gold-dark);">{{ $post->author?->alumniProfile?->islt_batch }}</span>
                        </td>
                        <td>
                            @if($post->status === 'published')
                                <span style="background: #ecfdf5; color: #065f46; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Disetujui</span>
                            @elseif($post->status === 'pending_review')
                                <span style="background: #fffbeb; color: #92400e; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Pending Review</span>
                            @elseif($post->status === 'revision_required')
                                <span style="background: #fef2f2; color: #991b1b; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Perlu Revisi</span>
                            @elseif($post->status === 'rejected')
                                <span style="background: #f1f5f9; color: #475569; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 12px;">Ditolak</span>
                            @endif
                        </td>
                        <td style="font-size: 0.82rem; color: #64748b;">
                            {{ $post->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('admin.review-posts.detail', $post->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-file-signature"></i> Tinjau Naskah
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 35px; color: #64748b;">
                            Tidak ada naskah tulisan dalam kategori filter ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 25px;">
    {{ $posts->links() }}
</div>

@endsection
