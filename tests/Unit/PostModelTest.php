<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_get_type_label_returns_accurate_descriptions(): void
    {
        $newsPost = new Post(['post_type' => 'news']);
        $this->assertEquals('Warta Resmi', $newsPost->getTypeLabel());
        $this->assertEquals('Warta Resmi', $newsPost->type_label);

        $kegiatanPost = new Post(['post_type' => 'kegiatan']);
        $this->assertEquals('Kegiatan', $kegiatanPost->getTypeLabel());

        $aksiPost = new Post(['post_type' => 'aksi_hatta_muda']);
        $this->assertEquals('Aksi Hatta Muda', $aksiPost->getTypeLabel());

        $artikelPost = new Post(['post_type' => 'artikel']);
        $this->assertEquals('Artikel Gagasan', $artikelPost->getTypeLabel());

        $customPost = new Post(['post_type' => 'kuliah_umum']);
        $this->assertEquals('Kuliah umum', $customPost->getTypeLabel());
    }

    public function test_featured_image_url_accessor_handles_urls_and_null(): void
    {
        $postNoImage = new Post(['featured_image' => null]);
        $this->assertNull($postNoImage->featured_image_url);

        $postHttp = new Post(['featured_image' => 'https://example.com/photo.jpg']);
        $this->assertEquals('https://example.com/photo.jpg', $postHttp->featured_image_url);

        $postLocal = new Post(['featured_image' => 'images/heritage/bung-hatta-hero.jpg']);
        $this->assertNotNull($postLocal->featured_image_url);
    }

    public function test_post_scopes_filter_by_type_and_status(): void
    {
        $publishedCount = Post::published()->count();
        $this->assertGreaterThan(0, $publishedCount);

        $newsCount = Post::news()->count();
        $this->assertGreaterThan(0, $newsCount);

        $aksiCount = Post::aksiHattaMuda()->count();
        $this->assertGreaterThan(0, $aksiCount);

        $artikelCount = Post::artikel()->count();
        $this->assertGreaterThan(0, $artikelCount);

        $author = User::where('role', 'admin')->first();
        $cat = Category::first();
        $sub = SubCategory::first();

        $draftPost = Post::create([
            'author_id' => $author->id,
            'post_type' => 'news',
            'category_id' => $cat->id,
            'sub_category_id' => $sub->id,
            'title' => 'Draft In Review',
            'slug' => 'draft-in-review',
            'excerpt' => 'Excerpt draft',
            'content' => 'Content draft',
            'status' => 'pending_review',
        ]);

        $this->assertTrue(Post::pendingReview()->where('id', $draftPost->id)->exists());
        $this->assertFalse(Post::published()->where('id', $draftPost->id)->exists());
    }

    public function test_post_relationships_are_properly_defined(): void
    {
        $post = Post::published()->first();
        $this->assertNotNull($post);

        $this->assertInstanceOf(User::class, $post->author);
        $this->assertInstanceOf(Category::class, $post->category);
        $this->assertInstanceOf(SubCategory::class, $post->subCategory);
    }
}
