<?php

namespace Tests\Feature;

use App\Models\IsltApplicant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IsltRegistrationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_islt_registration_requires_mandatory_fields(): void
    {
        $response = $this->post(route('program.islt.store'), []);

        $response->assertSessionHasErrors([
            'full_name',
            'birth_place',
            'birth_date',
            'gender',
            'whatsapp_number',
            'email',
            'province',
            'city',
            'school_name',
            'osis_position',
            'organization_experience',
            'motivation_essay',
        ]);
    }

    public function test_islt_valid_submission_creates_record_and_redirects(): void
    {
        $payload = [
            'full_name' => 'Siti Nurhaliza Putri',
            'nisn' => '0089988776',
            'birth_place' => 'Padang',
            'birth_date' => '2008-11-20',
            'gender' => 'P',
            'whatsapp_number' => '081298765432',
            'email' => 'siti.nurhaliza@test.com',
            'province' => 'Sumatera Barat',
            'city' => 'Kota Padang',
            'school_name' => 'SMAN 2 Padang',
            'osis_position' => 'Ketua Umum OSIS',
            'organization_experience' => 'Ketua OSIS 2025/2026',
            'motivation_essay' => 'Komitmen memperkuat koperasi siswa berlandaskan pemikiran Bung Hatta.',
        ];

        $response = $this->post(route('program.islt.store'), $payload);

        $applicant = IsltApplicant::where('email', 'siti.nurhaliza@test.com')->first();
        $this->assertNotNull($applicant);
        $this->assertStringStartsWith('ISLT-', $applicant->registration_code);

        $response->assertRedirect(route('program.islt.success', ['code' => $applicant->registration_code]));

        $this->get(route('program.islt.success', ['code' => $applicant->registration_code]))
            ->assertStatus(200)
            ->assertSee($applicant->registration_code)
            ->assertSee('Siti Nurhaliza Putri');

        $this->get(route('program.islt.success', ['code' => 'ISLT-FAKE-CODE-999']))
            ->assertStatus(404);
    }
}
