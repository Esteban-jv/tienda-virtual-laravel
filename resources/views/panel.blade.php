@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Panel</div>

                    <div class="card-body">

                        <div class="list-group">
                            <a href="{{ route('products.index') }}" class="list-group-item">Productos</a>
                        </div>
                        <div class="list-group">
                            <a href="{{ route('users.index') }}" class="list-group-item">Usuarios</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
