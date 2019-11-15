@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
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
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Crew Member</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('agent.update',[$objAgent->id]) }}">
                        <input name="_method" value="PUT" type="hidden">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Crew Member Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $objAgent->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Crew Member Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ? old('email') : $objAgent->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile_number" class="col-md-4 col-form-label text-md-right">Crew Member Mobile</label>

                            <div class="col-md-6">
                                <input id="mobile_number" type="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ old('mobile_number') ? old('mobile_number') : $objAgent->mobile_number }}" required autocomplete="mobile_number">

                                @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="agent_permission" class="col-md-4 col-form-label text-md-right">Crew Member Type</label>

                            <div class="col-md-6 custom-checkbox">
                                @php($permissions = json_decode($objAgent->permissions))
                                <input type="checkbox" class="checkbox-class" value="L1" name="agent_permission[]" id="agent_permission1" {{ in_array("L1", $permissions) ? "checked" : "" }}>
                                <label for="agent_permission1" class="checkbox-lable">Crew Level 1</label>
                                <input type="checkbox" class="checkbox-class" value="L2" name="agent_permission[]" id="agent_permission2" {{ in_array("L2", $permissions) ? "checked" : "" }}> 
                                <label for="agent_permission2" class="checkbox-lable">Crew Level 2</label>
                                @error('agent_permission')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
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
<style type="text/css">
    .checkbox-class
    {
        margin-top: 13px;
    }
    .custom-checkbox .invalid-feedback {
        display: block;
    }
</style>
@endsection