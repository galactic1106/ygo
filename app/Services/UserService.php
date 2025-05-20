<?php

namespace App\Services;

use App\Models\User;

class UserService
{
	public function get($id)
	{
		return User::findOrFail($id);
	}

	public function create(array $data)
	{
		return User::create($data);
	}

	public function update(User $user, array $data)
	{
		return $user->update($data);
	}

	public function delete(User $user)
	{
		return $user ? $user->delete() : false;
	}

	public function all()
	{
		return User::all();
	}
}