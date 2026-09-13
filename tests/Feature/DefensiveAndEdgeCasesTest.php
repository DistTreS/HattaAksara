<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\EJournal;
use App\Models\IsltApplicant;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DefensiveAndEdgeCasesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        Storage::fake('public');
    }

    public function test_sql_injection_payloads_in_search_queries_are_handled_safely(): void
    {
        $maliciousQueries = [
            "' OR '1'='1",
            "'; DROP TABLE posts; --",
            "1' UNION SELECT null, null, null--",
            "admin'--",
            "' OR ''='",
        ];

        foreach ($maliciousQueries as $query) {
            $newsResponse = $this->get(route('berita.index', ['q' => $query]));
            $newsResponse->assertStatus(200);

            $journalResponse = $this->get(route('ejurnal.index', ['q' => $query]));
            $journalResponse->assertStatus(200);
        }
    }

    public function test_xss_payloads_are_safely_escaped_when_rendered(): void
    {
        $post = Post::published()->first();
        $this->assertNotNull($post);

        $post->title = 'Judul XSS <script>alert("XSS_ATTACK")</script>';
        $post->save();

        $response = $this->get(route('berita.show', $post->slug));
        $response->assertStatus(200);

        $response->assertDontSee('<script>alert("XSS_ATTACK")</script>', false);
        $response->assertSee('&lt;script&gt;alert(&quot;XSS_ATTACK&quot;)&lt;/script&gt;', false);
    }

    public function test_file_upload_rejects_dangerous_executable_extensions(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();

        // Alumni tries to upload a .php script disguised as an image
        $maliciousFile = UploadedFile::fake()->create('exploit.php', 100, 'application/x-php');

        $response = $this->actingAs($alumni)->post(route('alumni.store-aksi'), [
            'title' => 'Aksi Injeksi Berkas',
            'action_location' => 'Jakarta',
            'content' => 'Konten teks uji berkas berbahaya.',
            'featured_image' => $maliciousFile,
            'action_button' => 'submit',
        ]);

        $response->assertSessionHasErrors(['featured_image']);
    }

    public function test_file_upload_rejects_oversized_images(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();

        // 5MB image exceeds max:3072 KB limit
        $oversizedImage = UploadedFile::fake()->create('huge_photo.jpg', 5120, 'image/jpeg');

        $response = $this->actingAs($alumni)->post(route('alumni.store-aksi'), [
            'title' => 'Aksi Foto Terlalu Besar',
            'action_location' => 'Bandung',
            'content' => 'Konten pengujian berkas raksasa.',
            'featured_image' => $oversizedImage,
            'action_button' => 'submit',
        ]);

        $response->assertSessionHasErrors(['featured_image']);
    }

    public function test_admin_review_rejects_invalid_action_states(): void
    {
        $admin = User::where('role', 'admin')->first();
        $post = Post::first();

        $response = $this->actingAs($admin)->post(route('admin.review-posts.status', $post->id), [
            'action' => 'unauthorized_action_bypass',
        ]);

        $response->assertSessionHasErrors(['action']);
    }

    public function test_admin_revision_fails_if_notes_are_missing(): void
    {
        $admin = User::where('role', 'admin')->first();
        $post = Post::first();

        $response = $this->actingAs($admin)->post(route('admin.review-posts.status', $post->id), [
            'action' => 'revision',
            'admin_notes' => '',
        ]);

        $response->assertSessionHasErrors(['admin_notes']);
    }

    public function test_islt_registration_code_generator_produces_unique_codes_without_collision(): void
    {
        $codes = [];
        for ($i = 0; $i < 100; $i++) {
            $code = IsltApplicant::generateRegistrationCode();
            $codes[] = $code;
            $this->assertMatchesRegularExpression('/^ISLT-\d{4}-\d{4}-[A-Z0-9]+$/', $code);
        }

        $this->assertCount(100, array_unique($codes), 'Detected collision in ISLT registration code generation!');
    }

    public function test_ejournal_download_handles_physically_missing_file_gracefully(): void
    {
        $journal = EJournal::first();
        $this->assertNotNull($journal);

        // Ensure file does not exist on disk
        $journal->file_path = 'ejournal/non_existent_physical_file_99999.pdf';
        $journal->save();

        $response = $this->get(route('ejurnal.download', $journal->slug));

        // It should return a graceful 200 response with text fallback, never a 500 error
        $response->assertStatus(200);
        $this->assertStringContainsString('text/plain', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('Hatta Aksara Project', $response->getContent());
    }

    public function test_ejournal_download_serves_actual_pdf_when_file_exists(): void
    {
        $fakePdfPath = 'ejournal/files/actual_document.pdf';
        Storage::disk('public')->put($fakePdfPath, '%PDF-1.4 Mock PDF Content');

        $journal = EJournal::first();
        $journal->file_path = $fakePdfPath;
        $journal->save();

        $response = $this->get(route('ejurnal.download', $journal->slug));
        $response->assertStatus(200);
        $this->assertTrue($response->headers->get('content-disposition') !== null);
    }

    public function test_unicode_and_emojis_in_content_are_stored_and_retrieved_correctly(): void
    {
        $post = Post::published()->first();
        $this->assertNotNull($post);

        $specialText = 'Pahlawan Bangsa 🇮🇩✨ — "Hanya ada satu tanah air yang bernama Indonesia."';
        $post->title = 'Keteladanan Hatta di Era Milenial 🌟';
        $post->content = $specialText;
        $post->save();

        $response = $this->get(route('berita.show', $post->slug));
        $response->assertStatus(200);
        $response->assertSee('Keteladanan Hatta di Era Milenial 🌟');
        $response->assertSee('🇮🇩✨');
    }
}
