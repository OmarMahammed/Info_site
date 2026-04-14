<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Normalize product.image to `products/filename` for the public disk.
 * Copy files from public/images/products/ into storage/app/public/products/ if needed — not handled here.
 */
return new class extends Migration
{
    public function up(): void
    {
        $rows = DB::table('products')->select('id', 'image')->get();

        foreach ($rows as $row) {
            $image = $row->image;

            if ($image === null || $image === '') {
                continue;
            }

            if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
                continue;
            }

            if (str_starts_with($image, 'products/')) {
                continue;
            }

            $path = str_replace('\\', '/', $image);
            $path = ltrim($path, '/');

            if (str_starts_with($path, 'storage/products/')) {
                $path = substr($path, strlen('storage/'));
            }

            if (str_starts_with($path, 'images/products/')) {
                $path = 'products/'.basename($path);
            } else {
                $path = 'products/'.basename($path);
            }

            DB::table('products')->where('id', $row->id)->update(['image' => $path]);
        }
    }

    public function down(): void
    {
        // Path normalization is not safely reversible.
    }
};
