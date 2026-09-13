# DOKUMEN SPESIFIKASI KEBUTUHAN SISTEM (REQUIREMENT.MD)
## PROYEK: PLATFORM WEB HATTA AKSARA PROJECT
**Versi:** 1.0.0  
**Tanggal:** 2026-09-12  
**Status:** Disetujui sebagai Dokumen Acuan Pengembangan  

---

## 1. PENDAHULUAN

### 1.1 Maksud dan Tujuan
Dokumen ini mendefinisikan seluruh kebutuhan fungsional, non-fungsional, arsitektur data, dan aturan bisnis untuk pengembangan aplikasi web **Hatta Aksara Project** menggunakan framework **Laravel**. Web ini berfungsi sebagai pusat informasi resmi, media publikasi jurnalistik & gagasan pemuda, repositori e-jurnal, platform pendaftaran ISLT, serta wadah kolaborasi alumni (Hatta Muda).

### 1.2 Lingkup Sistem
Sistem mencakup tiga area antarmuka utama:
1. **Public Web Portal (Frontend Tamu/Publik)**
2. **Hatta Muda Connection Portal (Member Area Alumni)**
3. **Admin & Editorial Backoffice (Panel Manajemen & Kurasi)**

---

## 2. SPESIFIKASI KEBUTUHAN FUNGSIONAL (FUNCTIONAL REQUIREMENTS)

### MODUL 1: GUEST / UMUM / PUBLIK

| ID Kebutuhan | Nama Fitur | Deskripsi & Aturan Bisnis |
| :--- | :--- | :--- |
| **FR-G-01** | Mengakses Beranda Publik | Menampilkan hero banner, profil singkat Hatta Aksara, highlight berita teranyar, spotlight program (ISLT & Media Edukasi), cuplikan artikel Hatta Muda, dan statistik dampak nasional. |
| **FR-G-02** | Membaca Berita | Menampilkan daftar berita dalam 3 kategori utama: **News** (resmi organisasi), **Aksi Hatta Muda** (kegiatan dampak alumni), dan **Kegiatan** (liputan acara/agenda). Dilengkapi filter sub-kategori (Ekonomi, Politik, Kebudayaan, SDGs, Agama, dll), pencarian kata kunci, dan pagination. |
| **FR-G-03** | Detail Berita | Halaman baca berita lengkap dengan gambar sampul, metadata penulis, tanggal rilis, kategori/sub-kategori, tombol bagikan sosial media, dan rekomendasi artikel terkait. |
| **FR-G-04** | Melihat Halaman Program | Menampilkan ikhtisar seluruh program inisiatif dengan fokus utama pada **ISLT** dan **Media Edukasi**. |
| **FR-G-05** | Halaman Detail ISLT | Menjelaskan latar belakang, visi, kurikulum kepemimpinan, napak tilas sejarah Bung Hatta, syarat kepesertaan, serta tombol Call-to-Action menuju formulir pendaftaran. |
| **FR-G-06** | Formulir Pendaftaran Peserta ISLT | Formulir publik tanpa registrasi akun. Mengumpulkan data diri lengkap: Nama Lengkap, NIK/NISN, Tempat & Tanggal Lahir, Jenis Kelamin, Nomor WhatsApp/Telepon, Email, Asal Provinsi & Kota/Kabupaten, Asal Sekolah, Jabatan di OSIS (Ketua OSIS / Wakil), Prestasi/Pengalaman Organisasi, Unggah Foto & Dokumen Pendukung (Kartu Pelajar / Surat Rekomendasi Sekolah), serta Esai Singkat Motivasi. Setelah kirim, peserta menerima Kode Pendaftaran Unik (misal: `ISLT-2026-00123`) dan tanda terima digital. |
| **FR-G-07** | Halaman Media Edukasi | Memuat penjelasan ekosistem digital Hatta Aksara, literasi koperasi & kebangsaan, peran platform ini sebagai wadah pergerakan, dan tombol Call-to-Action "Bergabung Menjadi Hatta Muda". |
| **FR-G-08** | Registrasi Akun Alumni ("Bergabung Menjadi Hatta Muda") | Formulir pendaftaran akun bagi alumni program ISLT: Nama Lengkap, Email, Password, Angkatan/Tahun Lulus ISLT, Provinsi Asal, Sekolah/Institusi Saat Ini, Nomor Kontak, Akun Media Sosial (LinkedIn/Instagram), dan Unggah Bukti Alumni (Sertifikat ISLT / Surat Kepesertaan). Akun berstatus `pending_verification` sampai disetujui Admin. |
| **FR-G-09** | Melihat Artikel Gagasan | Menampilkan daftar artikel pemikiran, esai ilmiah populer, dan opini yang ditulis oleh Hatta Muda (alumni) yang telah disetujui oleh redaksi. |
| **FR-G-10** | Melihat E-Jurnal & Perpustakaan Digital | Menampilkan repositori dokumen digital resmi (Kurikulum ISLT, Modul Kepemimpinan, Jurnal Ekonomi Kerakyatan, Arsip Dokumen Kebangsaan). Pengguna dapat melihat pratinjau PDF di browser atau mengunduhnya secara langsung. |
| **FR-G-11** | Melihat Halaman Tentang | Menjelaskan secara komprehensif profil Hatta Aksara Project, sejarah Yayasan Proklamator Bung Hatta, filosofi *Weltanschauung*, prinsip ekonomi koperasi Bung Hatta, visi-misi, dan struktur inisiator/tokoh pendukung. |

