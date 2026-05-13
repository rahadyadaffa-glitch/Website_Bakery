<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\Menu;
use App\Services\CartService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request, CartService $cartService, MenuCategory $category = null)
    {
        // Handle QR Code Table Parameter
        if ($request->has('table')) {
            $tableNumber = $request->table;
            session()->put('table_number', $tableNumber);

            // Jika meja berstatus 'available', berarti ini sesi baru (pelanggan baru)
            // Maka kita reset nama pelanggan di session
            $table = \App\Models\Table::where('number', $tableNumber)->first();
            if ($table && $table->status === 'available') {
                session()->forget('customer_name');
            }
        } elseif (session()->has('table_number')) {
            // Jika di URL tidak ada table tapi di session ada, redirect agar URL tetap konsisten
            return redirect()->route('menu.index', array_merge(
                ['category' => $category ? $category->id : null],
                $request->query(),
                ['table' => session('table_number')]
            ));
        }

        $categories = MenuCategory::where('is_active', true)->orderBy('order')->get();
        
        // If no category selected, redirect to the first one available
        if (!$category || !$category->exists) {
            $firstCategory = $categories->first();
            if ($firstCategory) {
                return redirect()->route('menu.index', array_merge(['category' => $firstCategory->id], $request->query()));
            }
        }

        $query = Menu::with('category')->available();
        if ($category && $category->exists) {
            $query->where('category_id', $category->id);
        }
        $menus = $query->get();

        // Fetch best sellers for the featured section (only on "All" or "Main" page)
        $bestSellers = Menu::with('category')->available()->where('badge', 'best_seller')->take(3)->get();

        $cart = $cartService->getCart();
        $cartTotal = $cartService->getTotal();

        return view('customer.menu.index', compact('categories', 'menus', 'cart', 'cartTotal', 'category', 'bestSellers'));
    }
}
