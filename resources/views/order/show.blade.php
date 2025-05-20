@extends('layouts.app')

@section('title', 'Order Details')
@section('location', 'Order Details')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Order #{{ $order->id }}</h2>
    <div class="card mb-4">
        <div class="card-header fw-bold">
            Order Information
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($order->state) }}</li>
                <li class="list-group-item"><strong>Order Date:</strong> {{ $order->order_date ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Shipping Address:</strong>
                    {{ $order->street ?? '' }} {{ $order->house_number ?? '' }},
                    {{ $order->city ?? '' }}, {{ $order->country ?? '' }} {{ $order->zip_code ?? '' }}
                </li>
                <li class="list-group-item"><strong>Paid with:</strong>
                    @if($order->creditCard && $order->creditCard->card_number)
                        ****-****-{{ $order->creditCard->card_number }}
                        (Exp: {{ $order->creditCard->expiration_date }})
                    @else
                        N/A
                    @endif
                </li>
            </ul>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-bold">
            Items in this Order
        </div>
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Card</th>
                        <th>Seller</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($order->offers as $offer)
                        @php
                            $subtotal = $offer->pivot->quantity * $offer->price;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $offer->card->name ?? 'Unknown' }}</td>
                            <td>{{ $offer->user->name ?? 'Unknown' }}</td>
                            <td>{{ $offer->pivot->quantity }}</td>
                            <td>${{ number_format($offer->price, 2) }}</td>
                            <td>${{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Total</td>
                        <td class="fw-bold">${{ number_format($total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('account.index') }}" class="btn btn-secondary">Back to Account</a>
</div>
@endsection