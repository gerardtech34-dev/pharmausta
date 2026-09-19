<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PharmaUSTA - Espace utilisateur')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>
<body class="bg-light">
    <header class="bg-white shadow-sm header-sticky">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand fw-bold brand-text d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="PharmaUSTA" height="40" class="me-2">
                    PharmaUSTA
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNavbar" aria-controls="userNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="userNavbar">
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('actualites.*') ? 'active' : '' }}" href="{{ route('actualites.index') }}">Actualités</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('ressources.*') || request()->routeIs('arborescence.*') ? 'active' : '' }}" href="{{ route('ressources.index') }}">Ressources</a>
                        </li>
                        @canany(['gerer-ressources', 'gerer-referentiels', 'gerer-utilisateurs', 'gerer-roles', 'gerer-actualites', 'voir-statistiques'])
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Espace de gestion</a>
                            </li>
                        @endcanany
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Mon profil</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-outline-danger btn-sm" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>
</body>
</html>
