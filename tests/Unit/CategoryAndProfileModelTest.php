<?php

namespace Tests\Unit;

use App\Models\AlumniProfile;
use App\Models\Category;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryAndProfileModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_category_has_subcategories_and_posts(): void
    {
        $category = Category::first();
        $this->assertNotNull($category);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $category->subCategories());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $category->posts());

        $subCategory = SubCategory::first();
        $this->assertNotNull($subCategory);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $subCategory->category());
        $this->assertInstanceOf(Category::class, $subCategory->category);
    }

    public function test_alumni_profile_relation_and_casts(): void
    {
        $alumni = User::where('role', 'hatta_muda')->first();
        $this->assertNotNull($alumni);

        $profile = $alumni->alumniProfile;
        $this->assertNotNull($profile);
        $this->assertInstanceOf(User::class, $profile->user);
        $this->assertIsBool($profile->is_phone_public);
    }

    public function test_page_content_updated_by_relation(): void
    {
        $admin = User::where('role', 'admin')->first();
        $content = PageContent::create([
            'section_key' => 'test_section',
            'title' => 'Test Title',
            'content' => 'Test Content',
            'updated_by' => $admin->id,
        ]);

        $this->assertInstanceOf(User::class, $content->updatedBy);
        $this->assertEquals($admin->id, $content->updatedBy->id);
    }
}
