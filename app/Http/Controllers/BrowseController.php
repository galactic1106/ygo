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
		if(count($param)==1 && $param['search-bar']=='')
		{
			return view('browse.index', ['cards' => []]);
		}
		$param['fname'] = $param['search-bar'];
		unset($param["search-bar"]);
		//return var_dump($param);
		$cards = $this->ygoApiService->getCardData($param)['data'];
		
		return view('browse.index', ['cards' => $cards]);
	}
}