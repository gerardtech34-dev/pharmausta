@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    @can('voir-statistiques')
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary me-3">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $nbUtilisateurs }}</h3>
                            <p class="text-muted mb-0">Utilisateurs inscrits</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-success me-3">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $nbUtilisateursActifs }}</h3>
                            <p class="text-muted mb-0">Utilisateurs actifs</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary me-3">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $nbRessourcesTotal }}</h3>
                            <p class="text-muted mb-0">Ressources totales</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-success me-3">
                            <i class="bi bi-newspaper"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $nbActualitesPublies }}</h3>
                            <p class="text-muted mb-0">Actualités publiées</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">Ressources par statut</div>
                    <div class="card-body">
                        @php
                            $total = $nbRessourcesTotal > 0 ? $nbRessourcesTotal : 0;
                        @endphp

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="badge bg-secondary me-2"><i class="bi bi-clock"></i> Brouillon</span>
                                </div>
                                <span class="fw-bold">{{ $ressourcesParStatut['brouillon'] }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-secondary" role="progressbar"
                                     style="width: {{ $total > 0 ? ($ressourcesParStatut['brouillon'] / $total) * 100 : 0 }}%"
                                     aria-valuenow="{{ $ressourcesParStatut['brouillon'] }}"
                                     aria-valuemin="0"
                                     aria-valuemax="{{ $total }}"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="badge bg-success me-2"><i class="bi bi-check-circle"></i> Publié</span>
                                </div>
                                <span class="fw-bold">{{ $ressourcesParStatut['publie'] }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ $total > 0 ? ($ressourcesParStatut['publie'] / $total) * 100 : 0 }}%"
                                     aria-valuenow="{{ $ressourcesParStatut['publie'] }}"
                                     aria-valuemin="0"
                                     aria-valuemax="{{ $total }}"></div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="badge bg-dark me-2"><i class="bi bi-archive"></i> Retiré</span>
                                </div>
                                <span class="fw-bold">{{ $ressourcesParStatut['retire'] }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-dark" role="progressbar"
                                     style="width: {{ $total > 0 ? ($ressourcesParStatut['retire'] / $total) * 100 : 0 }}%"
                                     aria-valuenow="{{ $ressourcesParStatut['retire'] }}"
                                     aria-valuemin="0"
                                     aria-valuemax="{{ $total }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">Ressources par année académique</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Année académique</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ressourcesParAnnee as $annee)
                                    <tr>
                                        <td>{{ $annee->libelle }}</td>
                                        <td>{{ $annee->total }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Aucune donnée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">Top 5 des ressources les plus téléchargées</div>
                    <div class="card-body">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">Rang</th>
                                    <th>Titre</th>
                                    <th>Téléchargements</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topRessources as $index => $ressource)
                                    <tr>
                                        <td>
                                            <span class="badge rounded-circle bg-primary d-inline-flex align-items-center justify-content-center"
                                                  style="width: 32px; height: 32px;">
                                                {{ $index + 1 }}
                                            </span>
                                        </td>
                                        <td>
                                            <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                            {{ $ressource->titre }}
                                        </td>
                                        <td>{{ $ressource->telechargements }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Aucune donnée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">Bienvenue dans votre espace de gestion. Utilisez le menu à gauche pour accéder aux sections autorisées.</div>
    @endcan
</div>
@endsection
