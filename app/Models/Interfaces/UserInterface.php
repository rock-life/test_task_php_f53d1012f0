<?php

namespace App\Models\Interfaces;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface UserInterface
{
    public function getId(): int;

    public function getName(): string;

    public function setName(string $name): UserInterface;

    public function getEmail(): string;

    public function getHashedPassword(): string;

    public function setEmail(string $email): UserInterface;

    public function createToken(string $name, array $abilities = ['*'], DateTimeInterface $expiresAt = null);

    public function teams(): BelongsToMany;

}
