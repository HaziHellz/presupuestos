@extends('base.master')
@section('title', 'Categorías')

@section('content')

    <div class="container">
        <h1>Categorías</h1>

        <!-- Alertas de éxito -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Alertas de errores -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if ($categories->isEmpty())
            <div class="alert alert-warning">
                No hay categorías disponibles.
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <!-- Ver los conceptos -->

                                <!-- Botón Editar -->
                                <button onclick="editCategory({{ $category }})"
                                    class="btn btn-primary btn-sm">Editar</button>
                                <!-- Botón Eliminar -->
                                <form method="post" action="{{ route('category-destroy') }}"
                                    style="display: inline;">
                                    @csrf
                                    <input type="hidden" value="{{$category->id}}" name="id">
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de eliminar esta categoría?')"
                                        type="submit">Borrar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Formulario dinámico para Crear/Editar Categorías -->
        <form id="categoryForm" action="{{ route('category-store') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" id="methodField" name="_method" value="POST"> <!-- Campo oculto para método -->
            <input type="hidden" id="categoryId" name="id" value=""> <!-- Campo para el ID de la categoría -->

            <div class="mb-3">
                <label for="name" class="form-label">Nombre de la categoría</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <!-- Botones -->
            <div class="d-flex gap-2">
                <button type="submit" id="formButton" class="btn btn-success">Agregar Categoría</button>
                <button type="button" onclick="resetForm()" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>

    </div>

    <script>
        // Función para editar una categoría
        function editCategory(category) {
            const form = document.getElementById('categoryForm');
            const methodField = document.getElementById('methodField');
            const formButton = document.getElementById('formButton');

            // Cambiar la acción a la ruta de actualización
            form.action = `/category/${category.id}`;
            methodField.value = 'PUT'; // Cambiar método a PUT
            document.getElementById('categoryId').value = category.id; // Establecer ID
            document.getElementById('name').value = category.name; // Rellenar el campo de nombre

            // Cambiar el texto y estilo del botón
            formButton.textContent = 'Actualizar Categoría';
            formButton.classList.remove('btn-success');
            formButton.classList.add('btn-primary');
        }

        // Función para reiniciar el formulario a "Agregar"
        function resetForm() {
            const form = document.getElementById('categoryForm');
            const methodField = document.getElementById('methodField');
            const formButton = document.getElementById('formButton');

            // Restablecer la acción y el método
            form.action = "{{ route('category-store') }}";
            methodField.value = 'POST'; // Cambiar método a POST
            document.getElementById('categoryId').value = ''; // Limpiar ID
            document.   getElementById('name').value = ''; // Limpiar nombre

            // Cambiar el texto y estilo del botón
            formButton.textContent = 'Agregar Categoría';
            formButton.classList.remove('btn-primary');
            formButton.classList.add('btn-success');
        }
    </script>
@stop
