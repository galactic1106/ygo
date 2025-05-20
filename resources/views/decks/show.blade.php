@extends('layouts.app')

@section('title', $deck->name)
@section('location', $deck->name)

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">{{ $deck->name }}</h2>

        <!-- Edit Deck Name & Notes -->
        <div class="card mb-4">
            <div class="card-header fw-bold">
                Edit Deck Name & Notes
            </div>
            <div class="card-body">
                <form action="{{ route('decks.update', $deck->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="deck-name" class="form-label">Deck Name</label>
                        <input type="text" class="form-control" id="deck-name" name="name" value="{{ $deck->name }}"
                            required maxlength="64">
                    </div>
                    <div class="mb-3">
                        <label for="deck-notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="deck-notes" name="notes" maxlength="255" rows="2">{{ $deck->notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Deck</button>
                </form>
            </div>
        </div>

        <!-- Add Card to Deck -->
        <div class="card mb-4">
            <div class="card-header fw-bold">
                Add Card to Deck
            </div>
            <div class="card-body">
                <!-- Add Card to Deck Form -->
                <form action="{{ route('decks.addCard') }}" method="post">
                    @csrf
                    <input type="hidden" name="deck_id" value="{{ $deck->id }}">
                    <div class="mb-3">
                        <label for="card-search" class="form-label">Search Card</label>
                        <input type="text" class="form-control" id="card-search" placeholder="Type card name...">
                        <input type="hidden" id="card_id" name="card_id" required>
                        <div id="card-search-result" class="list-group position-absolute w-100" style="z-index: 10;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1"
                            max="3" value="1" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Card</button>
                </form>
            </div>
        </div>

        <!-- Cards in Deck -->
        <div class="card">
            <div class="card-header fw-bold">
                Cards in Deck
            </div>
            <div class="card-body">
                @if ($deck->cards->count())
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Card ID</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deck->cards as $index => $card)
                                <tr>
                                    <td>{{ $card->id }}</td>
                                    <td>
                                        <a href="{{ url('card.show', $card->id) }}" target="_blank"
                                            class="link link-info fw-bold">

                                            <img src="{{ route('api.image', ['url' => $cards[$index]['card_images'][0]['image_url_cropped']]) }}"
                                                alt="" class="p-0 border border-2 me-3 rounded border-warning"
                                                style="aspect-ratio: 1 / 1; object-fit: cover;object-position: top; height: 120px;">
                                            {{ $cards[$index]['name'] }}
                                        </a>
                                    </td>
                                    <td>{{ $card->pivot->quantity }}</td>
                                    <td>

                                        <!-- Remove Card from Deck Form (inside the cards table loop) -->
                                        <form action="{{ route('decks.removeCard') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="deck_id" value="{{ $deck->id }}">
                                            <input type="hidden" name="card_id" value="{{ $card->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class=" col-10 mb-1 btn btn-danger btn-sm"
                                                title="Remove one">
                                                Remove 1
                                            </button>
                                        </form>

                                        <form action="{{ route('decks.removeCard') }}" method="POST"> @csrf
                                            <input type="hidden" name="deck_id" value="{{ $deck->id }}">
                                            <input type="hidden" name="card_id" value="{{ $card->id }}">
                                            <input type="hidden" name="quantity" value="{{ $card->pivot->quantity }}">
                                            <button type="submit" class=" col-10 mb-1  btn btn-danger btn-sm"
                                                title="Remove all"
                                                onclick="return confirm('Remove all copies of this card from the deck?')">
                                                Remove All
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">
                        This deck has no cards yet.
                    </div>
                @endif
            </div>
        </div>
        <a href="{{ route('decks.index') }}" class="btn btn-secondary mt-4">Back to My Decks</a>
    </div>

    <script>
        $(document).ready(function() {
            function renderResults(data, showUrl, imageUrl, resultContainer) {
                data = data.data;
                resultContainer.html('');
                if (!data || !data.length) {
                    resultContainer.append('<div class="list-group-item">No results found.</div>');
                    return;
                }
                data.forEach(function(card) {
                    const cardName = card.name || 'Unknown';
                    const cardId = card.id;
                    const imgSrc = imageUrl + '?url=' + encodeURIComponent(card.card_images[0]
                        .image_url_cropped);
                    const cardUrl = showUrl.endsWith('/') ? showUrl + cardId : showUrl + '/' + cardId;
                    const item = $(`
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center" data-card-id="${cardId}" data-card-name="${cardName}">
                        <img src="${imgSrc}" alt="${cardName}" class="col-3 p-0 border border-0 m-0" style="aspect-ratio: 1 / 1; object-fit: cover;object-position: top;">
                        <span>${cardName}</span>
                    </a>`);
                    resultContainer.append(item);
                });

                // Click event for selecting a card
                resultContainer.off('click', 'a').on('click', 'a', function(e) {
                    e.preventDefault();
                    $('#card_id').val($(this).data('card-id'));
                    $('#card-search').val($(this).data('card-name'));
                    resultContainer.empty();
                });
            }

            $('#card-search').on('input click change', function() {
                fuzzyFind(
                    $('#card-search'),
                    '{{ route('api.request') }}',
                    function(data) {
                        renderResults(
                            data,
                            '{{ route('card.show', '') }}',
                            '{{ route('api.image') }}',
                            $('#card-search-result')
                        );
                    }
                );

            });
            // Hide results when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#card-search, #card-search-result').length) {
                    $('#card-search-result').empty();
                }
            });

            // Prevent Enter key from submitting the form in the search field
            $('#card-search').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
