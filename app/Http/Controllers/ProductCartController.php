<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class ProductCartController extends Controller
{

    public $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $cart = $this->cartService->getFromCookieOrCreate();


        $quantity = $cart->products()
            ->find($product->id)
            ->pivot
            ->quantity ?? 0;

        if($product->stock < $quantity + 1)
        {
            throw ValidationException::withMessages([
                'quantity' => "No hay suficiente stock para {$product->title}"
            ]);
        }

        //attach tiene un array y guarda todo alv
        //sync "sincroniza" el carrito pero elimina el anterio??
        $cart->products()->syncWithoutDetaching([
            $product->id => ['quantity' => $quantity + 1]
        ]);

        $cart->touch();

        $cookie = $this->cartService->makeCookie($cart);

        return redirect()->back()->cookie($cookie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Cart $cart)
    {
        $cart->products()->detach($product);

        $cart->touch();

        //postergar la vida de la cookie
        $cookie = $this->cartService->makeCookie($cart);

        return redirect()->back()->cookie($cookie);
    }
}
