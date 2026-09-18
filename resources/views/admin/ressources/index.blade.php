@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Ressources (administration)</h4>
        <a href="{{ route('admin.ressources.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nouvelle ressource
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.ressources.index') }}" class="row g-2">
                <div class="col-md-3">
                    <select name="statut" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="brouillon" {{ request('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                        <option value="publie" {{ request('statut') == 'publie' ? 'selected' : '' }}>Publié</option>
                        <option value="retire" {{ request('statut') == 'retire' ? 'selected' : '' }}>Retiré</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="annee_academique_id" class="form-select">
                        <option value="">Toutes les années</option>
                        @foreach($anneesAcademiques as $annee)
                            <option value="{{ $annee->id }}" {{ request('annee_academique_id') == $annee->id ? 'selected' : '' }}>{{ $annee->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="niveau_id" class="form-select">
                        <option value="">Tous les niveaux</option>
                        @foreach($niveaux as $niveau)
                            <option value="{{ $niveau->id }}" {{ request('niveau_id') == $niveau->id ? 'selected' : '' }}>{{ $niveau->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="type_ressource_id" class="form-select">
                        <option value="">Tous les types</option>
                        @foreach($typesRessources as $type)
                            <option value="{{ $type->id }}" {{ request('type_ressource_id') == $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-primary">Filtrer</button>
                    <a href="{{ route('admin.ressources.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Année</th>
                            <th>Niveau</th>
                            <th>UE</th>
                            <th>ECUE</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Téléchargements</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ressources as $ressource)
                            <tr>
                                <td>{{ $ressource->titre }}</td>
                                <td>{{ $ressource->anneeAcademique->libelle ?? '-' }}</td>
                                <td>{{ $ressource->niveau->nom ?? '-' }}</td>
                                <td>{{ $ressource->ue->nom ?? '-' }}</td>
                                <td>{{ $ressource->ecue->nom ?? '-' }}</td>
                                <td>{{ $ressource->typeRessource->nom ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $ressource->statut == 'publie' ? 'success' : ($ressource->statut == 'brouillon' ? 'secondary' : 'danger') }}">
                                        {{ ucfirst($ressource->statut) }}
                                    </span>
                                </td>
                                <td>{{ $ressource->telechargements }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.ressources.edit', $ressource) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($ressource->statut !== 'publie')
                                        <form action="{{ route('admin.ressources.publish', $ressource) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-eye"></i> Publier
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.ressources.retract', $ressource) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-eye-slash"></i> Retirer
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.ressources.destroy', $ressource) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Aucune ressource trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $ressources->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
