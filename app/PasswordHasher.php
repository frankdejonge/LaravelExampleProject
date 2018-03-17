<?php

namespace App;

use Illuminate\Contracts\Hashing\Hasher;

class PasswordHasher
{
    /**
     * @var Hasher
     */
    private $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function hash(string $password): string
    {
        return $this->hasher->make($password);
    }
}