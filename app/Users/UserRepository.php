<?php


namespace App\Users;

use App\User;

interface UserRepository
{
    public function store(User $user);
    public function findByEmail(string $email): User;
}