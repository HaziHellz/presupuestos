<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function signin()
    {
        return view('auth.sign-in');
    }

    public function signup()
    {
        return view('auth.checkout');
    }

    public function doLogin(Request $request){
        $request->validate(
            [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ],
            [
                'email.required' => 'Tu correo electronico es requerido.',
                'email.string' => 'El correo electronico debe ser texto.',
                'email.max'=>'El correo electrónico debe contener menos de 255 caracteres.',
                'password.required'=>'La contraseña es obligatoria.',
                'password.string'=>'La contraseña debe ser texto.',
                'password.min'=>'La longitud mínima de la cadena es de 8 caracteres.'
            ]
        );


        $authenticated = Auth::attempt(
            $request->only('email', 'password'),
            true
        );

        if ($authenticated) {
            return redirect()->intended();
        }

        return back()->withErrors(['login' => 'Las credenciales no coinciden con nuestros registros.']);

    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ],
            [
                'name.required' => 'Tu nombre de usuario es requerido.',
                'name.string' => 'El nombre de usuario debe ser texto.',
                'name.max' => 'El nombre de usuario debe contener menos de 255 caracteres.',
                'email.required' => 'Tu correo electronico es requerido.',
                'email.string' => 'El correo electronico debe ser texto.',
                'email.max'=>'El correo electrónico debe contener menos de 255 caracteres.',
                'email.unique'=>'El correo electronico ya esta registrado.',
                'password.required'=>'La contraseña es obligatoria.',
                'password.string'=>'La contraseña debe ser texto.',
                'password.min'=>'La longitud mínima de la cadena es de 8 caracteres.'
            ]
        );

        $user = User::create(
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]
        );
        Auth::login($user);

        if(Auth::check()){
            return redirect()->route('quote-index');
        }else{
            return redirect()->route('user-sign-in');
        }
    }

    public function doLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
