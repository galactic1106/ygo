<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getUserById($id)
    {
        return User::find($id);
    }
    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser(User $user, array $data)
    {
        return $user->update($data);
    }

    public function deleteUser(User $user)
    {
        return $user ? $user->delete() : false;
    }
}