<?php

namespace Tests\Unit;

use App\Models\IsltApplicant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IsltApplicantModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_registration_code_has_correct_format(): void
    {
        $code = IsltApplicant::generateRegistrationCode();

        $this->assertStringStartsWith('ISLT-', $code);
        $this->assertMatchesRegularExpression('/^ISLT-\d{4}-\d{4}-[A-Z0-9]+$/', $code);
    }

    public function test_applicant_creation_and_attributes_casting(): void
    {
        $applicant = IsltApplicant::create([
            'registration_code' => IsltApplicant::generateRegistrationCode(),
            'full_name' => 'Bintang Kejora',
            'nisn' => '0098877665',
            'birth_place' => 'Bukittinggi',
            'birth_date' => '2008-08-17',
            'gender' => 'L',
            'whatsapp_number' => '081234567890',
            'email' => 'bintang.kejora@test.com',
            'province' => 'Sumatera Barat',
            'city' => 'Kota Bukittinggi',
            'school_name' => 'SMAN 1 Bukittinggi',
            'osis_position' => 'Ketua OSIS',
            'organization_experience' => 'Ketua MPK dan OSIS 2025',
            'motivation_essay' => 'Menjadi penerus Bung Hatta dalam menggerakkan ekonomi kerakyatan.',
            'selection_status' => 'submitted',
        ]);

        $this->assertNotNull($applicant->id);
        $this->assertEquals('Bintang Kejora', $applicant->full_name);
        $this->assertEquals('2008-08-17', $applicant->birth_date->format('Y-m-d'));
        $this->assertEquals('submitted', $applicant->selection_status);
    }
}
