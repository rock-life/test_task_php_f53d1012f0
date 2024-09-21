<?php

namespace App\Policies;

use App\Enums\UserTeamRoles;
use App\Models\Interfaces\TeamInterface;
use App\Models\Interfaces\UserInterface;
use App\Models\Team;
use App\Models\User;

class TeamPolicy
{

    public function create( UserInterface $user): bool
    {
        return !$user->teams()->where('role', '=', UserTeamRoles::Admin->value)->exists();
    }

    public function manage(UserInterface $user, TeamInterface $team){
        return $user->teams()->where('team_id', '=', $team->getId())->where('role', '=', UserTeamRoles::Admin->value)->exists() ;
    }
}
