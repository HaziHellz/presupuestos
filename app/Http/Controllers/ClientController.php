<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $clients = auth()->user()->clients()->get();
        return view('clients.index', compact('clients'));
    }

    public function store(Request $request){

        $validated = $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'telephone' => 'required',
        ],
            [
                'name.required' => 'El campo nombre es obligatorio',
                'last_name.required' => 'El campo apellido es obligatorio',
                'email.required' => 'El campo email es obligatorio',
                'telephone.required' => 'El campo telefono es obligatorio',
            ]
        );

        if($validated){
            $data = [
              'name' => $request->name,
              'last_name' => $request->last_name,
              'email' => $request->email,
              'telephone' => $request->telephone,
            ];

            try {
                $user = auth()->user();
                $user->clients()->create($data);
                return back()->with('success', 'El cliente fue registrado exitosamente');
            }catch (\Exception $e){

                $errorMessage = "Ocurrió un error inesperado.";

                // Verificar si el error es de tipo duplicado
                if (str_contains($e->getMessage(), 'Duplicate entry')) {
                    // Extraer el valor duplicado y el campo afectado
                    preg_match("/Duplicate entry '(.+)' for key '(.+)'/", $e->getMessage(), $matches);

                    if (!empty($matches)) {
                        $duplicatedValue = $matches[1]; // Valor duplicado (ejemplo: 'heb@gmail.com')
                        $affectedField = $matches[2]; // Llave afectada (ejemplo: 'clients_email_unique')

                        // Formatear el mensaje para el usuario
                        $fieldName = match ($affectedField) {
                            'clients.clients_email_unique' => 'correo electrónico',
                            'clients.clients_telephone_unique' => 'teléfono',
                            default => 'campo desconocido',
                        };

                        $errorMessage = "El {$fieldName} '{$duplicatedValue}' ya está registrado.";
                        return back()->with('error', $errorMessage);
                    }
                }else{
                    return back()->with('error', $e->getMessage());
                }




            }




        }else{
            return back()->withErrors($validated);
        }

    }

    public function delete(Request $request){
        $client = Client::find($request->client);

        // Verificar si el cliente existe antes de intentar eliminarlo
        if ($client) {
            try {
                // Intentar eliminar el cliente
                $client->delete();
                return redirect()->back()->with('success', 'Cliente eliminado exitosamente.');
            } catch (\Exception $e) {
                // Si no se puede eliminar, deshabilitar al cliente
                $client->active = 0;
                $client->save();
                return redirect()->back()->with('success', 'No se pudo eliminar el cliente. Se ha deshabilitado.');
            }
        } else {
            return redirect()->back()->with('error', 'Cliente no encontrado.');
        }
    }

    public function edit(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'telephone' => 'required',
            'clientEdit' => 'required',
        ],
            [
                'name.required' => 'El campo nombre es obligatorio',
                'last_name.required' => 'El campo apellido es obligatorio',
                'email.required' => 'El campo email es obligatorio',
                'telephone.required' => 'El campo telefono es obligatorio',
                'clientEdit.required' => 'El campo cliente es obligatorio',
            ]
        );

        if($validated){
            try {
                $user = auth()->user();
                $client = $user->clients()->find($request->clientEdit);
                $data = [
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'telephone' => $request->telephone,
                ];

                $client->update($data);
                $client->save();
                return back()->with('success', 'El cliente actualizado exitosamente');
            }catch (\Exception $e){

                $errorMessage = "Ocurrió un error inesperado.";

                // Verificar si el error es de tipo duplicado
                if (str_contains($e->getMessage(), 'Duplicate entry')) {
                    // Extraer el valor duplicado y el campo afectado
                    preg_match("/Duplicate entry '(.+)' for key '(.+)'/", $e->getMessage(), $matches);

                    if (!empty($matches)) {
                        $duplicatedValue = $matches[1]; // Valor duplicado (ejemplo: 'heb@gmail.com')
                        $affectedField = $matches[2]; // Llave afectada (ejemplo: 'clients_email_unique')

                        // Formatear el mensaje para el usuario
                        $fieldName = match ($affectedField) {
                            'clients.clients_email_unique' => 'correo electrónico',
                            'clients.clients_telephone_unique' => 'teléfono',
                            default => 'campo desconocido',
                        };

                        $errorMessage = "El {$fieldName} '{$duplicatedValue}' ya está registrado.";
                        return back()->with('error', $errorMessage);
                    }
                }else{
                    return back()->with('error', $e->getMessage());
                }

            }

        }else{
            return back()->withErrors($validated);
        }
    }

    public function storePage(){
        return view('clients.store');
    }


}
