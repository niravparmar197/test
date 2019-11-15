@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="row h-100">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 align-self-center">
            <div class="login_box">
                <div class=" mb-4">
                    <label class="label-fill" for="agent_id">Visitor Name: {{ $objGuest->name }} | {{ $objGuest->ticket_number }}</label>
                </div>
                <form action="{{ route("guest.update",[$objGuest->id]) }}" method="post">
                    @csrf
                    @method("PUT")
                    <div class=" mb-4">
                        <label class="label-fill" for="agent_id">Crew Member</label>
                        <select name="agent_id" id="agent_id" class="form-control @error('agent_id') is-invalid @enderror">
                            <option value="">Please Select Crew Member</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old("agent_id") == $agent->id ? "selected" : "" }}>{{ $agent->name }}</option>
                            @endforeach
                        </select>
                        @error('agent_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class=" mb-4">
                        <label class="label-fill" for="guest">Guest Type</label>
                        <div class="btn-group btn-group-toggle d-flex flex-wrap w-100 cust-redio-btn justify-content-between" data-toggle="buttons">
                        @foreach($guestTypeArray as $value)
                        {{-- <div class="col-12 col-sm-12 col-md-6 col-xl-6 col-lg-6"> --}}
                            <label class="btn btn-secondary ">
                                <input type="radio" name="guest_type" value="{{ $value }}" {{ old("guest_type") == $value ? "checked" : "" }} id="{{ $value }}"
                                autocomplete="off">{{ $value }}
                            </label>

                        {{-- </div> --}}
                        @endforeach
                        </div>
                        @error('guest_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class=""><button type="submit" class="btn_submit">Confirm</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="{{ url("js/select2/css/select2.min.css") }}">
<style type="text/css">
    .invalid-feedback {
        display: block;        
    }
    .select2-container .select2-selection--single{height:auto;}
    .select2-container--default .select2-selection--single .select2-selection__rendered{padding-top:8px; padding-bottom:8px; padding-left:14px}
    .select2-container--default .select2-selection--single .select2-selection__arrow{height:42px}
</style>
@endsection

@section("js")
<script type="text/javascript" src="{{ url("js/select2/js/select2.min.js") }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#agent_id").select2();
    });
</script>
@endsection
