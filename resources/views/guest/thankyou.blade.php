@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="row h-100">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 align-self-center">
            <div class="login_box">
                <h1>thank you! <span>{{ session()->get("success") }}</span></h1>
                <form action="{{ route("guest.create") }}">
                    <button type="submit" class="btn_submit">Continue</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("css")

@endsection

@section("js")

@endsection