@extends('layouts.app')

@section('content')
    <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">Doc {{ $doc->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('projects/'.$projectId.'/docs') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('projects/'.$projectId.'/docs/' . $doc->id . '/edit') }}" title="Edit Doc"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['projects/'.$projectId.'/docs', $doc->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Doc',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $doc->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Url </th><td> {{ $doc->url }} </td>
                                    </tr>
                                    <tr><th> Request </th><td> <code>{{ json_encode($doc->request, JSON_PRETTY_PRINT) }}</code> </td></tr>
                                    <tr><th> Method </th><td> {{ $doc->method }} </td></tr>
                                    <tr><th> Response </th><td> <iframe  width="100%" height="500px" frameBorder="0" srcdoc="{{ $doc->response }}"></iframe> </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
@endsection
