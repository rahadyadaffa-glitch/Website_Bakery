<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createOrder(array $data)
    {
        $cart = $this->cartService->getCart();
        if (empty($cart)) {
            throw new \Exception("Keranjang belanja kosong.");
        }

        $subtotal = $this->cartService->getTotal();
        
        return DB::transaction(function () use ($data, $cart, $subtotal) {
            $order = new Order();
            $order->order_number = $order->generateOrderNumber();
            $order->table_number = $data['table_number'];
            $order->customer_name = $data['customer_name'] ?? null;
            $order->notes = $data['notes'] ?? null;
            $order->subtotal = $subtotal;
            $order->total = $subtotal;
            $order->status = 'pending';
            $order->save();

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['menu_id'],
                    'menu_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty'],
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            $this->cartService->clearCart();

            return $order;
        });
    }
}
