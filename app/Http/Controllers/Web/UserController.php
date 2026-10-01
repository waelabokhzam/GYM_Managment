<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(
        private UserService $service
    ) {}

    /**
     * عرض المستخدمين.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', User::class);

        $users = User::query()
            ->with([
                'roles',
                'player',
                'staff',
            ])
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {

                    $search = $request->search;

                    $query->where(function ($query) use ($search) {

                        $query
                            ->where('fullname', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");

                    });
                }
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'users.index',
            compact('users')
        );
    }

    /**
     * صفحة إنشاء مستخدم.
     */
    public function create()
    {
        Gate::authorize('create', User::class);

        $roles = Role::query()
            ->where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view(
            'users.create',
            compact('roles')
        );
    }

    /**
     * إنشاء مستخدم.
     */
    public function store(StoreUserRequest $request)
    {
        $this->service->create(
            $request->validated()
        );

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'تم إنشاء المستخدم بنجاح.'
            );
    }

    /**
     * عرض المستخدم.
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user);

        $user->load([
            'roles',
            'player',
            'staff',
        ]);

        return view(
            'users.show',
            compact('user')
        );
    }

    /**
     * صفحة تعديل المستخدم.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        $user->load([
            'roles',
            'player',
            'staff',
        ]);

        $roles = Role::query()
            ->where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view(
            'users.edit',
            compact('user', 'roles')
        );
    }

    /**
     * تحديث المستخدم.
     */
    public function update(
        UpdateUserRequest $request,
        User $user
    ) {
        $this->service->update(
            $user,
            $request->validated()
        );

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'تم تحديث بيانات المستخدم بنجاح.'
            );
    }

    /**
     * حذف المستخدم.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $this->service->delete($user);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'تم حذف المستخدم بنجاح.'
            );
    }
}