{{-- filepath: /home/galactic1106/public_html/ygo/resources/views/browse/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Browse Cards')
@section('location', 'Browse Yu-Gi-Oh! Cards')

@section('content')
    <div class="container px-5 mt-3" style="min-width: 100%">
        <div class="row">
            <div class="col-3 d-flex flex-column align-items-center">
                <div class="sticky-top " style="min-width: 100%">
                    <div class="d-flex flex-column justify-content-center" style="min-height: 80vh;">
                        <form role="search" method="GET" action="{{ route('browse.index') }}">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <label for="fname" class="input-group-text">Name</label>
                                        <input class="form-control border-2" type="search" placeholder="Search"
                                            id="fname" name="fname" value="{{ request('fname') }}">
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <label for="archetype" class="input-group-text">Archetype</label>
                                        <select class="form-select" id="archetype" name="archetype">
                                            <option value="">Any</option>
                                            @foreach ($archetypes as $archetype)
                                                <option value="{{ $archetype['archetype_name'] }}"
                                                    {{ request('archetype') == $archetype['archetype_name'] ? 'selected' : '' }}>
                                                    {{ $archetype['archetype_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <label class="input-group-text" for="attribute">Attribute</label>
                                        <select class="form-select" id="attribute" name="attribute">
                                            <option value="">Any</option>
                                            @foreach ($attributes as $attribute)
                                                <option value="{{ $attribute }}"
                                                    {{ request('attribute') == $attribute ? 'selected' : '' }}>
                                                    {{ $attribute }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <label class="input-group-text" for="type">Type</label>
                                        <select class="form-select" id="type" name="type">
                                            <option value="">Any</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type }}"
                                                    {{ request('type') == $type ? 'selected' : '' }}>
                                                    {{ $type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <label class="input-group-text" for="race">Race</label>
                                        <select class="form-select" id="race" name="race">
                                            <option value="">Any</option>
                                            @foreach ($races as $race)
                                                <option value="{{ $race }}"
                                                    {{ request('race') == $race ? 'selected' : '' }}>
                                                    {{ $race }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <label class="input-group-text" for="atk">ATK</label>
                                        <input type="number" class="form-control" id="atk" name="atk"
                                            value="{{ request('atk') }}">
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <label class="input-group-text" for="def">DEF</label>
                                        <input type="number" class="form-control" id="def" name="def"
                                            value="{{ request('def') }}">
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="input-group">
                                        <label class="input-group-text" for="level">Level</label>
                                        <input type="number" class="form-control" id="level" name="level"
                                            value="{{ request('level') }}">
                                    </div>
                                </div>
                                <div class="list-group-item text-end">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                        @if (empty(request('fname')) && empty(request('archetype')) && empty(request('race')))
                            <div class="alert alert-warning mt-3">
                                Please use at least one of: <strong>Name</strong>, <strong>Archetype</strong>, or
                                <strong>Race</strong> to search.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                    @if (empty(request('fname')) && empty(request('archetype')) && empty(request('race')))
                        {{-- Do not show "No cards found" if user hasn't searched --}}
                    @else
                        @forelse($cards as $card)
                            <div class="col">
                                <div class="card h-100 shadow-sm border border-1 border-light">
                                    <a href="{{ route('card.show', $card['id']) }}">
                                        <img src="{{ $card['card_images'][0]['image_url_cropped'] ?? $card['card_images'][0]['image_url'] }}"
                                            class="card-img-top" alt="{{ $card['name'] }}"
                                            style="width: 100%; aspect-ratio: 1 / 1; object-fit: cover; object-position: top;">
                                    </a>
                                    <div class="card-body">
                                        <h5 class="card-title text-truncate" title="{{ $card['name'] }}">
                                            {{ $card['name'] }}</h5>
                                        <ul class="list-group list-group-flush small ">
                                            @if (isset($card['archetype']))
                                                <li class="list-group-item px-0 py-1"><strong>Archetype:</strong>
                                                    {{ $card['archetype'] }}</li>
                                            @endif
                                            @if (isset($card['attribute']))
                                                <li class="list-group-item px-0 py-1"><strong>Attribute:</strong>
                                                    {{ $card['attribute'] }}</li>
                                            @endif
                                            @if (isset($card['type']))
                                                <li class="list-group-item px-0 py-1"><strong>Type:</strong>
                                                    {{ $card['type'] }}</li>
                                            @endif
                                            @if (isset($card['race']))
                                                <li class="list-group-item px-0 py-1"><strong>Race:</strong>
                                                    {{ $card['race'] }}</li>
                                            @endif
                                            @if (isset($card['atk']))
                                                <li class="list-group-item px-0 py-1"><strong>ATK:</strong>
                                                    {{ $card['atk'] }}</li>
                                            @endif
                                            @if (isset($card['def']))
                                                <li class="list-group-item px-0 py-1"><strong>DEF:</strong>
                                                    {{ $card['def'] }}</li>
                                            @endif
                                            @if (isset($card['level']))
                                                <li class="list-group-item px-0 py-1"><strong>Level:</strong>
                                                    {{ $card['level'] }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="card-footer text-end">
                                        <a href="{{ route('card.show', $card['id']) }}"
                                            class="btn btn-primary btn-sm">View</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info mx-5 my-3">No cards found.</div>
                            </div>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
