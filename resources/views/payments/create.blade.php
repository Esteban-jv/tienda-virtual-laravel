@extends('layouts.app')

@section('content')
    <h1>Detalles del pago</h1>
    <h4 class="text-center">
        <strong>
            Total: ${{ $order->total }}
        </strong>
    </h4>

    <div class="text-center mb-3">
        <form
            action="{{ route('orders.payments.store', ['order' => $order->id]) }}"
            method="POST"
            class="d-inline">
            @csrf
            <button class="btn btn-success" type="submit">Pagar</button>
        </form>
    </div>
@endsection
