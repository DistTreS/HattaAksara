<?php

namespace Tests\Feature;

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
}
