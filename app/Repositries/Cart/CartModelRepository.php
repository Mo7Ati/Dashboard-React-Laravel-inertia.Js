<?php

namespace App\Repositries\Cart;

use App\Models\Cart;
use App\Models\Product;
use Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    public function get()
    {
        $items = Cart::with('Product')->paginate();
        return $items;
    }

    public function add(Product $product, $quantity)
    {

        $cart = Cart::where('product_id', $product->id)->first();
        if (!$cart) {
            return $cart = Cart::withoutGlobalScope('cookie_id')
                ->create([
                    'cookie_id' => Cart::getCookieId(),
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'quantity' => $quantity,
                ]);
        }

        return $cart->increment('quantity', $quantity);

    }

    public function update(Product $product, $quantity)
    {

        $cart = Cart::where('product_id', $product->id)->first();
        $cart->update([
            'quantity' => $quantity,
        ]);

    }

    public function delete(Product $product)
    {
        return Cart::where('product_id', $product->id)->delete();

    }

    public function empty()
    {
        $cart = Cart::query()->delete();
    }

    public function total()
    {
        $total = 0;
        foreach ($this->get() as $item) {
            $total += ( $item->quantity * $item->product->price);
        }
        return $total;
    }

}