---

### MODUL 2: HATTA MUDA CONNECTION (PORTAL ALUMNI)

| ID Kebutuhan | Nama Fitur | Deskripsi & Aturan Bisnis |
| :--- | :--- | :--- |
| **FR-HM-01** | Autentikasi & Hak Masuk | Alumni login dengan email & password. Sistem memverifikasi bahwa akun telah berstatus `approved` oleh Admin. Akun berstatus `pending` mendapatkan halaman peringatan verifikasi. Akun yang ditolak dihapus dari sistem. |
| **FR-HM-02** | Dashboard Hatta Muda | Menampilkan ringkasan data personal: status keanggotaan, jumlah berita aksi yang dipublikasikan, jumlah artikel yang dibuat, pengumuman internal alumni, dan daftar tulisan yang membutuhkan revisi. |
| **FR-HM-03** | Menulis Berita "Aksi Hatta Muda" | Formulir penulisan dampak sosial alumni: Judul Berita, Gambar Sampul, Sub-kategori, Lokasi Aksi (Provinsi/Kota), Isi Berita (WYSIWYG Editor), Tanggal Aksi. Tombol aksi: **Simpan Draf** atau **Ajukan untuk Ditinjau (Submit for Review)**. Status awal: `pending_review`. |
| **FR-HM-04** | Menulis "Artikel" Gagasan | Formulir penulisan gagasan, ide, atau pemikiran: Judul Artikel, Sinopsis/Kutipan Singkat, Kategori Tematik, Isi Artikel (WYSIWYG Editor), Tagar. Tombol aksi: **Simpan Draf** atau **Ajukan untuk Ditinjau**. Status awal: `pending_review`. |
| **FR-HM-05** | Manajemen & Pelacakan Status Tulisan | Hatta Muda dapat melihat tabel seluruh tulisannya beserta status: `Draft`, `Diajukan (Pending)`, `Perlu Revisi (Revision Required)`, `Disetujui (Published)`, atau `Ditolak (Rejected)`. Jika berstatus **Revisi**, penulis dapat membaca **Catatan Revisi dari Redaksi**, mengedit naskah, dan mengirimkannya ulang. |
| **FR-HM-06** | Mengakses Direktori Jejaring (*Networking Directory*) | Halaman pencarian sesama alumni Hatta Muda Connection se-Indonesia. Fitur: Filter berdasarkan Provinsi, Angkatan ISLT, Bidang Kepakaran/Minat. Menampilkan kartu profil dengan foto, nama, angkatan, sekolah/institusi, dan tautan sosial (LinkedIn/Instagram/Email). **Tidak menyediakan chat internal**, melainkan kanal kontak langsung via media sosial/surel resmi. |
| **FR-HM-07** | Kelola Profil Diri | Pengaturan data diri alumni: Foto profil, Bio singkat, Pekerjaan/Kampus terkini, Domisili sekarang, Link sosial media, serta opsi privasi kontak. |

---

