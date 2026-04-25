<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function confirmDummy(Order $order)
    {
        if ($order->status !== 'pending') {
            throw new \Exception("Pesanan ini tidak valid untuk dibayar.");
        }

        return DB::transaction(function () use ($order) {
            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total,
                'method' => 'dummy',
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $order->update(['status' => 'new']);

            $this->cartService->clearCart();

            return true;
        });
    }
}
