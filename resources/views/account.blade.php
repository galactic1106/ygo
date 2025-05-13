@extends('layouts.app')
@section('title')
    Account
@endsection
@section('location')
    Account
@endsection
@section('content')
    <div class="modal" tabindex="-1" id="username-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit username</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" value="{{ $user->name }}">
                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
        </div>
        <div class="d-flex flex-column flex-fill flex-grow-1 mx-5 text-nowrap">
            <div class="account-data collapse-horizontal">
                <div class="card card-body rounded-3 fs-5 mb-3">
                    <div class="d-flex flex-row align-items-center col-4 border border-2 rounded-3 mb-3">
                        <div class="p-2 pe-0 d-flex me-1 text-nowrap">Username:</div>
                        <div class="p-2 ps-0 d-flex flex-fill text-nowrap"> {{ $user->name }} </div>
                        <div class="p-2 px-3 d-flex border-start border-2 text-nowrap">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#username-modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-pencil" viewBox="0 0 16 16">
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
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#username-modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg></button>
                        </div>
                    </div>
                    <div class="d-flex flex-row align-items-center col-4 border border-2 rounded-3 mb-3">
                        <div class="p-2 pe-0 d-flex me-1 text-nowrap">Phone number:</div>
                        <div class="p-2 ps-0 d-flex flex-fill text-nowrap"> {{ $user->phone_number }} </div>
                        <div class="p-2 px-3 d-flex border-start border-2 text-nowrap">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#username-modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex flex-row align-items-center col-4 border border-2 rounded-3">
                        <div class="p-2 pe-0 d-flex me-1 text-nowrap">Password:</div>
                        <div class="p-2 ps-0 d-flex flex-fill text-nowrap"> *********** </div>
                        <div class="p-2 px-3 d-flex border-start border-2 text-nowrap">
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#username-modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse past-orders collapse-horizontal">
                @if ($orderCount)
                    @foreach ($user->orders as $order)
                        <div class="card card-body rounded-3 fs-5 mb-3">
                            <a href="{{ route('order.show', ['id' => $order->id]) }}">{{ $order->order_date }} payed with
                                ****-****-{{ $order->card_number }}</a>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning" role="alert">
                        No orders where found!
                    </div>
                @endif


            </div>
        </div>
    </div>
@endsection
