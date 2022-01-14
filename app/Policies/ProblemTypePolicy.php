<?php

namespace App\Policies;

use App\Models\ProblemType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProblemTypePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->is_active;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->is_active;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->is_active;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->is_active;
    }

    /**
     * @param User $user
     * @param ProblemType $problemType
     * @return bool
     */
    public function restore(User $user, ProblemType $problemType): bool
    {
        return $user->is_active && $problemType->trashed();
    }

}