### MODUL 3: ADMIN & REDAKSI (BACKOFFICE)

| ID Kebutuhan | Nama Fitur | Deskripsi & Aturan Bisnis |
| :--- | :--- | :--- |
| **FR-AD-01** | Dashboard Admin | Metrik real-time: Total pendaftar ISLT, Calon alumni butuh verifikasi, Tulisan pending review (Aksi & Artikel), Total berita terbit, Grafik sebaran pendaftar per provinsi. |
| **FR-AD-02** | Verifikasi Akun Hatta Muda | Menampilkan daftar akun pendaftar alumni baru beserta bukti sertifikat dan angkatan ISLT. Admin memiliki dua opsi tindakan: <br>1. **Setujui (Approve)**: Akun aktif, peran Hatta Muda diberikan, notifikasi email dikirim.<br>2. **Tolak (Reject)**: Sesuai spesifikasi, data akun pendaftar yang ditolak langsung dihapus permanen dari basis data. |
| **FR-AD-03** | Verifikasi Berita "Aksi Hatta Muda" | Menampilkan naskah aksi yang diajukan alumni. Admin dapat membaca naskah dan memilih 3 tindakan: <br>1. **Setujui (Approve)**: Status berubah menjadi `published` dan langsung tayang di portal publik.<br>2. **Minta Revisi (Revision)**: Admin mengisi catatan perbaikan (*editorial feedback*), status berubah menjadi `revision`, dan dikembalikan ke penulis.<br>3. **Tolak (Reject)**: Status berubah menjadi `rejected` dengan alasan penolakan. |
| **FR-AD-04** | Verifikasi Artikel Gagasan | Alur kerja yang sama dengan verifikasi berita: kurasi kelayakan pemikiran/etika penulisan -> **Setujui (Publish)**, **Revisi (+ Catatan)**, atau **Tolak**. |
| **FR-AD-05** | Manajemen Peserta ISLT | Tabel data seluruh pendaftar ISLT dengan filter angkatan, provinsi, asal sekolah, dan status seleksi. Dilengkapi fitur aksi: <br>- **Ekspor ke Excel (XLSX)**: Format file spreadsheet terstruktur dengan semua field pendaftaran.<br>- **Ekspor ke PDF**: Dokumen rekapitulasi data pendaftar siap cetak.<br>- **Koneksi / Sinkronisasi Google Sheets**: Integrasi real-time / webhook / Google API untuk menembuskan data pendaftar langsung ke Google Spreadsheet kepanitiaan. |
| **FR-AD-06** | Menulis & Mengelola Berita Organisasi | CRUD penuh untuk kategori Berita **News** (resmi organisasi) dan **Kegiatan**. Admin dapat langsung mempublikasikan tanpa moderasi. |
| **FR-AD-07** | Manajemen Kategori & Sub-Kategori | CRUD master kategori tematik (Ekonomi/Koperasi, Politik/Kebangsaan, Kebudayaan, SDGs, Pendidikan, dll) yang dapat digunakan lintas berita dan artikel. |
| **FR-AD-08** | Mengelola E-Jurnal & Dokumen | Upload file dokumen (PDF/DOCX), pengisian judul, deskripsi abstrak, nama penulis/penyusun, tahun publikasi, kategori dokumen, serta pantauan jumlah unduhan. |
| **FR-AD-09** | Mengelola Konten Program | Pengelolaan dinamis konten yang ditampilkan pada menu Program: teks deskripsi ISLT, silabus, tanggal pembukaan batch, media edukasi, serta fleksibilitas menambah program baru (misal: Program Kebudayaan atau SDGs). |
| **FR-AD-10** | Mengelola Halaman Tentang | Manajemen konten dinamis untuk teks sejarah Bung Hatta, visi, misi, nilai-nilai, serta daftar tokoh dewan pembina/pengurus inisiatif. |

---

## 3. SPESIFIKASI KEBUTUHAN NON-FUNGSIONAL (NON-FUNCTIONAL REQUIREMENTS)

