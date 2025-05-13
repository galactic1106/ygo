<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{

		if (!Storage::disk('public')->exists('images/cards/6983839.jpg')) {
			$responce = Http::get(url: 'https://images.ygoprodeck.com/images/cards/6983839.jpg');
			Storage::disk('public')->put('images/cards/6983839.jpg', $responce->body());
		}

		$img_url = asset('storage/images/cards/6983839.jpg');


		return view('home', ['img' => $img_url]);
	}
}
