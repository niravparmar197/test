<!DOCTYPE html>
<html>

<head>
<title>Welcome to Emxcel CRM</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
<link rel="icon" type="image/png" href="{{url("images/favicon.png")}}">
<link rel="stylesheet" href="{{ url("css/bootstrap.min.css") }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700,800|Roboto:300,400,500,700,900&display=swap" rel="stylesheet"> 
<link rel="stylesheet" href="{{ url("css/style.css") }}">
</head>
<body>
<div class="container h-100">
    <div class="row h-100">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 align-self-center">
                <div class="login_logo">
                    <a href="javascript:void(0);" title="Emxcel">
                        <img src="{{ url('images/emxcel-logo.svg') }}" alt="Emxcel" title="Emxcel" class="img-fluid" />
                    </a>
                </div>
                <div class="login_box">
                    <h1>Welcome to Emxcel CRM</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="far fa-user"></i></span>
                            </div>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="User Id"  value="{{ old('email') }}" required aria-label="User" aria-describedby="basic-addon1" autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" aria-label="password" aria-describedby="basic-addon1" equired autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn_submit">Submit</button>
                    
                        {{-- @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="{{ url("js/jquery-3.4.1.min.js") }}"></script>    
<script src="{{ url("js/bootstrap.min.js") }}"></script> 
</body>
</html>
