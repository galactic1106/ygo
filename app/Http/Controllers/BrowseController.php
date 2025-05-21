<?php

namespace App\Http\Controllers;

use App\Services\YgoApiService;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
	protected $ygoApiService;
	public function __construct(YgoApiService $ygoApiService)
	{
		$this->ygoApiService = $ygoApiService;
	}
	
	public function index(Request $request)
	{
		$param = $request->all();
		if (isset($param['search-bar'])) {
			$param['fname'] = $param['search-bar'];
			unset($param['search-bar']);
		}
		if (!isset($param['num'])) {
			$param['num'] = 40;
		}
		if (!isset($param['offset'])) {
			$param['offset'] = 0;
		}

		$cards = [];
		$cards = $this->ygoApiService->getCardData($param);
		$cards = isset($cards['data']) ? $cards['data'] : [];	

		$archetypes = $this->ygoApiService->getArchetypes();
		$attributes = $this->ygoApiService->getAttributes();
		$types = $this->ygoApiService->getTypes();
		$races = $this->ygoApiService->getRaces(); 

		return view('browse.index', [
			'cards' => $cards,
			'archetypes' => $archetypes,
			'attributes' => $attributes,
			'types' => $types,
			'races' => $races, 
		]);
	}
}