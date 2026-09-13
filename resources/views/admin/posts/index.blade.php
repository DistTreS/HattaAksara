@extends('layouts.admin')

@section('title', 'Manajemen Berita Resmi')
@section('page_title', 'Kelola Berita Resmi & Kegiatan')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-sm {{ $type === 'all' ? 'btn-primary' : 'btn-outline' }}">Semua</a>
        <a href="{{ route('admin.posts.index', ['type' => 'news']) }}" class="btn btn-sm {{ $type === 'news' ? 'btn-primary' : 'btn-outline' }}">News Resmi</a>
        <a href="{{ route('admin.posts.index', ['type' => 'kegiatan']) }}" class="btn btn-sm {{ $type === 'kegiatan' ? 'btn-primary' : 'btn-outline' }}">Kegiatan & Forum</a>
    </div>

    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Berita Baru
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Judul Berita</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Dibaca</th>
                    <th>Tanggal Terbit</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>
                            <strong style="color: #0f172a; font-size: 0.95rem; display: block;">{{ $post->title }}</strong>
                            <span style="font-size: 0.78rem; color: #64748b;">{{ $post->subCategory?->name ?? '-' }}</span>
                        </td>
                        <td>
                            <span style="font-size: 0.75rem; background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-weight: 700; text-transform: uppercase;">
                                {{ $post->post_type }}
                            </span>
                        </td>
                        <td>{{ $post->author?->name }}</td>
                        <td><i class="fa-regular fa-eye"></i> {{ $post->views_count }}</td>
                        <td style="font-size: 0.82rem; color: #64748b;">
                            {{ $post->published_at?->format('d/m/Y H:i') ?? $post->created_at->format('d/m/Y') }}
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                <a href="{{ route('berita.show', $post->slug) }}" target="_blank" class="btn btn-outline btn-sm" title="Lihat">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                                <form action="{{ route('admin.posts.delete', $post->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 35px; color: #64748b;">
                            Belum ada berita yang diterbitkan.
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
