<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumniProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'islt_batch',
        'province',
        'city',
        'school_origin',
        'current_institution',
        'phone_number',
        'is_phone_public',
        'bio',
        'avatar_path',
        'proof_document_path',
        'linkedin_url',
        'instagram_url',
    ];

    protected function casts(): array
    {
        return [
            'is_phone_public' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
