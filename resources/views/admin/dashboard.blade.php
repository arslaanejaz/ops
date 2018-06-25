@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if(Auth::user()->role==0)
                        {{--<div class="col-md-6">--}}
                            {{--<a href="{{ url('/scrape') }}">--}}
                                {{--<button type="button" class="btn btn-default navbar-btn">Scrape</button>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        <div class="col-md-6">
                            <a href="{{ url('/projects') }}">
                                <button type="button" class="btn btn-default navbar-btn">Projects</button>
                            </a>
                        </div>
                        {{--<div class="col-md-6">--}}
                            {{--<a href="{{ url('/links') }}">--}}
                                {{--<button type="button" class="btn btn-default navbar-btn">Links</button>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-6">--}}
                            {{--<a href="{{ url('/forms') }}">--}}
                                {{--<button type="button" class="btn btn-default navbar-btn">Forms</button>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-6">--}}
                            {{--<a href="{{ url('/test-cases') }}">--}}
                                {{--<button type="button" class="btn btn-default navbar-btn">Test Cases</button>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-6">--}}
                            {{--<a href="{{ url('/docs') }}">--}}
                                {{--<button type="button" class="btn btn-default navbar-btn">Docs</button>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
