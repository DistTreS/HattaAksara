<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniAndAdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_unauthenticated_users_are_redirected_to_login(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.posts.index'))->assertRedirect(route('login'));
        $this->get(route('admin.islt.index'))->assertRedirect(route('login'));
        $this->get(route('admin.verify-alumni.index'))->assertRedirect(route('login'));

        $this->get(route('alumni.dashboard'))->assertRedirect(route('login'));
        $this->get(route('alumni.profile'))->assertRedirect(route('login'));
        $this->get(route('alumni.create-aksi'))->assertRedirect(route('login'));
        $this->get(route('alumni.create-artikel'))->assertRedirect(route('login'));
    }

    public function test_alumni_cannot_access_admin_panel(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();

        $response = $this->actingAs($alumni)->get(route('admin.dashboard'));
        $this->assertTrue(in_array($response->status(), [403, 302]));
    }

    public function test_admin_can_access_all_management_screens(): void
    {
        $admin = User::where('role', 'admin')->first();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertStatus(200)
            ->assertSee('Dashboard Redaksi');

        $this->actingAs($admin)->get(route('admin.islt.index'))
            ->assertStatus(200);

        $this->actingAs($admin)->get(route('admin.verify-alumni.index'))
            ->assertStatus(200);

        $this->actingAs($admin)->get(route('admin.review-posts.index'))
            ->assertStatus(200);

        $this->actingAs($admin)->get(route('admin.posts.index'))
            ->assertStatus(200);

        $this->actingAs($admin)->get(route('admin.categories.index'))
            ->assertStatus(200);

        $this->actingAs($admin)->get(route('admin.programs.index'))
            ->assertStatus(200);

        $this->actingAs($admin)->get(route('admin.ejournal.index'))
            ->assertStatus(200);

        $this->actingAs($admin)->get(route('admin.about.index'))
            ->assertStatus(200);
    }

    public function test_approved_alumni_can_update_profile(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();

        $payload = [
            'name' => 'Alumni Terverifikasi',
            'phone_number' => '089988776655',
            'current_institution' => 'Universitas Indonesia',
            'bio' => 'Ketua OSIS yang aktif menggerakkan wawasan kebangsaan.',
        ];

        $response = $this->actingAs($alumni)->put(route('alumni.update-profile'), $payload);
        $response->assertSessionHas('success');

        $alumni->refresh();
        $this->assertEquals('Alumni Terverifikasi', $alumni->name);
        $this->assertEquals('Universitas Indonesia', $alumni->alumniProfile->current_institution);
    }
    public function test_editing_published_post_reverts_status_to_pending_review_and_hides_from_public(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();
        $post = Post::where('author_id', $alumni->id)->where('status', 'published')->first();
        $this->assertNotNull($post);

        // Sebelum diedit, naskah tayang di publik
        $this->get(route('berita.show', $post->slug))->assertStatus(200);

        // Alumni mengedit isi naskah dan mengirimkan ulang
        $payload = [
            'title' => 'Judul Setelah Diedit oleh Penulis',
            'action_location' => 'Kota Padang',
            'content' => 'Konten naskah baru yang direvisi oleh alumni.',
            'action_button' => 'submit',
        ];

        $response = $this->actingAs($alumni)->put(route('alumni.update-post', $post->id), $payload);
        $response->assertSessionHas('warning');

        $post->refresh();
        // Status WAJIB kembali ke pending_review
        $this->assertEquals('pending_review', $post->status);

        // Di publik, naskah otomatis tersembunyi (404 Not Found)
        $this->get(route('berita.show', $post->slug))->assertStatus(404);

        // Admin dapat melihat naskah ini kembali di antrean moderasi
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin)->get(route('admin.review-posts.detail', $post->id))
            ->assertStatus(200)
            ->assertSee('Judul Setelah Diedit oleh Penulis');
    }

    public function test_google_sheets_sync_lifecycle_and_webhook(): void
    {
        $admin = User::where('role', 'admin')->first();

        // 1. Saat webhook belum diset, sistem memberikan peringatan ramah
        \App\Models\PageContent::where('section_key', 'google_sheets_webhook_url')->delete();
        config(['services.google_sheets.webhook_url' => null]);

        $responseNoConfig = $this->actingAs($admin)->post(route('admin.islt.sync-sheets'));
        $responseNoConfig->assertSessionHas('warning');

        // 2. Admin menyimpan URL Webhook Google Apps Script
        $fakeWebhookUrl = 'https://script.google.com/macros/s/AKfycbz_MOCK_TEST/exec';
        $saveResponse = $this->actingAs($admin)->post(route('admin.islt.save-sheets-config'), [
            'sheets_webhook_url' => $fakeWebhookUrl,
        ]);
        $saveResponse->assertSessionHas('success');

        $this->assertDatabaseHas('page_contents', [
            'section_key' => 'google_sheets_webhook_url',
            'content' => $fakeWebhookUrl,
        ]);

        // 3. Saat ada pendaftar belum tersinkron dan webhook terpasang, data dikirim via HTTP
        \Illuminate\Support\Facades\Http::fake([
            $fakeWebhookUrl => \Illuminate\Support\Facades\Http::response(['status' => 'success', 'count' => 3], 200),
        ]);

        $syncResponse = $this->actingAs($admin)->post(route('admin.islt.sync-sheets'));
        $syncResponse->assertSessionHas('success');

        // Pastikan record pendaftar telah memiliki timestamp synced_to_sheets_at
        $unsyncedCount = \App\Models\IsltApplicant::whereNull('synced_to_sheets_at')->count();
        $this->assertEquals(0, $unsyncedCount);
    }
}
