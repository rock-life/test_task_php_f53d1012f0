<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserToTeam;
use App\Http\Requests\CreateTeam;
use App\Http\Resources\TeamResource;
use App\Http\Resources\TeamsCollection;
use App\Models\Interfaces\UserInterface;
use App\Models\Team;
use App\Models\User;
use App\Repositories\TeamRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller
{
    private TeamRepository $repository;

    public function __construct()
    {
        $this->repository = new TeamRepository();
    }

    public function create(CreateTeam $request)
    {
        $user = Auth()->user();
        $this->authorize('create', Team::class);
        $validated = $request->validated();

        $team = $this->repository->create($validated['name'], $user);

        return new TeamResource($team);
    }

    public function getUserTeams()
    {
        /**
         * @var UserInterface $user
         */
        $user = Auth()->user();

        $collection = $user->teams()->withPivot('role')->get();

        return new TeamsCollection($collection);
    }

    public function addUserToTeam(int $teamId, AddUserToTeam $request)
    {
        $validated = $request->validated();
        $team = Team::query()->find($teamId);

        $allows = Gate::allows('manage', $team);

        if (!$allows) {
            return new JsonResponse('You have no permission to add a user to the team', JsonResponse::HTTP_FORBIDDEN);
        }

        $this->repository->addUserToTeam($team, User::query()->find($validated['user_id']));
        return new JsonResponse();
    }

    public function deleteUserFromTeam(int $team_id, int $user_id)
    {
        $team = Team::query()->find($team_id);
        /**
         * @var UserInterface $user
         */
        $user = User::query()->find($user_id);
        if (!$user) {
            return new JsonResponse( 'User is not a member of this team.', 404);
        }
        $allows = Gate::allows('manage', $team);

        if (!$allows || $user->getId() == Auth()->user()->id) {
            return new JsonResponse('You have no delete the user from the team', JsonResponse::HTTP_FORBIDDEN);
        }
        $this->repository->removeUserFromTeam($team, $user);
        return new JsonResponse();
    }
}
