@extends('layouts.app')

@section('content')
    <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">Docs
                    {!! $total?'<span class="label label-default">Total: '.$total.'</span>':'' !!}
                    </div>
                    <div class="panel-body">
                        <a href="{{ url('projects/'.$projectId.'/docs/create') }}" class="btn btn-success btn-sm" title="Add New Doc">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => 'projects/'.$projectId.'/docs', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Status</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                (isset($_GET['page']) && $_GET['page']>1)?$i=($_GET['page']-1)*config('view.page_limit'):$i=1;
                                @endphp
                                @foreach($docs as $item)
                                    <tr>
                                        <td>
                                            Url: {{ $item->url }}
                                            <hr />
                                            Request: <code>{{ json_encode($item->request, JSON_PRETTY_PRINT) }}</code>
                                            <hr />
                                            Status Code: {{ $item->status_code }}
                                            <hr />
                                            <iframe  width="100%" height="400px" frameBorder="0" srcdoc="{{ $item->response }}"></iframe></td>
                                        <td>
                                            <a href="{{ url('projects/'.$projectId.'/docs/' . $item->id) }}" title="View Doc"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('projects/'.$projectId.'/docs/' . $item->id . '/edit') }}" title="Edit Doc"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['projects/'.$projectId.'/docs', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Doc',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $docs->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
@endsection
