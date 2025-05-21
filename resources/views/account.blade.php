@extends('layouts.app')
@section('title')
    Account
@endsection
@section('location')
    Account
@endsection
@section('messages')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
                @if (session('error'))
                    <div class="alert alert-danger">
                        <li>
                            {{ session('error') }}
                        <li>
                    </div>
                @endif
                @if (session('message'))
                    <div class="alert alert-danger">
                        <li>
                            {{ session('message') }}
                        <li>
                    </div>
                @endif
            </ul>
        </div>
    @endif
@endsection
@section('content')

    <div class="modal" tabindex="-1" id="username-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('account.edit', ['id' => $user->id]) }}" method="post">
                    @csrf
                    <input type="hidden" value="name" name="updating" id="updating">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit username</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="text" class="form-control " value="{{ old('name') }}" required autocomplete="name"
                            autofocus placeholder="{{ $user->name }}" id="new-name" name="new-name">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div class="modal" tabindex="-1" id="email-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('account.edit', ['id' => $user->id]) }}" method="post">
                    @csrf
                    <input type="hidden" value="email" name="updating" id="updating">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input id="new-email" type="email" class="form-control" name="new-email"
                            placeholder="{{ $user->email }}" required autocomplete="email">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="password-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('account.edit', ['id' => $user->id]) }}" method="post">
                    @csrf
                    <input type="hidden" value="password" name="updating" id="updating">

                    <div class="modal-header">
                        <h5 class="modal-title">Change password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input id="new-password" type="password" class="form-control mb-3" name="new-password"
                            minlength="8" required autocomplete="new-password" placeholder="new password">
                        <input id="new-password_confirmation" type="password" class="form-control"
                            name="new-password_confirmation" minlength="8" required placeholder="Confirm new password">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="phone-number-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('account.edit', ['id' => $user->id]) }}" method="post">
                    @csrf
                    <input type="hidden" value="phone-number" name="updating" id="updating">

                    <div class="modal-header">
                        <h5 class="modal-title">Phone number</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="text" class="form-control" id="new-phone-number" name="new-phone-number"
                            placeholder="{{ $user->phone_number }}" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="delete-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('account.destroy', ['id' => $user->id]) }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Delete account?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <span>write 'DELETE USER' to finish operation</span><br>
                        <input type="text" class="form-control" id="delete" name="delete"
                            placeholder="DELETE USER" minlength="11" maxlength="11" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">CONFIRM DELETE</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="d-flex flex-fill my-3" style="min-height: 500px">
        <div class="d-flex flex-column  bg-body-tertiary rounded-end-4 py-3 pe-3">
            <button data-bs-toggle="collapse" data-bs-target=".account-data"
                class="btn btn-primary bg-primary-subtle border-2 fs-4 border-start-0 rounded-start-0 py-2 px-3 mb-3">Account
                Data</button>
            <button data-bs-toggle="collapse" data-bs-target=".past-orders"
                class="btn btn-primary bg-primary-subtle border-2 fs-4 border-start-0 rounded-start-0 py-2 px-3 mb-3">Past
                Orders</button>
            <button data-bs-toggle="collapse" data-bs-target=".my-offers"
                class="btn btn-primary bg-primary-subtle border-2 fs-4 border-start-0 rounded-start-0 py-2 px-3 mb-3">
                My Offers
            </button>
        </div>
        <div class="d-flex flex-column flex-fill flex-grow-1 mx-5 text-nowrap">
            <div class="account-data collapse-horizontal">
                <div class="card card-body rounded-3 fs-5 mb-3">
                    <div class="d-flex flex-row align-items-center col-4 border border-2 rounded-3 mb-3">
                        <div class="p-2 pe-0 d-flex me-1 text-nowrap">Username:</div>
                        <div class="p-2 ps-0 d-flex flex-fill text-nowrap"> {{ $user->name }} </div>
                        <div class="p-2 px-3 d-flex border-start border-2 text-nowrap">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#username-modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex flex-row align-items-center col-4 border border-2 rounded-3 mb-3">
                        <div class="p-2 pe-0 d-flex me-1 text-nowrap">Email:</div>
                        <div class="p-2 ps-0 d-flex flex-fill text-nowrap"> {{ $user->email }} </div>
                        <div class="p-2 px-3 d-flex border-start border-2 text-nowrap">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#email-modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg></button>
                        </div>
                    </div>
                    <div class="d-flex flex-row align-items-center col-4 border border-2 rounded-3 mb-3">
                        <div class="p-2 pe-0 d-flex me-1 text-nowrap">Phone number:</div>
                        <div class="p-2 ps-0 d-flex flex-fill text-nowrap"> {{ $user->phone_number }} </div>
                        <div class="p-2 px-3 d-flex border-start border-2 text-nowrap">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#phone-number-modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex flex-row align-items-center col-4 border border-2 rounded-3 mb-3">
                        <div class="p-2 pe-0 d-flex me-1 text-nowrap">Password:</div>
                        <div class="p-2 ps-0 d-flex flex-fill text-nowrap"> *********** </div>
                        <div class="p-2 px-3 d-flex border-start border-2 text-nowrap">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#password-modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-danger p-3 bg-danger-subtle fw-bold" data-bs-toggle="modal"
                            data-bs-target="#delete-modal">DELETE USER</button>
                    </div>

                </div>
            </div>
            <div class="collapse past-orders collapse-horizontal">
                @if ($orderCount)
                    @foreach ($user->orders as $order)
                        @if ($order->state != 'cart' && $order->creditCard->card_number)
                            <div class="card card-body rounded-3 fs-5 mb-3">
                                <a href="{{ route('order.show', ['id' => $order->id]) }}">
                                    {{ $order->order_date }} payed with
                                    ****-****-{{ $order->creditCard->card_number }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="alert alert-warning" role="alert">
                        No orders where found!
                    </div>
                @endif
            </div>
            <div class="collapse my-offers collapse-horizontal">
                <div class="card card-body rounded-3 fs-5 mb-3">
                    <h4>My Offers</h4>
                    @if ($user->offers->count())
                        <ul class="list-group">
                            @foreach ($user->offers as $offer)
                                <li class="list-group-item d-flex justify-content-start align-items-center">
                                    Card ID:
                                    <a class="d-inline link link-info"
                                        href="{{ route('card.show', ['id' => $offer->card_id]) }}">
                                        {{ $offer->card_id }}
                                    </a> |
                                    Quantity: {{ $offer->card_quantity }} |
                                    Available quantity: {{ $offer->available_quantity }} |
                                    Price:
                                    <form action="{{ route('offer.changePrice', $offer->id) }}" method="POST"
                                        class="d-inline ms-1 me-2">
                                        @csrf
                                        <input type="number" name="price" id="price" value="{{ $offer->price }}"
                                            min="0.01" step="0.01" style="width: 90px;"
                                            class="form-control border border-2 rounded d-inline border-primary" required>
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-primary py-0 px-2">Update</button>
                                    </form>
                                    <span class="badge bg-primary rounded-pill ms-2">{{ ucfirst($offer->quality) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-warning" role="alert">
                            No offers found!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
