<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::whereIn('status', ['new', 'processing'])
                       ->orderBy('created_at', 'asc')
                       ->get();

        if ($request->ajax()) {
            return view('admin.orders.partials.list', compact('orders'))->render();
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function process(Order $order)
    {
        if ($order->status === 'new') {
            $order->update(['status' => 'processing']);
        }
        return back()->with('success', 'Pesanan sedang diproses.');
    }

    public function complete(Order $order)
    {
        if ($order->status === 'processing') {
            $order->update(['status' => 'completed']);
        }
        return back()->with('success', 'Pesanan selesai.');
    }

    public function history(Request $request)
    {
        $query = Order::with(['items', 'payment'])
                      ->where('status', 'completed')
                      ->orderBy('updated_at', 'desc');

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('updated_at', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('table_number', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(20);
        $selectedDate = $request->date;

        return view('admin.orders.history', compact('orders', 'selectedDate'));
    }
}
