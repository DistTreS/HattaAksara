<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\EJournal;
use App\Models\IsltApplicant;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Program;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HappyPathWorkflowsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        Storage::fake('public');
    }

    public function test_user_can_login_and_logout_successfully(): void
    {
        $response = $this->post(route('login.store'), [
            'email' => 'admin@hattaaksara.id',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();

        $logoutResponse = $this->post(route('logout'));
        $logoutResponse->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_alumni_can_create_aksi_hatta_muda_and_it_is_pending_review(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();
        $this->assertNotNull($alumni);

        $file = UploadedFile::fake()->create('kegiatan.jpg', 600, 'image/jpeg');

        $payload = [
            'title' => 'Gerakan Literasi Pelajar di Bukittinggi',
            'action_location' => 'Bukittinggi, Sumatera Barat',
            'action_date' => '2026-08-17',
            'excerpt' => 'Aksi nyata alumni ISLT menginisiasi pojok baca di sekolah-sekolah.',
            'content' => '<p>Deskripsi lengkap tentang kegiatan literasi kebangsaan untuk pelajar.</p>',
            'featured_image' => $file,
            'action_button' => 'submit',
        ];

        $response = $this->actingAs($alumni)->post(route('alumni.store-aksi'), $payload);
        $response->assertRedirect(route('alumni.my-posts'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('posts', [
            'author_id' => $alumni->id,
            'title' => 'Gerakan Literasi Pelajar di Bukittinggi',
            'post_type' => 'aksi_hatta_muda',
            'status' => 'pending_review',
        ]);
    }

    public function test_alumni_can_create_artikel_and_it_is_pending_review(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();

        $payload = [
            'title' => 'Relevansi Koperasi Pemuda di Era Digital',
            'excerpt' => 'Kajian pemikiran ekonomi Mohammad Hatta dalam kacamata generasi Z.',
            'content' => '<p>Gagasan mendalam mengenai penguatan ekonomi gotong royong modern.</p>',
            'action_button' => 'submit',
        ];

        $response = $this->actingAs($alumni)->post(route('alumni.store-artikel'), $payload);
        $response->assertRedirect(route('alumni.my-posts'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('posts', [
            'author_id' => $alumni->id,
            'title' => 'Relevansi Koperasi Pemuda di Era Digital',
            'post_type' => 'artikel',
            'status' => 'pending_review',
        ]);
    }

    public function test_alumni_can_update_own_post(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();
        $post = Post::where('author_id', $alumni->id)->first();
        $this->assertNotNull($post);

        $payload = [
            'title' => 'Judul Naskah Telah Diperbarui',
            'action_location' => 'Jakarta Selatan',
            'excerpt' => 'Ringkasan yang diperbarui.',
            'content' => 'Konten lengkap yang telah direvisi oleh penulis.',
            'action_button' => 'submit',
        ];

        $response = $this->actingAs($alumni)->put(route('alumni.update-post', $post->id), $payload);
        $response->assertRedirect(route('alumni.my-posts'));
        $response->assertSessionHas('success');

        $post->refresh();
        $this->assertEquals('Judul Naskah Telah Diperbarui', $post->title);
    }

    public function test_alumni_can_browse_networking_portal(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();

        $response = $this->actingAs($alumni)->get(route('alumni.networking'));
        $response->assertStatus(200);
        $response->assertSee('Jejaring');
    }

    public function test_admin_can_approve_pending_alumni_registration(): void
    {
        $admin = User::where('role', 'admin')->first();
        $pendingUser = User::where('role', 'hatta_muda')->where('status', 'pending')->first();
        $this->assertNotNull($pendingUser);

        $response = $this->actingAs($admin)->post(route('admin.verify-alumni.approve', $pendingUser->id));
        $response->assertSessionHas('success');

        $pendingUser->refresh();
        $this->assertEquals('approved', $pendingUser->status);
    }

    public function test_admin_can_review_and_publish_pending_post(): void
    {
        $admin = User::where('role', 'admin')->first();
        $author = User::where('role', 'hatta_muda')->first();
        $category = Category::first();

        $post = Post::create([
            'author_id' => $author->id,
            'category_id' => $category->id,
            'title' => 'Naskah Uji Review Admin',
            'slug' => 'naskah-uji-review-admin',
            'post_type' => 'artikel',
            'content' => 'Konten naskah yang menunggu persetujuan admin.',
            'status' => 'pending_review',
        ]);

        $detailResponse = $this->actingAs($admin)->get(route('admin.review-posts.detail', $post->id));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Naskah Uji Review Admin');

        $approveResponse = $this->actingAs($admin)->post(route('admin.review-posts.status', $post->id), [
            'action' => 'approve',
        ]);
        $approveResponse->assertSessionHas('success');

        $post->refresh();
        $this->assertEquals('published', $post->status);
        $this->assertNotNull($post->published_at);
    }

    public function test_admin_can_request_revision_with_editorial_notes(): void
    {
        $admin = User::where('role', 'admin')->first();
        $author = User::where('role', 'hatta_muda')->first();
        $category = Category::first();

        $post = Post::create([
            'author_id' => $author->id,
            'category_id' => $category->id,
            'title' => 'Naskah Butuh Perbaikan Referensi',
            'slug' => 'naskah-butuh-perbaikan-referensi',
            'post_type' => 'artikel',
            'content' => 'Konten naskah awal.',
            'status' => 'pending_review',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.review-posts.status', $post->id), [
            'action' => 'revision',
            'admin_notes' => 'Harap sertakan sumber kutipan buku Mohammad Hatta di paragraf kedua.',
        ]);
        $response->assertSessionHas('success');

        $post->refresh();
        $this->assertEquals('revision_required', $post->status);
        $this->assertEquals('Harap sertakan sumber kutipan buku Mohammad Hatta di paragraf kedua.', $post->admin_notes);
    }

    public function test_admin_can_publish_news_and_delete_post(): void
    {
        $admin = User::where('role', 'admin')->first();

        $payload = [
            'title' => 'Peluncuran Gerakan Aksara Muda 2026',
            'post_type' => 'news',
            'content' => 'Kabar gembira tentang peluncuran program unggulan baru.',
            'excerpt' => 'Inisiatif literasi kebangsaan untuk generasi muda.',
        ];

        $storeResponse = $this->actingAs($admin)->post(route('admin.posts.store'), $payload);
        $storeResponse->assertRedirect(route('admin.posts.index'));
        $storeResponse->assertSessionHas('success');

        $createdPost = Post::where('title', 'Peluncuran Gerakan Aksara Muda 2026')->first();
        $this->assertNotNull($createdPost);
        $this->assertEquals('published', $createdPost->status);

        $deleteResponse = $this->actingAs($admin)->delete(route('admin.posts.delete', $createdPost->id));
        $deleteResponse->assertSessionHas('info');
        $this->assertDatabaseMissing('posts', ['id' => $createdPost->id]);
    }

    public function test_admin_can_create_subcategory(): void
    {
        $admin = User::where('role', 'admin')->first();
        $category = Category::first();

        $payload = [
            'category_id' => $category->id,
            'name' => 'Wirausaha Mandiri',
            'description' => 'Sub kategori kewirausahaan berbasis gotong royong.',
        ];

        $response = $this->actingAs($admin)->post(route('admin.categories.store-sub'), $payload);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('sub_categories', [
            'category_id' => $category->id,
            'name' => 'Wirausaha Mandiri',
        ]);
    }

    public function test_admin_can_upload_and_delete_ejournal(): void
    {
        $admin = User::where('role', 'admin')->first();
        $pdf = UploadedFile::fake()->create('jurnal_pemikiran.pdf', 1500, 'application/pdf');

        $payload = [
            'title' => 'Jurnal Kajian Demokrasi Kerakyatan Vol 3',
            'author_or_curator' => 'Pusat Kajian Kebangsaan',
            'publication_year' => 2026,
            'category' => 'Ekonomi & Demokrasi',
            'description' => 'Edisi khusus bedah gagasan Mohammad Hatta.',
            'document_file' => $pdf,
        ];

        $storeResponse = $this->actingAs($admin)->post(route('admin.ejournal.store'), $payload);
        $storeResponse->assertSessionHas('success');

        $journal = EJournal::where('title', 'Jurnal Kajian Demokrasi Kerakyatan Vol 3')->first();
        $this->assertNotNull($journal);

        $deleteResponse = $this->actingAs($admin)->delete(route('admin.ejournal.delete', $journal->id));
        $deleteResponse->assertSessionHas('info');
        $this->assertDatabaseMissing('e_journals', ['id' => $journal->id]);
    }

    public function test_admin_can_update_program_and_about_content(): void
    {
        $admin = User::where('role', 'admin')->first();
        $program = Program::first();
        $this->assertNotNull($program);

        $progPayload = [
            'title' => 'Indonesian Student Leadership Training 2026 (Updated)',
            'tagline' => 'Membangun Karakter Pemimpin Berintegritas',
            'description' => 'Program pelatihan kepemimpinan intensif untuk generasi penerus.',
            'is_registration_open' => 1,
        ];

        $progResponse = $this->actingAs($admin)->put(route('admin.programs.update', $program->id), $progPayload);
        $progResponse->assertSessionHas('success');

        $program->refresh();
        $this->assertEquals('Indonesian Student Leadership Training 2026 (Updated)', $program->title);

        $section = PageContent::first();
        if ($section) {
            $aboutPayload = [
                'title' => 'Visi & Karakter Kebangsaan',
                'content' => 'Uraian visi diperbarui oleh administrator.',
            ];

            $aboutResponse = $this->actingAs($admin)->put(route('admin.about.update', $section->id), $aboutPayload);
            $aboutResponse->assertSessionHas('success');

            $section->refresh();
            $this->assertEquals('Visi & Karakter Kebangsaan', $section->title);
        }
    }

    public function test_admin_can_export_islt_applicants_data(): void
    {
        $admin = User::where('role', 'admin')->first();

        $xlsxResponse = $this->actingAs($admin)->get(route('admin.islt.export-xlsx'));
        $xlsxResponse->assertStatus(200);

        $pdfResponse = $this->actingAs($admin)->get(route('admin.islt.export-pdf'));
        $pdfResponse->assertStatus(200);
    }
}
