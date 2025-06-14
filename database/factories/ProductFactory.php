<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => function () {
                // Copy the placeholder image with a unique filename
                $filename = 'product-' . Str::random(10) . '.jpg';
                Storage::disk('public')->copy(
                    'products/placeholder.jpg',
                    'products/' . $filename
                );
                return 'products/' . $filename;
            },
            'is_special_offer' => $this->faker->boolean(20), // 20% chance of being special offer
            'offer_expires_at' => $this->faker->optional(0.3)->dateTimeBetween('now', '+1 month'),
        ];
    }
}
