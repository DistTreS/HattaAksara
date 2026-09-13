@extends('layouts.admin')

@section('title', 'Tinjau Naskah: ' . $post->title)
@section('page_title', 'Tinjau Naskah Tulisan')

@section('content')

<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.review-posts.index') }}" class="btn btn-outline btn-sm">
        &larr; Kembali ke Daftar Naskah
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Naskah Content Column -->
    <div>
        <div class="card">
            <div class="card-header">
                <div>
                    <span style="font-size: 0.74rem; font-weight: 700; background: rgba(122, 22, 30, 0.1); color: var(--maroon-primary); padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">
                        {{ $post->post_type === 'aksi_hatta_muda' ? 'Aksi Hatta Muda' : 'Artikel Gagasan' }}
                    </span>
                    <h2 style="font-family: var(--font-display); font-size: 1.5rem; color: #0f172a; margin-top: 10px; line-height: 1.35;">
                        {{ $post->title }}
                    </h2>
                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 6px;">
                        Diajukan oleh: <strong>{{ $post->author?->name }}</strong> &bull; {{ $post->created_at->format('d F Y, H:i') }}
                    </div>
                </div>
            </div>
            <div class="card-body" style="font-size: 1rem; line-height: 1.85; color: #334155;">
                @if($post->post_type === 'aksi_hatta_muda')
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; font-size: 0.88rem;">
                        <strong>Lokasi Aksi:</strong> {{ $post->action_location ?? '-' }} &bull; 
                        <strong>Tanggal Aksi:</strong> {{ $post->action_date?->format('d/m/Y') ?? '-' }}
                    </div>
                @endif

                <div style="font-family: var(--font-serif); font-style: italic; color: #64748b; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;">
                    "{{ $post->excerpt }}"
                </div>

                <div>
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Moderation Decision Column -->
    <div>
        <!-- Author Profile Snippet -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-user-graduate" style="color:var(--gold-dark); margin-right:6px;"></i> Profil Penulis</h3>
            </div>
            <div class="card-body" style="font-size: 0.88rem;">
                <strong style="font-size: 1rem; color: #0f172a; display: block;">{{ $post->author?->name }}</strong>
                <div style="color: #64748b; margin-bottom: 10px;">{{ $post->author?->email }}</div>
                
                @php $prof = $post->author?->alumniProfile; @endphp
                <div style="display: flex; flex-direction: column; gap: 6px; font-size: 0.84rem; color: #475569;">
                    <div><strong>Angkatan:</strong> {{ $prof?->islt_batch ?? '-' }}</div>
                    <div><strong>Asal Sekolah:</strong> {{ $prof?->school_origin ?? '-' }}</div>
                    <div><strong>Wilayah:</strong> {{ $prof?->city }}, {{ $prof?->province }}</div>
                    @if($prof?->current_institution)
                        <div><strong>Institusi:</strong> {{ $prof->current_institution }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Decision Box -->
        <div class="card" style="border-top: 4px solid var(--maroon-primary);">
            <div class="card-header">
                <h3 class="card-title"><i class="fa-solid fa-gavel" style="color:var(--maroon-primary); margin-right:6px;"></i> Keputusan Redaksi</h3>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 14px; font-size: 0.84rem; color: #64748b;">
                    Status Saat Ini: <strong style="text-transform: uppercase; color: #0f172a;">{{ str_replace('_', ' ', $post->status) }}</strong>
                </div>

                <form action="{{ route('admin.review-posts.status', $post->id) }}" method="POST">
                    @csrf

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                            Pilih Tindakan Moderasi:
                        </label>
                        <select name="action" id="moderation_action" class="form-control" style="width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px;" onchange="handleActionChange(this.value)">
                            <option value="approve">Setujui (Langsung Terbit di Publik)</option>
                            <option value="revision">Minta Revisi (Kembalikan ke Penulis)</option>
                            <option value="reject">Tolak Naskah</option>
                        </select>
                    </div>

                    <div id="notes_container" style="margin-bottom: 18px; display: none;">
                        <label style="display: block; font-size: 0.84rem; font-weight: 700; color: #991b1b; margin-bottom: 6px;">
                            Catatan Revisi / Alasan Penolakan:
                        </label>
                        <textarea name="admin_notes" id="admin_notes_input" rows="4" class="form-control" style="width:100%; padding:10px; border:1px solid #fca5a5; border-radius:6px; font-size:0.86rem;" placeholder="Tuliskan bagian mana yang perlu diperbaiki (misal: rujukan data, keselarasan nilai, etika tulisan)...">{{ old('admin_notes', $post->admin_notes) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-check-double"></i> Simpan Keputusan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function handleActionChange(val) {
        const notesContainer = document.getElementById('notes_container');
        if (val === 'revision' || val === 'reject') {
            notesContainer.style.display = 'block';
        } else {
            notesContainer.style.display = 'none';
        }
    }
</script>
@endpush

@endsection
