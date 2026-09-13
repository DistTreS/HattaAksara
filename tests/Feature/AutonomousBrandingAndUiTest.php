<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutonomousBrandingAndUiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_homepage_does_not_contain_yayasan_proklamator_mentions(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);

        $content = $response->getContent();
        $this->assertStringNotContainsString('Yayasan Proklamator Bung Hatta', $content);
        $this->assertStringContainsString('Hatta Aksara Project', $content);
        $this->assertStringContainsString('Gerakan Mandiri', $content);
    }

    public function test_about_page_reflects_autonomous_hatta_aksara_identity(): void
    {
        $response = $this->get(route('about'));
        $response->assertStatus(200);

        $content = $response->getContent();
        $this->assertStringNotContainsString('Yayasan Proklamator Bung Hatta', $content);
        $this->assertStringContainsString('Hatta Aksara Project', $content);
    }

    public function test_all_five_youtube_videos_are_present_in_homepage(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);

        $videoIds = ['4_arGLyBZqQ', 'KfYjfXxEnmk', 'FL4FSSxFjCg', '4bcwLaUQONI', 'xorTCWOmiZE'];
        foreach ($videoIds as $id) {
            $response->assertSee($id);
        }

        $response->assertSee('@hattaaksaraproject');
        $response->assertSee('https://www.youtube.com/@hattaaksaraproject');
    }

    public function test_subpage_headers_have_proper_contrast_styling(): void
    {
        $pages = [
            route('berita.index'),
            route('artikel.index'),
            route('about'),
            route('program.index'),
            route('program.islt'),
            route('program.media-edukasi'),
            route('ejurnal.index'),
        ];

        foreach ($pages as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
            $response->assertSee('Hatta Aksara Project');
            $response->assertDontSee('Yayasan Proklamator Bung Hatta');
        }
    }
}
