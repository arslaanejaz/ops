@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Link: <b>{{ $link->title }}</b></div>
                    <div class="panel-body">

                        <a href="{{ url('projects/'.$projectId.'/page-speed') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        {{--<a href="{{ url('projects/'.$projectId.'/page-speed/' . $link->id . '/edit') }}" title="Edit Link"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>--}}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><th> Uri </th><td> {{ $link->uri }} </td></tr>
                                    <tr><th> Title </th><td> {{ $link->title }} </td></tr>
                                    <tr><th> Data </th><td>{{ str_replace(['{', '}'], ['<br />', '<br />'], json_encode($link->pageSpeed->data, JSON_PRETTY_PRINT)) }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