### 3.1 Desain & Antarmuka Pengguna (UI/UX)
- **Tema Visual**: *Bung Hatta Heritage & Youth Intellectualism*. Warna utama: Crimson/Maroon (`#781D23`), Warm Gold Accent (`#C29B38`), Slate Navy (`#0F172A`), Latar Bersih Off-White (`#FBFBFB`).
- **Tipografi**: Judul menggunakan Serif modern yang berwibawa (*Merriweather* / *Playfair Display* / *Plus Jakarta Sans Bold*), dan teks isi menggunakan Sans-Serif dengan tingkat keterbacaan tinggi (*Inter* / *Plus Jakarta Sans*).
- **Responsivitas**: 100% Mobile-first responsive (Smartphone, Tablet, Laptop, Desktop Ultra-wide).
- **Mikro-Interaksi**: Transisi halus, tombol hover responsif, modal konfirmasi interaktif, dan toast notification yang elegan.

### 3.2 Keamanan & Proteksi Data
- **Proteksi Akses (RBAC)**: Pembagian hak akses terisolasi menggunakan Middleware Laravel (`role:admin`, `role:hatta_muda`, `guest`).
- **CSRF & XSS Protection**: Seluruh form publik dan internal diamankan dengan `@csrf` token dan sanitasi output HTML pada konten WYSIWYG.
- **Validasi Unggahan**: Pembatasan ekstensi file (hanya `.pdf`, `.jpg`, `.jpeg`, `.png`, `.webp`), pembatasan ukuran maksimal (maksimal 2MB untuk foto, 10MB untuk PDF E-Jurnal).
- **Rate Limiting**: Pembatasan frekuensi pengiriman form pendaftaran ISLT publik (misal: maksimal 5 kali per IP per jam) guna mencegah bot/spamming.

### 3.3 Kinerja & Keandalan
- **Kecepatan Muat**: Waktu respons halaman publik di bawah 1.5 detik.
- **Optimasi Gambar**: Konversi otomatis ke format modern (WebP) atau kompresi gambar saat unggah thumbnail.
- **Export Asinkron**: Ekspor data ribuan peserta ISLT dirancang efisien dengan memory footprint rendah (menggunakan chunking / lazy loading).

---

## 4. DESAIN BASIS DATA (DATA ARCHITECTURE & SCHEMA)

### 4.1 Tabel: `users`
Menyimpan kredensial akun pengguna sistem (Admin dan Hatta Muda).
- `id`: BIGINT (Primary Key, Auto Increment)
- `name`: VARCHAR(255)
- `email`: VARCHAR(255) (Unique)
- `password`: VARCHAR(255)
- `role`: ENUM('admin', 'hatta_muda')
- `status`: ENUM('pending', 'approved', 'rejected') (Default: 'pending' untuk alumni baru, 'approved' untuk admin)
- `remember_token`: VARCHAR(100)
- `created_at`, `updated_at`: TIMESTAMP

### 4.2 Tabel: `alumni_profiles`
Data tambahan khusus untuk Hatta Muda (alumni ISLT).
- `id`: BIGINT (Primary Key)
- `user_id`: BIGINT (Foreign Key -> `users.id` ON DELETE CASCADE)
- `islt_batch`: VARCHAR(50) (Misal: 'Angkatan I - 2024')
- `province`: VARCHAR(100)
- `city`: VARCHAR(100)
- `school_origin`: VARCHAR(255) (Asal SMA saat ISLT)
- `current_institution`: VARCHAR(255) (Kampus / Tempat Bekerja Sekarang)
- `phone_number`: VARCHAR(50)
- `is_phone_public`: BOOLEAN (Default: FALSE)
- `bio`: TEXT
- `avatar_path`: VARCHAR(255)
- `proof_document_path`: VARCHAR(255) (Bukti sertifikat ISLT saat registrasi)
- `linkedin_url`: VARCHAR(255) (Nullable)
- `instagram_url`: VARCHAR(255) (Nullable)
- `created_at`, `updated_at`: TIMESTAMP

