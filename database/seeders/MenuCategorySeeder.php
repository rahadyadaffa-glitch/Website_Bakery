<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuCategory;

class MenuCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Kue', 'order' => 1],
            ['name' => 'Minuman', 'order' => 2],
            ['name' => 'Dessert', 'order' => 3],
            ['name' => 'Paket', 'order' => 4],
        ];

        foreach ($categories as $category) {
            MenuCategory::create($category);
        }
    }
}
