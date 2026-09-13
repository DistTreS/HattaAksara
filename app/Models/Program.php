<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'tagline',
        'description',
        'banner_image',
        'is_registration_open',
        'additional_metadata',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_registration_open' => 'boolean',
            'additional_metadata' => 'array',
            'sort_order' => 'integer',
        ];
    }
}
