<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty' => 'required|integer|min:1'
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $this->cartService->addToCart($menu, $request->qty, $request->notes);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => array_sum(array_column($this->cartService->getCart(), 'qty')),
                'cart_total' => $this->cartService->getTotal(),
                'items' => $this->cartService->getCart(),
                'message' => 'Menu ditambahkan.'
            ]);
        }

        return back()->with('cart_added', $menu->name);
    }

    public function update(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|uuid',
            'qty' => 'required|integer|min:0'
        ]);

        $this->cartService->updateQty($request->menu_id, $request->qty);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => array_sum(array_column($this->cartService->getCart(), 'qty')),
                'cart_total' => $this->cartService->getTotal(),
                'items' => $this->cartService->getCart()
            ]);
        }

        return back();
    }

    public function clear()
    {
        $this->cartService->clearCart();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return back();
    }
}
