@extends('layouts.app')

@section('title', 'My Decks')
@section('location', 'Decks')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">My Decks</h2>

        <!-- Create Deck Form -->
        <div class="card mb-4">
            <div class="card-header fw-bold">
                Create New Deck
            </div>
            <div class="card-body">
                <form action="{{ route('decks.create') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="deck-name" class="form-label">Deck Name</label>
                        <input type="text" class="form-control" id="deck-name" name="name" required maxlength="64"
                            placeholder="Enter deck name">
                    </div>
                    <div class="mb-3">
                        <label for="deck-notes" class="form-label">Notes (optional)</label>
                        <textarea class="form-control" id="deck-notes" name="notes" maxlength="255" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Create Deck</button>
                </form>
            </div>
        </div>

        <!-- List of Decks -->
        <div class="card">
            <div class="card-header fw-bold">
                Your Decks
            </div>
            <div class="card-body">
                @if ($decks->count())
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Notes</th>
                                <th>Cards</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($decks as $deck)
                                <tr>
                                    <td>
                                        <a href="{{ route('decks.show', $deck->id) }}" class="fw-semibold">
                                            {{ $deck->name }}
                                        </a>
                                    </td>
                                    <td>{{ $deck->notes }}</td>
                                    <td>{{ $deck->cards->count() }}</td>
                                    <td>
                                        <form action="{{ route('decks.delete', $deck->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to delete this deck?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                        <a href="{{ route('decks.show', $deck->id) }}"
                                            class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">
                        You have no decks yet. Create one above!
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
