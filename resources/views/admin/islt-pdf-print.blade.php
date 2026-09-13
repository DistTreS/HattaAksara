<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Pendaftar ISLT - Yayasan Proklamator Bung Hatta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            color: #111;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 14pt;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .header h2 {
            font-size: 12pt;
            margin: 4px 0;
            color: #333;
        }
        .header p {
            font-size: 9pt;
            color: #555;
            margin: 0;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title h3 {
            margin: 0;
            font-size: 12pt;
            text-transform: uppercase;
        }
        .title span {
            font-size: 9pt;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .btn-print {
            background: #7a161e;
            color: white;
            padding: 8px 18px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 15px;
        }
        @media print {
            .btn-print {
                display: none;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <div style="text-align: right;">
        <button onclick="window.print()" class="btn-print">Cetak / Simpan PDF</button>
    </div>

    <div class="header">
        <h1>YAYASAN PROKLAMATOR BUNG HATTA</h1>
        <h2>HATTA AKSARA PROJECT</h2>
        <p>Sekretariat Pusat: Jakarta & Bukittinggi &bull; Email: sekretariat@hattaaksara.id &bull; Web: hattaaksara.id</p>
    </div>

    <div class="title">
        <h3>Rekapitulasi Calon Peserta Seleksi ISLT 2026</h3>
        <span>Dicetak pada: {{ date('d F Y, H:i') }} WIB &bull; Total Terdaftar: {{ $applicants->count() }} Orang</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Kode Registrasi</th>
                <th>Nama Calon Peserta</th>
                <th>L/P</th>
                <th>Asal Sekolah & OSIS</th>
                <th>Provinsi & Kota</th>
                <th>WhatsApp</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applicants as $index => $app)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td><strong>{{ $app->registration_code }}</strong></td>
                    <td>{{ $app->full_name }}</td>
                    <td style="text-align: center;">{{ $app->gender }}</td>
                    <td>{{ $app->school_name }} ({{ $app->osis_position }})</td>
                    <td>{{ $app->province }} - {{ $app->city }}</td>
                    <td>{{ $app->whatsapp_number }}</td>
                    <td style="text-transform: uppercase;">{{ $app->selection_status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Belum ada pendaftar yang tercatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
