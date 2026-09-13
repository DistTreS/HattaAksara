<?php

namespace Tests\Unit;

use App\Models\AlumniProfile;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_user_roles_and_approval_helpers(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isHattaMuda());
        $this->assertTrue($admin->isApproved());

        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();
        $this->assertTrue($alumni->isHattaMuda());
        $this->assertFalse($alumni->isAdmin());
        $this->assertTrue($alumni->isApproved());

        $pending = User::where('role', 'hatta_muda')->where('status', 'pending')->first();
        $this->assertTrue($pending->isHattaMuda());
        $this->assertFalse($pending->isApproved());
    }

    public function test_user_relationships_with_profile_and_posts(): void
    {
        $alumni = User::where('role', 'hatta_muda')->where('status', 'approved')->first();
        $this->assertNotNull($alumni);

        $this->assertInstanceOf(AlumniProfile::class, $alumni->alumniProfile);
        $this->assertNotEmpty($alumni->alumniProfile->school_origin);

        $author = User::whereHas('posts')->first();
        $this->assertNotNull($author);
        $this->assertGreaterThan(0, $author->posts()->count());
        $this->assertInstanceOf(Post::class, $author->posts()->first());
    }
}
