<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // First create the placeholder image if it doesn't exist
        if (!Storage::disk('public')->exists('products/placeholder.jpg')) {
            Storage::disk('public')->put(
                'products/placeholder.jpg', 
                file_get_contents(public_path('images/default-product.jpg'))
            );
        }
        
        $this->call([
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
        ]);

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin', 
            'password' => 'password1234', 
        ]);
    }
}
