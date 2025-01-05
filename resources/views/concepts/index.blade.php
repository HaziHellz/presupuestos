@extends('base.master')
@section('title','Conceptos')
@section('content')
    <h1>Conceptos</h1>
    <!-- Alertas de éxito -->
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    <!-- Alertas de errores -->
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-3">
        <a href="{{route('concept-store-page')}}" class="btn btn-info">Agregar un concepto</a>
    </div>
    @isset($categories)
        @if($categories->isEmpty())
            <div class="alert alert-warning mt-3">
                <p>La lista de conceptos está vacía.</p>
            </div>
        @else
            <table class="table table-striped mt-3">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Categoría</th>
                    <th>Concepto</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    @foreach($category['concepts'] as $concept)
                        <tr>
                            <td>{{$concept['id']}}</td>
                            <td>{{$category['name']}}</td>
                            <td>{{$concept['description']}}</td>
                            <td>
                                <div class="container d-flex ">
                                    <!-- Botón Editar -->
                                    <a href="{{route('concept-edit', [$category['id'], $concept['id']])}}"
                                       class="btn btn-info">Editar</a>

                                    <!-- Botón Eliminar -->
                                    <form id="concept{{$concept['id']}}Form" class="d-flex ms-2"
                                          action="{{route('concept-delete')}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" value="{{$concept['id']}}" name="concept_id">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmDeletionConceptModal{{$concept['id']}}">
                                            <span class="bi bi-trash"></span>
                                            Borrar
                                        </button>
                                    </form>
                                </div>
                                <div class="modal fade" id="confirmDeletionConceptModal{{$concept['id']}}" tabindex="-1"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Eliminar concepto</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Eliminar el concepto de la categoría de
                                                    <strong>{{$category['name']}}</strong>.</p>
                                                <p>¿Está seguro de realizar la acción?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Cancelar
                                                </button>
                                                <button type="button" class="btn btn-primary"
                                                        id="confirmDeletionConceptButton{{$concept['id']}}">Ok
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('confirmDeletionConceptButton{{$concept['id']}}').addEventListener('click', function () {
                                        document.getElementById('concept{{$concept['id']}}Form').submit(); // Enviar el formulario al confirmar
                                    });
                                </script>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        @endif
    @else
        <div class="alert alert-danger mt-3">
            <p>No se ha proporcionado una lista de conceptos.</p>
        </div>
    @endisset
@stop
