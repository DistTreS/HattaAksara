# Hatta Aksara Project

> **Gerakan Kepemimpinan Pemuda, Literasi Kebangsaan, dan Rekayasa Karakter Bangsa.**

Platform digital resmi **Hatta Aksara Project** — sebuah inisiatif otonom pemuda Indonesia yang berdedikasi melahirkan pemimpin berkarakter luhur, berintegritas tinggi, dan berwawasan kebangsaan yang kokoh berakar pada nilai-nilai keteladanan Mohammad Hatta.

[![Laravel](https://img.shields.io/badge/Laravel-11%2F12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tests](https://img.shields.io/badge/PHPUnit-77%20Passed%20(100%25)-success?style=for-the-badge&logo=php)](tests)
[![License](https://img.shields.io/badge/License-MIT-blue.style=for-the-badge)](LICENSE)

---

## 🌟 Fitur Utama

1. **Indonesian Student Leadership Training (ISLT)**
   - Formulir registrasi seleksi ketua/pengurus OSIS se-Indonesia.
   - Generasi otomatis kode registrasi unik (`ISLT-YYYY-XXXX-XXXX`).
   - Ekspor data pendaftar ke format Excel (XLSX) dan PDF untuk tim seleksi.

2. **Jejaring Alumni Hatta Muda**
   - Portal registrasi dan verifikasi alumni ISLT lintas angkatan.
   - Ruang kontribusi karya (Aksi Hatta Muda & Opini/Artikel).
   - Pengelolaan profil dan jejaring kolaborasi nasional.

3. **Ruang Baca & E-Jurnal Kebangsaan**
   - Publikasi artikel ilmiah, esai pemikiran, dan kajian kebangsaan.
   - Unduhan berkas E-Jurnal dengan pelacak jumlah unduhan otomatis (*download counter*).

4. **Media Edukasi & Galeri Video Resmi**
   - Integrasi video resmi dari kanal YouTube [@hattaaksaraproject](https://www.youtube.com/@hattaaksaraproject).
   - Pemutar modal interaktif langsung di dalam platform tanpa iklan luar.

5. **Dashboard Redaksi & Manajemen Admin**
   - Kurasi dan persetujuan naskah masuk dari kontributor/alumni.
   - Verifikasi berkas dan persetujuan akun alumni baru.
   - Manajemen konten program, berita, kategori, dan e-jurnal.

---

## 🎨 Desain & UI/UX

- **Nuansa Warna Elegan**: Deep Cosmic Violet (`#0C0022`), Maroon Bung Hatta (`#800000`), dan Gold Accent (`#E6B800`).
- **Clean & High-Contrast Layout**: Tipografi modern Google Fonts (Plus Jakarta Sans), cards interaktif dengan micro-interactions, dan glassmorphism halus.
- **Responsif**: Dioptimalkan untuk pengalaman mulus di desktop, tablet, dan perangkat seluler.

---

## 🚀 Panduan Instalasi & Menjalankan Lokal

### Prasyarat
- PHP >= 8.2 (dengan ekstensi `pdo_sqlite`, `mbstring`, `openssl`, `curl`)
- Composer
- Node.js & NPM

### Langkah Instalasi

1. **Clone repository:**
   ```bash
   git clone https://github.com/DistTreS/HattaAksara.git
   cd HattaAksara
   ```

2. **Install dependensi PHP & JavaScript:**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi Database & Seeding Data Awal:**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Buka peramban di `http://localhost:8000`.

---

## 🧪 Pengujian (Unit & Feature Testing)

Platform ini dilengkapi dengan 77 pengujian otomatis (**100% Passed**) mencakup Model, Eloquent Relations, Query Scopes, Alur Registrasi, RBAC, dan Validasi Keamanan:

```bash
# Menjalankan seluruh test suite
php artisan test

# Menjalankan hanya Unit Tests
php artisan test --testsuite=Unit

# Menjalankan hanya Feature Tests
php artisan test --testsuite=Feature
```

### Statistik Uji Coba:
- **Total Tests**: 77 Passed (0 Failed)
- **Total Assertions**: 467 Assertions
- **Durasi Eksekusi**: ~1.1 detik (In-memory SQLite)

---

## 🔑 Kredensial Default (Seeder)

Setelah menjalankan `php artisan db:seed`, Anda dapat login menggunakan kredensial bawaan:

- **Administrator:**
  - Email: `admin@hattaaksara.id`
  - Password: `password`
- **Alumni Terverifikasi (Hatta Muda):**
  - Email: `alumni@hattaaksara.id`
  - Password: `password`

---

## 📄 Lisensi

Platform ini dirilis di bawah lisensi MIT License.
