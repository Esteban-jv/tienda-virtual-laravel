@extends('layouts.app')

@section('content')
    <h1>Usuarios</h1>

    @empty($users)
        <div class="alert alert-warning">
            <h3>La lista de usuarios está vacía</h3>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Admin desde</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ optional($user->admin_since)->diffForHumans() ?? 'N/A' }}</td>
                        <td>
                            <form method="POST" class="d-inline" action="{{ route('users.admin_toggle',['user' => $user->id]) }}">
                                @csrf
                                <button class="btn btn-link">
                                    {{ $user->isAdmin() ? 'Quitar' : 'Agregar' }} administrador
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
