<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;

class UserApiController extends Controller
{
	protected $userService;

	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}

	public function create(Request $request)
	{
		$data = $request->all();
		$user = $this->userService->create($data);
		return response()->json($user, 201);
	}
	public function update(Request $request, User $user)
	{
		$data = $request->all();
		$this->userService->update($user, $data);
		return response()->json($user->fresh(), 200);
	}
	public function delete(User $user)
	{
		$this->userService->delete($user);
		return response()->json(null, 204);
	}
	public function all()
	{
		$users = $this->userService->all();
		return response()->json($users, 200);
	}
	public function find(User $user)
	{
		return response()->json($user, 200);
	}
}