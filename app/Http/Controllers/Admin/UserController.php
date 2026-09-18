<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:gerer-utilisateurs'),
        ];
    }

    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('nom', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('matricule', 'like', "%{$q}%");
        }

        $users = $query->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.users.show', compact('user'));
    }

    public function toggleActive(User $user)
    {
        if ($user->hasRole('Administrateur')) {
            session()->flash('error', 'Ce compte ne peut pas être désactivé.');
            return redirect()->route('admin.users.index');
        }

        $user->actif = !$user->actif;
        $user->save();
        session()->flash('success', 'Statut du compte modifié avec succès.');
        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('Administrateur')) {
            session()->flash('error', 'Ce compte ne peut pas être supprimé.');
            return redirect()->route('admin.users.index');
        }

        $user->delete();
        session()->flash('success', 'Utilisateur supprimé avec succès.');
        return redirect()->route('admin.users.index');
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role_ids' => ['required', 'array'],
            'role_ids.*' => ['exists:roles,id'],
        ]);

        $roleNames = Role::whereIn('id', $request->input('role_ids'))->pluck('name')->toArray();
        $user->syncRoles($roleNames);

        session()->flash('success', 'Rôles assignés avec succès.');
        return redirect()->route('admin.users.show', $user);
    }
}
