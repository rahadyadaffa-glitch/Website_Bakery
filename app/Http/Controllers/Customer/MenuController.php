<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\Menu;
use App\Services\CartService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(CartService $cartService, MenuCategory $category = null)
    {
        $categories = MenuCategory::where('is_active', true)->orderBy('order')->get();
        
        // If no category selected, redirect to the first one available
        if (!$category || !$category->exists) {
            $firstCategory = $categories->first();
            if ($firstCategory) {
                return redirect()->route('menu.index', $firstCategory->id);
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
