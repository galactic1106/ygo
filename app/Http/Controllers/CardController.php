<?php
namespace App\Http\Controllers;

use App\Services\YgoApiService;
use Illuminate\Http\Request;

class CardController extends Controller
{
	public function show($api_id, YgoApiService $ygoApiService)
	{
		$data = $ygoApiService->getCardData(['id' => $api_id]);
		$card = isset($data['data'][0]) ? $data['data'][0] : null;
		return view('card.show', ['card' => $card]);
	}
}
