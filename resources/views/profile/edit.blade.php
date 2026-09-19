@extends('layouts.user')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @php
                $user = auth()->user();
                $initiales = strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1));
            @endphp

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center rounded-circle me-3"
                         style="width: 80px; height: 80px; background-color: #6B3FD4; color: white; font-size: 1.75rem; font-weight: bold;">
                        {{ $initiales }}
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">{{ $user->prenom }} {{ $user->nom }}</h4>
                        <p class="text-muted mb-0"><i class="bi bi-envelope me-1"></i> {{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white fw-bold">
                            <i class="bi bi-person-gear me-1"></i> Informations personnelles
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="nom" class="form-label">
                                        <i class="bi bi-person me-1"></i> Nom
                                    </label>
                                    <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom', $user->nom) }}" required>
                                    @error('nom')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="prenom" class="form-label">
                                        <i class="bi bi-person me-1"></i> Prénom
                                    </label>
                                    <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
                                    @error('prenom')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="bi bi-envelope me-1"></i> Adresse email
                                    </label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i> Mettre à jour
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white fw-bold">
                            <i class="bi bi-shield-lock me-1"></i> Changer le mot de passe
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.password.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">
                                        <i class="bi bi-lock me-1"></i> Mot de passe actuel
                                    </label>
                                    <div class="input-group">
                                        <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        @error('current_password')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-lock me-1"></i> Nouveau mot de passe
                                    </label>
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="bi bi-lock me-1"></i> Confirmer le nouveau mot de passe
                                    </label>
                                    <div class="input-group">
                                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-shield-check me-1"></i> Changer le mot de passe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = document.getElementById(this.dataset.target);
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
});
</script>
@endsection
