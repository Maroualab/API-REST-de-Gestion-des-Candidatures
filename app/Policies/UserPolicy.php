<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, User $model)
    {
        return $user->id === $model->id || $user->hasRole('admin');
    }

    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id || $user->hasRole('admin');
    }

    public function delete(User $user, User $model)
    {
        return $user->hasRole('admin');
    }
}