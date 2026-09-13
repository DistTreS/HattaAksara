@extends('layouts.admin')

@section('title', 'Manajemen Peserta ISLT')
@section('page_title', 'Manajemen Pendaftar Calon Peserta ISLT')

@section('content')

<!-- Action & Export Bar -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
    <div>
        <h2 style="font-family: var(--font-display); font-size: 1.35rem; color: #0f172a; margin-bottom: 4px;">
            Data Pendaftaran Siswa (Ketua OSIS Se-Indonesia)
        </h2>
        <span style="font-size: 0.84rem; color: #64748b;">
            Total Pendaftar Masuk: <strong>{{ $applicants->total() }} Calon Peserta</strong>
        </span>
    </div>

    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <!-- Export Excel -->
        <a href="{{ route('admin.islt.export-xlsx') }}" class="btn btn-outline" style="color: #065f46; border-color: #10b981;">
            <i class="fa-solid fa-file-excel" style="color: #10b981;"></i> Ekspor XLSX / Excel
        </a>

        <!-- Export PDF -->
        <a href="{{ route('admin.islt.export-pdf') }}" target="_blank" class="btn btn-outline" style="color: #991b1b; border-color: #ef4444;">
            <i class="fa-solid fa-file-pdf" style="color: #ef4444;"></i> Ekspor Dokumen PDF
        </a>

        <!-- Sync Google Sheets -->
        <form action="{{ route('admin.islt.sync-sheets') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-primary" title="Sinkronkan data pendaftar baru ke Google Spreadsheet">
                <i class="fa-solid fa-table-cells"></i> Sinkron Google Sheets
            </button>
        </form>
    </div>
</div>

<!-- Filters -->
<div style="background: white; border-radius: 12px; padding: 18px; border: 1px solid var(--border-color); margin-bottom: 24px;">
    <form action="{{ route('admin.islt.index') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 14px; align-items: center;">
        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, kode registrasi, sekolah, atau email..." class="form-control" style="width:100%; padding:9px 14px; border:1px solid #cbd5e1; border-radius:6px;">

        <select name="status" class="form-control" style="width:100%; padding:9px 14px; border:1px solid #cbd5e1; border-radius:6px;">
            <option value="">-- Semua Status Seleksi --</option>
            <option value="submitted" {{ $status === 'submitted' ? 'selected' : '' }}>Submitted (Pendaftaran Masuk)</option>
            <option value="screening" {{ $status === 'screening' ? 'selected' : '' }}>Screening (Pemeriksaan Berkas)</option>
            <option value="interview" {{ $status === 'interview' ? 'selected' : '' }}>Interview (Wawancara)</option>
            <option value="passed" {{ $status === 'passed' ? 'selected' : '' }}>Passed (Lulus Seleksi)</option>
            <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected (Tidak Lulus)</option>
        </select>

        <select name="prov" class="form-control" style="width:100%; padding:9px 14px; border:1px solid #cbd5e1; border-radius:6px;">
            <option value="">-- Semua Provinsi --</option>
            @foreach($provinces as $prv)
                <option value="{{ $prv }}" {{ $province === $prv ? 'selected' : '' }}>{{ $prv }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-outline" style="padding: 9px 18px;">
            <i class="fa-solid fa-filter"></i> Saring
        </button>
    </form>
</div>

<!-- Applicants Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Kode Registrasi</th>
                    <th>Nama & Jenis Kelamin</th>
                    <th>Asal Sekolah & Jabatan</th>
                    <th>Provinsi / Kota</th>
                    <th>Kontak WhatsApp</th>
                    <th>Status Seleksi</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applicants as $app)
                    <tr>
                        <td>
                            <code style="background: #f1f5f9; padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 0.8rem;">
                                {{ $app->registration_code }}
                            </code>
                            @if($app->synced_to_sheets_at)
                                <div style="font-size: 0.7rem; color: #10b981; margin-top: 2px;">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> Terhubung Sheets
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong style="color: #0f172a; display: block;">{{ $app->full_name }}</strong>
                            <span style="font-size: 0.78rem; color: #64748b;">
                                {{ $app->gender === 'L' ? 'Laki-Laki' : 'Perempuan' }} &bull; Lahir: {{ $app->birth_place }}
                            </span>
                        </td>
                        <td>
                            <strong style="color: #334155; display: block;">{{ $app->school_name }}</strong>
                            <span style="font-size: 0.78rem; color: var(--gold-dark); font-weight: 600;">{{ $app->osis_position }}</span>
                        </td>
                        <td>
                            <span style="font-size: 0.85rem; color: #334155; display: block;">{{ $app->province }}</span>
                            <span style="font-size: 0.76rem; color: #64748b;">{{ $app->city }}</span>
                        </td>
                        <td>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $app->whatsapp_number) }}" target="_blank" style="color: #15803d; font-weight: 600; font-size: 0.84rem;">
                                <i class="fa-brands fa-whatsapp"></i> {{ $app->whatsapp_number }}
                            </a>
                            <div style="font-size: 0.76rem; color: #64748b;">{{ $app->email }}</div>
                        </td>
                        <td>
                            @if($app->selection_status === 'passed')
                                <span style="background: #ecfdf5; color: #065f46; font-size: 0.74rem; font-weight: 700; padding: 3px 8px; border-radius: 8px; text-transform: uppercase;">Lulus</span>
                            @elseif($app->selection_status === 'screening')
                                <span style="background: #fffbeb; color: #92400e; font-size: 0.74rem; font-weight: 700; padding: 3px 8px; border-radius: 8px; text-transform: uppercase;">Screening</span>
                            @elseif($app->selection_status === 'interview')
                                <span style="background: #e0f2fe; color: #0369a1; font-size: 0.74rem; font-weight: 700; padding: 3px 8px; border-radius: 8px; text-transform: uppercase;">Wawancara</span>
                            @else
                                <span style="background: #f1f5f9; color: #475569; font-size: 0.74rem; font-weight: 700; padding: 3px 8px; border-radius: 8px; text-transform: uppercase;">Submitted</span>
                            @endif
                        </td>
                        <td style="font-size: 0.8rem; color: #64748b;">
                            {{ $app->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                            Tidak ada calon peserta yang memenuhi kriteria saringan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 25px;">
    {{ $applicants->links() }}
</div>

@endsection
