<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardDataRequest;
use App\Services\YgoApiProxyService;
use Illuminate\Http\JsonResponse;

class YapRequestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CardDataRequest $request, YgoApiProxyService $yaps): JsonResponse
    {
        try {
            $response = $yaps->getCardData($request->validated());
            // Return proper JSON response with status
            if (empty($response)) {
                return response()->json([
                    'data' => [],
                    'message' => 'No cards found'
                ], 200);
            }

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch card data',
                'message' => config('app.debug') ? $e->getMessage() : 'An error occurred'
            ], 500);
        }
    }
}
