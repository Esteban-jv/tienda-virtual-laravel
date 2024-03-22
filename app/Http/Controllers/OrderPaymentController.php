<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderPaymentController extends Controller
{
    public $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Order $order)
    {
        return view('payments.create')->with([
            'order' => $order
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Order $order)
    {
        return DB::transaction(function () use($request, $order) {
            //Procesar un servicio o pasarela de pago

            $this->cartService->getFromCookie()->products()->detach();

            $order->payment()->create([
                'amount' => $order->total,
                'payed_at' => now(),
            ]);

            $order->status = 'payed';
            $order->save();

            return redirect()
                ->route('main')
                ->withSuccess("Gracias, hemos recibido tu pago por \${$order->total}");
        });
    }
}
