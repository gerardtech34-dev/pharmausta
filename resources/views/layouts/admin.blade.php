<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PharmaUSTA - Administration')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="d-flex">
        <aside class="text-white d-flex flex-column flex-shrink-0 p-3" style="width: 250px; min-height: 100vh; background-color: #2E1A5C;">
            <a href="{{ url('/admin') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                 <img src="{{ asset('images/logo.png') }}" alt="PharmaUSTA" height="40" class="me-2">
                <span class="fs-5 fw-bold">PharmaUSTA</span>
            </a>
            <hr class="text-white-50">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-2"></i> Tableau de bord
                    </a>
                </li>
                @can('gerer-actualites')
                    <li class="nav-item">
                        <a href="{{ route('admin.actualites.index') }}" class="nav-link text-white">
                            <i class="bi bi-newspaper me-2"></i> Actualités
                        </a>
                    </li>
                @endcan
                @can('gerer-ressources')
                    <li class="nav-item">
                        <a href="{{ route('admin.ressources.index') }}" class="nav-link text-white">
                            <i class="bi bi-file-earmark-pdf me-2"></i> Ressources
                        </a>
                    </li>
                @endcan
                @can('gerer-referentiels')
                    <li class="nav-item">
                        <a href="#referentielsSubmenu" class="nav-link text-white" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="referentielsSubmenu">
                            <i class="bi bi-diagram-3 me-2"></i> Référentiels
                        </a>
                        <div class="collapse" id="referentielsSubmenu">
                            <ul class="nav nav-pills flex-column ms-3">
                                <li class="nav-item">
                                    <a href="{{ route('admin.annees-academiques.index') }}" class="nav-link text-white-50">
                                        <i class="bi bi-calendar2-week me-2"></i> Années académiques
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.niveaux.index') }}" class="nav-link text-white-50">
                                        <i class="bi bi-layers me-2"></i> Niveaux
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.ues.index') }}" class="nav-link text-white-50">
                                        <i class="bi bi-journal-bookmark me-2"></i> UE
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.ecues.index') }}" class="nav-link text-white-50">
                                        <i class="bi bi-journal-text me-2"></i> ECUE
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.types-ressources.index') }}" class="nav-link text-white-50">
                                        <i class="bi bi-tags me-2"></i> Types de ressources
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('gerer-utilisateurs')
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link text-white">
                            <i class="bi bi-people me-2"></i> Utilisateurs
                        </a>
                    </li>
                @endcan
                @can('gerer-roles')
                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}" class="nav-link text-white">
                            <i class="bi bi-shield-lock me-2"></i> Rôles et permissions
                        </a>
                    </li>
                @endcan
            </ul>
        </aside>

        <div class="flex-grow-1">
            <header class="bg-white shadow-sm px-4 py-3 d-flex justify-content-between align-items-center header-sticky">
                <h5 class="mb-0">@yield('page-title', 'Administration')</h5>
                <div class="d-flex align-items-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm me-3">
                        <i class="bi bi-house me-1"></i> Retour au site
                    </a>
                    <span class="me-3">{{ Auth::user()->nom ?? Auth::user()->name }} {{ Auth::user()->prenom ?? '' }}</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </header>
            <main class="p-4 bg-light" style="min-height: calc(100vh - 60px);">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
