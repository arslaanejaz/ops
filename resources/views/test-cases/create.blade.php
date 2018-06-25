@extends('layouts.app')

@section('content')
    <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New TestCase</div>
                    <div class="panel-body">
                        <a href="{{ url('projects/'.$projectId.'/test-cases') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => 'projects/'.$projectId.'/test-cases', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @include ('test-cases.form')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
@endsection
