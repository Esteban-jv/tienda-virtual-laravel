@extends('layouts.app')

@section('content')
    <h1>Products ;)</h1>

    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Crear nuevo</a>

    @empty($products)
        <div class="alert alert-warning">
            <h3>This product list is empty</h3>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->status }}</td>
                        <td>
                            <a href="{{
                                    route('products.show',['product' => $product->id])
                                }}" class="btn btn-link">Show</a>
                            <a href="{{
                                    route('products.edit',['product' => $product->id])
                                }}" class="btn btn-link">Editar</a>
                            <form method="POST" class="d-inline" action="{{ route('products.destroy',['product' => $product->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endempty
@endsection
