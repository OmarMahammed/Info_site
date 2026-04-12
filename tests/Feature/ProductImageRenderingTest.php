<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageRenderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_product_storage_image(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/keyboard.jpg', 'fake-image');

        Product::create([
            'name' => 'Keyboards',
            'slug' => 'keyboards',
            'description' => 'لوحات مفاتيح احترافية للأعمال والمكاتب',
            'image' => 'products/keyboard.jpg',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('/storage/products/keyboard.jpg', escape: false);
    }

    public function test_filament_products_page_renders_product_storage_image(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/keyboard.jpg', 'fake-image');

        $user = User::factory()->create();

        Product::create([
            'name' => 'Keyboards',
            'slug' => 'keyboards',
            'description' => 'لوحات مفاتيح احترافية للأعمال والمكاتب',
            'image' => 'products/keyboard.jpg',
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/admin/products');

        $response->assertOk();
        $response->assertSee('/storage/products/keyboard.jpg', escape: false);
    }
}
