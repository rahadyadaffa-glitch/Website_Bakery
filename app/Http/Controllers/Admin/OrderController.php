<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil list item yang baru masuk (hanya status 'pending')
        // Sesuai permintaan: Jika sudah klik diterima (processing), notifnya hilang dari sini
        $incomingItems = \App\Models\OrderItem::with('order')
            ->where('status', 'pending')
            ->whereHas('order', function($q) {
                $q->where('status', '!=', 'completed');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Ambil status seluruh meja (12 meja)
        $tables = \App\Models\Table::orderBy('id', 'asc')->get();
        
        // 3. Ambil statistik item per meja yang aktif (belum selesai)
        $tableStats = [];
        foreach ($tables as $table) {
            $tableStats[$table->number] = \App\Models\OrderItem::whereHas('order', function($q) use ($table) {
                    $q->where('table_number', $table->number)
                      ->where('status', '!=', 'completed');
                })
                ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_count, SUM(CASE WHEN status = "delivered" THEN 1 ELSE 0 END) as delivered_count')
                ->first();
        }

        if ($request->ajax()) {
            return response()->json([
                'incoming_list' => view('admin.orders.partials.incoming_list', compact('incomingItems'))->render(),
                'table_grid' => view('admin.orders.partials.table_grid', compact('tables', 'tableStats'))->render(),
                'pending_count' => $incomingItems->count(),
            ]);
        }

        return view('admin.orders.index', compact('incomingItems', 'tableStats', 'tables'));
    }

    public function printTableReceipt($tableNumber)
    {
        $items = \App\Models\OrderItem::with(['order', 'menu'])
            ->whereHas('order', function($q) use ($tableNumber) {
                $q->where('table_number', $tableNumber)
                  ->where('status', '!=', 'completed');
            })
            ->where('status', 'processing')
            ->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Tidak ada pesanan yang siap cetak (status harus diterima dulu).');
        }

        return view('admin.orders.receipt', compact('items', 'tableNumber'));
    }

    // Detail per Meja
    public function showTable($tableNumber)
    {
        $table = \App\Models\Table::where('number', $tableNumber)->firstOrFail();
        
        $items = \App\Models\OrderItem::with('order')
            ->whereHas('order', function($q) use ($tableNumber) {
                $q->where('table_number', $tableNumber)
                  ->where('status', '!=', 'completed');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.orders.table_show', compact('table', 'items'));
    }

    // Update status per item (Step-by-step: pending -> processing -> delivered)
    public function updateItemStatus(\App\Models\OrderItem $item)
    {
        if ($item->status === 'pending') {
            $item->update(['status' => 'processing']);
            return back()->with('success', "Pesanan {$item->menu_name} diterima.");
        } elseif ($item->status === 'processing') {
            $item->update(['status' => 'delivered']);
            return back()->with('success', "Pesanan {$item->menu_name} telah diantar.");
        }
        return back();
    }

    // Selesaikan seluruh pesanan di satu meja
    public function completeTable($tableNumber)
    {
        // Cek apakah ada item yang belum diantar (status selain 'delivered')
        $undeliveredItemsCount = \App\Models\OrderItem::whereHas('order', function($q) use ($tableNumber) {
                $q->where('table_number', $tableNumber)
                  ->where('status', '!=', 'completed');
            })
            ->where('status', '!=', 'delivered')
            ->count();

        if ($undeliveredItemsCount > 0) {
            return back()->with('error', "Meja {$tableNumber} belum bisa diselesaikan karena masih ada {$undeliveredItemsCount} item yang belum diantar.");
        }

        // Update semua order di meja tersebut menjadi completed
        \App\Models\Order::where('table_number', $tableNumber)
            ->where('status', '!=', 'completed')
            ->update(['status' => 'completed']);
        
        // Kosongkan meja
        \App\Models\Table::where('number', $tableNumber)->update(['status' => 'available']);

        return redirect()->route('admin.orders.index')->with('success', "Meja {$tableNumber} telah dikosongkan.");
    }

    public function process(Order $order)
    {
        // Tetap ada untuk backward compatibility atau jika ingin per order
        if ($order->status === 'new') {
            $order->update(['status' => 'processing']);
        }
        return back()->with('success', 'Pesanan sedang diproses.');
    }

    public function complete(Order $order)
    {
        // Sekarang memicu selesainya meja
        return $this->completeTable($order->table_number);
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
