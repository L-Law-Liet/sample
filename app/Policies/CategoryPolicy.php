<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->isAdmin;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->isAdmin;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->isAdmin;
    }

    /**
     * @param User $user
     * @param Category $category
     * @return bool
     */
    public function restore(User $user, Category $category): bool
    {
        return $user->isAdmin && $category->trashed();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->isAdmin;
    }
}
