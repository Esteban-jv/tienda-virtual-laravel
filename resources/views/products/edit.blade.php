@extends('layouts.app')

@section('content')
    <h1>Editar producto {{ $product->title }}</h1>

    <form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-row">
            <label for="title">Título</label>
            <input type="text" class="form-control" name="title" value="{{ old('title') ?? $product->title }}" required>
        </div>
        <div class="form-row">
            <label for="title">Descripción</label>
            <input type="text" class="form-control" name="description" value="{{ old('description') ?? $product->description }}" required>
        </div>
        <div class="form-row">
            <label for="title">Precio</label>
            <input type="number" min="1.00" step="0.01" class="form-control" name="price" value="{{ old('price') ?? $product->price }}" required>
        </div>
        <div class="form-row">
            <label for="title">Stock</label>
            <input type="number" min="0" class="form-control" name="stock" value="{{ old('stock') ?? $product->stock }}" required>
        </div>
        <div class="form-row">
            <label for="title">Estado</label>
            <select name="status" id="" class="form-select" required>
                <option value="available" {{ old('status') == 'available' ? 'selected' : ($product->status == 'available' ? 'selected' : '') }}>Disponible</option>
                <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : ($product->status == 'unavailable' ? 'selected' : '') }}>No disponible</option>
            </select>
        </div>
        <div class="form-row mb-3">
            <label for="password-confirm" class="">{{ __('Images') }}</label>
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile01" name="images[]" accept="image/*" multiple>
                <label class="input-group-text" for="inputGroupFile01">Upload</label>
            </div>
        </div>
        <div class="form-row mt-3">
            <button class="btn btn-primary btn-large">Edit producto</button>
        </div>
    </form>
@endsection
