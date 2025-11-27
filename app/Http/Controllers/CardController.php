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
    public function index(CardDataRequest $request): Response
    {
        $cards = [];
        $validated = $request->validated();

        $meta = null;

        // Only fetch cards if there are search parameters
        if (!empty($validated)) {
            $response = $this->yaps->getCardData($validated);
            $cards = $response['data'] ?? [];
            $meta = $response['meta'] ?? null;
        }

        return Inertia::render('Browse', [
            'races' => $this->yaps->getRaces(),
            'types' => $this->yaps->getTypes(),
            'frameTypes' => $this->yaps->getFrameTypes(),
            'archetypes' => $this->yaps->getArchetypes(),
            'attributes' => $this->yaps->getAttributes(),
            'linkMarkers' => $this->yaps->getLinkMarkers(),
            'formats' => $this->yaps->getFormats(),
            'sortables' => $this->yaps->getSortables(),
            'banLists' => $this->yaps->getBanLists(),
            'regions' => $this->yaps->getRegions(),
            'cards' => $cards,
            'filters' => $validated,
            'meta' => $meta,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $card = $this->yaps->getCardData(['id' => $id])['data'][0];
        //get other versions of the card
        //
        if($card){ $other = $this->yaps->getCardData(["name" => $card["name"]])["data"][0]["card_images"]; }
        return Inertia::render('Card', ['card' => $card ?? [],"other"=>$other ?? []]);
    }
}
