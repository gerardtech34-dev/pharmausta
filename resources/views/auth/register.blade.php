@extends('layouts.public')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0" style="min-height: calc(100vh - 76px);">
        <div class="col-md-5 d-none d-md-flex hero-gradient text-white align-items-center">
            <div class="p-5 text-center w-100">
                <img src="{{ asset('images/logo.png') }}" alt="PharmaUSTA" height="80" class="mb-4">
                <h2 class="fw-bold text-uppercase mb-3">Rejoignez PharmaUSTA</h2>
                <p class="mb-0">Créez votre compte et accédez à toutes les ressources pédagogiques de la faculté de Pharmacie.</p>
            </div>
        </div>

        <div class="col-md-7 col-12 bg-white d-flex align-items-center">
            <div class="w-100 px-4 px-md-5 py-5">
                <div class="mx-auto" style="max-width: 520px;">
                    <h3 class="fw-bold mb-4" style="color: #6B3FD4;">Inscription</h3>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required>
                                    @error('nom')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" required>
                                    @error('prenom')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="matricule" class="form-label">Matricule</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input id="matricule" type="text" class="form-control @error('matricule') is-invalid @enderror" name="matricule" value="{{ old('matricule') }}" required>
                                @error('matricule')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="niveau_id" class="form-label">Niveau</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                                <select id="niveau_id" class="form-select @error('niveau_id') is-invalid @enderror" name="niveau_id" required>
                                    <option value="">Sélectionnez un niveau</option>
                                    @foreach($niveaux as $niveau)
                                        <option value="{{ $niveau->id }}" {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>{{ $niveau->nom }}</option>
                                    @endforeach
                                </select>
                                @error('niveau_id')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">S'inscrire</button>
                        <p class="text-center text-muted mb-0">
                            Déjà un compte ?
                            <a href="{{ route('login') }}" style="color: #6B3FD4; font-weight: 600;">Se connecter</a>
                        </p>
                    </form>
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
