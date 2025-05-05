<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserProcedure;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserProcedurePolicy
{
    use HandlesAuthorization;

    public function view(User $user, UserProcedure $userProcedure)
    {
        return $user->id === $userProcedure->user_id || $user->role === 'admin';
    }
    public function update(User $user, UserProcedure $userProcedure)
    {
        return $user->id === $userProcedure->user_id || $user->role === "admin";
    }
    public function delete(User $user, UserProcedure $userProcedure)
    {
        return $user->id === $userProcedure->user_id;
    }
}
