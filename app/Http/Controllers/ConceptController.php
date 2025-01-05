<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use Illuminate\Http\Request;

class ConceptController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->categories()->get()
            ->filter(function ($category) {
                return $category->concepts()->count() > 0;
            })
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'concepts' => $category->concepts()->get()->map(function ($concept) {
                        return [
                            'id' => $concept->id,
                            'description' => $concept->description,
                        ];
                    })
                ];
            });

        return view('concepts.index', compact('categories'));
    }


    public function addForm()
    {
        $categories = auth()->user()->categories()->get();
        if ($categories->isEmpty()) {
            return redirect()->route('category-index');
        }
        return view('concepts.form', ['categories' => $categories, 'is_update' => false]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'category_id' => 'required|integer|exists:categories,id',
                'description' => 'required|string'
            ],
            [
                'category_id.required' => 'La categoría es obligatoria.',
                'category_id.integer' => 'EL identificador de la categoría debe ser un entero.',
                'category_id.exists' => 'La categoría no existe.',
                'description.required' => 'La descripción del concepto es obligatoria.',
                'description.string' => 'La descripción del concepto debe ser una cadena de texto.'
            ]
        );
        $concept = auth()->user()->categories()->findOrFail($request->input('category_id'))
            ->concepts()->create(
                [
                    'category_id' => $request->input('category_id'),
                    'description' => $request->input('description')
                ]
            );
        if ($concept) {
            return redirect()->back()->with('success', 'Se ha agregado el concepto correctamente.');
        }
        return redirect()->back()->with('error', 'Ocurrió un error al agregar el concepto.');
    }

    public function editForm(int $category_id, int $concept_id)
    {
        $concept = auth()->user()->categories()->findOrFail($category_id)
            ->concepts()->findOrFail($concept_id);
        $categories = auth()->user()->categories()->get();
        if ($categories->isEmpty()) {
            return redirect()->route('category-index');
        }
        return view('concepts.form', ['concept' => $concept, 'categories' => $categories, 'is_update' => true]);
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'concept_id' => 'required|integer|exists:concepts,id',
                'category_id' => 'required|integer|exists:categories,id',
                'prev_category' => 'required|integer|exists:categories,id',
                'description' => 'required|string'
            ],
            [
                'category_id.required' => 'La categoría es obligatoria.',
                'category_id.integer' => 'EL identificador de la categoría debe ser un entero.',
                'category_id.exists' => 'La categoría no existe.',
                'description.required' => 'La descripción del concepto es obligatoria.',
                'description.string' => 'La descripción del concepto debe ser una cadena de texto.',
                'concept_id.required' => 'El concepto es obligatorio.',
                'concept_id.integer' => 'EL identificador de concepto debe ser un entero.',
                'concept_id.exists' => 'El concepto no existe.',
                'prev_category.required' => 'La categoría anterior es obligatoria.',
                'prev_category.integer' => 'EL identificador de la categoría anterior debe ser un entero.',
                'prev_category.exists' => 'La categoría anterior no existe.',
            ]
        );

        $concept = Concept::where('id', $request->input('concept_id'))->update(
            [
                'category_id' => $request->input('category_id'),
                'description' => $request->input('description')
            ]
        );

        if ($concept) {
            return redirect()->route('concept-index')->with('success', 'Se ha editado el concepto correctamente.');
            //return redirect()->route('concept-edit', [$request->input('category_id'), $request->input('concept_id')])->with('success', 'Se ha editado el concepto correctamente.');
        }
        return redirect()->back()->with('error', 'Ocurrió un error al editar el concepto.');
    }

    public function delete(Request $request)
    {
        $request->validate(
            [
                'concept_id' => 'required|integer|exists:concepts,id',
            ],
            [
                'concept_id.required' => 'El concepto es obligatoria.',
                'concept_id.integer' => 'El identificador del concepto debe ser un entero.',
                'concept_id.exists' => 'El concepto no existe.',
            ]
        );

        $concept = Concept::where('id', $request->input('concept_id'));
        if ($concept) {
            try {
                $concept->delete();
                return redirect()->back()->with('success', 'Concepto eliminado exitosamente.');
            } catch (\Exception $e) {
                $concept->active = false;
                $concept->save();
                return redirect()->back()->with('success', 'No se ha podido eliminar el concepto. Se ha deshabilitado.');
            }
        }else{
            return redirect()->back()->with('error', 'El concepto no existe.');
        }
    }
}
