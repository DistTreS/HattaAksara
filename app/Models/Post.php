<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'post_type',
        'category_id',
        'sub_category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'action_location',
        'action_date',
        'status',
        'admin_notes',
        'published_at',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'action_date' => 'date',
            'published_at' => 'datetime',
            'views_count' => 'integer',
        ];
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (! $this->featured_image) {
            return null;
        }

        if (Str::startsWith($this->featured_image, ['http://', 'https://'])) {
            return $this->featured_image;
        }

        if (file_exists(public_path($this->featured_image))) {
            return asset($this->featured_image);
        }

        return asset('storage/'.$this->featured_image);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    // Scopes
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeNews(Builder $query): Builder
    {
        return $query->where('post_type', 'news');
    }

    public function scopeAksiHattaMuda(Builder $query): Builder
    {
        return $query->where('post_type', 'aksi_hatta_muda');
    }

    public function scopeKegiatan(Builder $query): Builder
    {
        return $query->where('post_type', 'kegiatan');
    }

    public function scopeArtikel(Builder $query): Builder
    {
        return $query->where('post_type', 'artikel');
    }

    public function scopePendingReview(Builder $query): Builder
    {
        return $query->where('status', 'pending_review');
    }

    public function getTypeLabel(): string
    {
        return match($this->post_type) {
            'news' => 'Warta Resmi',
            'kegiatan' => 'Kegiatan',
            'aksi_hatta_muda' => 'Aksi Hatta Muda',
            'artikel' => 'Artikel Gagasan',
            default => ucfirst(str_replace('_', ' ', $this->post_type ?? 'Berita')),
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->getTypeLabel();
    }

}
