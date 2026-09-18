<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:gerer-roles'),
        ];
    }

    public function index()
    {
        $roles = Role::withCount(['permissions', 'users'])->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        return view('admin.roles.show', compact('role'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->validated()['name']]);
        $role->syncPermissions($request->validated()['permissions'] ?? []);
        session()->flash('success', 'Rôle créé avec succès.');
        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        if ($role->name === 'Administrateur') {
            session()->flash('error', 'Ce rôle est protégé et ne peut pas être modifié ou supprimé.');
            return redirect()->route('admin.roles.index');
        }

        $role->name = $request->validated()['name'];
        $role->save();
        $role->syncPermissions($request->validated()['permissions'] ?? []);
        session()->flash('success', 'Rôle modifié avec succès.');
        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'Administrateur') {
            session()->flash('error', 'Ce rôle est protégé et ne peut pas être modifié ou supprimé.');
            return redirect()->route('admin.roles.index');
        }

        $role->delete();
        session()->flash('success', 'Rôle supprimé avec succès.');
        return redirect()->route('admin.roles.index');
    }
}
