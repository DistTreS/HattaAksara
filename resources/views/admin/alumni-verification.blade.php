@extends('layouts.admin')

@section('title', 'Verifikasi Akun Hatta Muda')
@section('page_title', 'Verifikasi Akun Alumni Hatta Muda')

@section('content')

<div style="margin-bottom: 24px;">
    <h2 style="font-family: var(--font-display); font-size: 1.4rem; color: #0f172a; margin-bottom: 4px;">
        Daftar Pendaftar Alumni Menunggu Keputusan
    </h2>
    <p style="color: #64748b; font-size: 0.9rem;">
        Periksa keabsahan kepesertaan ISLT pendaftar. Jika disetujui, akun akan aktif. Jika ditolak, data pendaftar akan langsung dihapus dari sistem.
    </p>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Data Pendaftar</th>
                    <th>Angkatan ISLT</th>
                    <th>Asal Sekolah & Domisili</th>
                    <th>Institusi Terkini</th>
                    <th>Bukti Sertifikat</th>
                    <th style="text-align: right;">Aksi Keputusan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingAlumni as $alm)
                    @php $prof = $alm->alumniProfile; @endphp
                    <tr>
                        <td>
                            <strong style="color: #0f172a; font-size: 0.95rem; display: block;">{{ $alm->name }}</strong>
                            <span style="font-size: 0.8rem; color: #64748b;">{{ $alm->email }}</span>
                            <div style="font-size: 0.78rem; color: #0284c7; margin-top: 2px;">
                                <i class="fa-brands fa-whatsapp"></i> {{ $prof?->phone_number ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <span style="background: rgba(197, 155, 39, 0.15); color: var(--gold-dark); font-weight: 700; font-size: 0.8rem; padding: 4px 10px; border-radius: 8px;">
                                {{ $prof?->islt_batch }}
                            </span>
                        </td>
                        <td>
                            <strong style="color: #334155; display: block;">{{ $prof?->school_origin }}</strong>
                            <span style="font-size: 0.78rem; color: #64748b;">{{ $prof?->city }}, {{ $prof?->province }}</span>
                        </td>
                        <td>
                            {{ $prof?->current_institution ?? '-' }}
                        </td>
                        <td>
                            @if($prof?->proof_document_path)
                                <a href="{{ asset('storage/' . $prof->proof_document_path) }}" target="_blank" class="btn btn-outline btn-sm">
                                    <i class="fa-solid fa-file-pdf" style="color: #ef4444;"></i> Lihat Berkas
                                </a>
                            @else
                                <span style="font-size: 0.78rem; color: #94a3b8; font-style: italic;">Tidak ada berkas</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <form action="{{ route('admin.verify-alumni.approve', $alm->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-check"></i> Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.verify-alumni.reject', $alm->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak akun ini? Data akun akan langsung dihapus dari database.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i> Tolak & Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #64748b;">
                            <i class="fa-solid fa-circle-check" style="font-size: 2rem; color: #10b981; margin-bottom: 8px; display: block;"></i>
                            Semua pendaftaran alumni telah diverifikasi! Tidak ada data yang pending.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 25px;">
    {{ $pendingAlumni->links() }}
</div>

@endsection
