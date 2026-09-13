<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NegativeScenariosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_login_fails_with_invalid_password(): void
    {
        $response = $this->post(route('login.store'), [
            'email' => 'admin@hattaaksara.id',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_login_fails_with_unregistered_email(): void
    {
        $response = $this->post(route('login.store'), [
            'email' => 'tidakada@hattaaksara.id',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_pending_alumni_redirected_to_pending_notice(): void
    {
        $pendingUser = User::where('role', 'hatta_muda')->where('status', 'pending')->first();
        $this->assertNotNull($pendingUser);

        $response = $this->actingAs($pendingUser)->get(route('alumni.dashboard'));
        $response->assertRedirect(route('alumni.pending-notice'));
    }

    public function test_rejected_or_inactive_alumni_is_logged_out_when_accessing_portal(): void
    {
        $user = User::factory()->create([
            'role' => 'hatta_muda',
            'status' => 'rejected',
        ]);

        $response = $this->actingAs($user)->get(route('alumni.dashboard'));
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_regular_alumni_forbidden_from_admin_actions(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();

        $approveResponse = $this->actingAs($alumni)->post(route('admin.verify-alumni.approve', 1));
        $this->assertTrue(in_array($approveResponse->status(), [403, 302]));

        $createNewsResponse = $this->actingAs($alumni)->get(route('admin.posts.create'));
        $this->assertTrue(in_array($createNewsResponse->status(), [403, 302]));
    }

    public function test_alumni_cannot_edit_or_update_post_owned_by_another_user(): void
    {
        $alumniA = User::where('role', 'hatta_muda')->where('status', 'approved')->first();

        // Create a second alumni user with their own post
        $alumniB = User::factory()->create([
            'role' => 'hatta_muda',
            'status' => 'approved',
        ]);

        $category = Category::first();
        $postB = Post::create([
            'author_id' => $alumniB->id,
            'category_id' => $category->id,
            'title' => 'Naskah Milik Alumni B',
            'slug' => 'naskah-milik-alumni-b',
            'post_type' => 'artikel',
            'content' => 'Konten rahasia alumni B.',
            'status' => 'pending_review',
        ]);

        // Alumni A attempts to update Post B
        $response = $this->actingAs($alumniA)->put(route('alumni.update-post', $postB->id), [
            'title' => 'Judul Dibajak Oleh Alumni A',
            'content' => 'Konten dibajak.',
            'action_button' => 'submit',
        ]);

        $response->assertStatus(404);

        $postB->refresh();
        $this->assertEquals('Naskah Milik Alumni B', $postB->title);
    }

    public function test_register_hatta_muda_validation_fails_on_missing_fields(): void
    {
        $response = $this->post(route('register.hatta-muda.store'), []);
        $response->assertSessionHasErrors(['name', 'email', 'password', 'islt_batch', 'school_origin']);
    }

    public function test_register_hatta_muda_fails_on_duplicate_email(): void
    {
        $existing = User::first();

        $response = $this->post(route('register.hatta-muda.store'), [
            'name' => 'Duplikat User',
            'email' => $existing->email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'islt_batch' => '2025',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'school_origin' => 'SMAN 3 Bandung',
            'phone_number' => '081234567890',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_register_hatta_muda_fails_when_password_confirmation_does_not_match(): void
    {
        $response = $this->post(route('register.hatta-muda.store'), [
            'name' => 'Mismatch Password User',
            'email' => 'mismatch@hattaaksara.id',
            'password' => 'password123',
            'password_confirmation' => 'berbeda456',
            'islt_batch' => '2025',
            'school_origin' => 'SMAN 1 Jakarta',
            'phone_number' => '081234567890',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_islt_registration_fails_on_invalid_email_and_missing_fields(): void
    {
        $response = $this->post(route('program.islt.store'), [
            'full_name' => 'Ahmad Pelajar',
            'email' => 'bukan-format-email-valid',
        ]);

        $response->assertSessionHasErrors(['email', 'birth_place', 'birth_date', 'gender', 'whatsapp_number', 'school_name', 'osis_position', 'motivation_essay']);
    }

    public function test_alumni_create_aksi_fails_validation_with_missing_title_or_content(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();

        $response = $this->actingAs($alumni)->post(route('alumni.store-aksi'), [
            'action_button' => 'submit',
        ]);

        $response->assertSessionHasErrors(['title', 'action_location', 'content']);
    }

    public function test_admin_create_post_fails_validation_with_invalid_post_type(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post(route('admin.posts.store'), [
            'title' => 'Judul Berita',
            'post_type' => 'tipe_ilegal_123',
            'content' => 'Konten berita.',
        ]);

        $response->assertSessionHasErrors(['post_type']);
    }

    public function test_admin_create_subcategory_fails_with_invalid_category_id(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post(route('admin.categories.store-sub'), [
            'category_id' => 999999,
            'name' => 'Sub Kategori Invalid',
        ]);

        $response->assertSessionHasErrors(['category_id']);
    }

    public function test_admin_create_ejournal_fails_without_document_file(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post(route('admin.ejournal.store'), [
            'title' => 'Jurnal Tanpa File',
            'author_or_curator' => 'Kurator',
            'publication_year' => 2026,
            'category' => 'Demokrasi',
        ]);

        $response->assertSessionHasErrors(['document_file']);
    }

    public function test_accessing_non_existent_news_slug_returns_404(): void
    {
        $response = $this->get(route('berita.show', 'slug-fiktif-tidak-ada-12345'));
        $response->assertStatus(404);
    }

    public function test_accessing_non_existent_article_slug_returns_404(): void
    {
        $response = $this->get(route('artikel.show', 'slug-artikel-fiktif-12345'));
        $response->assertStatus(404);
    }

    public function test_downloading_non_existent_ejournal_returns_404(): void
    {
        $response = $this->get(route('ejurnal.download', 'slug-jurnal-tidak-ada'));
        $response->assertStatus(404);
    }

    public function test_admin_reviewing_non_existent_post_returns_404(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.review-posts.detail', 999999));
        $response->assertStatus(404);
    }

    public function test_admin_approving_non_existent_alumni_returns_404(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post(route('admin.verify-alumni.approve', 999999));
        $response->assertStatus(404);
    }
}
