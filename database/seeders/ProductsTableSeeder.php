<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    private $productData = [
        'electronics' => [
            ['name' => 'Quantum Pro 4K Smart TV', 'price' => 1299.99, 'description' => '65-inch 4K UHD Smart TV with Quantum Dot technology'],
            ['name' => 'Nexus 5G Smartphone', 'price' => 899.99, 'description' => 'Flagship smartphone with 108MP camera'],
            ['name' => 'Blaze Wireless Earbuds', 'price' => 149.99, 'description' => 'True wireless earbuds with active noise cancellation'],
            ['name' => 'Thunder Laptop Pro', 'price' => 1599.99, 'description' => '16-inch laptop with 10-core processor'],
            ['name' => 'Smart Home Hub', 'price' => 199.99, 'description' => 'Central control for all smart home devices'],
            ['name' => '4K Action Camera', 'price' => 349.99, 'description' => 'Waterproof camera with 4K60 video recording'],
            ['name' => 'Ultra HD Blu-ray Player', 'price' => 249.99, 'description' => 'High-end player with Dolby Vision support'],
            ['name' => 'Gaming Monitor 240Hz', 'price' => 599.99, 'description' => '27-inch monitor with 1ms response time'],
            ['name' => 'Mechanical Keyboard Pro', 'price' => 129.99, 'description' => 'RGB keyboard with Cherry MX switches'],
            ['name' => 'Noise Cancelling Headphones', 'price' => 379.99, 'description' => 'Over-ear headphones with 30-hour battery']
        ],
        'clothing' => [
            ['name' => 'Premium Cashmere Sweater', 'price' => 149.99, 'description' => '100% pure cashmere sweater'],
            ['name' => 'Slim Fit Dress Shirt', 'price' => 59.99, 'description' => 'Non-iron cotton dress shirt'],
            ['name' => 'Performance Running Shoes', 'price' => 129.99, 'description' => 'Lightweight shoes with responsive cushioning'],
            ['name' => 'Wool Blend Overcoat', 'price' => 299.99, 'description' => 'Classic overcoat with modern tailoring'],
            ['name' => 'Yoga Leggings', 'price' => 49.99, 'description' => 'High-waisted leggings with moisture-wicking fabric'],
            ['name' => 'Denim Jacket', 'price' => 89.99, 'description' => 'Vintage wash denim jacket'],
            ['name' => 'Silk Tie Collection', 'price' => 39.99, 'description' => 'Set of three premium silk ties'],
            ['name' => 'Athletic Shorts', 'price' => 34.99, 'description' => 'Breathable shorts with built-in liner'],
            ['name' => 'Leather Dress Belt', 'price' => 59.99, 'description' => 'Full-grain leather belt'],
            ['name' => 'Winter Parka', 'price' => 249.99, 'description' => 'Waterproof parka with faux fur trim']
        ],
        'home-garden' => [
            ['name' => 'Smart Air Purifier', 'price' => 299.99, 'description' => 'HEPA air purifier with smart sensors'],
            ['name' => 'Memory Foam Mattress', 'price' => 899.99, 'description' => '12-inch gel-infused memory foam'],
            ['name' => 'Ceramic Cookware Set', 'price' => 199.99, 'description' => '10-piece non-toxic ceramic set'],
            ['name' => 'Robot Vacuum', 'price' => 349.99, 'description' => 'Self-charging vacuum with app control'],
            ['name' => 'Outdoor Patio Set', 'price' => 599.99, 'description' => '5-piece rattan furniture set'],
            ['name' => 'Smart LED Bulbs', 'price' => 49.99, 'description' => 'Color-changing bulbs with voice control'],
            ['name' => 'French Press Coffee Maker', 'price' => 29.99, 'description' => 'Stainless steel 34oz press'],
            ['name' => 'Organic Cotton Sheets', 'price' => 89.99, 'description' => '400 thread count queen size'],
            ['name' => 'Indoor Herb Garden Kit', 'price' => 39.99, 'description' => 'Hydroponic system with LED grow lights'],
            ['name' => 'Wall Art Canvas Set', 'price' => 129.99, 'description' => '3-piece modern abstract prints']
        ],
        'books' => [
            ['name' => 'The Silent Echo Hardcover', 'price' => 24.99, 'description' => 'Bestselling mystery novel'],
            ['name' => 'Space Exploration Guide', 'price' => 39.99, 'description' => 'Complete visual encyclopedia'],
            ['name' => 'Python Programming Bible', 'price' => 49.99, 'description' => 'Comprehensive coding guide'],
            ['name' => 'World History Atlas', 'price' => 59.99, 'description' => 'Historical maps and timelines'],
            ['name' => 'Healthy Cooking Cookbook', 'price' => 29.99, 'description' => '500+ nutritious recipes'],
            ['name' => 'Business Strategy Mastery', 'price' => 19.99, 'description' => 'Wall Street Journal bestseller'],
            ['name' => 'Children\'s Science Encyclopedia', 'price' => 34.99, 'description' => 'Illustrated STEM resource'],
            ['name' => 'Mindfulness Meditation Guide', 'price' => 14.99, 'description' => 'Stress reduction techniques'],
            ['name' => 'Photography Composition Manual', 'price' => 44.99, 'description' => 'Professional techniques'],
            ['name' => 'Classic Literature Collection', 'price' => 29.99, 'description' => '10 timeless novels in one']
        ],
        'sports-outdoors' => [
            ['name' => 'Pro Carbon Fiber Bike', 'price' => 2499.99, 'description' => 'Ultralight road bike'],
            ['name' => 'Fitness Tracker Watch', 'price' => 199.99, 'description' => 'Heart rate and GPS tracking'],
            ['name' => 'Camping Tent 4-Person', 'price' => 249.99, 'description' => 'Weatherproof dome tent'],
            ['name' => 'Yoga Mat Premium', 'price' => 59.99, 'description' => 'Eco-friendly non-slip mat'],
            ['name' => 'Running Hydration Vest', 'price' => 89.99, 'description' => '2L capacity with pockets'],
            ['name' => 'Golf Club Set', 'price' => 599.99, 'description' => 'Complete 14-piece set'],
            ['name' => 'Hiking Backpack 65L', 'price' => 129.99, 'description' => 'Water-resistant with frame'],
            ['name' => 'Adjustable Dumbbells', 'price' => 299.99, 'description' => '5-50lbs quick-select'],
            ['name' => 'Inflatable Stand-Up Paddleboard', 'price' => 499.99, 'description' => 'Includes paddle and pump'],
            ['name' => 'Trail Running Shoes', 'price' => 139.99, 'description' => 'Vibram outsole for grip']
        ]
    ];

    private $productImages = [
        'electronics' => [
            'https://images.unsplash.com/photo-1550009158-9ebf69173e03',
            'https://images.unsplash.com/photo-1546868871-7041f2a55e12',
            'https://images.unsplash.com/photo-1593642632823-8f785ba67e45'
        ],
        'clothing' => [
            'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f',
            'https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9',
            'https://images.unsplash.com/photo-1542272604-787c3835535d'
        ],
        'home-garden' => [
            'https://images.unsplash.com/photo-1556911220-bff31c812dba',
            'https://images.unsplash.com/photo-1583845112203-29329902330b',
            'https://images.unsplash.com/photo-1513694203232-719a280e022f'
        ],
        'books' => [
            'https://images.unsplash.com/photo-1544947950-fa07a98d237f',
            'https://images.unsplash.com/photo-1541963463532-d68292c34b19',
            'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c'
        ],
        'sports-outdoors' => [
            'https://images.unsplash.com/photo-1574629810360-7efbbe195018',
            'https://images.unsplash.com/photo-1531545514256-b1400bc00f31',
            'https://images.unsplash.com/photo-1517649763962-0c623066013b'
        ]
    ];

    public function run()
    {
        $categories = Category::all()->keyBy('slug');

        foreach ($this->productData as $slug => $products) {
            if (!isset($categories[$slug])) continue;
            
            foreach ($products as $index => $product) {
                Product::create([
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => rand(10, 100),
                    'category_id' => $categories[$slug]->id,
                    'image' => $this->downloadAndStoreImage(
                        $this->getRandomImageForCategory($slug),
                        $slug,
                        $index + 1
                    ),
                    'is_special_offer' => rand(0, 1) === 1,
                    'offer_expires_at' => rand(0, 1) === 1 ? now()->addDays(rand(7, 60)) : null
                ]);
            }
        }
    }

    private function getRandomImageForCategory(string $slug): string
    {
        return $this->productImages[$slug][array_rand($this->productImages[$slug])];
    }

    private function downloadAndStoreImage(string $url, string $slug, int $index): string
    {
        try {
            $contents = file_get_contents($url);
            $name = "products/{$slug}-{$index}.jpg";
            Storage::disk('public')->put($name, $contents);
            return $name;
        } catch (\Exception $e) {
            return 'products/placeholder.jpg';
        }
    }
}