<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuCategory;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $kue = MenuCategory::where('name', 'Kue')->first();
        $minuman = MenuCategory::where('name', 'Minuman')->first();
        $dessert = MenuCategory::where('name', 'Dessert')->first();
        $paket = MenuCategory::where('name', 'Paket')->first();

        $menus = [
            [
                'category_id' => $kue->id,
                'name' => 'Red Velvet Cake',
                'description' => 'Kue red velvet lembut dengan cream cheese lezat.',
                'price' => 35000,
                'badge' => 'best_seller',
                'is_featured' => true,
            ],
            [
                'category_id' => $kue->id,
                'name' => 'Choco Lava',
                'description' => 'Kue cokelat lumer dengan tekstur lembut.',
                'price' => 30000,
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Matcha Latte',
                'description' => 'Campuran matcha premium dan susu segar.',
                'price' => 25000,
                'badge' => 'new',
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Iced Americano',
                'description' => 'Kopi hitam segar menyegarkan hari.',
                'price' => 20000,
            ],
            [
                'category_id' => $dessert->id,
                'name' => 'Mango Bingsu',
                'description' => 'Es serut Korea dengan potongan mangga manis.',
                'price' => 45000,
                'is_featured' => true,
            ],
            [
                'category_id' => $paket->id,
                'name' => 'Paket Ngemil Sore',
                'description' => '1 Red Velvet Cake + 1 Matcha Latte',
                'price' => 50000,
                'badge' => 'best_seller',
            ]
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
