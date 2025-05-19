@extends('layouts.app')
@section('title')
    Home
@endsection
@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Newest Cards</h2>
        <ul class="nav nav-tabs mb-3" id="cardTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-medium" id="monsters-tab" data-bs-toggle="tab" data-bs-target="#monsters"
                    type="button" role="tab" aria-controls="monsters" aria-selected="true">Monsters</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium" id="spells-tab" data-bs-toggle="tab" data-bs-target="#spells"
                    type="button" role="tab" aria-controls="spells" aria-selected="false">Spell Cards</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium" id="traps-tab" data-bs-toggle="tab" data-bs-target="#traps"
                    type="button" role="tab" aria-controls="traps" aria-selected="false">Trap Cards</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium" id="extra-tab" data-bs-toggle="tab" data-bs-target="#extra"
                    type="button" role="tab" aria-controls="extra" aria-selected="false">Extra Deck</button>
            </li>
        </ul>
        <div class="tab-content" id="cardTabsContent">
            <div class="tab-pane fade show active" id="monsters" role="tabpanel" aria-labelledby="monsters-tab">
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach ($monsters as $card)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ url('/api/card/images?url=' . urlencode($card['card_images'][0]['image_url'])) }}"
                                    class="card-img-top" alt="{{ $card['name'] }}">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate" title="{{ $card['name'] }}">{{ $card['name'] }}
                                    </h5>
                                    <a href="{{ route('card.show', ['id' => $card['id']]) }}"
                                        class="btn btn-primary btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="spells" role="tabpanel" aria-labelledby="spells-tab">
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach ($spells as $card)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ url('/api/card/images?url=' . urlencode($card['card_images'][0]['image_url'])) }}"
                                    class="card-img-top" alt="{{ $card['name'] }}">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate" title="{{ $card['name'] }}">{{ $card['name'] }}
                                    </h5>
                                    <a href="{{ route('card.show', ['id' => $card['id']]) }}"
                                        class="btn btn-primary btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="traps" role="tabpanel" aria-labelledby="traps-tab">
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach ($traps as $card)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ url('/api/card/images?url=' . urlencode($card['card_images'][0]['image_url'])) }}"
                                    class="card-img-top" alt="{{ $card['name'] }}">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate" title="{{ $card['name'] }}">{{ $card['name'] }}
                                    </h5>
                                    <a href="{{ route('card.show', ['id' => $card['id']]) }}"
                                        class="btn btn-primary btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="extra" role="tabpanel" aria-labelledby="extra-tab">
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach ($extraDeck as $card)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ url('/api/card/images?url=' . urlencode($card['card_images'][0]['image_url'])) }}"
                                    class="card-img-top" alt="{{ $card['name'] }}">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate" title="{{ $card['name'] }}">{{ $card['name'] }}
                                    </h5>
                                    <a href="{{ route('card.show', ['id' => $card['id']]) }}"
                                        class="btn btn-primary btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
