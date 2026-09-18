@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">UE</h4>
        <a href="{{ route('admin.ues.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nouvelle UE
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" id="filtre-texte" class="form-control" placeholder="Rechercher une UE...">
                </div>
                <div class="col-md-6">
                    <select id="filtre-niveau" class="form-select">
                        <option value="">Tous les niveaux</option>
                        @foreach($niveaux as $niveau)
                            <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="table-ues">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Niveau</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ues as $ue)
                            <tr data-niveau-id="{{ $ue->niveau_id }}" data-nom="{{ strtolower($ue->nom) }}">
                                <td>{{ $ue->nom }}</td>
                                <td>{{ $ue->niveau->nom ?? '-' }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.ues.edit', $ue) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.ues.destroy', $ue) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
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
                                <td colspan="3" class="text-center text-muted">Aucune UE.</td>
                            </tr>
                        @endforelse
                        <tr id="ligne-aucun-resultat" style="display: none;">
                            <td colspan="3" class="text-center text-muted">Aucune UE trouvée</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtreTexte = document.getElementById('filtre-texte');
    const filtreNiveau = document.getElementById('filtre-niveau');
    const lignes = document.querySelectorAll('#table-ues tbody tr[data-nom]');
    const ligneAucun = document.getElementById('ligne-aucun-resultat');

    function appliquerFiltres() {
        const texte = filtreTexte.value.toLowerCase().trim();
        const niveauId = filtreNiveau.value;
        let visibles = 0;

        lignes.forEach(tr => {
            const nom = tr.dataset.nom;
            const niveau = tr.dataset.niveauId;
            const matchTexte = !texte || nom.includes(texte);
            const matchNiveau = !niveauId || niveau === niveauId;
            const visible = matchTexte && matchNiveau;
            tr.style.display = visible ? '' : 'none';
            if (visible) visibles++;
        });

        ligneAucun.style.display = visibles === 0 ? '' : 'none';
    }

    filtreTexte.addEventListener('input', appliquerFiltres);
    filtreNiveau.addEventListener('change', appliquerFiltres);
});
</script>
@endsection
