<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ url("css/fontawesome/css/font-awesome.min.css") }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700,800|Roboto:300,400,500,700,900&display=swap" rel="stylesheet"> 
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}?v=11" rel="stylesheet">
    <style type="text/css">
        .user-icon-span
        {
            padding: 0 13px;
            font-size:20px;
        }
        .user_icon
        {
            padding: 3px 0;
        }
        .btn-warning
        {
            color:#fff;
            background-color: #333;
            border-color: #333;
        }
        .btn-warning:hover
        {
            color:#fff;
            background-color: #555;
            border-color: #555;
        }
    </style>
    @yield("css")
    <style type="text/css">
        .dataTables_wrapper .dataTables_paginate .paginate_button{padding:3px 8px !important; background:#444; color:#fff !important; border:none !important;}
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{background:#01599a; color:#fff !important}
        .dataTables_wrapper .dataTables_paginate .paginate_button.current{background:#01599a; color:#fff !important;}
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate{font-size:14px; color:#01599a}
        .dataTables_wrapper .dataTables_filter input{border:1px solid #01599a; border-radius:4px;}
        .dataTables_length select{box-shadow: none;}
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-5 col-sm-5 col-md-6 col-lg-6 col-xl-6 align-self-center">
                    <div class="inner_logo">
                        <a href="{{ url("/") }}" title="Emxcel">
                            <img src="{{ url("images/emxcel-logo.svg") }}" alt="Emxcel" title="Emxcel" class="img-fluid" />
                        </a>
                    </div>
                </div>
                <div class="col-7 col-sm-7 col-md-6 col-lg-6 col-xl-6 d-flex justify-content-end">
                    <div class="user_block cst-drop-menu">
                        @guest
                        @else
                        <div class="dropdown show">
                          <a class="btn btn-secondary dropdown-toggle" href="javascript:void(0);" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="user_icon">
                                <span class="user-icon-span">{{ substr(ucwords(Auth::user()->name),0,1) }}</span>                            
                            </div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <p class="dropdown-item">Hey {{ ucwords(Auth::user()->name) }}</p>
                            @if(Auth::user()->role_id == 1)
                            <a class="dropdown-item" href="{{ route("agent.index") }}">Crew</a>
                            <a class="dropdown-item" href="{{ route("event.index") }}">Events</a>
                            <a class="dropdown-item" href="{{ route("guest.admin.index") }}">Guests</a>
                            @endif
                            @if(Auth::user()->role_id == 2)
                            <a class="dropdown-item" href="{{ route("guest.revisit.index") }}">Feedback/Revisit </a>
                            @endif
                            <a class="dropdown-item" href="javascript:void(0);"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
    </div>
</div>  
</header>





@yield('content')
<script src="{{ url("js/jquery-3.4.1.min.js") }}"></script>
<script src="{{ url("js/popper.min.js") }}"></script>
<script src="{{ url("js/bootstrap.min.js") }}"></script>
@yield("js")
</body>
</html>
