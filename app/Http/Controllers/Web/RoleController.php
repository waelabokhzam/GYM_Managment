<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\role\UpdateRoleRequest;
use App\Services\Role\RoleService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function __construct(
        private RoleService $service
    ) {}

    public function index()
    {
        Gate::authorize('viewAny', Role::class);

        $roles = Role::withCount('users')->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        Gate::authorize('create', Role::class);

        $permissions = Permission::orderBy('name')->get();

        return view('roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('roles.index')
            ->with('success', 'تم إنشاء الصلاحية.');
    }

    public function show(Role $role)
    {
        Gate::authorize('view', Role::class);

        $role->load('permissions', 'users');

        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        Gate::authorize('update', Role::class);

        $permissions = Permission::orderBy('name')->get();

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->service->update($role, $request->validated());

        return redirect()->route('roles.index')
            ->with('success', 'تم تحديث الصلاحية.');
    }

    public function destroy(Role $role)
    {
        Gate::authorize('delete', Role::class);

        $this->service->delete($role);

        return redirect()->route('roles.index')
            ->with('success', 'تم حذف الصلاحية.');
    }
}