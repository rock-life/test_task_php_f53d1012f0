<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TeamsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'teams' => $this->collection->map(function ($team) {
                    return [
                        'id' => $team->id,
                        'name' => $team->name,
                        'role' => $team->pivot->role,
                    ];
                }),
            ];
    }
}
