@extends('layouts.app')

@section('content')
    <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">TestCase {{ $testcase->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('projects/'.$projectId.'/test-cases') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('projects/'.$projectId.'/test-cases/' . $testcase->id . '/edit') }}" title="Edit TestCase"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['testcases', $testcase->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete TestCase',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $testcase->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Name </th><td> {{ $testcase->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Action </th><td> {{ $testcase->action }} </td>
                                    </tr>
                                    <tr>
                                        <th> Method </th><td> {{ $testcase->method }} </td>
                                    </tr>
                                    <tr>
                                        <th> Method </th><td> <code class="">{{ json_encode($testcase->obj, JSON_PRETTY_PRINT) }}</code> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
@endsection
