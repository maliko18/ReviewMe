<?php
// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('manage roles');

        return Inertia::render('Admin/Roles/Index', [
            'roles' => Role::with('permissions')->get(),
            'permissions' => Permission::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('manage roles');

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array'
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return redirect()->back()->with('success', 'Role created successfully');
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('manage roles');

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'required|array'
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return redirect()->back()->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        $this->authorize('manage roles');

        if ($role->name === 'super-admin') {
            return redirect()->back()->with('error', 'Cannot delete super-admin role');
        }

        $role->delete();

        return redirect()->back()->with('success', 'Role deleted successfully');
    }
}
