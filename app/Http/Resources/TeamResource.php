<?php

namespace App\Http\Resources;

use App\Models\Interfaces\TeamInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var TeamInterface $team
         */
        $team = $this->resource;

        return [
            'id' => $team->getId(),
            'name' => $team->getName(),
        ];
    }
}
