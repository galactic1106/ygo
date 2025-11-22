<?php

namespace App\Http\Controllers;

use App\Services\YgoApiProxyService;
use Illuminate\Http\Request;

class YapRacesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return array<int, string>
     */
    public function __invoke(Request $request, YgoApiProxyService $yaps): array
    {
        $cardType = $request->get('type', 'all');

        return $yaps->getRaces($cardType);
    }
}
