<?php

namespace App\Repositories;

use App\DTO\NewUserDTO;
use App\Models\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function create(NewUserDTO $newUserDTO): UserInterface
    {
        return User::query()->create([
            'name' => $newUserDTO->getName(),
            'email' => $newUserDTO->getEmail(),
            'password' => Hash::make($newUserDTO->getPassword()),
        ]);
    }

    public function getUserByEmail(mixed $email): UserInterface
    {
        return User::query()->where('email', $email)->firstOrFail();
    }

}
