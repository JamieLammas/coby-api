<?php

namespace App\Policies;

use App\User;
use App\Hanger;
use Illuminate\Auth\Access\HandlesAuthorization;

class HangerPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Hanger $hanger)
    {
        return $user->ownsHanger($hanger);
    }

    public function destroy(User $user, Hanger $hanger)
    {
        return $user->ownsHanger($hanger);
    }
}
