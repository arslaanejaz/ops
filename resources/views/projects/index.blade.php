@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">Projects
            {!! $total?'<span class="label label-default">Total: '.$total.'</span>':'' !!}
        </div>
        <div class="panel-body">
            <a href="{{ url('/projects/create') }}" class="btn btn-success btn-sm" title="Add New Project">
                <i class="fa fa-plus" aria-hidden="true"></i> Add New
            </a>

            {!! Form::open(['method' => 'GET', 'url' => '/projects', 'class' => 'navbar-form navbar-right', 'role' =>
            'search']) !!}
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
            {!! Form::close() !!}

            <br />
            <br />
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Uri</th>
                            <th>Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        (isset($_GET['page']) && $_GET['page']>1)?$i=($_GET['page']-1)*config('view.page_limit'):$i=1;
                        @endphp
                        @foreach($projects as $item)
                        <tr class="{{$item->testing === "1" ? "bg-primary" : ""}}">
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->uri }}</td>
                            <td>{{ json_encode($item->login) }}</td>
                            <td>
                                <a href="{{ url('/projects/' . $item->id) }}" title="View Project"><button
                                        class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i>
                                        View</button></a>
                                <a href="{{ url('/projects/' . $item->id . '/edit') }}" title="Edit Project"><button
                                        class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"
                                            aria-hidden="true"></i> Edit</button></a>
                                {!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['/projects', $item->id],
                                'style' => 'display:inline'
                                ]) !!}
                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'title' => 'Delete Project',
                                'onclick'=>'return confirm("Confirm delete?")'
                                )) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $projects->appends(['search' => Request::get('search')])->render()
                    !!} </div>
            </div>

        </div>
    </div>
</div>
@endsection