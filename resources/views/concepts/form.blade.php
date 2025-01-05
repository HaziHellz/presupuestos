@extends('base.master')
@section('title', 'Conceptos')

@section('content')

    @if(session('success'))
        <div class="alert alert-success col-12 mt-2">
            <p class="text-center">
                {{session('success')}}
            </p>
        </div>
    @endif
    @if($errors->first('concept_id'))
        <div class="alert alert-danger col-12 mt-2">
            <p class="text-center">
                {{$errors->first('concept_id')}}
            </p>
        </div>
    @endif
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4">Agregar Concepto</h2>
            <form method="post"
                  @if($is_update) action={{route('concept-update')}} @else action={{route('concept-store')}} @endif>
                @csrf
                @if($is_update)
                    @method('put')
                    <input type="hidden" value="{{$concept->category_id}}" name="prev_category">
                    <input type="hidden" value="{{$concept->id}}" name="concept_id">
                @endif
                <div class="col-12 mb-3">
                    <label for="category_id" class="form-label">Categoría</label>
                    <select name="category_id"
                            @class(['form-control', 'is-invalid' => $errors->has('category_id'), 'w-100']) id="category"
                            required>
                        <option value="">Escoger...</option>
                        @isset($categories)
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                        @if($is_update && $category->id == $concept->category_id) selected @endif>
                                    {{$category->name}}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    <div class="invalid-feedback">
                        {{$errors->first('category_id')}}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <input type="text"
                           @class(['form-control', 'is-invalid' => $errors->has('description')]) id="description"
                           name="description"
                           placeholder="Introduce la descripción del concepto." @if($is_update)value="{{$concept->description}}"@endif required>
                    <div class="invalid-feedback">
                        {{$errors->first('description')}}
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">Enviar</button>
                <a href="{{route('concept-index')}}" class="btn btn-outline-info w-100 mt-1">Regresar</a>
            </form>
        </div>
    </div>
@stop
