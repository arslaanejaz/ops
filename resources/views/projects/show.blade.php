@extends('layouts.app')

@section('content')
    <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">Project {{ $project->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/projects') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/projects/' . $project->id . '/edit') }}" title="Edit Project"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['projects', $project->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Project',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $project->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $project->name }} </td></tr>
                                    <tr><th> Uri </th><td> {{ $project->uri }} </td></tr>
                                    <tr><th> Login </th>
                                        <td> {{ json_encode($project->login) }} </td>
                                    </tr>
                                    <tr>
                                        <th> Components </th>
                                        <td>
                                            <a href="{{ url('/projects/'.$project->id.'/links') }}" class="btn btn-primary btn-md" role="button">Links</a>
                                            <a href="{{ url('/projects/'.$project->id.'/forms') }}" class="btn btn-danger btn-md" role="button">Forms</a>
                                            <a href="{{ url('/projects/'.$project->id.'/test-cases') }}" class="btn btn-info btn-md" role="button">Test Cases</a>
                                            <a href="{{ url('/projects/'.$project->id.'/docs') }}" class="btn btn-success btn-md" role="button">Docs</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
@endsection
