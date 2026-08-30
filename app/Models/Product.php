<?php

namespace App\Models;

use App\Support\PublicImagePathResolver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'short_description',
        'main_image',
        'is_catalog_visible',
        'youtube_video_url',
        'category_id',
    ];

    protected $appends = [
        'main_image_url',
    ];

    public function subImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    public function getMainImageUrlAttribute(): ?string
    {
        return PublicImagePathResolver::resolveAssetUrl($this->main_image);
    }
}
