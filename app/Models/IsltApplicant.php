<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsltApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_code',
        'full_name',
        'nisn',
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
        'photo_path',
        'recommendation_letter_path',
        'selection_status',
        'synced_to_sheets_at',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'synced_to_sheets_at' => 'datetime',
        ];
    }

    public static function generateRegistrationCode(): string
    {
        $year = date('Y');
        $random = strtoupper(substr(uniqid(), -5));
        $count = self::whereYear('created_at', $year)->count() + 1;

        return sprintf('ISLT-%s-%04d-%s', $year, $count, $random);
    }
}
