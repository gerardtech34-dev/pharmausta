<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use App\Models\Ressource;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:gerer-ressources|gerer-referentiels|gerer-utilisateurs|gerer-roles|gerer-actualites|voir-statistiques'),
        ];
    }

    public function index()
    {
        $nbUtilisateurs = User::count();
        $nbUtilisateursActifs = User::where('actif', true)->count();
        $nbRessourcesTotal = Ressource::count();
        $nbActualitesPublies = Actualite::where('statut', 'publie')->count();

        $statutsParDefaut = [
            'brouillon' => 0,
            'publie' => 0,
            'retire' => 0,
        ];

        $resultat = Ressource::select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->pluck('total', 'statut')
            ->toArray();

        $ressourcesParStatut = array_merge($statutsParDefaut, $resultat);

        $ressourcesParAnnee = Ressource::join('annees_academiques', 'ressources.annee_academique_id', '=', 'annees_academiques.id')
            ->select('annees_academiques.libelle', DB::raw('count(*) as total'))
            ->groupBy('annees_academiques.libelle')
            ->get();

        $topRessources = Ressource::where('telechargements', '>', 0)
            ->orderByDesc('telechargements')
            ->limit(5)
            ->get(['id', 'titre', 'telechargements']);

        return view('admin.dashboard', compact(
            'nbUtilisateurs',
            'nbUtilisateursActifs',
            'nbRessourcesTotal',
            'nbActualitesPublies',
            'ressourcesParStatut',
            'ressourcesParAnnee',
            'topRessources'
        ));
    }
}
