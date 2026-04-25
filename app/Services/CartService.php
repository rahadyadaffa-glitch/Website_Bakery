<?php

namespace App\Services;

class CartService
{
    protected $sessionKey = 'cart';

    public function getCart()
    {
        return session()->get($this->sessionKey, []);
    }

    public function addToCart($menu, $qty = 1, $notes = null)
    {
        $cart = $this->getCart();
        $id = $menu->id;

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
            if ($notes) {
                $cart[$id]['notes'] = $notes;
            }
        } else {
            $cart[$id] = [
                'menu_id' => $id,
                'name' => $menu->name,
                'price' => $menu->price,
                'qty' => $qty,
                'notes' => $notes,
            ];
        }

        session()->put($this->sessionKey, $cart);
    }

    public function updateQty($menuId, $qty)
    {
        $cart = $this->getCart();
        if (isset($cart[$menuId])) {
            if ($qty <= 0) {
                unset($cart[$menuId]);
            } else {
                $cart[$menuId]['qty'] = $qty;
            }
            session()->put($this->sessionKey, $cart);
        }
    }

    public function clearCart()
    {
        session()->forget($this->sessionKey);
    }

    public function getTotal()
    {
        $cart = $this->getCart();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }
}
