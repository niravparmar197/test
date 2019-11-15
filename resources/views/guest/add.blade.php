@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="row h-100">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 align-self-center">
            <div class="login_box check_in">
                <div class="row justify-content-center">
                    <div class="b-s-20"></div>
                    @if(session()->has("message"))
                    <div class="col-md-8">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session()->get("message") }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    @if(session()->has("success"))
                    <div class="col-md-8">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get("success") }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
                
                <form action="{{ route("guest.store") }}" method="POST" id="guest_form">
                    @csrf
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="name" placeholder="Visitor Name" aria-label="visitor" aria-describedby="basic-addon1" value="{{ old("name") }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group flex-wrap-inherit">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-mobile"></i></pan>
                        </div>
                        <input id="phone" class="form-control" name="mobile_number" type="tel" value="{{ old("country_code").old("mobile_number") }}">
                        <input id="country_code" class="form-control" name="country_code" type="hidden" value="+91">
                    </div>
                    @error('mobile_number')
                        <div class="row">
                            <span class="invalid-feedback col-xs-12" role="alert">
                                <strong style="padding-left: 15px;">{{ $message }}</strong>
                            </span>
                        </div>
                    @enderror
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                        </div>
                        <input type="email" class="form-control" name="email" placeholder="Email ID" aria-label="email" aria-describedby="basic-addon1" value="{{ old("email") }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class=" mb-4">
                        <hr>
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
                    <div class="mb-4">
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
                        <label class="label-fill" for="note">Notes</label>
                        <div class="input-group">
                            <textarea id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" placeholder="Enter your notes here">{{ old('note') }}</textarea>
                            @error('note')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <button type="submit" class="btn_submit" id="submit_btn">Submit</button>  
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <button type="button" class="btn_submit" id="reset-button">Clear</button>  
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="box loading">
    <div class="loader-15"></div>
</div>

@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="{{ url("js/select2/css/select2.min.css") }}">
<link rel="stylesheet" type="text/css" href="{{ url("css/intlTelInput.css") }}">
<style type="text/css">
    .checkbox-class
    {
        margin-top: 13px;
    }
    .invalid-feedback {
        display: block;
    }
    #phone{padding-left:96px !important}
    .fa.fa-mobile{font-size:22px;}
    [class*="loader-"] {
        display: inline-block;
        width: 1em;
        height: 1em;
        color: inherit;
        vertical-align: middle;
        pointer-events: none;
    }
    .loader-15 {
      background: currentcolor;
      position: relative;
      -webkit-animation: loader-15 1s ease-in-out infinite;
              animation: loader-15 1s ease-in-out infinite;
      -webkit-animation-delay: 0.4s;
              animation-delay: 0.4s;
      width: .25em;
      height: .5em;
      margin: 0 .5em;
    }
    .loader-15:after, .loader-15:before {
      content: '';
      position: absolute;
      width: inherit;
      height: inherit;
      background: inherit;
      -webkit-animation: inherit;
              animation: inherit;
    }
    .loader-15:before {
      right: .5em;
      -webkit-animation-delay: 0.2s;
              animation-delay: 0.2s;
    }
    .loader-15:after {
      left: .5em;
      -webkit-animation-delay: 0.6s;
              animation-delay: 0.6s;
    }

    @-webkit-keyframes loader-15 {
      0%,
        100% {
        box-shadow: 0 0 0 currentcolor, 0 0 0 currentcolor;
      }
      50% {
        box-shadow: 0 -.25em 0 currentcolor, 0 .25em 0 currentcolor;
      }
    }

    @keyframes loader-15 {
      0%,
        100% {
        box-shadow: 0 0 0 currentcolor, 0 0 0 currentcolor;
      }
      50% {
        box-shadow: 0 -.25em 0 currentcolor, 0 .25em 0 currentcolor;
      }
    }
    .loading {
        display: none;
      position: fixed;
      z-index: 999;
      height: 2em;
      width: 2em;
      overflow: show;
      margin: auto;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
    }

    /* Transparent Overlay */
    .loading:after {
      content: '';
      display: block;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
        background: radial-gradient(rgba(255, 255, 255,.2), rgba(200, 200, 200,.8));

      background: -webkit-radial-gradient(rgba(255, 255, 255,.2), rgba(200, 200, 200,.8));
      z-index: 9;
    }
    .invalid-feedback {
        display: block;        
    }
    .select2-container .select2-selection--single{height:auto;}
    .select2-container--default .select2-selection--single .select2-selection__rendered{padding-top:8px; padding-bottom:8px; padding-left:14px}
    .select2-container--default .select2-selection--single .select2-selection__arrow{height:42px}
</style>
@endsection

@section("js")
<script src="{{ url("js/intlTelInput.js") }}"></script>
<script type="text/javascript" src="{{ url("js/select2/js/select2.min.js") }}"></script>
<script>
    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input,{
        preferredCountries:["in","us"],
        setCountry:"in",
        separateDialCode:true,
        utilsScript: "{{ url("/") }}/js/build/utils.js",
    });
    // var phone = $("#phone").intlTelInput();

    $("#phone").on("countrychange",function(e){
        country_data = iti.getSelectedCountryData();
        $("#country_code").val("+"+country_data.dialCode)
    });

    $(document).ready(function(){
        $("#guest_form").on("submit",function(){
            $("#submit_btn").prop("disabled",true);
            $(".loading").css("display","block");
        });
        $("#agent_id").select2();
        $("#reset-button").click(function() { 
            $("#guest_form")[0].reset();
            $("#agent_id").select2().trigger("change");
            $('[data-toggle="buttons"] :radio').prop('checked', false);
            $('[data-toggle="buttons"] label').removeClass('active');
        }); 
    });
</script>
@endsection