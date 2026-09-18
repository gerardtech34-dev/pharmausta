<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Models\Ecue;
use App\Models\Niveau;
use App\Models\Ressource;
use App\Models\Ue;

class ArborescenceController extends Controller
{
    public function index()
    {
        $anneesAcademiques = AnneeAcademique::whereHas('ressources', function ($query) {
            $query->where('statut', 'publie');
        })->orderBy('libelle')->get();

        return view('arborescence.annees', compact('anneesAcademiques'));
    }

    public function niveaux(AnneeAcademique $anneeAcademique)
    {
        $niveaux = Niveau::whereHas('ressources', function ($query) use ($anneeAcademique) {
            $query->where('statut', 'publie')
                  ->where('annee_academique_id', $anneeAcademique->id);
        })->orderBy('nom')->get();

        return view('arborescence.niveaux', compact('anneeAcademique', 'niveaux'));
    }

    public function ues(AnneeAcademique $anneeAcademique, Niveau $niveau)
    {
        $ues = Ue::whereHas('ressources', function ($query) use ($anneeAcademique, $niveau) {
            $query->where('statut', 'publie')
                  ->where('annee_academique_id', $anneeAcademique->id)
                  ->where('niveau_id', $niveau->id);
        })->orderBy('nom')->get();

        return view('arborescence.ues', compact('anneeAcademique', 'niveau', 'ues'));
    }

    public function ecues(AnneeAcademique $anneeAcademique, Niveau $niveau, Ue $ue)
    {
        if ($ue->ecues()->count() === 0) {
            return redirect()->route('arborescence.ressources', [
                'anneeAcademique' => $anneeAcademique,
                'niveau' => $niveau,
                'ue' => $ue,
                'ecue' => null,
            ]);
        }

        $ecues = Ecue::where('ue_id', $ue->id)
            ->whereHas('ressources', function ($query) use ($anneeAcademique, $niveau, $ue) {
                $query->where('statut', 'publie')
                      ->where('annee_academique_id', $anneeAcademique->id)
                      ->where('niveau_id', $niveau->id)
                      ->where('ue_id', $ue->id);
            })
            ->orderBy('nom')
            ->get();

        return view('arborescence.ecues', compact('anneeAcademique', 'niveau', 'ue', 'ecues'));
    }

    public function ressources(AnneeAcademique $anneeAcademique, Niveau $niveau, Ue $ue, ?Ecue $ecue = null)
    {
        $ressources = Ressource::where('statut', 'publie')
            ->where('annee_academique_id', $anneeAcademique->id)
            ->where('niveau_id', $niveau->id)
            ->where('ue_id', $ue->id)
            ->when($ecue, function ($query) use ($ecue) {
                $query->where('ecue_id', $ecue->id);
            }, function ($query) {
                $query->whereNull('ecue_id');
            })
            ->with(['anneeAcademique', 'niveau', 'ue', 'ecue', 'typeRessource'])
            ->paginate(12);

        return view('arborescence.ressources', compact('anneeAcademique', 'niveau', 'ue', 'ecue', 'ressources'));
    }
}
