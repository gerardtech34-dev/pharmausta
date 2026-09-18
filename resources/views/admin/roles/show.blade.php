@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Détails du rôle : {{ $role->name }}</h4>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <p class="fw-bold mb-2">Permissions ({{ $role->permissions->count() }}) :</p>
            @forelse($role->permissions as $permission)
                <span class="badge bg-primary me-1 mb-1">{{ $permission->name }}</span>
            @empty
                <p class="text-muted mb-0">Aucune permission assignée.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
