<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardDataRequest;
use App\Services\YgoApiProxyService;

class YapRequestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CardDataRequest $request, YgoApiProxyService $yaps): ?array
    {
        $response = $yaps->getCardData($request->validated());
        if ($response) {
            return $response;
        }

        return [];
    }
}
