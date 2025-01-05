@extends('base.master')
@section('title', 'Clientes')

@section('content')

    @if(session('success'))
        <div class="alert alert-success col-12 mt-2">
            <p class="text-center">
                {{session('success')}}
            </p>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger col-12 mt-2">
            <p class="text-center">
                {{session('error')}}
            </p>
        </div>
    @endif

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4">Agregar Cliente</h2>
            <form method="post" action={{route('client-store')}}>
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Introduce tu nombre" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Introduce tu apellido" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Introduce tu correo" required>
                </div>
                <div class="mb-3">
                    <label for="telephone" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Introduce tu teléfono" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Enviar</button>
            </form>
        </div>
    </div>
@stop
