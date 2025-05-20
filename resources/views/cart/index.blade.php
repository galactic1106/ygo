{{-- filepath: resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Your Cart</h2>
        @if ($cart && $cart->offers->count())
            <table class="table table-bordered align-middle table-hover">
                <thead>
                    <tr>
                        <th>Card</th>
                        <th>Seller</th>
                        <th>Quality</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cart->offers as $offer)
                        <tr>
                            <td>
                                @if ($offer->card)
                                    <div class="d-flex align-items-center">
                                        <img src="" alt="" id="card-image-{{ $offer->card->id }}"
                                            style="width: 60px; height: auto;" class="me-2">
                                        <div>
                                            <strong id="card-name-{{ $offer->card->id }}"></strong><br>
                                            <small>#{{ $offer->card->id }}</small>
                                        </div>
                                        <script>
                                            $.ajax({
                                                url: "{{ route('api.request', ['id' => $offer->card->id]) }}",
                                                type: "GET",
                                                dataType: "json",
                                                data: {
                                                    id: {{ $offer->card->id }}
                                                },
                                                success: function(data) {
                                                    // Handle the response data
                                                    data = data.data[0];
                                                    console.log(data);
                                                    // Update the image source
                                                    $("#card-image-{{ $offer->card->id }}")
													.attr("src", '{{route('api.image')}}' +"?url="+data.card_images[0].image_url);
													// Update the card name and ID
													$("#card-name-{{ $offer->card->id }}").text(data.name);
                                                },
                                                error: function(xhr, status, error) {
                                                    // Handle errors
                                                    console.error(error);
                                                }
                                            })
                                        </script>
                                    </div>
                                @else
                                    <span class="text-muted">No card info</span>
                                @endif
                            </td>
                            <td>{{ $offer->user->name }}</td>
                            <td>{{ $offer->quality }}</td>
                            <td>${{ number_format($offer->price, 2) }}</td>
                            <td>{{ $offer->pivot->quantity }}</td>
                            <td>
                                @php
                                    $subtotal = $offer->price * $offer->pivot->quantity;
                                    $total += $subtotal;
                                @endphp
                                ${{ number_format($subtotal, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Total</th>
                        <th>${{ number_format($total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end">
                <a href="{{ route('checkout.show') }}" class="btn btn-success">Proceed to Checkout</a>
            </div>
        @else
            <div class="alert alert-info">Your cart is empty.</div>
        @endif
    </div>
@endsection
