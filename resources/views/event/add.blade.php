@extends('layouts.app')

@section('content')
<div class="container">
    <div class="b-s-20"></div>
    <div class="row justify-content-center">        
        <div class="col-lg-7 col-md-12 col-12 cust-md-12">
            <div class="card">
                <div class="card-header">Add Event</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('event.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="form-group row">
                                    <label for="event_name" class="ol-12 col-md-12 col-lg-12 col-form-label">Event Name</label>

                                    <div class="ol-12 col-md-12 col-lg-12">
                                        <input id="event_name" type="text" class="form-control @error('event_name') is-invalid @enderror" name="event_name" value="{{ old('event_name') }}" required autocomplete="event_name" autofocus>

                                        @error('event_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="form-group row">
                                    <label for="venue" class="ol-12 col-md-12 col-lg-12 col-form-label">Event Venue</label>

                                    <div class="ol-12 col-md-12 col-lg-12">
                                        <input id="venue" type="text" class="form-control @error('venue') is-invalid @enderror" name="venue" value="{{ old('venue') }}" required autocomplete="venue" >

                                        @error('venue')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="form-group row">
                                    <label for="event_from_time" class="ol-12 col-md-12 col-lg-12 col-form-label">Event From Time</label>

                                    <div class="ol-12 col-md-12 col-lg-12 position-relative calender-icon">
                                        <input id="event_from_time" type="text" class="form-control @error('event_from_time') is-invalid @enderror" name="event_from_time" value="{{ old('event_from_time') }}" required autocomplete="event_from_time">

                                        @error('event_from_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="form-group row">
                                    <label for="event_to_time" class="ol-12 col-md-12 col-lg-12 col-form-label">Event To Time</label>

                                    <div class="ol-12 col-md-12 col-lg-12 position-relative calender-icon">
                                        <input id="event_to_time" type="text" class="form-control @error('event_to_time') is-invalid @enderror" name="event_to_time" value="{{ old('event_to_time') }}" required autocomplete="event_to_time">

                                        @error('event_to_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 col-lg-12">
                                <div class="form-group row">
                                    <label for="description" class="ol-12 col-md-12 col-lg-12 col-form-label">Event Short Description</label>

                                    <div class="ol-12 col-md-12 col-lg-12">
                                        <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>

                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 col-lg-12">
                                <button type="submit" class="btn_submit">
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="{{ url("js/datepicker/css/bootstrap-datepicker.min.css") }}">
@endsection

@section("js")
<script type="text/javascript" src="{{ url("js/datepicker/js/bootstrap-datepicker.min.js") }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#event_from_time").datepicker({
            format: 'yyyy-mm-dd',
            startDate: 'today'
        });
        $("#event_to_time").datepicker({
            format: 'yyyy-mm-dd',
            startDate: 'tomorrow'
        });
    });
</script>
@endsection
