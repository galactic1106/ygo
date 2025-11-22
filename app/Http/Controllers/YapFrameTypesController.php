<?php

namespace App\Http\Controllers;

use App\Services\YgoApiProxyService;

class YapFrameTypesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return array<int, string>
     */
    public function __invoke(YgoApiProxyService $yaps): array
    {
        return $yaps->getFrameTypes();
    }
}
