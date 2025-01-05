@extends('base.master')
@section('title', 'Clientes')

@section('content')
    <h1>Clientes</h1>
    @if($clients->count() < 1)
        <div class="alert alert-danger col-12 mt-2">
                <p class="text-center">
                    No hay clientes registrados.
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

    @if(session('success'))
        <div class="alert alert-success col-12 mt-2">
            <p class="text-center">
                {{session('success')}}
            </p>
        </div>
    @endif


    <div class="container">
        <div class="row">
            <a type="button" class="btn btn-dark w-auto" href={{route('client-storePage')}}>Agregar Cliente</a>
        </div>
    </div>

    <table class="table">
        <thead>
        <!-- <th scope="col">ID</th> -->
        <th scope="col">Nombre(s)</th>
        <th scope="col">Apellido(s)</th>
        <th scope="col">E-mail</th>
        <th scope="col">Telefono</th>
        <th class="text-center" scope="col" colspan="3">Opciones</th>
        </thead>
        <tbody id="tableBody">
            @foreach($clients as $client)
                <tr>
                    <!--    <th scope="row">{{$client->id}}</th> -->
                    <td>{{$client->name}}</td>
                    <td>{{$client->last_name}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->telephone}}</td>
                    <td></td>
                    <td>
                        <a class="btn btn-dark px-2 btnEdit" data-bs-toggle="modal" data-bs-target="#editModal" data-client='{{json_encode($client)}}'
                           data-url= {{route('client-edit')}}>
                            Editar
                        </a>
                    </td>
                    <td>
                        <form method="post" action={{route('client-delete')}} >
                            @csrf
                            <input type="hidden" id="client" name="client" value={{$client->id}}>

                            <!--
                            <a class="btn btn-danger px-2" href={{route('client-delete')}}>
                                Borrar
                            </a>
                               -->
                            <button class="btn btn-danger px-2" type="submit"> Borrar </button>
                        </form>

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="editForm" action={{route('client-edit')}}>
                        @csrf
                        <input type="hidden" id="clientEdit" name="clientEdit" value="" required>
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
                        <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/clients.js')

@stop
