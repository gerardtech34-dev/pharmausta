<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UeRequest;
use App\Models\Ue;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:gerer-referentiels'),
        ];
    }

    public function index(Request $request)
    {
        $ues = Ue::with('niveau')->orderBy('niveau_id')->orderBy('nom')->get();
        if ($request->expectsJson()) {
            return response()->json($ues);
        }
        $niveaux = Niveau::orderBy('nom')->get();
        return view('admin.ues.index', compact('ues', 'niveaux'));
    }

    public function create()
    {
        $niveaux = Niveau::orderBy('nom')->get();
        return view('admin.ues.create', compact('niveaux'));
    }

    public function store(UeRequest $request)
    {
        Ue::create($request->validated());
        session()->flash('success', 'UE créée avec succès.');
        return redirect()->route('admin.ues.index');
    }

    public function edit(Ue $ue)
    {
        $niveaux = Niveau::orderBy('nom')->get();
        return view('admin.ues.edit', compact('ue', 'niveaux'));
    }

    public function update(UeRequest $request, Ue $ue)
    {
        $ue->update($request->validated());
        session()->flash('success', 'UE modifiée avec succès.');
        return redirect()->route('admin.ues.index');
    }

    public function destroy(Ue $ue)
    {
        $ue->delete();
        session()->flash('success', 'UE supprimée avec succès.');
        return redirect()->route('admin.ues.index');
    }
}
