<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'icon_image',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Get sanitized Bootstrap icon class string (e.g. 'bi bi-briefcase-fill')
     */
    public function getIconClassAttribute(): string
    {
        $icon = trim($this->icon_image ?? '');
        if (empty($icon)) {
            return 'bi bi-tag';
        }

        // If raw HTML was entered, extract the class attribute
        if (preg_match('/class=["\']([^"\']+)["\']/', $icon, $matches)) {
            $icon = $matches[1];
        }

        // Remove redundant 'bi' prefix if present
        $icon = preg_replace('/^bi\s+/', '', $icon);

        // Ensure it starts with 'bi-'
        if (!str_starts_with($icon, 'bi-')) {
            $icon = 'bi-' . $icon;
        }

        return 'bi ' . $icon;
    }
}
