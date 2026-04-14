<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Public URL for the product image.
     * DB should store paths like `products/filename.jpg` (public disk).
     * Legacy rows may store only a filename or `images/products/...`; those fall back to public/images/products/.
     */
    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return asset('images/placeholder.png');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        $path = str_replace('\\', '/', $this->image);
        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (str_starts_with($path, 'products/')) {
            return asset('storage/'.$path);
        }

        return asset('images/products/'.basename($path));
    }
}
