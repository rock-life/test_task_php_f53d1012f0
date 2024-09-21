<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface TeamInterface
{
    public function getId(): int;
    public function getName(): string;

    public function setName(string $name): TeamInterface;

    public function users() :BelongsToMany;
}
