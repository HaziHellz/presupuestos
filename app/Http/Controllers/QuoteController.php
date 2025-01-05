<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class QuoteController extends Controller
{

    public function index()
    {
        $categories = auth()->user()->categories()->get()
            ->filter(function ($category) {
                return $category->concepts()->count() > 0;
            });
        if ($categories->isEmpty()) {
            return redirect()->route('category-index');
        }

        $clients = auth()->user()->clients()->get();
        if ($clients->isEmpty()) {
            return redirect()->route('client-index');
        }

        $quotes = auth()->user()->quotes()->get()->map(function ($quote) {
            return [
                'id' => $quote->id,
                'category' => [
                    'id' => $quote->category->id,
                    'name' => $quote->category->name,
                ],
                'total' => $quote->details()->sum('registered_price'),
                'client' => $quote->client->name . ' ' . $quote->client->last_name,
                'completed' => $quote->completed
            ];
        });
        return view('quotes.index', compact('categories', 'clients', 'quotes'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'client_id' => 'required|integer|exists:clients,id',
                'category_id' => 'required|integer|exists:categories,id',
            ],
            [
                'client_id.required' => 'El cliente es obligatorio.',
                'client_id.integer' => 'El cliente debe ser un entero.',
                'client_id.exists' => 'El cliente seleccionado no existe.',
                'category_id.required' => 'La categoria es obligatoria.',
                'category_id.integer' => 'La categoria debe ser un entero.',
                'category_id.exists' => 'La categoria seleccionada no existe.',
            ]
        );

        $category = Category::where('id', $request->input('category_id'))->get()->filter(function ($category) {
            return $category->concepts()->count() > 0;
        })->first();
        if (!$category) {
            return redirect()->route('category-index');
        }
        $quote = auth()->user()->quotes()->create([
            'client_id' => $request->get('client_id'),
            'category_id' => $request->get('category_id'),
        ]);
        if ($quote) {
            return redirect()->route('quote-page', ['id' => $quote->id, 'category_id' => $category->id]);
        }
        return redirect()->back()->with('error', 'Ocurrió un error al crear la cotización.');
    }


    public function quotePage(int $id, int $categoryId)
    {
        $category = Category::where('id', $categoryId)->get()->filter(function ($category) {
            return $category->concepts()->count() > 0;
        })->first();
        if (!$category) {
            return redirect()->route('category-index');
        }
        $quote = Quote::where('id', $id)->first();
        $details = $quote->details()->get()->map(function ($detail) {
            return [
                'id' => $detail->id,
                'concept' => $detail->concept->description,
                'quantity' => $detail->quantity,
                'price' => $detail->registered_price,
            ];
        });

        $total = $details->sum(function ($detail) {
            return $detail['price'] * $detail['quantity'];
        });

        $concepts = $category->concepts()->get();

        return view('quotes.show', compact('quote', 'category', 'concepts', 'details', 'total'));
    }


    public function update(Request $request)
    {
        $request->validate(
            [
                'quote_id' => 'required|integer|exists:quotes,id',
            ],
            [
                'quote_id.required' => 'La cotización es obligatorio.',
                'quote_id.integer' => 'El identificador de la cotización debe ser un entero.',
                'quote_id.exists' => 'La cotización seleccionada no existe.',
            ]
        );

        $quote = Quote::where('id', $request->get('quote_id'))->first();

        if ($quote->details()->get()->isEmpty()) {
            return redirect()->back()->with('error', "No se ha podido finalizar la cotización porque no tiene servicios incluidos.");
        }
        $quote->completed = true;
        $quote->save();
        if ($quote) {
            return redirect()->route('quote-index')->with('success', 'Se ha finalizado la cotización correctamente.');
        } else {
            return redirect()->back()->with('error', "No se ha podido finalizar la cotización.");
        }
    }

    public function delete(Request $request)
    {
        $request->validate(
            [
                'quote_id' => 'required|integer|exists:quotes,id',
            ],
            [
                'quote_id.required' => 'La cotización es obligatorio.',
                'quote_id.integer' => 'El identificador de la cotización debe ser un entero.',
                'quote_id.exists' => 'La cotización seleccionada no existe.',
            ]
        );

        $quote = Quote::where('id', $request->get('quote_id'))->first()->delete();
        if ($quote) {
            return redirect()->route('quote-index')->with('success', 'Se ha cancelado la cotización correctamente.');
        } else {
            return redirect()->back()->with('error', "No se ha podido cancelar la cotización.");
        }
    }

    public function pdf(int $id, int $categoryId)
    {
        $category = Category::where('id', $categoryId)->get()->filter(function ($category) {
            return $category->concepts()->count() > 0;
        })->first();
        if (!$category) {
            return redirect()->route('category-index');
        }
        $quote = Quote::where('id', $id)->first();
        $details = $quote->details()->get()->map(function ($detail) {
            return [
                'id' => $detail->id,
                'concept' => $detail->concept->description,
                'quantity' => $detail->quantity,
                'price' => $detail->registered_price,
            ];
        });

        $total = $details->sum(function ($detail) {
            return $detail['price'] * $detail['quantity'];
        });

        $date = date("d-m-Y");


        $data = [
            'quote' => $quote,
            'category' => $category,
            'details' => $details,
            'total' => $total,
            'date' => $date
        ];


        $pdf = Pdf::loadView('quotes.pdf', $data);
        $pdf->download('cotización.pdf');
        return $pdf->stream();
    }
}
