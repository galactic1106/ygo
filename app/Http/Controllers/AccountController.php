<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
	protected $userService;
	public function __construct(UserService $userService)
	{
		$this->middleware('auth');
		$this->userService = $userService;
	}

	public function index()
	{

		$user = auth()->user();
		$user->load(['orders.creditCard']);
		if (count($user->orders) > 0)
			$orderCount = true;
		else
			$orderCount = false;
		//return response()->json($user);
		return view('account', ['user' => $user, 'orderCount' => $orderCount]);
	}

	public function edit(Request $request, $id)
	{
		$request->validate([
			'updating' => 'required|string',
			'new-name' => 'nullable|string|max:255',
			'new-email' => 'nullable|string|email|max:255|unique:users,email,' . auth()->user()->id,
			'new-password' => 'nullable|string|min:8|confirmed', // 'confirmed' ensures passwords match
			'new-password_confirmation' => 'nullable|string|min:8', // This is the confirmation field
			'new-phone-number' => 'nullable|numeric|digits_between:1,20',

		]);
		if (auth()->user()->id != $id)
			return redirect()->route('account.index')->with('error', 'mismatch id error');

		switch ($request->input('updating')) {
			case 'name':
				$name = $request->input('new-name');
				$this->userService->update(auth()->user(), ['name' => $name]);
				break;

			case 'email':
				$email = $request->input('new-email');
				$this->userService->update(auth()->user(), ['email' => $email]);
				break;

			case 'password':
				$password = $request->input('new-password');
				$this->userService->update(auth()->user(), ['password' => Hash::make($password)]);
				break;

			case 'phone-number':
				$phoneNumber = $request->input('new-phone-number');
				$this->userService->update(auth()->user(), ['phone_number' => $phoneNumber]);
				break;
		}
		return redirect()->route('account.index')->with('message', 'update successfull');
	}
	public function destroy(Request $request, $id)
	{
		$request->validate([
			'delete' => 'required|min:11|max:11|string'
		]);
		if (strcmp($request->input('delete'), 'DELETE USER') != 0)
			return redirect()->route('account.index')->with('error', 'confirmation string wrong');

		if (auth()->user()->id != $id)
			return redirect()->route('account.index')->with('error', 'mismatch id error');

		$this->userService->delete(auth()->user());
		return redirect()->route('home')->with('message','user deleted successfully');
	}
}
