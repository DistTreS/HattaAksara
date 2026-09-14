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

        <!-- Settings Modal Button -->
        <button type="button" onclick="openSheetsModal()" class="btn btn-outline" style="color: #0369a1; border-color: #0284c7;">
            <i class="fa-solid fa-sliders"></i> Pengaturan Spreadsheet
        </button>

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


<!-- Google Sheets Config Modal -->
<div id="sheetsModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: white; border-radius: 16px; max-width: 680px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); border: 1px solid #e2e8f0;">
        <div style="padding: 24px 28px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fa-brands fa-google-drive"></i>
                </div>
                <div>
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin: 0;">Integrasi Google Spreadsheet Panitia</h3>
                    <span style="font-size: 0.8rem; color: #64748b;">Hubungkan pendaftaran calon peserta ISLT ke Google Sheet panitia</span>
                </div>
            </div>
            <button type="button" onclick="closeSheetsModal()" style="background: none; border: none; font-size: 1.3rem; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>

        <div style="padding: 28px;">
            <!-- Status Badge -->
            <div style="margin-bottom: 24px; padding: 14px 18px; border-radius: 10px; background: {{ !empty($sheetsWebhookUrl) ? '#f0fdf4' : '#fffbeb' }}; border: 1px solid {{ !empty($sheetsWebhookUrl) ? '#bbf7d0' : '#fde68a' }}; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid {{ !empty($sheetsWebhookUrl) ? 'fa-circle-check' : 'fa-triangle-exclamation' }}" style="color: {{ !empty($sheetsWebhookUrl) ? '#16a34a' : '#d97706' }}; font-size: 1.1rem;"></i>
                    <span style="font-size: 0.88rem; font-weight: 600; color: {{ !empty($sheetsWebhookUrl) ? '#166534' : '#92400e' }};">
                        {{ !empty($sheetsWebhookUrl) ? 'Status: Webhook Google Spreadsheet Aktif' : 'Status: Webhook Belum Dikonfigurasi' }}
                    </span>
                </div>
                @if(!empty($sheetsWebhookUrl))
                    <span style="font-size: 0.75rem; background: #22c55e; color: white; padding: 2px 8px; border-radius: 6px; font-weight: 700;">TERHUBUNG</span>
                @endif
            </div>

            <!-- Form Save Webhook URL -->
            <form action="{{ route('admin.islt.save-sheets-config') }}" method="POST" style="margin-bottom: 28px;">
                @csrf
                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    URL Webhook Google Apps Script:
                </label>
                <div style="display: flex; gap: 10px;">
                    <input type="url" name="sheets_webhook_url" value="{{ old('sheets_webhook_url', $sheetsWebhookUrl ?? '') }}" placeholder="https://script.google.com/macros/s/.../exec" class="form-control" style="flex: 1; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem;" required>
                    <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </div>
                <span style="font-size: 0.78rem; color: #64748b; margin-top: 4px; display: block;">
                    Masukkan link Web App Google Apps Script dari spreadsheet panitia.
                </span>
            </form>

            <!-- Guide & Apps Script Code -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
                <h4 style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin: 0 0 12px 0;">
                    <i class="fa-solid fa-circle-question" style="color: #0284c7; margin-right: 6px;"></i> Cara Menghubungkan ke Google Spreadsheet Anda:
                </h4>
                <ol style="font-size: 0.84rem; color: #475569; padding-left: 20px; line-height: 1.6; margin: 0 0 16px 0;">
                    <li>Buka Google Spreadsheet panitia (misal: <em>"Data Pendaftar Seleksi ISLT 2026"</em>).</li>
                    <li>Klik menu <strong>Extensions &gt; Apps Script</strong> (Ekstensi &gt; Apps Script).</li>
                    <li>Hapus kode bawaan, lalu tempel kode skrip di bawah ini.</li>
                    <li>Klik <strong>Deploy &gt; New deployment</strong>, pilih type <strong>Web app</strong>.</li>
                    <li>Pilih <strong>Who has access: Anyone</strong> (Siapa saja), lalu klik <strong>Deploy</strong>.</li>
                    <li>Salin <strong>Web App URL</strong> yang dihasilkan ke kolom input di atas, lalu klik <strong>Simpan</strong>.</li>
                </ol>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <span style="font-size: 0.78rem; font-weight: 700; color: #334155;">Kode Google Apps Script:</span>
                    <button type="button" onclick="copyAppsScriptCode()" id="copyScriptBtn" class="btn btn-outline btn-sm" style="padding: 3px 10px; font-size: 0.75rem;">
                        <i class="fa-solid fa-copy"></i> Salin Kode
                    </button>
                </div>
                <pre id="appsScriptCodeBlock" style="background: #0f172a; color: #e2e8f0; padding: 14px; border-radius: 8px; font-size: 0.75rem; overflow-x: auto; line-height: 1.5; font-family: monospace; margin: 0;">function doPost(e) {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
  var data = JSON.parse(e.postData.contents);
  var applicants = data.applicants || [];
  
  for (var i = 0; i < applicants.length; i++) {
    var a = applicants[i];
    sheet.appendRow([
      a.submitted_at || new Date(),
      a.registration_code,
      a.full_name,
      a.nisn,
      a.gender,
      a.whatsapp_number,
      a.email,
      a.school_name,
      a.osis_position,
      a.province,
      a.city,
      a.motivation_essay
    ]);
  }
  
  return ContentService.createTextOutput(JSON.stringify({ status: "success", count: applicants.length }))
    .setMimeType(ContentService.MimeType.JSON);
}</pre>
            </div>
        </div>

        <div style="padding: 16px 28px; border-top: 1px solid #e2e8f0; background: #f8fafc; display: flex; justify-content: flex-end;">
            <button type="button" onclick="closeSheetsModal()" class="btn btn-outline btn-sm">Tutup</button>
        </div>
    </div>
</div>

<script>
function openSheetsModal() {
    document.getElementById('sheetsModal').style.display = 'flex';
}
function closeSheetsModal() {
    document.getElementById('sheetsModal').style.display = 'none';
}
function copyAppsScriptCode() {
    var code = document.getElementById('appsScriptCodeBlock').innerText;
    navigator.clipboard.writeText(code).then(function() {
        var btn = document.getElementById('copyScriptBtn');
        btn.innerHTML = '<i class="fa-solid fa-check" style="color:#10b981;"></i> Tersalin!';
        setTimeout(function() {
            btn.innerHTML = '<i class="fa-solid fa-copy"></i> Salin Kode';
        }, 2000);
    });
}
</script>

@endsection
