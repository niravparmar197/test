@extends('layouts.app')

@section('content')
@if(Auth::user()->role_id == 1)
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="login_logo">
                <div class="b-s-50"></div>
                <div class="row justify-content-center">
                    <div class="col-md-3 margin-top-for-user-link">
                        <div class="card position-relative blue-theme-color">
                            <div class="card-header">Total Crew Members</div>
                            <div class="card-body d-flex justify-content-between">
                                <span class="fa fa-user-secret fa-3x"></span>
                                <span class="count_class">{{ $agentsCount }}</span>
                            </div>
                            <a href="{{ route("agent.index") }}" class="full-links position-absolute"></a>
                        </div>
                    </div>
                    <div class="col-md-3 margin-top-for-user-link">
                        <div class="card position-relative blue-theme-color">
                            <div class="card-header">Total Events</div>
                            <div class="card-body d-flex justify-content-between">
                                <span class="fa fa-line-chart fa-3x"></span>
                                <span class="count_class">{{ $eventsCount }}</span>
                            </div>
                            <a href="{{ route("event.index") }}" class="full-links position-absolute"></a>
                        </div>
                    </div>
                    <div class="col-md-3 margin-top-for-user-link">
                        <div class="card position-relative blue-theme-color">
                            <div class="card-header">Total Guests</div>
                            <div class="card-body d-flex justify-content-between">
                                <span class="fa fa-users fa-3x"></span>
                                <span class="count_class">{{ $guestsCount }}</span>
                            </div>
                            <a href="{{ route("guest.admin.index") }}" class="full-links position-absolute"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container h-100">
    <div class="row h-100">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 align-self-center">
            <div class="login_logo">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-4 col-12">
                        <a href="{{ route("set_dashboard",[1]) }}" class="btn_submit">Go To Level 1 Dashboard</a>
                        
                    </div>
                    <div class="col-md-12 col-lg-4 col-12">
                        <a href="{{ route("set_dashboard",[2]) }}" class="btn_submit">Go To Level 2 Dashboard</a>                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endif

@endsection

@section('css')
<style type="text/css">
    .count_class{
        float: right;
        font-size: 32px;
    }
</style>
@endsection