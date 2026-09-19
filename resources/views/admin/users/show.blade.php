@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Détails de l'utilisateur</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nom</dt>
                        <dd class="col-sm-8">{{ $user->nom }} {{ $user->prenom }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $user->email }}</dd>

                        <dt class="col-sm-4">Matricule</dt>
                        <dd class="col-sm-8">{{ $user->matricule }}</dd>

                        <dt class="col-sm-4">Niveau</dt>
                        <dd class="col-sm-8">{{ $user->niveau->nom ?? '-' }}</dd>

                        <dt class="col-sm-4">Statut</dt>
                        <dd class="col-sm-8">
                            @if($user->actif)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-danger">Inactif</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Rôles assignés</h5>
                </div>
                <div class="card-body">
                    @if($user->roles->count() > 0)
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary d-inline-flex align-items-center" style="font-size: 0.9rem; padding: 0.5em 0.75em;">
                                    {{ $role->name }}
                                    @if($role->name !== 'Administrateur')
                                        <form action="{{ route('admin.users.removeRole', [$user, $role]) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Retirer ce rôle ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-white p-0 border-0" style="text-decoration: none; line-height: 1;" title="Retirer ce rôle">
                                                <i class="bi bi-x-circle-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-3">Aucun rôle assigné.</p>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Réassigner les rôles</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.assign-role', $user) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Sélectionner les rôles</label>
                            <select name="role_ids[]" class="form-select" multiple size="6">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Cette action remplace la sélection actuelle (syncRoles).</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Mettre à jour les rôles</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
