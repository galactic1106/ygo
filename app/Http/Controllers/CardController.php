<?php
namespace App\Http\Controllers;

use App\Services\YgoApiService;
use Illuminate\Http\Request;

class CardController extends Controller
{
	protected $ygoApiService;
	public function __construct(YgoApiService $ygoApiService)
	{
		$this->ygoApiService = $ygoApiService;
	}

	public function show($id)
	{
		$data = $this->ygoApiService->getCardData(['id' => $id]);
		$card = isset($data['data'][0]) ? $data['data'][0] : null;
		$data = $this->ygoApiService->getCardData(['name' => $card['name']]);
		$card = isset($data['data'][0]) ? $data['data'][0] : null;

		return view('card.show', ['card' => $card]);
	}
}
