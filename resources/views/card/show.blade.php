{{-- filepath: /home/galactic1106/public_html/ygo/resources/views/card/show.blade.php --}}
@extends('layouts.app')

@section('title', $card ? $card['name'] : 'Card Not Found')
@section('location', $card ? $card['name'] : 'Card Not Found')
@section('body-begin')

@endsection
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
    <!-- Button trigger modal -->
    <div class="container py-4">
        @if ($card)
            <div class="row">
                <div class="col-md-4">
                    @if (isset($card['card_images']) && count($card['card_images']) > 1)
                        <div class="border border-2 border-warning rounded">
                            <div id="artworkCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($card['card_images'] as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ $image['image_url'] }}"
                                                alt="{{ $card['name'] }} artwork {{ $index + 1 }}"
                                                class="img-fluid rounded border">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <div class="btn-group w-50">
                                <button class="btn btn-warning bg-warning-subtle btn-outline-warning" type="button"
                                    data-bs-target="#artworkCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="btn btn-warning bg-warning-subtle btn-outline-warning" type="button"
                                    data-bs-target="#artworkCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    @else
                        <img src="{{ $card['card_images'][0]['image_url'] }}" alt="{{ $card['name'] }}"
                            class="img-fluid rounded border">
                    @endif
                </div>
                <div class="col-md-8">
                    <h2 class="fw-bold">{{ $card['name'] }}</h2>
                    <p class="text-muted mb-1">{{ $card['type'] }}</p>
                    <p>{{ $card['desc'] }}</p>
                    <ul class="list-group mb-5">
                        @if (isset($card['atk']))
                            <li class="list-group-item">ATK: {{ $card['atk'] }}</li>
                        @endif
                        @if (isset($card['def']))
                            <li class="list-group-item">DEF: {{ $card['def'] }}</li>
                        @endif
                        @if (isset($card['level']))
                            <li class="list-group-item">Level: {{ $card['level'] }}</li>
                        @endif
                        @if (isset($card['race']))
                            <li class="list-group-item">Type: {{ $card['race'] }}</li>
                        @endif
                        @if (isset($card['attribute']))
                            <li class="list-group-item">Attribute: {{ $card['attribute'] }}</li>
                        @endif
                    </ul>
                    <ul class="list-group w-25">
                        <button type="button"
                            class="list-group-item list-group-item-action border border-2 border-success bg-success-subtle fs-5 fw-semibold"
                            data-bs-toggle="modal" data-bs-target="#sell-modal">Sell</button>
                        <button type="button"
                            class="list-group-item list-group-item-action border border-2 border-info bg-info-subtle fs-5 fw-semibold"
                            data-bs-toggle="modal" data-bs-target="#deck-modal">Add to deck</button>
                        <button type="button"
                            class="list-group-item list-group-item-action border border-2 border-warning bg-warning-subtle fs-5 fw-semibold"
                            data-bs-toggle="modal" data-bs-target="#cart-modal">Add to cart</button>
                    </ul>
                </div>
            </div>
        @else
            <div class="alert alert-danger">
                Card not found.
            </div>
        @endif

        <!-- Add to Cart Modal -->
        <div class="modal fade" id="cart-modal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="cartModalLabel">Add "{{ $card['name'] }}" to Cart</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Image selection -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Select Card Image:</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($card['card_images'] as $index => $image)
                                        <div>
                                            <input type="radio" class="btn-check" name="selected_image"
                                                id="image{{ $index }}" value="{{ $image['image_url_cropped'] }}"
                                                data-image-number="{{ $index }}"
                                                {{ $index === 0 ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary p-1" for="image{{ $index }}">
                                                <img src="{{ route('api.image') }}?url={{ urlencode($image['image_url_cropped']) }}"
                                                    alt="Card Image {{ $index + 1 }}"
                                                    style="height: 120px; width: auto;"> {{-- Increased from 80px to 120px --}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Offers -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Available Offers:</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="offers-table">
                                        <thead>
                                            <tr>
                                                <th>Seller</th>
                                                <th>Price</th>
                                                <th>Available</th>
                                                <th>Select</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Offers will be rendered here by JS -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Quantity -->
                            <div class="mb-3">
                                <label for="quantity" class="form-label fw-semibold">Quantity:</label>
                                <input type="number" class="form-control" id="quantity" name="quantity"
                                    min="1" value="1" required>
                            </div>
                            <input type="hidden" name="card_id" value="{{ $card['id'] }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Add to Cart</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sell (Make an Offer) Modal -->
        <div class="modal fade" id="sell-modal" tabindex="-1" aria-labelledby="sellModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="{{ route('offer.make') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="sellModalLabel">Create Offer for "{{ $card['name'] }}"</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Select Card Image -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Select Card Image:</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($card['card_images'] as $index => $image)
                                        <div>
                                            <input type="radio" class="btn-check" name="image_number"
                                                id="sell-image{{ $index }}" value="{{ $index }}"
                                                {{ $index === 0 ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary p-1"
                                                for="sell-image{{ $index }}">
                                                <img src="{{ route('api.image') }}?url={{ urlencode($image['image_url_cropped']) }}"
                                                    alt="Card Image {{ $index + 1 }}"
                                                    style="height: 80px; width: auto;">
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Quality -->
                            <div class="mb-3">
                                <label for="sell-quality" class="form-label fw-semibold">Quality:</label>
                                <select class="form-select" id="sell-quality" name="quality" required>
                                    <option value="" disabled selected>Select quality</option>
                                    <!-- Options will be loaded by jQuery -->
                                </select>
                            </div>
                            <!-- Quantity -->
                            <div class="mb-3">
                                <label for="sell-quantity" class="form-label fw-semibold">Quantity:</label>
                                <input type="number" class="form-control" id="sell-quantity" name="card_quantity"
                                    min="1" value="1" required>
                            </div>
                            <!-- Price -->
                            <div class="mb-3">
                                <label for="sell-price" class="form-label fw-semibold">Price per Card ($):</label>
                                <input type="number" class="form-control" id="sell-price" name="price"
                                    min="0.01" step="0.01" required>
                            </div>
                            <!-- Description -->
                            <div class="mb-3">
                                <label for="sell-description" class="form-label fw-semibold">Description
                                    (optional):</label>
                                <textarea class="form-control" id="sell-description" name="description" rows="2"></textarea>
                            </div>
                            <input type="hidden" name="card_id" value="{{ $card['id'] }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Create Offer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                loadQualities('#sell-quality', '{{ route('api.qualities') }}');
                setupOfferModal(
                    {{ $card['id'] }},
                    'input[name="selected_image"]',
                    '#offers-table'
                );
            }, 300)
        </script>
    @endsection
