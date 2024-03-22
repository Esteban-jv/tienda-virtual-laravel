@extends('layouts.app')
@section('content')
    <div class="bg-dots-darker">
        <h1>Welcome</h1>
        @empty($products)
            <div class="alert alert-danger">
                No hay productos aún
            </div>
        @else
            <div class="row">
{{--                @dump($products)--}}
                @foreach($products as $product)
                    <div class="col-3">
                        @include('components.product-card')
                    </div>
                @endforeach
            </div>
        @endempty
    </div>
@endsection