### 4.3 Tabel: `islt_applicants`
Menyimpan pendaftaran peserta seleksi program ISLT dari kalangan publik.
- `id`: BIGINT (Primary Key)
- `registration_code`: VARCHAR(50) (Unique, misal: 'ISLT-2026-00042')
- `full_name`: VARCHAR(255)
- `nisn`: VARCHAR(20) (Nullable)
- `birth_place`: VARCHAR(100)
- `birth_date`: DATE
- `gender`: ENUM('L', 'P')
- `whatsapp_number`: VARCHAR(50)
- `email`: VARCHAR(255)
- `province`: VARCHAR(100)
- `city`: VARCHAR(100)
- `school_name`: VARCHAR(255)
- `osis_position`: VARCHAR(100) (Ketua OSIS / Wakil / Pengurus Inti)
- `organization_experience`: TEXT
- `motivation_essay`: TEXT
- `photo_path`: VARCHAR(255)
- `recommendation_letter_path`: VARCHAR(255)
- `selection_status`: ENUM('submitted', 'screening', 'interview', 'passed', 'rejected') (Default: 'submitted')
- `synced_to_sheets_at`: TIMESTAMP (Nullable)
- `created_at`, `updated_at`: TIMESTAMP

### 4.4 Tabel: `categories` & `sub_categories`
Master klasifikasi tulisan.
- `categories`: `id`, `name`, `slug`, `type` ('berita', 'artikel', 'program'), `created_at`, `updated_at`
  *(Default Utama Berita: 'News', 'Aksi Hatta Muda', 'Kegiatan')*
- `sub_categories`: `id`, `category_id` (FK), `name`, `slug`, `description`, `created_at`, `updated_at`
  *(Contoh: 'Ekonomi Kerakyatan', 'Kebangsaan & Politik', 'Kebudayaan', 'SDGs', 'Pendidikan')*

### 4.5 Tabel: `posts`
Pusat seluruh artikel dan berita dalam sistem.
- `id`: BIGINT (Primary Key)
- `author_id`: BIGINT (Foreign Key -> `users.id`)
- `post_type`: ENUM('news', 'aksi_hatta_muda', 'kegiatan', 'artikel')
- `category_id`: BIGINT (Foreign Key -> `categories.id`)
- `sub_category_id`: BIGINT (Nullable, Foreign Key -> `sub_categories.id`)
- `title`: VARCHAR(255)
- `slug`: VARCHAR(255) (Unique)
- `excerpt`: TEXT
- `content`: LONGTEXT
- `featured_image`: VARCHAR(255)
- `action_location`: VARCHAR(255) (Khusus Aksi Hatta Muda: misal "Padang, Sumatera Barat")
- `action_date`: DATE (Nullable)
- `status`: ENUM('draft', 'pending_review', 'revision_required', 'published', 'rejected') (Default: 'draft')
- `admin_notes`: TEXT (Nullable, catatan revisi dari editor/admin)
- `published_at`: TIMESTAMP (Nullable)
- `views_count`: INT (Default: 0)
- `created_at`, `updated_at`: TIMESTAMP

### 4.6 Tabel: `e_journals`
Perpustakaan digital dan arsip dokumen resmi.
- `id`: BIGINT (Primary Key)
- `title`: VARCHAR(255)
- `slug`: VARCHAR(255) (Unique)
- `author_or_curator`: VARCHAR(255) (Contoh: "Yayasan Proklamator Bung Hatta")
- `publication_year`: YEAR
- `category`: VARCHAR(100) (Contoh: "Kurikulum ISLT", "Jurnal Ekonomi", "Modul Kebangsaan")
- `description`: TEXT
- `cover_image`: VARCHAR(255) (Nullable)
- `file_path`: VARCHAR(255) (Path berkas PDF)
- `file_size_kb`: INT
- `download_count`: INT (Default: 0)
- `created_at`, `updated_at`: TIMESTAMP

### 4.7 Tabel: `programs`
Manajemen halaman program dinamis (ISLT, Media Edukasi, dll).
- `id`: BIGINT (Primary Key)
- `title`: VARCHAR(255) (Contoh: "Indonesian Students Leadership Training (ISLT)")
- `slug`: VARCHAR(255) (Unique, misal: 'islt', 'media-edukasi')
- `tagline`: VARCHAR(255)
- `description`: LONGTEXT
- `banner_image`: VARCHAR(255)
- `is_registration_open`: BOOLEAN (Default: TRUE)
- `additional_metadata`: JSON (Nullable, untuk menyimpan silabus/tahapan)
- `sort_order`: INT (Default: 0)
- `created_at`, `updated_at`: TIMESTAMP

