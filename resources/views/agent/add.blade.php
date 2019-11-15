@extends('layouts.app')

@section('content')
<div class="container">
    <div class="b-s-20"></div>
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-12 col-12 cust-md-12">
            <div class="card">
                <div class="card-header">Add Crew Member</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('agent.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="form-group row">
                                    <label for="name" class="col-12 col-md-12 col-lg-12 col-form-label">Crew Member Name</label>

                                    <div class="col-12 col-md-12 col-lg-12">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>        
                            </div>
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="form-group row">
                                    <label for="email" class="col-12 col-md-12 col-lg-12 col-form-label">Crew Member Email</label>

                                    <div class="col-12 col-md-12 col-lg-12">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="form-group row">
                                    <label for="mobile_number" class="ccol-12 col-md-12 col-lg-12 col-form-label">Crew Member Mobile</label>

                                    <div class="col-12 col-md-12 col-lg-12">
                                        <input id="mobile_number" type="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ old('mobile_number') }}" required autocomplete="mobile_number">

                                        @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="form-group row">
                                    <label for="agent_permission" class="col-12 col-md-12 col-lg-12 col-form-label">Crew Member Type</label>
                                    @php($permissions = old('agent_permission'))
                                    @php($permissions = is_array($permissions) ? $permissions : [])
                                    <div class="col-12 col-md-12 col-lg-12 agent-error-label">
                                        <div class="d-flex cus-che-boexes flex-wrap-479" >
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="L1" name="agent_permission[]" id="agent_permission1" {{ in_array("L1", $permissions) ? "checked" : ""}}>
                                                <label for="agent_permission1" class="custom-control-label">Crew Level 1</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="L2" name="agent_permission[]" id="agent_permission2" {{ in_array("L2", $permissions) ? "checked" : ""}}>
                                                <label for="agent_permission2" class="custom-control-label">Crew Level 2</label>
                                            </div>
                                        </div>
                                        @error('agent_permission')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="form-group row">
                                    <label for="password" class="col-12 col-md-12 col-lg-12 col-form-label">Password</label>

                                    <div class="col-12 col-md-12 col-lg-12">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="form-group row">
                                    <label for="password-confirm" class="ccol-12 col-md-12 col-lg-12 col-form-label">Confirm Password</label>

                                    <div class="col-12 col-md-12 col-lg-12">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-12 col-md-12">
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
<style type="text/css">
    .checkbox-class
    {
        margin-top: 13px;
    }
    .agent-error-label .invalid-feedback {
        display: block;
    }
</style>
@endsection