<?php

namespace App\Http\Controllers;

use GuzzleHttp\Middleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Order;

class OrderController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show($id)
    {
        $order = Order::with(['offers.card', 'offers.user', 'creditCard'])->findOrFail($id);

        // Optionally, check if the authenticated user owns this order
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Unauthorized');
        }

        return view('order.show', compact('order'));
    }
}
