@extends('base.master')
@section('title','Principal')
@section('content')
    <h1>Cotizaciones</h1>
    <div class="row g-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createQuoteModal">
            Crear cotización
        </button>
    </div>
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
    <div class="modal fade" id="createQuoteModal" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear cotización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('quote-store')}}" id="createQuoteForm">
                        @csrf
                        <div class="col-12 mb-3">
                            <label for="category_id" class="form-label">Categoría</label>
                            <select name="category_id"
                                    @class(['form-control', 'is-invalid' => $errors->has('category_id'), 'w-100']) id="category"
                                    required>
                                <option value="">Escoger...</option>
                                @isset($categories)
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">
                                            {{$category->name}}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            <div class="invalid-feedback">
                                {{$errors->first('category_id')}}
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="category_id" class="form-label">Cliente</label>
                            <select name="client_id"
                                    @class(['form-control', 'is-invalid' => $errors->has('client_id'), 'w-100']) id="client"
                                    required>
                                <option value="">Escoger...</option>
                                @isset($clients)
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">
                                            {{$client->name . ' ' . $client->last_name}}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            <div class="invalid-feedback">
                                {{$errors->first('client_id')}}
                            </div>
                        </div>
                    </form>
                    <p>Al crear la cotización la podrás cancelar antes de confirmarla.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary"
                            id="createQuoteButton">Ok
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('createQuoteButton').addEventListener('click', function () {
            document.getElementById('createQuoteForm').submit(); // Enviar el formulario al confirmar
        });
    </script>



    @isset($quotes)
        @if($quotes->isEmpty())
            <div class="alert alert-warning mt-3">
                <p>Todavía no se han agregado cotizaciones.</p>
            </div>
        @else
            <table class="table table-striped mt-3">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Servicio</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($quotes as $quote)
                    <tr>
                        <td>{{$quote['id']}}</td>
                        <td>{{$quote['category']['name']}}</td>
                        <td>{{$quote['client']}}</td>
                        <td>${{$quote['total']}} MXN</td>
                        <td>
                            <div class="container d-flex">
                                <a href="{{route('quote-page', ['id' => $quote['id'], 'category_id' => $quote['category']['id']])}}"
                                   class="btn btn-success">Ver</a>
                                @if($quote['completed'])
                                    <a href="{{route('quote-pdf', ['id' => $quote['id'], 'category_id' => $quote['category']['id']])}}"
                                       class="btn btn-info ms-2">PDF</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    @else
        <div class="alert alert-danger mt-3">
            <p>No se ha proporcionado una lista de cotizaciones hechas.</p>
        </div>
    @endisset

@stop
