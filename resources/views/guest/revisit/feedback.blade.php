@extends('layouts.app')

@section('content')
@include("alert.index")
<div class="container h-100">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 align-self-center">
        <div class="login_box">
            <div class="row h-100">
                <div class="user_deatils">
                    <ul>
                        <li><span>Ticket No:</span> {{ $objGuest->ticket_number }}</li>
                        <li><span>Guest Name:</span> {{ $objGuest->name }}</li>
                        <li><span>Email:</span> {{ $objGuest->email }}</li>
                        <li><span>Mobile:</span> {{ $objGuest->country_code." ".$objGuest->mobile_number }}</li>
                        <li><span>Type:</span> {{ $objGuest->guest_type }}</li>
                        <li><span>Note:</span> {{ $objGuest->note }}</li>
                        <li><span>Created By:</span> {{ isset($objGuest->createUser->name) ? $objGuest->createUser->name : "" }}</li>
                        <li><span>Assigned To:</span> {{ isset($objGuest->assignUser->name) ? $objGuest->assignUser->name : "" }}</li>
                        {{-- <li><span>Status:</span> Open</li> --}}
                    </ul>
                </div>
                <div class="b-s-30"></div>
                <h3 class="sub_titile pl-0">Remarks/Comments History</h3>
                <div class="user_deatils es">
                    <ul>
                        @foreach($remarks as $remark)
                        <li>
                            <div class="font-weight-bold">{{ isset($remark->createUser->name) ? $remark->createUser->name : "User" }}:</div>
                            <p class="remark-time-date">{{ formattedDateTime($remark->created_at) }}</p>
                            {{ $remark->remarks }}                             
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="social_block">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="{{ route("guest.revisit.feedback.post") }}">
                                @csrf
                                <div class="b-s-20"></div>
                                <h3 class="sub_titile pl-0">Remarks/Comments</h3>
                                <div class="input-group">
                                    <input type="hidden" name="guest_master_id" value="{{ $objGuest->id }}">
                                    <textarea id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" placeholder="Enter your remarks/comments here" required="">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn_submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="b-s-50"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("css")
<style type="text/css">
    .text-yellow{
        color: #ffbf00 !important;
    }
    .text-blue{
        color: #01599A !important;
    }
</style>
@endsection

@section("js")
@endsection