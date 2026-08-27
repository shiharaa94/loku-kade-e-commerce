<?php

namespace App\Models;

use App\Support\PublicImagePathResolver;
use Illuminate\Database\Eloquent\Model;

class CatalogFeedback extends Model
{
    protected $table = 'catalog_feedbacks';

    protected $fillable = [
        'customer_name',
        'customer_city',
        'rating',
        'feedback_text',
        'image_path',
        'is_active',
        'display_order',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? PublicImagePathResolver::resolveAssetUrl($this->image_path) : null;
    }
}
