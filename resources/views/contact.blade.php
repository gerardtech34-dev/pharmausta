@extends('layouts.public')

@section('content')
<section class="hero-gradient text-white py-5">
    <div class="container py-4">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-uppercase mb-3">Contactez-nous</h1>
                <p class="lead mb-0">N'hésitez pas à nous contacter pour toute question concernant PharmaUSTA.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="icon-circle mx-auto mb-3 bg-primary">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h5 class="fw-bold">Téléphone</h5>
                    <p class="text-muted mb-0">
                        <a href="tel:+22654724434" class="text-decoration-none text-muted">+226 54 72 44 34</a>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="icon-circle mx-auto mb-3 bg-primary">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <h5 class="fw-bold">E-mail</h5>
                    <p class="text-muted mb-0">
                        <a href="mailto:cepharmusta@gmail.com" class="text-decoration-none text-muted">cepharmusta@gmail.com</a>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="icon-circle mx-auto mb-3 bg-primary">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h5 class="fw-bold">Adresse</h5>
                    <p class="text-muted mb-0">03 BP 7021 Ouagadougou 03, Burkina Faso</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">Envoyez-nous un message</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('contact.send') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nom" class="form-label">Nom *</label>
                                    <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="sujet" class="form-label">Sujet *</label>
                                <input type="text" name="sujet" id="sujet" class="form-control @error('sujet') is-invalid @enderror" value="{{ old('sujet') }}" required>
                                @error('sujet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message *</label>
                                <textarea name="message" id="message" rows="6" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Envoyer le message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
