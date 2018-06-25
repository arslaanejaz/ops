@extends('layouts.app')

@section('content')
    <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit TestCase #{{ $testcase->id }}</div>
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

                        {!! Form::model($testcase, [
                            'method' => 'PATCH',
                            'url' => ['projects/'.$projectId.'/test-cases', $testcase->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('test-cases.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
@endsection