### 4.8 Tabel: `page_contents`
Manajemen konten statis & profil (Halaman Tentang, Sejarah Bung Hatta, Visi Misi).
- `id`: BIGINT (Primary Key)
- `section_key`: VARCHAR(100) (Unique, misal: 'about_history', 'about_vision', 'about_mission', 'about_values')
- `title`: VARCHAR(255)
- `content`: LONGTEXT
- `media_path`: VARCHAR(255) (Nullable)
- `updated_by`: BIGINT (FK -> `users.id`)
- `updated_at`: TIMESTAMP

---

## 5. DETAIL INTEGRASI & EKSPOR DATA

### 5.1 Ekspor Data Peserta ISLT
1. **Excel (XLSX)**:
   - Menggunakan library Laravel Excel (`maatwebsite/excel` atau `openspout`).
   - Menyertakan header resmi Hatta Aksara Project, penomoran urut, kode registrasi, nama lengkap, sekolah, provinsi, kontak WhatsApp, dan tanggal pendaftaran.
2. **PDF Rekapitulasi**:
   - Menggunakan `barryvdh/laravel-dompdf` untuk menghasilkan dokumen rekapitulasi data pendaftar dengan kop resmi surat Yayasan Proklamator Bung Hatta.
3. **Koneksi Google Sheets (Spreadsheet Sync)**:
   - Opsi A (Langsung): Menggunakan Google Sheets API v4 via Service Account Credentials (`credentials.json`), otomatis melakukan append baris data baru setiap kali peserta submit pendaftaran.
   - Opsi B (Webhook): Integrasi Webhook URL Google Apps Script yang menerima payload JSON pendaftar baru dan mengisinya ke Google Spreadsheet secara instan.
   - Admin juga memiliki tombol *"Sinkronkan Ulang ke Google Sheets"* di dashboard untuk batch update.

---

## 6. RENCANA TAHAPAN IMPLEMENTASI (ROADMAP)

- **Tahap 1**: Penyiapan Lingkungan (PHP 8.3+, Composer, Laravel Boost, Migrasi Database, Model Eloquent, Seeders, & Factory).
- **Tahap 2**: Desain Sistem & Template Layout (Frontend Publik, Hatta Muda Space, Admin Dashboard dengan tema Bung Hatta Heritage).
- **Tahap 3**: Implementasi Halaman Publik & Pendaftaran ISLT (Beranda, Berita, Program ISLT + Form Pendaftaran Publik + Bukti Unduh).
- **Tahap 4**: Implementasi Registrasi & Verifikasi Alumni Hatta Muda (Form Registrasi Alumni, Approval Admin, Auto-delete on Reject).
- **Tahap 5**: Implementasi Ruang Tulis Hatta Muda & Sistem Editorial (Pembuatan Berita Aksi, Pembuatan Artikel, Moderasi Admin Setujui/Revisi/Tolak).
- **Tahap 6**: Implementasi E-Jurnal & Direktori Jejaring Alumni (PDF Viewer, Download Counter, Filter Provinsi Alumni).
- **Tahap 7**: Integrasi Ekspor Data (XLSX, PDF, Google Sheets Sync) & Pengelolaan Halaman Tentang / Program CMS.
- **Tahap 8**: Pengujian Komprehensif (Unit/Feature Tests), Optimasi SEO, dan Finalisasi.

---

## 7. SPESIFIKASI DEPLOYMENT SERVER (cPanel & PHP 8.3)

Untuk menjamin kelancaran implementasi pada lingkungan produksi berbasis cPanel:
1. **Target Versi PHP**: PHP 8.3.x (Locked di `composer.json` via `platform.php: 8.3.0`).
2. **Ekstensi PHP Wajib di cPanel**:
   - `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `curl`, `zip`, `bcmath`.
3. **Konfigurasi Webroot**:
   - Target direktori domain/subdomain diarahkan ke folder `/public`.
   - Atau struktur subfolder di luar `public_html` dengan konten `public/` berada di dalam `public_html` (disertai penyesuaian path bootstrap di `index.php`).
4. **Environment Database**: MySQL 8.0+ / MariaDB 10.4+.
5. **Symlink Storage**: `php artisan storage:link` untuk akses publik file upload (foto, sertifikat, berkas PDF e-jurnal).

