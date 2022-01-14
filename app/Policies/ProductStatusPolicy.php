<?php

namespace App\Policies;

use App\Models\ProductStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductStatusPolicy
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
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductStatus  $productStatus
     * @return mixed
     */
    public function view(User $user, ProductStatus $productStatus)
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
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductStatus  $productStatus
     * @return mixed
     */
    public function update(User $user, ProductStatus $productStatus)
    {
        return $user->isAdmin && $productStatus->created_at;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductStatus  $productStatus
     * @return mixed
     */
    public function delete(User $user, ProductStatus $productStatus)
    {
        return $user->isAdmin && $productStatus->created_at;
    }

    /**
     * @param User $user
     * @param ProductStatus $status
     * @return bool
     */
    public function restore(User $user, ProductStatus $status): bool
    {
        return $user->isAdmin && $status->trashed();
    }
}
