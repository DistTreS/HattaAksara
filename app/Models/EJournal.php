<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EJournal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author_or_curator',
        'publication_year',
        'category',
        'description',
        'cover_image',
        'file_path',
        'file_size_kb',
        'download_count',
    ];

    protected function casts(): array
    {
        return [
            'publication_year' => 'integer',
            'file_size_kb' => 'integer',
            'download_count' => 'integer',
        ];
    }
}
