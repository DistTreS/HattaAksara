<?php

namespace Tests\Feature;

use App\Models\EJournal;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicContentAndNavigationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_berita_index_and_filtering(): void
    {
        $this->get(route('berita.index'))
            ->assertStatus(200)
            ->assertSee('Semua Berita');

        $this->get(route('berita.index', ['type' => 'news']))
            ->assertStatus(200)
            ->assertSee('News Resmi');

        $this->get(route('berita.index', ['type' => 'kegiatan']))
            ->assertStatus(200);

        $this->get(route('berita.index', ['type' => 'aksi_hatta_muda']))
            ->assertStatus(200);

        $this->get(route('berita.index', ['q' => 'Hatta']))
            ->assertStatus(200);
    }

    public function test_berita_show_increments_views(): void
    {
        $post = Post::published()->first();
        $this->assertNotNull($post);

        $initialViews = $post->views_count;

        $this->get(route('berita.show', $post->slug))
            ->assertStatus(200)
            ->assertSee($post->title);

        $post->refresh();
        $this->assertEquals($initialViews + 1, $post->views_count);

        $this->get(route('berita.show', 'non-existent-post-slug-12345'))
            ->assertStatus(404);
    }

    public function test_artikel_index_and_detail(): void
    {
        $this->get(route('artikel.index'))
            ->assertStatus(200)
            ->assertSee('Artikel Gagasan');

        $article = Post::published()->artikel()->first();
        if ($article) {
            $this->get(route('artikel.show', $article->slug))
                ->assertStatus(200)
                ->assertSee($article->title);
        }

        $this->get(route('artikel.show', 'non-existent-article-slug-xyz'))
            ->assertStatus(404);
    }

    public function test_media_edukasi_shows_all_five_videos(): void
    {
        $response = $this->get(route('program.media-edukasi'));
        $response->assertStatus(200);

        $response->assertSee('Inspiring Speech dari Ibu Meutia Farida Hatta');
        $response->assertSee('ISLT 2025 Menuju Masyarakat Kooperatif');
        $response->assertSee('Kepemimpinan Empati — Pilar I ISLT');
        $response->assertSee('Social Problem Solving | Pilar ISLT');
        $response->assertSee('Mengapa Kita Harus Menjadi Bung Hatta?');
    }

    public function test_ejournal_download_tracking(): void
    {
        $journal = EJournal::first();
        $this->assertNotNull($journal);

        $initialDownloads = $journal->download_count;

        $response = $this->get(route('ejurnal.download', $journal->slug));

        $journal->refresh();
        $this->assertEquals($initialDownloads + 1, $journal->download_count);

        $this->get(route('ejurnal.download', 'non-existent-journal-999'))
            ->assertStatus(404);
    }
}
