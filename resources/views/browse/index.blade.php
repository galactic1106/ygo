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
                        <!-- <form id="search-form" role="search"> -->
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="input-group">
                                    <label for="fname" class="input-group-text">Name</label>
                                    <input class="form-control border-2" type="search" placeholder="Search" id="fname"
                                        name="fname" value="{{ request('fname') }}">
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
                                <button class="btn btn-primary" id='search-button'>Search</button>
                            </div>
                        </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div id="card-results" class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4"></div>
                <div class="d-flex justify-content-center my-3">
                    <button id="prev-page" class="btn btn-outline-primary me-2"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                        </svg></button>
                    <span id="page-indicator" class="align-self-center"></span>
                    <button id="next-page" class="btn btn-outline-primary ms-2"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-arrow-right"
                            viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                        </svg></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let num = 40;
        let page = 0;

        function filter() {
            filterCards(
                '{{ route('api.request') }}',
                $('#fname'),
                $('#archetype'),
                $('#attribute'),
                $('#type'),
                $('#race'),
                $('#atk'),
                $('#def'),
                $('#level'),
                num,
                num * page,
                function(data) {
                    console.log(data);
                    renderFilteredCards(
                        data,
                        $('#card-results'),
                        '{{ route('api.image', '') }}',
                        '{{ route('card.show', '') }}'
                    );
                    // Update page indicator
                    $('#page-indicator').text('Page ' + (page + 1));
                    // Disable prev button on first page
                    $('#prev-page').prop('disabled', page === 0);
                    // Optionally, disable next if less than num results
                    $('#next-page').prop('disabled', !data || data.length < num);
                }
            );
        }

        $('#search-button').on('click', function() {
            console.log('click');
            
            page = 0;
            filter();
        });

        $('#prev-page').on('click', function() {
            if (page > 0) {
                page--;
                filter();
            }
        });

        $('#next-page').on('click', function() {
            page++;
            filter();
        });

        // Initial load
        filter();

    </script>
@endsection
