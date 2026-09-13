<?php

namespace Tests\Unit;

use App\Models\EJournal;
use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramAndEJournalModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_program_casting_and_sorting(): void
    {
        $programs = Program::orderBy('sort_order')->get();
        $this->assertGreaterThanOrEqual(2, $programs->count());

        $first = $programs->first();
        $this->assertIsBool($first->is_registration_open);
        $this->assertIsInt($first->sort_order);
        if ($first->additional_metadata) {
            $this->assertIsArray($first->additional_metadata);
        }
    }

    public function test_ejournal_casts_and_download_tracking(): void
    {
        $journal = EJournal::first();
        $this->assertNotNull($journal);

        $this->assertIsInt($journal->publication_year);
        $this->assertIsInt($journal->download_count);

        $initialDownloads = $journal->download_count;
        $journal->increment('download_count');
        $journal->refresh();

        $this->assertEquals($initialDownloads + 1, $journal->download_count);
    }
}
