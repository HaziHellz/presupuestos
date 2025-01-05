<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->categories()->get(); // Obtener categorías del usuario autenticado
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
            ],
            [
                'name.required' => 'El nombre de la categoría es requerido.',
                'name.string' => 'El nombre debe ser texto.',
            ]
        );

        if ($request->has('id') && $request->input('id')) {
            // Actualizar categoría existente
            $category = auth()->user()->categories()->findOrFail($request->input('id'));
            $category->update([
                'name' => $request->input('name'),
            ]);
            return redirect()->back()->with('success', 'Categoría actualizada exitosamente.');
        } else {
            // Crear nueva categoría
            auth()->user()->categories()->create([
                'name' => $request->input('name'),
            ]);
            return redirect()->back()->with('success', 'Categoría creada exitosamente.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string',
            ],
            [
                'name.required' => 'El nombre de la categoría es requerido',
                'name.string' => 'El nombre debe ser texto.',
            ]
        );

        $category = auth()->user()->categories()->findOrFail($id);
        $category->update(
            [
                'name' => $request->input('name'),
            ]
        );
        $categories = auth()->user()->categories()->get();
        return view('categories.index', compact('categories'))->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Request $request)
    {
        $category = Category::find($request->input('id'));
        if ($category) {
            try {
                $category->destroy();
                return redirect()->back()->with('success', 'Categoria eliminado exitosamente.');
            } catch (\Exception $e) {
                $category->active = 0;
                $category->save();
                return redirect()->back()->with('success', 'No se pudo eliminar la Categoría. Se ha deshabilitado.');
            }
        } else {
            return redirect()->back()->with('error', 'Categoría no encontrada.');
        }
    }
}
