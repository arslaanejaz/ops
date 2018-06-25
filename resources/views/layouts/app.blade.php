<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OPS') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="/font_awesome/css/font-awesome.min.css">
    <script src="/js/jquery-3.2.1.min.js"></script>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
@php $projects = \App\Models\Project::pluck('name', '_id')->all()@endphp
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <a class="navbar-brand" style="font-size: 24px" href="{{ url('/') }}">
                        {{ config('app.name', 'OPS') }}
                    </a>
                     {{--<p class="navbar-text">Signed in as Mark Otto</p> --}}
                    @if(isset($projectId))
                        <span class="navbar-text">
                        <a href="{{ url('/projects/'.$projectId) }}" class="btn btn-primary" role="button">{{strtoupper($projects[$projectId])}}</a>
                        <a href="{{ url('/projects/'.$projectId.'/links') }}" class="btn btn-primary" role="button">Links</a>
                        <a href="{{ url('/projects/'.$projectId.'/forms') }}" class="btn btn-danger" role="button">Forms</a>
                        <a href="{{ url('/projects/'.$projectId.'/test-cases') }}" class="btn btn-info" role="button">Test Cases</a>
                        <a href="{{ url('/projects/'.$projectId.'/docs') }}" class="btn btn-success" role="button">Docs</a>
                        <a href="{{ url('/projects/'.$projectId.'/reports') }}" class="btn btn-success" role="button">Reports</a>
                        <a href="{{ url('/projects/'.$projectId.'/page-speed') }}" class="btn btn-success" role="button">Page Speed</a>
                        </span>


                    @endif
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/') }}">Login</a></li>
                            <li><a href="{{ url('/users/create') }}">Register</a></li>
                        @else


                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Projects <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @foreach($projects as $key=>$val)
                                    <li>
                                        <a href="{{ url('/projects/'.$key) }}">
                                            {{$val}}
                                        </a>
                                    </li>
                                        @endforeach
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
<div class="container-fluid">
        @yield('content')
</div>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
