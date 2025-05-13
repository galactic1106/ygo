<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class AccountController extends Controller
{
	protected $userService;
	public function __construct(UserService $userService)
	{
		$this->middleware('auth');
		$this->userService=$userService;
	}


	public function index()
	{

		$user = auth()->user();
		if(count($user->orders)>0)$orderCount=true;
		else $orderCount=false; 
		return view('account',['user'=>$user,'orderCount'=>$orderCount]);
	} 
}
