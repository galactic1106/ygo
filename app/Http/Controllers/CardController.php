<?php

namespace App\Http\Controllers;

use App\Services\YgoApiProxyService;
use App\Http\Requests\CardDataRequest;
use Inertia\Inertia;

class CardController extends Controller
{
    private YgoApiProxyService $yaps;

    function __construct(YgoApiProxyService $yaps)
    {
        $this->yaps=$yaps;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CardDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
     public function show(string $id)
         {
            $card=$this->yaps->getCardData(['id'=>$id])['data'][0];
            return Inertia::render('Card',['card'=>$card??[]]);
         }
}
