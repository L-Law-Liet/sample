<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->is_active;
    }

    public function view(User $user, Product $product)
    {
        return $user->is_active;
    }
    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function update(User $user, Product $product): bool
    {
        return $user->isAdmin;
    }

    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->isAdmin;
    }

    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function claim(User $user, Product $product): bool
    {
        return $user->role_id == Role::ROLE_TECHNICIAN && is_null($product->user_id);
    }

    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function disclaim(User $user, Product $product): bool
    {
        return $user->id == $product->user_id;
    }

    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->is_active && $product->trashed();
    }

    public function makeReport(User $user, Product $product): bool
    {
        return $user->id == $product->user_id;
    }

    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function audit(User $user, Product $product): bool
    {
        return $user->isAdmin && $product->product_status_id == ProductStatus::FOR_AUDIT;
    }
}
