<?php

namespace Database\Seeders;

use App\Models\AlumniProfile;
use App\Models\Category;
use App\Models\EJournal;
use App\Models\IsltApplicant;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Program;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@hattaaksara.id'],
            [
                'name' => 'Redaksi Hatta Aksara',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        // 2. Create Verified Alumni (Hatta Muda)
        $alumniUser = User::firstOrCreate(
            ['email' => 'ahmad.fauzan@alumni.hattaaksara.id'],
            [
                'name' => 'Ahmad Fauzan Pratama',
                'password' => Hash::make('password'),
                'role' => 'hatta_muda',
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        AlumniProfile::firstOrCreate(
            ['user_id' => $alumniUser->id],
            [
                'islt_batch' => 'Angkatan I (2024)',
                'province' => 'Sumatera Barat',
                'city' => 'Bukittinggi',
                'school_origin' => 'SMAN 1 Bukittinggi',
                'current_institution' => 'Universitas Indonesia - Ilmu Ekonomi',
                'phone_number' => '081234567890',
                'is_phone_public' => true,
                'bio' => 'Alumni ISLT Angkatan I. Pegiat ekonomi koperasi muda dan ketua inisiatif Komunitas Pemuda Kooperatif Bukittinggi.',
                'avatar_path' => null,
                'proof_document_path' => 'proofs/sertifikat-islt-2024-001.pdf',
                'linkedin_url' => 'https://linkedin.com/in/ahmadfauzan',
                'instagram_url' => 'https://instagram.com/ahmadfauzan_p',
            ]
        );

        // 3. Create Another Verified Alumni for Directory
        $alumniUser2 = User::firstOrCreate(
            ['email' => 'siti.nurhaliza@alumni.hattaaksara.id'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password'),
                'role' => 'hatta_muda',
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        AlumniProfile::firstOrCreate(
            ['user_id' => $alumniUser2->id],
            [
                'islt_batch' => 'Angkatan I (2024)',
                'province' => 'Sulawesi Selatan',
                'city' => 'Makassar',
                'school_origin' => 'SMAN 5 Makassar',
                'current_institution' => 'Universitas Hasanuddin - Hubungan Internasional',
                'phone_number' => '082198765432',
                'is_phone_public' => false,
                'bio' => 'Fokus pada diplomasi pemuda dan implementasi SDGs nomor 4 dan 8 di wilayah Indonesia Timur.',
                'avatar_path' => null,
                'proof_document_path' => 'proofs/sertifikat-islt-2024-015.pdf',
                'linkedin_url' => 'https://linkedin.com/in/sitinurhaliza',
                'instagram_url' => 'https://instagram.com/sitinurhaliza_m',
            ]
        );

        // 4. Create Pending Alumni for Admin Verification Demo
        $pendingUser = User::firstOrCreate(
            ['email' => 'budi.santoso@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'hatta_muda',
                'status' => 'pending',
            ]
        );

        AlumniProfile::firstOrCreate(
            ['user_id' => $pendingUser->id],
            [
                'islt_batch' => 'Angkatan II (2025)',
                'province' => 'Jawa Timur',
                'city' => 'Surabaya',
                'school_origin' => 'SMAN 2 Surabaya',
                'current_institution' => 'Institut Teknologi Sepuluh Nopember',
                'phone_number' => '085712345678',
                'is_phone_public' => false,
                'bio' => 'Ketua OSIS SMAN 2 Surabaya 2024/2025, pendaftar alumni baru.',
                'proof_document_path' => 'proofs/sertifikat-islt-budi.pdf',
                'linkedin_url' => 'https://linkedin.com/in/budisantoso',
                'instagram_url' => 'https://instagram.com/budisantoso',
            ]
        );

        // 5. Create Categories
        $catNews = Category::firstOrCreate(
            ['slug' => 'news'],
            ['name' => 'News', 'type' => 'berita', 'description' => 'Berita resmi institusional dan pengumuman Hatta Aksara Project']
        );

        $catAksi = Category::firstOrCreate(
            ['slug' => 'aksi-hatta-muda'],
            ['name' => 'Aksi Hatta Muda', 'type' => 'berita', 'description' => 'Kiprah, aksi nyata, dan dampak sosial yang digerakkan oleh alumni Hatta Muda di daerah']
        );

        $catKegiatan = Category::firstOrCreate(
            ['slug' => 'kegiatan'],
            ['name' => 'Kegiatan', 'type' => 'berita', 'description' => 'Dokumentasi agenda, napak tilas, lokakarya, dan forum kepemimpinan']
        );

        $catArtikel = Category::firstOrCreate(
            ['slug' => 'artikel'],
            ['name' => 'Artikel Gagasan', 'type' => 'artikel', 'description' => 'Gagasan, esai pemikiran, dan refleksi intelektual pemuda']
        );

        // 6. Create Sub-Categories
        $subKoperasi = SubCategory::firstOrCreate(
            ['category_id' => $catNews->id, 'slug' => 'ekonomi-kerakyatan'],
            ['name' => 'Ekonomi Kerakyatan & Koperasi', 'description' => 'Kajian dan implementasi pemikiran ekonomi Bung Hatta']
        );

        $subKebangsaan = SubCategory::firstOrCreate(
            ['category_id' => $catNews->id, 'slug' => 'kebangsaan-politik'],
            ['name' => 'Kebangsaan & Weltanschauung', 'description' => 'Etika kepemimpinan nasional dan wawasan kebangsaan']
        );

        $subBudaya = SubCategory::firstOrCreate(
            ['category_id' => $catAksi->id, 'slug' => 'kebudayaan'],
            ['name' => 'Kebudayaan & Kearifan Lokal', 'description' => 'Pelestarian nilai budaya dan kearifan masyarakat nusantara']
        );

        $subSdgs = SubCategory::firstOrCreate(
            ['category_id' => $catAksi->id, 'slug' => 'sdgs-lingkungan'],
            ['name' => 'SDGs & Pemberdayaan Komunitas', 'description' => 'Pembangunan berkelanjutan dan aksi nyata kemasyarakatan']
        );

        $subKepemimpinan = SubCategory::firstOrCreate(
            ['category_id' => $catKegiatan->id, 'slug' => 'pelatihan-kepemimpinan'],
            ['name' => 'Kepemimpinan Pemuda', 'description' => 'Pengembangan kapasitas kepemimpinan berintegritas']
        );

        // 7. Seed Posts
        // Post 1: News (Admin)
        Post::firstOrCreate(
            ['slug' => 'yayasan-proklamator-bung-hatta-resmikan-hatta-aksara-project'],
            [
                'author_id' => $admin->id,
                'post_type' => 'news',
                'category_id' => $catNews->id,
                'sub_category_id' => $subKebangsaan->id,
                'title' => 'Hatta Aksara Project Luncurkan Hatta Aksara Project untuk Generasi Pemimpin Muda',
                'excerpt' => 'Inisiatif nasional guna menyiapkan pemuda yang memahami jati diri bangsa dan prinsip ekonomi kerakyatan melalui pelatihan intensif dan ekosistem digital.',
                'content' => '<p>Hatta Aksara Project secara resmi meluncurkan <strong>Hatta Aksara Project</strong>, sebuah program strategis jangka panjang yang didedikasikan untuk membina generasi muda Indonesia berkarakter teguh, berintegritas, dan memahami <em>weltanschauung</em> (pandangan hidup) bangsa.</p><p>Bung Hatta senantiasa berpesan bahwa Indonesia tidak akan bercahaya hanya karena obor besar di Jakarta, melainkan oleh lilin-lilin kecil yang menyala di desa-desa dan pelosok nusantara. Semangat inilah yang melandasi terbentuknya Hatta Aksara Project.</p><p>Program ini mencakup pelatihan kepemimpinan Indonesian Students Leadership Training (ISLT) bagi ketua OSIS berprestasi dari 38 provinsi, seminar pemikiran ekonomi koperasi, hingga penerbitan karya ilmiah dan gagasan pemuda melalui kanal digital ini.</p>',
                'featured_image' => 'images/heritage/bung-hatta-hero.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'views_count' => 342,
            ]
        );

        // Post 2: Kegiatan (Admin)
        Post::firstOrCreate(
            ['slug' => 'napak-tilas-sejarah-perjuangan-bung-hatta-di-bukittinggi'],
            [
                'author_id' => $admin->id,
                'post_type' => 'kegiatan',
                'category_id' => $catKegiatan->id,
                'sub_category_id' => $subKepemimpinan->id,
                'title' => 'Napak Tilas Sejarah Perjuangan Bung Hatta di Bukittinggi: Menghidupkan Kembali Semangat Integritas',
                'excerpt' => 'Peserta pelatihan kepemimpinan menelusuri jejak masa kecil sang proklamator di Bukittinggi, menggali nilai kesederhanaan dan kecintaan pada ilmu pengetahuan.',
                'content' => '<p>Rangkaian kegiatan napak tilas perjuangan Bung Hatta berlangsung khidmat di Rumah Kelahiran Bung Hatta, Bukittinggi, Sumatera Barat. Para peserta diajak memahami bagaimana masa kecil Mohammad Hatta ditempa oleh disiplin waktu, kecintaan membaca, dan nilai-nilai religius serta adat Minangkabau.</p><p>Melalui agenda ini, peserta tidak hanya mempelajari sejarah sebagai catatan masa lalu, melainkan menjadikannya kompas moral dalam memimpin organisasi siswa di sekolah masing-masing.</p>',
                'featured_image' => 'images/heritage/bukittinggi-napak-tilas.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'views_count' => 218,
            ]
        );

        // Post 3: Aksi Hatta Muda (Alumni Fauzan)
        Post::firstOrCreate(
            ['slug' => 'membangun-koperasi-pelajar-berbasis-digital-di-sumatera-barat'],
            [
                'author_id' => $alumniUser->id,
                'post_type' => 'aksi_hatta_muda',
                'category_id' => $catAksi->id,
                'sub_category_id' => $subKoperasi->id,
                'title' => 'Menggerakkan Koperasi Pelajar Berbasis Gotong Royong Digital di Tiga Sekolah Sumatera Barat',
                'excerpt' => 'Inisiatif alumni ISLT Angkatan I mendampingi pengurus OSIS merevitalisasi koperasi sekolah dengan sistem transparansi digital dan pembagian sisa hasil usaha yang adil.',
                'content' => '<p>Sepulang dari pelatihan ISLT, saya tergerak untuk merealisasikan ajaran Bung Hatta tentang koperasi di lingkungan terdekat saya, yaitu sekolah. Bersama rekan-rekan alumni Hatta Muda di Sumatera Barat, kami menginisiasi program pendampingan Koperasi Pelajar Mandiri.</p><p>Hasilnya, tiga koperasi sekolah kini telah mengadopsi pencatatan keuangan transparan dan melibatkan siswa sebagai pemilik sekaligus penggerak roda ekonomi mini di sekolah.</p>',
                'featured_image' => 'images/heritage/islt-training.jpg',
                'action_location' => 'Bukittinggi & Agam, Sumatera Barat',
                'action_date' => now()->subMonths(1),
                'status' => 'published',
                'published_at' => now()->subDay(),
                'views_count' => 189,
            ]
        );

        // Post 4: Artikel Gagasan (Alumni Siti)
        Post::firstOrCreate(
            ['slug' => 'relevansi-koperasi-bung-hatta-di-era-ekonomi-platform'],
            [
                'author_id' => $alumniUser2->id,
                'post_type' => 'artikel',
                'category_id' => $catArtikel->id,
                'sub_category_id' => $subKoperasi->id,
                'title' => 'Relevansi Koperasi Bung Hatta di Era Ekonomi Platform: Mengapa Pemuda Harus Kooperatif, Bukan Kompetitif Berlebihan?',
                'excerpt' => 'Sebuah refleksi kritis tentang jebakan gig economy dan bagaimana prinsip kepemilikan bersama ala Mohammad Hatta menawarkan solusi keadilan ekonomi masa depan.',
                'content' => '<p>Di tengah maraknya ekonomi digital yang serba cepat, seringkali kita terjebak dalam kompetisi tanpa batas yang menguntungkan segelintir konglomerasi platform. Mohammad Hatta sejak awal telah mengingatkan bahwa persaingan bebas tanpa rem akan menindas yang lemah.</p><p>Prinsip koperasi—yakni usaha bersama berdasar atas asas kekeluargaan—sebenarnya adalah prototipe dari sistem desentralisasi dan kepemilikan kolektif yang kini kembali dicari oleh generasi muda global. Pemuda hari ini harus berani merancang model bisnis kooperatif yang berkeadilan.</p>',
                'featured_image' => 'images/heritage/bung-hatta-hero.jpg',
                'status' => 'published',
                'published_at' => now()->subHours(12),
                'views_count' => 145,
            ]
        );

        // Post 5: Draft tulisan yang butuh revisi (untuk demonstrasi review)
        Post::firstOrCreate(
            ['slug' => 'peran-pemuda-dalam-pelestarian-bahasa-daerah'],
            [
                'author_id' => $alumniUser->id,
                'post_type' => 'artikel',
                'category_id' => $catArtikel->id,
                'sub_category_id' => $subBudaya->id,
                'title' => 'Peran Pemuda dalam Menjaga Bahasa Ibu di Era Media Sosial',
                'excerpt' => 'Kajian singkat tentang pentingnya bahasa daerah dalam memperkaya identitas kebangsaan generasi Z.',
                'content' => '<p>Bahasa daerah adalah kekayaan tak ternilai bangsa Indonesia. Naskah ini mengkaji langkah konkret yang dapat diambil pemuda...</p>',
                'status' => 'revision_required',
                'admin_notes' => 'Tolong lengkapi dengan data rujukan statistik kepunahan bahasa daerah di Indonesia dan kaitkan dengan kutipan pidato Bung Hatta tentang kebudayaan nusantara.',
            ]
        );

        // 8. Seed Programs
        Program::firstOrCreate(
            ['slug' => 'islt'],
            [
                'title' => 'Indonesian Students Leadership Training (ISLT)',
                'tagline' => 'Kawah Candradimuka Kepemimpinan Pemuda Berkarakter & Kooperatif Tingkat Nasional',
                'description' => 'Indonesian Students Leadership Training (ISLT) adalah program unggulan dari Hatta Aksara Project yang menghadirkan ketua-ketua OSIS terpilih dari 38 provinsi di Indonesia. Program ini menggabungkan pelatihan kepemimpinan intensif, dialog pemikiran ekonomi kerakyatan Bung Hatta, studi kasus kebangsaan, serta napak tilas sejarah perjuangan para pendiri bangsa.',
                'is_registration_open' => true,
                'sort_order' => 1,
                'additional_metadata' => [
                    'duration' => '7 Hari Pelatihan Intensif',
                    'location' => 'Jakarta - Bukittinggi',
                    'target_audience' => 'Ketua OSIS SMA/SMK/MA Pilihan Se-Indonesia',
                    'batch_info' => 'Batch III - Tahun 2026',
                    'benefits' => [
                        'Pelatihan Kepemimpinan Berbasis Karakter & Integritas',
                        'Wawasan Mendalam Ekonomi Kerakyatan & Koperasi Bung Hatta',
                        'Jejaring Erat Pemimpin Muda Antar-Provinsi se-Indonesia',
                        'Sertifikasi Resmi dari Hatta Aksara Project',
                        'Akses Eksklusif Ekosistem Alumni Hatta Muda Connection',
                    ],
                ],
            ]
        );

        Program::firstOrCreate(
            ['slug' => 'media-edukasi'],
            [
                'title' => 'Media Edukasi & Ekosistem Digital Hatta Aksara',
                'tagline' => 'Kanal Literasi Kebangsaan, Ekonomi Kerakyatan, dan Ruang Gerak Alumni',
                'description' => 'Media Edukasi Hatta Aksara adalah ekosistem publikasi dan komunikasi terbuka yang menghubungkan gagasan kepemimpinan, kepustakaan digital, serta karya nyata para pemuda. Melalui media ini, alumni program ISLT (Hatta Muda) dapat menerbitkan laporan aksi dampak masyarakat, mengemukakan gagasan bernas dalam bentuk artikel, serta terhubung erat dalam jaringan alumni nasional.',
                'is_registration_open' => false,
                'sort_order' => 2,
                'additional_metadata' => [
                    'audience' => 'Masyarakat Luas, Pelajar, Guru, Peneliti & Alumni Hatta Muda',
                    'pillars' => [
                        'Pusat Publikasi Berita Resmi & Aksi Nyata Daerah',
                        'Repositori Digital E-Jurnal & Naskah Bung Hatta',
                        'Kanal Opini Pemikiran Pemuda Indonesia',
                        'Gerbang Pendaftaran Komunitas Alumni Hatta Muda Connection',
                    ],
                ],
            ]
        );

        // 9. Seed E-Journals
        EJournal::firstOrCreate(
            ['slug' => 'kurikulum-kepemimpinan-islt-panduan-resmi'],
            [
                'title' => 'Kurikulum & Silabus Kepemimpinan Siswa Nasional (ISLT)',
                'author_or_curator' => 'Tim Kurator Hatta Aksara Project',
                'publication_year' => 2025,
                'category' => 'Kurikulum ISLT',
                'description' => 'Dokumen resmi kurikulum pembinaan karakter kepemimpinan, modul integritas, modul diskusi ekonomi kerakyatan, serta panduan proyek dampak sosial bagi ketua OSIS.',
                'file_path' => 'ejournal/kurikulum-islt-2025.pdf',
                'file_size_kb' => 4520,
                'download_count' => 412,
            ]
        );

        EJournal::firstOrCreate(
            ['slug' => 'bung-hatta-dan-ekonomi-kerakyatan-buku-saku'],
            [
                'title' => 'Bung Hatta dan Ekonomi Kerakyatan: Buku Saku Kader Bangsa',
                'author_or_curator' => 'Hatta Aksara Project',
                'publication_year' => 2024,
                'category' => 'Jurnal Ekonomi & Koperasi',
                'description' => 'Kompilasi sari pemikiran Mohammad Hatta mengenai sendi-sendi koperasi, pasal 33 UUD 1945, dan pembentukan watak kooperatif masyarakat merdeka.',
                'file_path' => 'ejournal/buku-saku-ekonomi-kerakyatan.pdf',
                'file_size_kb' => 2850,
                'download_count' => 789,
            ]
        );

        EJournal::firstOrCreate(
            ['slug' => 'modul-wawasan-kebangsaan-weltanschauung'],
            [
                'title' => 'Modul Weltanschauung: Menemukan Kembali Jiwa Kepemimpinan Berintegritas',
                'author_or_curator' => 'Dewan Pakar Hatta Aksara Project',
                'publication_year' => 2024,
                'category' => 'Modul Kebangsaan',
                'description' => 'Bahan ajar pengenalan jati diri bangsa Indonesia, etika politik tanpa cela, dan napak tilas keteladanan para pahlawan kemerdekaan.',
                'file_path' => 'ejournal/modul-weltanschauung.pdf',
                'file_size_kb' => 3120,
                'download_count' => 564,
            ]
        );

        // 10. Seed Page Content (Halaman Tentang)
        PageContent::firstOrCreate(
            ['section_key' => 'about_history'],
            [
                'title' => 'Sejarah & Fondasi Berdirinya Hatta Aksara Project',
                'content' => 'Hatta Aksara Project lahir dari kesadaran mendalam para penerus perjuangan di bawah Hatta Aksara Project akan mendesaknya regenerasi kepemimpinan berintegritas di tanah air. Mohammad Hatta, Sang Proklamator dan Bapak Koperasi Indonesia, meyakini bahwa kemerdekaan sejati hanya dapat dijaga oleh masyarakat yang berpendidikan, mandiri secara ekonomi melalui asas gotong royong, dan memiliki kompas moral yang kokoh. Hatta Aksara dirancang sebagai jembatan yang menghubungkan kearifan nilai-nilai luhur Bung Hatta dengan generasi muda masa kini.',
            ]
        );

        PageContent::firstOrCreate(
            ['section_key' => 'about_vision'],
            [
                'title' => 'Visi Kami',
                'content' => 'Menjadi pusat pembinaan kepemimpinan pemuda terdepan di Indonesia yang melahirkan generasi pemimpin berkarakter, berpegang teguh pada jati diri bangsa (weltanschauung), serta aktif memajukan keadilan sosial melalui prinsip ekonomi kerakyatan dan kebudayaan.',
            ]
        );

        PageContent::firstOrCreate(
            ['section_key' => 'about_mission'],
            [
                'title' => 'Misi Kami',
                'content' => "1. Menyelenggarakan pelatihan kepemimpinan berstandar tinggi (ISLT) bagi calon-calon pemimpin muda dari seluruh provinsi di Indonesia.\n2. Mengembangkan ekosistem literasi dan ruang diskusi terbuka mengenai pemikiran ekonomi koperasi Bung Hatta dan SDGs.\n3. Membangun jejaring alumni (Hatta Muda Connection) yang solid dan berdampak nyata bagi masyarakat di daerah masing-masing.\n4. Merawat kepustakaan digital dan arsip sejarah nilai-nilai pahlawan nasional untuk pencerahan generasi mendatang.",
            ]
        );

        PageContent::firstOrCreate(
            ['section_key' => 'about_values'],
            [
                'title' => 'Nilai-Nilai Luhur',
                'content' => "1. **Integritas Tanpa Kompromi**: Keselarasan antara perkataan, pemikiran, dan tindakan demi kepentingan bangsa di atas kepentingan pribadi.\n2. **Kooperatif & Gotong Royong**: Membina semangat kebersamaan dan tolong-menolong sebagai asas utama kehidupan sosial dan ekonomi.\n3. **Cinta Ilmu & Kebudayaan**: Menghargai pemikiran rasional, budaya membaca mendalam, dan penghormatan pada kearifan lokal nusantara.\n4. **Kesederhanaan & Pengabdian**: Sikap hidup bersahaja yang diabdikan sepenuhnya bagi kemaslahatan rakyat.",
            ]
        );

        // 11. Seed Sample ISLT Applicants
        IsltApplicant::firstOrCreate(
            ['registration_code' => 'ISLT-2026-0001-K39FA'],
            [
                'full_name' => 'Muhammad Rifqi Al-Ghifari',
                'nisn' => '0068192381',
                'birth_place' => 'Padang',
                'birth_date' => '2008-04-14',
                'gender' => 'L',
                'whatsapp_number' => '081377889900',
                'email' => 'rifqi.ghifari@gmail.com',
                'province' => 'Sumatera Barat',
                'city' => 'Kota Padang',
                'school_name' => 'SMAN 1 Padang',
                'osis_position' => 'Ketua OSIS',
                'organization_experience' => 'Ketua OSIS SMAN 1 Padang 2025/2026, Delegasi Parlemen Remaja DPR RI 2025, Juara 1 Lomba Debat Kebangsaan.',
                'motivation_essay' => 'Saya ingin memahami lebih dalam gagasan ekonomi kerakyatan Bung Hatta untuk mereformasi program kerja OSIS berbasis pemberdayaan siswa.',
                'selection_status' => 'submitted',
                'created_at' => now()->subDays(2),
            ]
        );

        IsltApplicant::firstOrCreate(
            ['registration_code' => 'ISLT-2026-0002-M88PQ'],
            [
                'full_name' => 'Ni Putu Anindya Saraswati',
                'nisn' => '0071293844',
                'birth_place' => 'Denpasar',
                'birth_date' => '2008-09-22',
                'gender' => 'P',
                'whatsapp_number' => '082144556677',
                'email' => 'anindya.saraswati@gmail.com',
                'province' => 'Bali',
                'city' => 'Kota Denpasar',
                'school_name' => 'SMAN 3 Denpasar',
                'osis_position' => 'Ketua OSIS',
                'organization_experience' => 'Ketua OSIS SMAN 3 Denpasar, Inisiator Gerakan Pemuda Peduli Lingkungan & Budaya Bali.',
                'motivation_essay' => 'Ingin menyelaraskan kearifan lokal Tri Hita Karana dengan prinsip ekonomi gotong royong Bung Hatta dalam memimpin generasi muda di Bali.',
                'selection_status' => 'screening',
                'created_at' => now()->subDay(),
            ]
        );

        IsltApplicant::firstOrCreate(
            ['registration_code' => 'ISLT-2026-0003-T92BC'],
            [
                'full_name' => 'Yohanes Maria Vianney',
                'nisn' => '0069921823',
                'birth_place' => 'Jayapura',
                'birth_date' => '2007-12-10',
                'gender' => 'L',
                'whatsapp_number' => '081299887766',
                'email' => 'yohanes.vianney@gmail.com',
                'province' => 'Papua',
                'city' => 'Kota Jayapura',
                'school_name' => 'SMA Katolik Taruna Dharma Jayapura',
                'osis_position' => 'Ketua OSIS',
                'organization_experience' => 'Ketua OSIS 2025/2026, Komandan Paskibra Kota Jayapura.',
                'motivation_essay' => 'Membangun jembatan persaudaraan dari timur Indonesia untuk meneladani kejujuran Bung Hatta demi kemajuan pemuda Papua.',
                'selection_status' => 'interview',
                'created_at' => now()->subHours(6),
            ]
        );
    }
}
