<?php

namespace App\Policies\InternalRequests;

use App\Models\InternalRequest;
use App\Models\User;

class InternalRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('internal_requests.view');
    }

    public function view(User $user, InternalRequest $request): bool
    {
        if ($user->can('internal_requests.manage')) {
            return true;
        }

        return $request->requested_by === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('internal_requests.create');
    }

    public function update(User $user, InternalRequest $request): bool
    {
        if ($user->can('internal_requests.manage')) {
            return true;
        }

        return $request->requested_by === $user->id
            && $request->status === 'pending';
    }

    public function delete(User $user, InternalRequest $request): bool
    {
        if ($user->can('internal_requests.manage')) {
            return true;
        }

        return $request->requested_by === $user->id
            && $request->status === 'pending';
    }
}