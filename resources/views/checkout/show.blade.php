@extends('layouts.app')

@section('title', 'Checkout')
@section('location', 'Checkout')

@section('messages')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endsection

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Checkout</h2>
    @if ($cart && $cart->offers->count())
        <div class="card mb-4">
            <div class="card-header fw-bold">
                Order Summary
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
                        @foreach ($cart->offers as $offer)
                            @php
                                $subtotal = $offer->pivot->quantity * $offer->price;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>
                                    #{{ $offer->card->id}}
                                </td>
                                <td>
                                    {{ $offer->user->name}}
                                </td>
                                <td>
                                    {{ $offer->pivot->quantity }}
                                </td>
                                <td>
                                    ${{ number_format($offer->price, 2) }}
                                </td>
                                <td>
                                    ${{ number_format($subtotal, 2) }}
                                </td>
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

        <div class="card">
            <div class="card-header fw-bold">
                Shipping & Payment Information
            </div>
            <div class="card-body">
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <h5 class="mb-3">Shipping Details</h5>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" required maxlength="64" placeholder="Country">
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" required maxlength="64" placeholder="City">
                    </div>
                    <div class="mb-3">
                        <label for="street" class="form-label">Street</label>
                        <input type="text" class="form-control" id="street" name="street" required maxlength="128" placeholder="Street">
                    </div>
                    <div class="mb-3">
                        <label for="house_number" class="form-label">House Number</label>
                        <input type="text" class="form-control" id="house_number" name="house_number" required maxlength="16" placeholder="House Number">
                    </div>
                    <div class="mb-3">
                        <label for="zip_code" class="form-label">ZIP Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" required maxlength="16" placeholder="ZIP Code">
                    </div>
                    <hr>
                    <h5 class="mb-3">Payment Details</h5>
                    <div class="mb-3">
                        <label for="card_number" class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" required maxlength="19" placeholder="1234 5678 9012 3456">
                    </div>
                    <div class="mb-3">
                        <label for="card_expiration" class="form-label">Expiration Date</label>
                        <input type="text" class="form-control" id="card_expiration" name="card_expiration" required maxlength="7" placeholder="MM/YYYY">
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" required maxlength="4" placeholder="123">
                    </div>
                    <button type="submit" class="btn btn-success">Complete Purchase</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Your cart is empty.
        </div>
    @endif
</div>
@endsection