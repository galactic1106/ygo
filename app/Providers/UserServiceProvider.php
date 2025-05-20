<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class UserServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		$this->app->bind(UserService::class, function ($app) {
			return new UserService();
		});
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		/*
			  // Log when a User is created
			  User::created(function ($user) {
				  Log::info("User created: ", ['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);
			  });

			  // Log when a User is updated
			  User::updated(function ($user) {
				  Log::info("User updated: ", ['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);
			  });

			  // Log when a User is deleted
			  User::deleted(function ($user) {
				  Log::info("User deleted: ", ['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);
			  });

			  // Log when a User is retrieved
			  User::retrieved(function ($user) {
				  Log::info("User retrieved: ", ['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);
			  });
			  */
	}
}