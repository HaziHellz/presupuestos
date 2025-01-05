<!doctype html>
@use(App\Http\Controllers\UserController)
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Cotizaciones - @yield('title')</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sticky-footer-navbar/">


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
    @vite(['resources/css/sticky-footer-navbar.css'])
</head>
<body class="d-flex flex-column h-100">

<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('quote-index')}}">Sistema de cotizaciones</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->is('/')]) @if(request()->is('/')) aria-current="page"
                           @else tabindex="-1" aria-disabled="true"
                           @endif href="{{route('quote-index')}}">Cotizaciones</a>
                    </li>
                    <li class="nav-item">
                        <a @class(
                            [
                                'nav-link',
                                'active' => request()->is('category')
                            ])
                           @if(request()->is('category')) aria-current="page"
                           @else tabindex="-1" aria-disabled="true"
                           @endif href="{{route('category-index')}}">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a @class(
                            [
                                'nav-link',
                                'active' => request()->is('concepts')
                            ])
                           @if(request()->is('concepts')) aria-current="page"
                           @else tabindex="-1" aria-disabled="true"
                           @endif href="{{route('concept-index')}}"
                        >Conceptos</a>
                    </li>
                    <li class="nav-item">
                        <a @class(
                            [
                                'nav-link',
                                'active' => request()->is('client')
                            ])
                           @if(request()->is('client')) aria-current="page"
                           @else tabindex="-1" aria-disabled="true"
                           @endif href="{{route('client-index')}}"
                        >Clientes</a>
                    </li>
                </ul>
                <form class="d-flex" method="get" action="{{action([UserController::class, 'doLogout'])}}">
                    @csrf
                    <button class="btn btn-danger">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>
</header>

<!-- Begin page content -->
<main class="flex-shrink-0">
    <div class="container">
        @yield('content')
    </div>
</main>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <div class="row g-3 d-flex justify-content-center">
            <div class="col-12">
                <span class="text-muted mb-1">&copy; Sistema de cotizaciones.</span>
            </div>
            <div class="col-12">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#">Anyelin Elizabeth Cabrera Morales</a></li>
                    <li class="list-inline-item"><a href="#">Juan Antonio Tafoya Cabrera</a></li>
                    <li class="list-inline-item"><a href="#">Heber Haziel Nava Martínez</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>


@vite(['resources/js/bootstrap.bundle.js'])
</body>
</html>
