<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function show(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('order.success', $order->id);
        }
        return view('customer.payment.show', compact('order'));
    }

    public function confirm(Order $order)
    {
        try {
            $this->paymentService->confirmDummy($order);
            return redirect()->route('order.success', $order->id)->with('success', 'Pembayaran berhasil dikonfirmasi!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
