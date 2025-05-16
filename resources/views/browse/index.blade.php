{{-- filepath: /home/galactic1106/public_html/ygo/resources/views/browse/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Browse Cards')
@section('location', 'Browse Yu-Gi-Oh! Cards')

@section('content')
    <div class="container px-5 mt-3" style="min-width: 100%">

        <div class="row">
            <div class="col-3">
                <form role="search" method="GET" action="{{ route('browse.index') }}">
                    <div class="list-group">
                        <div class="list-group-item row d-flex">
                            <div class="col border border-0 m-0 p-0 pe-2">
                                <input class="form-control border-2" type="search" placeholder="Search" id="search-bar"
                                    name="search-bar">
                            </div>
                            <button class="btn btn-outline-success bg-success-subtle fw-bold border-2 col-2" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 20 20">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-9">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                    @forelse($cards as $card)
                        <div class="col">
                            <div class="card h-100 shadow-sm border border-1 border-light">
                                <a href="{{ route('card.show', $card['id']) }}">
                                    <img src="{{ $card['card_images'][0]['image_url_cropped'] ?? $card['card_images'][0]['image_url'] }}"
                                        class="card-img-top" alt="{{ $card['name'] }}">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title text-truncate" title="{{ $card['name'] }}">{{ $card['name'] }}
                                    </h5>
                                    <p class="card-text small text-muted mb-1">{{ $card['type'] ?? '' }}</p>
                                    <p class="card-text small">{{ \Illuminate\Support\Str::limit($card['desc'] ?? '', 60) }}
                                    </p>
                                </div>
                                <div class="card-footer text-end">
                                    <a href="{{ route('card.show', $card['id']) }}" class="btn btn-primary btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        @section('messages')
                            <div class="alert alert-info mx-5 my-3">No cards found.</div>
                        @endsection
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
