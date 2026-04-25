<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Stats Today
        $ordersCount = Order::whereDate('created_at', $today)->count();
        $revenue = Order::whereDate('created_at', $today)
            ->whereIn('status', ['new', 'processing', 'completed'])
            ->sum('total');
            
        // Top Menu (All Time)
        $topMenu = OrderItem::select('menu_name', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('menu_name')
            ->orderBy('total_qty', 'desc')
            ->first();
            
        // Active Tables
        $activeTablesCount = Order::whereIn('status', ['new', 'processing'])
            ->distinct('table_number')
            ->count();
        
        return view('admin.dashboard.index', compact(
            'ordersCount', 
            'revenue', 
            'topMenu', 
            'activeTablesCount'
        ));
    }
}
