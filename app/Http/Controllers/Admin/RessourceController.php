<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RessourceRequest;
use App\Models\AnneeAcademique;
use App\Models\Ecue;
use App\Models\Niveau;
use App\Models\Ressource;
use App\Models\TypeRessource;
use App\Models\Ue;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class RessourceController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:gerer-ressources'),
        ];
    }

    public function index(Request $request)
    {
        $query = Ressource::with(['anneeAcademique', 'niveau', 'ue', 'ecue', 'typeRessource']);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('annee_academique_id')) {
            $query->where('annee_academique_id', $request->annee_academique_id);
        }

        if ($request->filled('niveau_id')) {
            $query->where('niveau_id', $request->niveau_id);
        }

        if ($request->filled('ue_id')) {
            $query->where('ue_id', $request->ue_id);
        }

        if ($request->filled('ecue_id')) {
            $query->where('ecue_id', $request->ecue_id);
        }

        if ($request->filled('type_ressource_id')) {
            $query->where('type_ressource_id', $request->type_ressource_id);
        }

        $ressources = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        $anneesAcademiques = AnneeAcademique::orderBy('libelle')->get();
        $niveaux = Niveau::orderBy('nom')->get();
        $ues = Ue::orderBy('nom')->get();
        $ecues = Ecue::orderBy('nom')->get();
        $typesRessources = TypeRessource::orderBy('nom')->get();

        return view('admin.ressources.index', compact(
            'ressources',
            'anneesAcademiques',
            'niveaux',
            'ues',
            'ecues',
            'typesRessources'
        ));
    }

    public function create()
    {
        $anneesAcademiques = AnneeAcademique::orderBy('libelle')->get();
        $niveaux = Niveau::orderBy('nom')->get();
        $ues = Ue::orderBy('nom')->get();
        $ecues = Ecue::orderBy('nom')->get();
        $typesRessources = TypeRessource::orderBy('nom')->get();
        return view('admin.ressources.create', compact('anneesAcademiques', 'niveaux', 'ues', 'ecues', 'typesRessources'));
    }

    public function store(RessourceRequest $request)
    {
        $data = $request->validated();
        $data['statut'] = 'brouillon';

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('ressources', $filename, 'local');
            $data['fichier'] = $path;
        }

        Ressource::create($data);
        session()->flash('success', 'Ressource créée avec succès.');
        return redirect()->route('admin.ressources.index');
    }

    public function edit(Ressource $ressource)
    {
        $anneesAcademiques = AnneeAcademique::orderBy('libelle')->get();
        $niveaux = Niveau::orderBy('nom')->get();
        $ues = Ue::orderBy('nom')->get();
        $ecues = Ecue::orderBy('nom')->get();
        $typesRessources = TypeRessource::orderBy('nom')->get();
        return view('admin.ressources.edit', compact('ressource', 'anneesAcademiques', 'niveaux', 'ues', 'ecues', 'typesRessources'));
    }

    public function update(RessourceRequest $request, Ressource $ressource)
    {
        $data = $request->validated();

        if ($request->hasFile('fichier')) {
            if ($ressource->fichier) {
                Storage::disk('local')->delete($ressource->fichier);
            }
            $file = $request->file('fichier');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('ressources', $filename, 'local');
            $data['fichier'] = $path;
        }

        $ressource->update($data);
        session()->flash('success', 'Ressource modifiée avec succès.');
        return redirect()->route('admin.ressources.index');
    }

    public function publish(Ressource $ressource)
    {
        $ressource->update(['statut' => 'publie']);
        session()->flash('success', 'Ressource publiée avec succès.');
        return redirect()->route('admin.ressources.index');
    }

    public function retract(Ressource $ressource)
    {
        $ressource->update(['statut' => 'retire']);
        session()->flash('success', 'Ressource retirée avec succès.');
        return redirect()->route('admin.ressources.index');
    }

    public function destroy(Ressource $ressource)
    {
        if ($ressource->fichier) {
            Storage::disk('local')->delete($ressource->fichier);
        }
        $ressource->delete();
        session()->flash('success', 'Ressource supprimée avec succès.');
        return redirect()->route('admin.ressources.index');
    }
}
