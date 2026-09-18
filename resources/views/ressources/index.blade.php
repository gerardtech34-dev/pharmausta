@extends('layouts.user')

@section('content')
<div class="container py-4">
    <h1 class="fw-bold mb-4">Ressources pédagogiques</h1>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('ressources.index') }}" id="form-recherche" class="row g-3">
                <div class="col-md-6">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" name="titre" id="titre" class="form-control" value="{{ request('titre') }}" placeholder="Rechercher par titre...">
                </div>
                <div class="col-md-6">
                    <label for="mot_cle" class="form-label">Mot-clé</label>
                    <input type="text" name="mot_cle" id="mot_cle" class="form-control" value="{{ request('mot_cle') }}" placeholder="Rechercher dans le titre ou la description...">
                </div>
                <div class="col-md-4">
                    <label for="annee_academique_id" class="form-label">Année académique</label>
                    <select name="annee_academique_id" id="annee_academique_id" class="form-select">
                        <option value="">Toutes</option>
                        @foreach($anneesAcademiques as $annee)
                            <option value="{{ $annee->id }}" {{ request('annee_academique_id') == $annee->id ? 'selected' : '' }}>{{ $annee->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="niveau_id" class="form-label">Niveau</label>
                    <select name="niveau_id" id="niveau_id" class="form-select">
                        <option value="">Tous</option>
                        @foreach($niveaux as $niveau)
                            <option value="{{ $niveau->id }}" {{ request('niveau_id') == $niveau->id ? 'selected' : '' }}>{{ $niveau->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="ue_id" class="form-label">UE</label>
                    <select name="ue_id" id="ue_id" class="form-select">
                        <option value="">Toutes</option>
                        @foreach($ues as $ue)
                            <option value="{{ $ue->id }}" {{ request('ue_id') == $ue->id ? 'selected' : '' }}>{{ $ue->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="ecue_id" class="form-label">ECUE</label>
                    <select name="ecue_id" id="ecue_id" class="form-select" disabled>
                        <option value="">Sélectionnez d'abord une UE</option>
                        @if(request('ue_id') && request('ecue_id'))
                            @foreach($ecues->where('ue_id', request('ue_id')) as $ecue)
                                <option value="{{ $ecue->id }}" {{ request('ecue_id') == $ecue->id ? 'selected' : '' }}>{{ $ecue->nom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="type_ressource_id" class="form-label">Type de ressource</label>
                    <select name="type_ressource_id" id="type_ressource_id" class="form-select">
                        <option value="">Tous</option>
                        @foreach($typesRessources as $type)
                            <option value="{{ $type->id }}" {{ request('type_ressource_id') == $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <div id="zone-resultats">
        @include('ressources._resultats')
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-recherche');
    const zoneResultats = document.getElementById('zone-resultats');
    const ueSelect = document.getElementById('ue_id');
    const ecueSelect = document.getElementById('ecue_id');

    let debounceTimer = null;

    function chargerResultats() {
        const params = new URLSearchParams(new FormData(form)).toString();
        const url = form.action + '?' + params;

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            zoneResultats.innerHTML = data.html;
        })
        .catch(err => console.error(err));
    }

    function debounce(callback, delay) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(callback, delay);
    }

    form.querySelectorAll('input[type="text"]').forEach(el => {
        el.addEventListener('input', () => debounce(chargerResultats, 400));
    });

    form.querySelectorAll('select').forEach(el => {
        el.addEventListener('change', chargerResultats);
    });

    const ecuesRouteBase = "{{ route('ressources.ecuesParUe', ['ue' => '__ID__']) }}";

    function chargerEcues(ueId, ecueSelectionnee = null) {
        ecueSelect.innerHTML = '<option value="">Chargement...</option>';
        ecueSelect.disabled = true;

        if (!ueId) {
            ecueSelect.innerHTML = '<option value="">Sélectionnez d\'abord une UE</option>';
            return;
        }

        fetch(ecuesRouteBase.replace('__ID__', ueId))
            .then(r => r.json())
            .then(data => {
                if (data.length > 0) {
                    ecueSelect.innerHTML = '<option value="">Toutes</option>';
                    data.forEach(ecue => {
                        const opt = document.createElement('option');
                        opt.value = ecue.id;
                        opt.textContent = ecue.nom;
                        if (ecueSelectionnee && ecueSelectionnee == ecue.id) opt.selected = true;
                        ecueSelect.appendChild(opt);
                    });
                    ecueSelect.disabled = false;
                } else {
                    ecueSelect.innerHTML = '<option value="">Aucune ECUE pour cette UE</option>';
                }
            });
    }

    ueSelect.addEventListener('change', function() {
        chargerEcues(this.value);
    });

    if (ueSelect.value) {
        chargerEcues(ueSelect.value, "{{ request('ecue_id') }}");
    }
});
</script>
@endsection
