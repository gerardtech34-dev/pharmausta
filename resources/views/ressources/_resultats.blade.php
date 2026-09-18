<div class="row g-4">
    @forelse($ressources as $ressource)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary">{{ $ressource->typeRessource->nom ?? 'Type inconnu' }}</span>
                        <small class="text-muted">{{ $ressource->anneeAcademique->libelle ?? '' }}</small>
                    </div>
                    <h5 class="card-title fw-bold">{{ $ressource->titre }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($ressource->description, 120) }}</p>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            {{ $ressource->niveau->nom ?? '' }} · {{ $ressource->ue->nom ?? '' }}
                            @if($ressource->ecue)
                                · {{ $ressource->ecue->nom }}
                            @endif
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('ressources.show', $ressource) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Voir
                            </a>
                            <a href="{{ route('ressources.download', $ressource) }}" class="btn btn-sm btn-success">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Aucune ressource publiée ne correspond à vos critères.</div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $ressources->links() }}
</div>
