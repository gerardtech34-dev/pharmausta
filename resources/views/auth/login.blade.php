@extends('layouts.public')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0" style="min-height: calc(100vh - 76px);">
        <div class="col-md-5 d-none d-md-flex hero-gradient text-white align-items-center">
            <div class="p-5 text-center w-100">
                <img src="{{ asset('images/logo.png') }}" alt="PharmaUSTA" height="80" class="mb-4">
                <h2 class="fw-bold text-uppercase mb-3">Bienvenue sur PharmaUSTA</h2>
                <p class="mb-0">La plateforme numérique des ressources pédagogiques des étudiants en Pharmacie de l'USTA.</p>
            </div>
        </div>

        <div class="col-md-7 col-12 bg-white d-flex align-items-center">
            <div class="w-100 px-4 px-md-5 py-5">
                <div class="mx-auto" style="max-width: 480px;">
                    <h3 class="fw-bold mb-4" style="color: #6B3FD4;">Connexion</h3>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
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
                        <div class="d-flex justify-content-end mb-4">
                            <a href="{{ route('password.request') }}" style="color: #6B3FD4;">Mot de passe oublié ?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">Se connecter</button>
                        <p class="text-center text-muted mb-0">
                            Pas encore de compte ?
                            <a href="{{ route('register') }}" style="color: #6B3FD4; font-weight: 600;">Créer un compte</a>
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
