<?php

namespace Tests\Feature;

use App\Models\IsltApplicant;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HattaAksaraTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_guest_pages_are_accessible(): void
    {
        $this->get(route('home'))->assertStatus(200)->assertSee('Hatta Aksara');
        $this->get(route('about'))->assertStatus(200)->assertSee('Sejarah');
        $this->get(route('berita.index'))->assertStatus(200)->assertSee('Media Berita');
        $this->get(route('program.index'))->assertStatus(200)->assertSee('Program');
        $this->get(route('program.islt'))->assertStatus(200)->assertSee('ISLT');
        $this->get(route('program.islt.daftar'))->assertStatus(200)->assertSee('Formulir Calon Peserta');
        $this->get(route('program.media-edukasi'))->assertStatus(200)->assertSee('Media Edukasi');
        $this->get(route('artikel.index'))->assertStatus(200)->assertSee('Artikel Gagasan');
        $this->get(route('ejurnal.index'))->assertStatus(200)->assertSee('E-Jurnal');
        $this->get(route('login'))->assertStatus(200)->assertSee('Masuk ke Portal');
        $this->get(route('register.hatta-muda'))->assertStatus(200)->assertSee('Bergabung Menjadi Hatta Muda');
    }

    public function test_islt_public_registration_succeeds_without_account(): void
    {
        $payload = [
            'full_name' => 'Aditya Pratama Putra',
            'nisn' => '0071122334',
            'birth_place' => 'Surakarta',
            'birth_date' => '2008-05-12',
            'gender' => 'L',
            'whatsapp_number' => '081234567899',
            'email' => 'aditya.pratama@gmail.com',
            'province' => 'Jawa Tengah',
            'city' => 'Kota Surakarta',
            'school_name' => 'SMAN 1 Surakarta',
            'osis_position' => 'Ketua OSIS',
            'organization_experience' => 'Ketua OSIS masa bakti 2025/2026',
            'motivation_essay' => 'Ingin meneladani Bung Hatta dalam menggerakkan koperasi pelajar.',
        ];

        $response = $this->post(route('program.islt.store'), $payload);

        $applicant = IsltApplicant::where('email', 'aditya.pratama@gmail.com')->first();
        $this->assertNotNull($applicant);
        $this->assertStringStartsWith('ISLT-', $applicant->registration_code);

        $response->assertRedirect(route('program.islt.success', ['code' => $applicant->registration_code]));

        $this->get(route('program.islt.success', ['code' => $applicant->registration_code]))
            ->assertStatus(200)
            ->assertSee($applicant->registration_code)
            ->assertSee('Aditya Pratama Putra');
    }

    public function test_hatta_muda_alumni_registration_requires_admin_verification(): void
    {
        $payload = [
            'name' => 'Fadli Rahman',
            'email' => 'fadli.rahman@alumni.test',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
            'islt_batch' => 'Angkatan I (2024)',
            'province' => 'Aceh',
            'city' => 'Banda Aceh',
            'school_origin' => 'SMAN 1 Banda Aceh',
            'current_institution' => 'Universitas Syiah Kuala',
            'phone_number' => '081233445566',
            'bio' => 'Ketua OSIS Angkatan 2024.',
        ];

        $response = $this->post(route('register.hatta-muda.store'), $payload);
        $response->assertRedirect(route('alumni.pending-notice'));

        $user = User::where('email', 'fadli.rahman@alumni.test')->first();
        $this->assertNotNull($user);
        $this->assertEquals('pending', $user->status);
        $this->assertEquals('hatta_muda', $user->role);

        // Pending user cannot access protected alumni workspace directly
        $this->actingAs($user)->get(route('alumni.dashboard'))->assertRedirect(route('alumni.pending-notice'));
    }

    public function test_admin_can_approve_alumni_and_reject_deletes_record(): void
    {
        $admin = User::where('role', 'admin')->first();
        $pendingUser = User::where('role', 'hatta_muda')->where('status', 'pending')->first();

        // 1. Approve alumni
        $this->actingAs($admin)
            ->post(route('admin.verify-alumni.approve', $pendingUser->id))
            ->assertSessionHas('success');

        $pendingUser->refresh();
        $this->assertEquals('approved', $pendingUser->status);

        // Now approved alumni can access dashboard
        $this->actingAs($pendingUser)
            ->get(route('alumni.dashboard'))
            ->assertStatus(200)
            ->assertSee('Dashboard Alumni');

        // 2. Reject another alumni -> deletes immediately from database
        $userToDelete = User::factory()->create(['role' => 'hatta_muda', 'status' => 'pending']);
        $this->actingAs($admin)
            ->delete(route('admin.verify-alumni.reject', $userToDelete->id))
            ->assertSessionHas('info');

        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    public function test_editorial_workflow_aksi_and_artikel(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();
        $admin = User::where('role', 'admin')->first();

        // 1. Alumni writes Berita Aksi Hatta Muda
        $aksiPayload = [
            'title' => 'Inisiatif Koperasi Siswa di Kota Bukittinggi',
            'action_location' => 'Kota Bukittinggi',
            'action_date' => now()->toDateString(),
            'excerpt' => 'Dampak nyata pendampingan OSIS untuk mendirikan koperasi.',
            'content' => 'Laporan lengkap aksi nyata di lapangan.',
            'action_button' => 'submit',
        ];

        $this->actingAs($alumni)->post(route('alumni.store-aksi'), $aksiPayload);

        $post = Post::where('title', 'Inisiatif Koperasi Siswa di Kota Bukittinggi')->first();
        $this->assertNotNull($post);
        $this->assertEquals('pending_review', $post->status);

        // 2. Admin asks for revision with notes
        $this->actingAs($admin)->post(route('admin.review-posts.status', $post->id), [
            'action' => 'revision',
            'admin_notes' => 'Tolong tambahkan foto dan detail jumlah siswa yang terlibat.',
        ]);

        $post->refresh();
        $this->assertEquals('revision_required', $post->status);
        $this->assertEquals('Tolong tambahkan foto dan detail jumlah siswa yang terlibat.', $post->admin_notes);

        // 3. Alumni sees revision notes and updates
        $this->actingAs($alumni)->get(route('alumni.edit-post', $post->id))
            ->assertStatus(200)
            ->assertSee('Tolong tambahkan foto');

        $this->actingAs($alumni)->put(route('alumni.update-post', $post->id), [
            'title' => 'Inisiatif Koperasi Siswa di Kota Bukittinggi (Revisi)',
            'action_location' => 'Kota Bukittinggi',
            'content' => 'Laporan lengkap yang telah diperbarui dengan data siswa.',
            'action_button' => 'submit',
        ]);

        $post->refresh();
        $this->assertEquals('pending_review', $post->status);

        // 4. Admin approves post
        $this->actingAs($admin)->post(route('admin.review-posts.status', $post->id), [
            'action' => 'approve',
        ]);

        $post->refresh();
        $this->assertEquals('published', $post->status);

        // 5. Post is now visible to public
        $this->get(route('berita.show', $post->slug))
            ->assertStatus(200)
            ->assertSee('Inisiatif Koperasi Siswa');
    }

    public function test_admin_export_islt_applicants_csv(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.islt.export-xlsx'));
        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-type'), 'text/csv'));
    }

    public function test_admin_has_superuser_access_to_alumni_portal_without_403(): void
    {
        $admin = User::where('role', 'admin')->first();

        $this->actingAs($admin)->get(route('alumni.dashboard'))->assertStatus(200);
        $this->actingAs($admin)->get(route('alumni.networking'))->assertStatus(200);
        $this->actingAs($admin)->get(route('alumni.my-posts'))->assertStatus(200);
        $this->actingAs($admin)->get(route('alumni.profile'))->assertStatus(200);
    }
}
