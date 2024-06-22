<?php

namespace App\Policies;

use App\Models\User;

class SetupPolicy
{
    /**
     * Create a new policy instance.
     */
    public function view(User $user): bool
    {
        return $user->hasRole('client');
    }
}
