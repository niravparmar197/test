@extends('layouts.app')

@section('content')
@include ('alert.index')
<div class="container h-100">
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 align-self-center">
        <div class="login_box">
            <div class="row h-100">
                @if(count($guestMasters) == 0)
                    <div class="user_deatils text-center pt-3 py-3">
                        <label class="my-0">No visitor assigned yet</label>    
                    </div>
                @endif
                @foreach($guestMasters as $key => $guest)
                <div class="user_deatils">
                    <a href="{{ route("guest.review", [$guest->ticket_number]) }}">
                        <ul>
                            <li><span>Ticket No:</span> {{ $guest->ticket_number }}</li>
                            <li><span>Name:</span> {{ $guest->name }}</li>
                            <li><span>Type:</span> {{ $guest->guest_type }}</li>
                            <li><span>Status:</span> Open</li>
                        </ul>
                    </a>
                </div>
                @endforeach
                <div class="b-s-50"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("css")
@endsection

@section("js")
@endsection