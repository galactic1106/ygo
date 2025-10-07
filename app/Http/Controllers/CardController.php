<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardDataRequest;
use App\Services\YgoApiProxyService;
use Inertia\Inertia;
use Inertia\Response;

class CardController extends Controller
{
    private YgoApiProxyService $yaps;

    public function __construct(YgoApiProxyService $yaps)
    {
        $this->yaps = $yaps;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CardDataRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $card = $this->yaps->getCardData(['id' => $id])['data'][0];

        return Inertia::render('Card', ['card' => $card ?? []]);
    }
}
