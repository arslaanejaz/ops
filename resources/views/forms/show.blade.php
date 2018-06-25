@extends('layouts.app')

@section('content')
    <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">Form: <b>{{ $form->name }}</b></div>
                    <div class="panel-body">

                        <a href="{{ url('projects/'.$projectId.'/forms') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('projects/'.$projectId.'/forms/' . $form->id . '/edit') }}" title="Edit Form"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['projects/'.$projectId.'/forms', $form->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Form',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><th> Inputs </th><td>
                                        @foreach($form->inputs as $i)
                                               {!! json_format_custom($i) !!}
                                            <hr />
                                            @endforeach
                                        </td></tr>

                                    <tr><th> Selects </th><td>
                                        @foreach($form->selects as $i)
                                                {!! json_format_custom($i) !!}
                                            <hr />
                                            @endforeach
                                        </td></tr><tr><th> Textareas </th><td>
                                        @foreach($form->textareas as $i)
                                                {!! json_format_custom($i) !!}
                                            <hr />
                                            @endforeach
                                        </td></tr>
                                    <tr><th> Status </th><td> {{ $form->status }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
    @php
    function json_format_custom($i){
    if($i->status==1) return '<code>'.json_encode($i, JSON_PRETTY_PRINT).'</code>';
    else return json_encode($i, JSON_PRETTY_PRINT);
    } @endphp
@endsection

