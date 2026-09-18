@extends('layouts.admin')

@section('content')
@php
$categories = [
    'Ressources' => ['gerer-ressources'],
    'Référentiels' => ['gerer-referentiels'],
    'Utilisateurs' => ['gerer-utilisateurs'],
    'Rôles' => ['gerer-roles'],
    'Statistiques' => ['voir-statistiques'],
    'Actualités' => ['gerer-actualites'],
];
@endphp
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Créer un rôle</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label">Nom du rôle *</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h6 class="fw-bold mb-3">Permissions</h6>
                <div class="row g-3">
                    @foreach($categories as $titre => $nomsPerms)
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-light fw-bold">{{ $titre }}</div>
                                <div class="card-body">
                                    @php
                                        $permsCategorie = $permissions->whereIn('name', $nomsPerms);
                                    @endphp
                                    @forelse($permsCategorie as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm-{{ $permission->id }}" {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @empty
                                        <span class="text-muted small">Aucune</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @error('permissions')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
