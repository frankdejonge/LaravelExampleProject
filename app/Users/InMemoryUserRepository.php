<?php

namespace App\Users;

use App\User;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private $users = [];

    public function store(User $user)
    {
        $this->users[$user->email] = $user;
    }

    public function findByEmail(string $email): User
    {
        if ( ! isset($this->users[$email])) {
            throw new SorryUserNotFound();
        }

        return $this->users[$email];
    }
}