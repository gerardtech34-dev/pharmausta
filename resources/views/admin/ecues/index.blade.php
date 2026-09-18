@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">ECUE</h4>
        <a href="{{ route('admin.ecues.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nouvelle ECUE
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" id="filtre-texte" class="form-control" placeholder="Rechercher une ECUE...">
                </div>
                <div class="col-md-6">
                    <select id="filtre-ue" class="form-select">
                        <option value="">Toutes les UE</option>
                        @foreach($ues as $ue)
                            <option value="{{ $ue->id }}">{{ $ue->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="table-ecues">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>UE</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ecues as $ecue)
                            <tr data-ue-id="{{ $ecue->ue_id }}" data-nom="{{ strtolower($ecue->nom) }}">
                                <td>{{ $ecue->nom }}</td>
                                <td>{{ $ecue->ue->nom ?? '-' }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.ecues.edit', $ecue) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.ecues.destroy', $ecue) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
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
                                <td colspan="3" class="text-center text-muted">Aucune ECUE.</td>
                            </tr>
                        @endforelse
                        <tr id="ligne-aucun-resultat" style="display: none;">
                            <td colspan="3" class="text-center text-muted">Aucune ECUE trouvée</td>
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
    const filtreUe = document.getElementById('filtre-ue');
    const lignes = document.querySelectorAll('#table-ecues tbody tr[data-nom]');
    const ligneAucun = document.getElementById('ligne-aucun-resultat');

    function appliquerFiltres() {
        const texte = filtreTexte.value.toLowerCase().trim();
        const ueId = filtreUe.value;
        let visibles = 0;

        lignes.forEach(tr => {
            const nom = tr.dataset.nom;
            const ue = tr.dataset.ueId;
            const matchTexte = !texte || nom.includes(texte);
            const matchUe = !ueId || ue === ueId;
            const visible = matchTexte && matchUe;
            tr.style.display = visible ? '' : 'none';
            if (visible) visibles++;
        });

        ligneAucun.style.display = visibles === 0 ? '' : 'none';
    }

    filtreTexte.addEventListener('input', appliquerFiltres);
    filtreUe.addEventListener('change', appliquerFiltres);
});
</script>
@endsection
