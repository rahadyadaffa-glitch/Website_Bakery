<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CheckoutRequest;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;
    protected $cartService;

    public function __construct(OrderService $orderService, CartService $cartService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }
    
    public function checkout()
    {
        $cart = $this->cartService->getCart();
        if(empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang kosong');
        }
        $total = $this->cartService->getTotal();
        return view('customer.order.checkout', compact('cart', 'total'));
    }

    public function store(CheckoutRequest $request)
    {
        try {
            $order = $this->orderService->createOrder($request->validated());
            session()->put('last_order_id', $order->id);
            return redirect()->route('payment.show', $order->id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        if ($order->status === 'pending') {
            return redirect()->route('payment.show', $order->id);
        }
        return view('customer.order.success', compact('order'));
    }
}
