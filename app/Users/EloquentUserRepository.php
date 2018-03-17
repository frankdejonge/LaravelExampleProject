<?php

namespace App\Users;

use App\User;

class EloquentUserRepository implements UserRepository
{
    public function store(User $user)
    {
        $user->save();
    }

    public function findByEmail(string $email): User
    {
        $user = User::where('email', $email)->first();

        if ( ! $user instanceof User) {
            throw new SorryUserNotFound();
        }

        return $user;
    }
}