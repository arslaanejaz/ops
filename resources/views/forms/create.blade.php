@extends('layouts.app')

@section('content')
    <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Form</div>
                    <div class="panel-body">
                        <a href="{{ url('projects/'.$projectId.'/forms') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => 'projects/'.$projectId.'/forms', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @include ('forms.form')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
@endsection
