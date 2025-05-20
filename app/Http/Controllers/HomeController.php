<?php

namespace App\Http\Controllers;

use App\Services\YgoApiService;

class HomeController extends Controller
{
	protected $ygoApiService;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(YgoApiService $ygoApiService)
	{
		$this->ygoApiService = $ygoApiService;
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
	
		// Main Deck Monsters (excluding Extra Deck types)
		$monsterTypes = [
			'Normal Monster',
			'Effect Monster',
			'Ritual Monster',
			'Pendulum Effect Monster',
			'Pendulum Normal Monster',
			'Pendulum Tuner Effect Monster',
			'Spirit Monster',
			'Toon Monster',
			'Union Effect Monster',
			'Gemini Monster',
			'Tuner Monster'
		];

		// Extra Deck types
		$extraDeckTypes = [
			'Fusion Monster',
			'Synchro Monster',
			'Xyz Monster',
			'Link Monster',
			'Synchro Pendulum Effect Monster',
			'Fusion Pendulum Effect Monster'
		];

		// Monsters (main deck)
		$monsters = $this->ygoApiService->getCardData(params: [
			'offset' => 0,
			'num' => 12,
			'sort' => 'new',
			'type' => implode(',', $monsterTypes)
		]);
		$monsters = $monsters['data'] ?? [];

		// Spells
		$spells = $this->ygoApiService->getCardData(params: [
			'offset' => 0,
			'num' => 12,
			'sort' => 'new',
			'type' => 'Spell Card'
		]);
		$spells = $spells['data'] ?? [];

		// Traps
		$traps = $this->ygoApiService->getCardData(params: [
			'offset' => 0,
			'num' => 12,
			'sort' => 'new',
			'type' => 'Trap Card'
		]);
		$traps = $traps['data'] ?? [];

		// Extra Deck
		$extraDeck = collect();
		foreach ($extraDeckTypes as $type) {
			$result = $this->ygoApiService->getCardData(params: [
				'offset' => 0,
				'num' => 12,
				'sort' => 'new',
				'type' => $type
			]);
			$extraDeck = $extraDeck->concat($result['data'] ?? []);
		}
		$extraDeck = $extraDeck->unique('id')->take(12)->values();

		return view('home', compact('monsters', 'spells', 'traps', 'extraDeck'));
	}
}
