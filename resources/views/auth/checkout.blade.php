<!doctype html>
<html lang="en">
@use(App\Http\Controllers\UserController)
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Formulario de registro</title>


    <!-- Bootstrap core CSS -->
    @vite(['resources/css/bootstrap.css'])
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    @vite(['resources/css/form-validation.css'])
</head>
<body class="bg-light">
<div class="container">
    <main>
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="{{asset('images/user.svg')}}" alt="" width="72"
                 height="57">
            <h2>Formulario de registro</h2>
        </div>

        <div class="row g-5 ">
            <div class="col-12">
                <h4 class="mb-3">Información personal</h4>
                <form class="needs-validation" method="post" action="{{action([UserController::class, 'store'])}}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="firstName" class="form-label">Nombre</label>
                            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) name="name" id="firstName" placeholder="" value=""
                                   required>
                            <div class="invalid-feedback">
                                {{$errors->first('name')}}
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text">@</span>
                                <input type="email" @class(['form-control', 'is-invalid' => $errors->has('email')]) name="email" id="email"
                                       placeholder="Correo electrónico" required>
                                <div class="invalid-feedback">
                                    {{$errors->first('email')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" @class(['form-control', 'is-invalid' => $errors->has('password')]) name="password" id="password" placeholder=""
                                   required>
                            <div class="invalid-feedback">
                                {{$errors->first('password')}}
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Registrarse</button>
                    <div class="col-12 mt-4 d-flex justify-content-center">
                        <a href="{{route('user-sign-in')}}" class="link-info mt-4">Iniciar sesión</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="my-4 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; Sistema de cotizaciones</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Anyelin Elizabeth Cabrera Morales</a></li>
            <li class="list-inline-item"><a href="#">Juan Antonio Tafoya Cabrera</a></li>
            <li class="list-inline-item"><a href="#">Heber Haziel Nava Martínez</a></li>
        </ul>
    </footer>
</div>


@vite(['resources/js/bootstrap.bundle.js'])
@vite(['resources/js/form-validation.js'])
</body>
</html>
