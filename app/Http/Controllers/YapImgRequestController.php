<?php

namespace App\Http\Controllers;

use App\Services\YgoApiProxyService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class YapImgRequestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $size, string $id, YgoApiProxyService $yaps): BinaryFileResponse
    {
        $imgPath = $yaps->getCardImage($id, $size);

        if ($imgPath === null) {
            // Return 404 response when image is not available
            abort(404, 'Image not found');
        }

        return response()->file($imgPath);
    }
}
