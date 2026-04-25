<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Payment;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $menus = Menu::all();
        
        if ($menus->isEmpty()) return;

        // Buat 5 Pesanan Dummy untuk Hari Ini
        for ($i = 0; $i < 5; $i++) {
            $order = Order::create([
                'order_number' => 'SB-' . date('Ymd') . '-' . Str::upper(Str::random(4)),
                'table_number' => rand(1, 20),
                'customer_name' => 'Customer ' . ($i + 1),
                'status' => $i < 3 ? 'completed' : 'processing',
                'subtotal' => 0,
                'total' => 0,
                'created_at' => now()->subHours(rand(1, 5)),
            ]);

            $total = 0;
            // Tambahkan 1-3 item per pesanan
            $selectedMenus = $menus->random(rand(1, 3));
            foreach ($selectedMenus as $menu) {
                $qty = rand(1, 2);
                $sub = $menu->price * $qty;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'price' => $menu->price,
                    'quantity' => $qty,
                    'subtotal' => $sub,
                ]);
                $total += $sub;
            }

            $order->update([
                'subtotal' => $total,
                'total' => $total
            ]);

            // Buat Payment jika status completed atau processing
            Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'method' => 'dummy',
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }
    }
}
