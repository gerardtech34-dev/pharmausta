<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PharmaUSTA')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="bg-white shadow-sm header-sticky">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand fw-bold brand-text d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="PharmaUSTA" height="40" class="me-2">
                    PharmaUSTA
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('actualites.*') ? 'active' : '' }}" href="{{ route('actualites.index') }}">Actualités</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Connexion</a>
                            </li>
                            <li class="nav-item ms-lg-2">
                                <a class="btn btn-primary text-white px-3" href="{{ route('register') }}">Créer un compte</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('ressources.*') || request()->routeIs('arborescence.*') ? 'active' : '' }}" href="{{ route('ressources.index') }}">Ressources</a>
                            </li>
                            @canany(['gerer-ressources', 'gerer-referentiels', 'gerer-utilisateurs', 'gerer-roles', 'gerer-actualites', 'voir-statistiques'])
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Espace de gestion</a>
                                </li>
                            @endcanany
                            <li class="nav-item dropdown ms-lg-2">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ Auth::user()->prenom ?? Auth::user()->nom }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                            <i class="bi bi-person me-2"></i> Mon profil
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                                        </a>
                                    </li>
                                </ul>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="text-white pt-5 pb-4" style="background-color: #1A1030;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="PharmaUSTA" height="40" class="me-2">
                        <span class="fw-bold fs-5 text-white">PharmaUSTA</span>
                    </div>
                    <p class="text-white-50 small">La plateforme numérique des ressources pédagogiques des étudiants en Pharmacie de l'USTA.</p>
                    <p class="text-white-50 small mb-0">&copy; {{ date('Y') }} PharmaUSTA – Tous droits réservés.</p>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold text-uppercase mb-3">Liens rapides</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ url('/') }}" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right" style="color: #5FA82C;"></i> Accueil
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('actualites.index') }}" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right" style="color: #5FA82C;"></i> Actualités
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('contact') }}" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right" style="color: #5FA82C;"></i> Contact
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-uppercase mb-3">Ressources</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right" style="color: #5FA82C;"></i> Cours
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right" style="color: #5FA82C;"></i> Anciens sujets d'examens
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right" style="color: #5FA82C;"></i> Exposés
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right" style="color: #5FA82C;"></i> Documents complémentaires
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold text-uppercase mb-3">Nous contacter</h6>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex">
                            <i class="bi bi-telephone me-2" style="color: #5FA82C;"></i>
                            <span class="text-white-50 small">+226 54 72 44 34</span>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="bi bi-envelope me-2" style="color: #5FA82C;"></i>
                            <a href="mailto:cepharmusta@gmail.com" class="text-white-50 text-decoration-none small">cepharmusta@gmail.com</a>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="bi bi-geo-alt me-2" style="color: #5FA82C;"></i>
                            <span class="text-white-50 small">03 BP 7021 Ouagadougou 03, Burkina Faso</span>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 text-center">
                    <h6 class="fw-bold text-uppercase mb-3">Une initiative du</h6>
                    <img src="{{ asset('images/cepharm-logo.png') }}" alt="CEPHARM USTA" style="width: 90px; height: auto;" class="mb-2">
                    <p class="text-white-50 small mb-0">CEPHARM USTA</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
