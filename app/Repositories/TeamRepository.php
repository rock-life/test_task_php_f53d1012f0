<?php

namespace App\Repositories;

use App\Enums\UserTeamRoles;
use App\Models\Interfaces\TeamInterface;
use App\Models\Interfaces\UserInterface;
use App\Models\Team;
use App\Models\User;
use Ramsey\Uuid\Type\Time;

class TeamRepository
{

    public function create(mixed $name, UserInterface $admin): TeamInterface
    {
        $team = Team::query()->create(['name' => $name]);
        $team->users()->attach($admin, ['role' => UserTeamRoles::Admin->value]);
        return $team;
    }

    public function addUserToTeam(TeamInterface $team, UserInterface $user)
    {
        $team->users()->attach($user->getId(), ['role' => UserTeamRoles::User->value]);

    }

    public function removeUserFromTeam(TeamInterface $team, UserInterface $user)
    {
        $team->users()->detach($user);
    }
}
