@extends('base.master')
@section('title','Principal')
@section('content')
    <h1>Cotización para {{$quote->client->name . ' ' . $quote->client->last_name}}</h1>
    <div class="row g-3">
        <h2>{{$category->name}}</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createQuoteModal">
            Añadir servicio
        </button>
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-warning mt-3">
            <p>{{session('error')}}</p>
        </div>
    @endif
    <!-- Alertas de errores -->
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <p>{{$errors->first()}}</p>
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
                    <form method="post" action="{{route('quote-detail-add-detail')}}" id="createQuoteForm">
                        @csrf
                        <input type="hidden" value="{{$quote->id}}" name="quote_id">
                        <input type="hidden" value="{{$category->id}}" name="category_id">
                        <div class="col-12 mb-3">
                            <label for="concept_id" class="form-label">Concepto</label>
                            <select name="concept_id" id="concept_id"
                                    @class(['form-control', 'is-invalid' => $errors->has('concept_id'), 'w-100']) id="concept"
                                    required>
                                <option value="">Escoger...</option>
                                @isset($concepts)
                                    @foreach($concepts as $concept)
                                        <option value="{{$concept->id}}">
                                            {{$concept->description}}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            <div class="invalid-feedback">
                                {{$errors->first('concept_id')}}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Cantidad</label>
                            <input type="number" id="quantity" name="quantity"
                                   @class(['form-control', 'is-invalid' => $errors->has('quantity')])
                                   placeholder="Introduce la cantidad." min="1" step="1" value="1" required>
                            <div class="invalid-feedback">
                                {{$errors->first('quantity')}}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="registered_price" class="form-label">Precio</label>
                            <input type="number" id="registered_price" name="registered_price"
                                   @class(['form-control', 'is-invalid' => $errors->has('registered_price')])
                                   placeholder="Introduce el precio por el servicio." min="1.0" step="0.1" value="1.0"
                                   required>
                            <div class="invalid-feedback">
                                {{$errors->first('registered_price')}}
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

    @isset($details)
        @if($details->isEmpty())
            <div class="alert alert-warning mt-3">
                <p>Todavía no se han agregado servicios.</p>
            </div>
        @else
            <table class="table table-striped mt-3">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Servicio</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($details as $detail)
                    <tr>
                        <td>{{$detail['id']}}</td>
                        <td>{{$detail['concept']}}</td>
                        <td>{{$detail['quantity']}}</td>
                        <td>${{$detail['price']}} MXN</td>
                        <td>
                            <form id="detail{{$detail['id']}}Form" class="d-flex ms-2"
                                  action="{{route('quote-detail-delete-detail')}}" method="post">
                                @csrf
                                @method('delete')
                                <input type="hidden" value="{{$detail['id']}}" name="detail_id">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeletionDetailModal{{$detail['id']}}">
                                    <span class="bi bi-trash"></span>
                                    Borrar
                                </button>
                            </form>
                            <div class="modal fade" id="confirmDeletionDetailModal{{$detail['id']}}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Eliminar servicio</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Eliminar el servicio de la cotización.</p>
                                            <p>¿Está seguro de realizar la acción?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <button type="button" class="btn btn-primary"
                                                    id="confirmDeletionDetailButton{{$detail['id']}}">Ok
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.getElementById('confirmDeletionDetailButton{{$detail['id']}}').addEventListener('click', function () {
                                    document.getElementById('detail{{$detail['id']}}Form').submit(); // Enviar el formulario al confirmar
                                });
                            </script>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>${{$total}} MXN</th>
                </tr>
                </tbody>
            </table>
        @endif
    @else
        <div class="alert alert-danger mt-3">
            <p>No se ha proporcionado una lista de servicios.</p>
        </div>
    @endisset

    <div class="container g-3 d-flex justify-content-between">
        <form id="quoteUpdateForm{{$quote->id}}" class="d-flex ms-2"
              action="{{route('quote-update')}}" method="post">
            @csrf
            @method('put')
            <input type="hidden" value="{{$quote->id}}" name="quote_id">
            <button type="button" @class(['btn', 'btn-success', 'disabled' => $quote->completed]) data-bs-toggle="modal"
                    data-bs-target="#confirmCompleteModal{{$quote->id}}">
                Finalizar
            </button>
        </form>
        <form id="quoteDeleteForm{{$quote->id}}" class="d-flex ms-2"
              action="{{route('quote-delete')}}" method="post">
            @csrf
            @method('delete')
            <input type="hidden" value="{{$quote->id}}" name="quote_id">
            <button type="button" @class(['btn', 'btn-success', 'disabled' => $quote->completed]) data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteModal{{$quote->id}}">
                Cancelar cotización
            </button>
        </form>
    </div>

    <div class="modal fade" id="confirmCompleteModal{{$quote->id}}" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Finalizar cotización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Esto hará que la cotización ya no se pueda cancelar o eliminar.</p>
                    <p>¿Está seguro de realizar la acción?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary"
                            id="confirmCompleteButton{{$quote->id}}">Ok
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteModal{{$quote->id}}" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancelar la cotización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Esto hará que la cotización se elimine permanentemente.</p>
                    <p>¿Está seguro de realizar la acción?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary"
                            id="confirmDeleteButton{{$quote->id}}">Ok
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('confirmCompleteButton{{$quote->id}}').addEventListener('click', function () {
            document.getElementById('quoteUpdateForm{{$quote->id}}').submit(); // Enviar el formulario al confirmar
        });
        document.getElementById('confirmDeleteButton{{$quote->id}}').addEventListener('click', function () {
            document.getElementById('quoteDeleteForm{{$quote->id}}').submit(); // Enviar el formulario al confirmar
        });
    </script>
@stop
