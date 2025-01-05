<?php

namespace App\Http\Controllers;

use App\Models\QuoteDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuoteDetailController extends Controller
{

    public function addDetail(Request $request)
    {
        $request->validate(
            [
                'quote_id' => 'required|integer|exists:quotes,id',
                'category_id' => 'required|integer|exists:categories,id',
                'concept_id' => 'required|integer|exists:concepts,id',
                'quantity' => 'required|integer|min:1',
                'registered_price' => 'required',
            ],
            [
                'quote_id.required' => 'El campo identificador de la cotización es obligatorio',
                'quote_id.integer' => 'El campo identificador de la cotización debe ser un entero',
                'quote_id.exists' => 'La cotización seleccionada no existe',
                'category_id.required' => 'El campo categoria es obligatorio',
                'category_id.integer' => 'El campo categoria debe ser un entero',
                'category_id.exists' => 'El campo categoria no existe',
                'concept_id.required' => 'El campo concepto es obligatorio',
                'concept_id.integer' => 'El campo concepto debe ser un entero',
                'concept_id.exists' => 'El campo concepto no existe',
                'quantity.required' => 'El campo cantidad es obligatorio',
                'quantity.integer' => 'El campo cantidad debe ser un entero',
                'quantity.min' => 'El campo cantidad debe ser mayor que 1',
                'registered_price.required' => 'El campo precio es obligatorio'
            ]
        );


        $quote = auth()->user()->quotes()->findOrFail($request->input('quote_id'))
            ->first();
        $id = $request->input('concept_id');
        $quoteDetail = $quote->details()->where('concept_id', $id)->first();
        if ($quoteDetail) {
            $quantity = $quoteDetail->quantity + $request->input('quantity');
            $quoteDetail->quantity = $quantity;
            $quoteDetail->registered_price = $request->input('registered_price');
            $quoteDetail->save();
        } else {
            $quoteDetail = $quote->details()->create(
                [
                    'category_id' => $request->input('category_id'),
                    'concept_id' => $request->input('concept_id'),
                    'quantity' => $request->input('quantity'),
                    'registered_price' => $request->input('registered_price')
                ]
            );
        }
        if ($quoteDetail) {
            return redirect()->route('quote-page', ['id' => $quote->id, 'category_id' => $request->input('category_id')])
                ->with('success', 'Se ha agregado correctamente el servicio.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al crear el detalle.');
        }
    }

    public function delete(Request $request)
    {
        $request->validate(
            [
                'detail_id' => 'required|integer|exists:quotes_details,id',
            ],
            [
                'detail_id.required' => 'El campo identificador del servicio es obligatorio',
                'detail_id.integer' => 'El identificador del servicio debe ser un entero',
                'detail_id.exists' => 'El servicio no existe no existe',
            ]
        );

        $detail = QuoteDetail::where('id', $request->input('detail_id'));
        if ($detail) {
            try {
                $detail->delete();
                return redirect()->back()->with('success', 'El servicio se ha eliminado exitosamente.');
            } catch (\Exception $e) {
                return redirect()->back()->with('success', 'No se ha podido eliminar el servicio.');
            }
        }else{
            return redirect()->back()->with('error', 'El servicio no existe.');
        }
    }
}
