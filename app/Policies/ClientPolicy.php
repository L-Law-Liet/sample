<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
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
     * @param Client $client
     * @return bool
     */
    public function restore(User $user, Client $client): bool
    {
        return $user->is_active && $client->trashed();
    }
}
