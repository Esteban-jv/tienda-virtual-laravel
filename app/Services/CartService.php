<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;

// Esta clase demuestra la lección 69 (Inyección de dependencias y mostrando los productos de un carrito)
class CartService
{
    protected $cookieName;
    protected $cookieExpiration;

    public function __construct()
    {
        $this->cookieName = config('cart.cookie.name');
        $this->cookieExpiration = config('cart.cookie.expiration');
    }

    public function getFromCookie()
    {
        $cardId = Cookie::get($this->cookieName);

        $cart = Cart::find($cardId);

        return $cart;
    }

    public function getFromCookieOrCreate()
    {
        return $this->getFromCookie() ?? Cart::create();
    }

    public function makeCookie(Cart $cart)
    {
        return Cookie::make($this->cookieName,$cart->id, $this->cookieExpiration);
    }

    public function countProducts()
    {
        $cart = $this->getFromCookie();

        if(!is_null($cart))
        {
            return $cart->products->pluck('pivot.quantity')->sum();
        }

        return 0;
    }
}
