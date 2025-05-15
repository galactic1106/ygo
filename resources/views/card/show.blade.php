{{-- filepath: /home/galactic1106/public_html/ygo/resources/views/card/show.blade.php --}}
@extends('layouts.app')

@section('title', $card ? $card['name'] : 'Card Not Found')

@section('content')
<div class="container py-4">
    @if($card)
        <div class="row">
            <div class="col-md-4">
                <img src="{{ $card['card_images'][0]['image_url'] }}" alt="{{ $card['name'] }}" class="img-fluid rounded border">
            </div>
            <div class="col-md-8">
                <h2 class="fw-bold">{{ $card['name'] }}</h2>
                <p class="text-muted mb-1">{{ $card['type'] }}</p>
                <p>{{ $card['desc'] }}</p>
                <ul class="list-group mb-3">
                    @if(isset($card['atk']))
                        <li class="list-group-item">ATK: {{ $card['atk'] }}</li>
                    @endif
                    @if(isset($card['def']))
                        <li class="list-group-item">DEF: {{ $card['def'] }}</li>
                    @endif
                    @if(isset($card['level']))
                        <li class="list-group-item">Level: {{ $card['level'] }}</li>
                    @endif
                    @if(isset($card['race']))
                        <li class="list-group-item">Type: {{ $card['race'] }}</li>
                    @endif
                    @if(isset($card['attribute']))
                        <li class="list-group-item">Attribute: {{ $card['attribute'] }}</li>
                    @endif
                </ul>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            Card not found.
        </div>
    @endif
</div>
@endsection