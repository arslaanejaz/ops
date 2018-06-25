@extends('layouts.app')

@section('content')
    <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">Forms
                    {!! $total?'<span class="label label-default">Total: '.$total.'</span>':'' !!}
                    </div>
                    <div class="panel-body">
                        <a href="{{ url('projects/'.$projectId.'/forms/create') }}" class="btn btn-success btn-sm" title="Add New Form">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => 'projects/'.$projectId.'/forms', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
                                        <th>#</th><th>Page</th><th>Method</th><th>Action</th><th>Status</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                (isset($_GET['page']) && $_GET['page']>1)?$i=($_GET['page']-1)*config('view.page_limit'):$i=1;
                                @endphp
                                @foreach($forms as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td><a target="_blank" href="{{$item->link->uri}}">{{ strip_tags($item->name?$item->name:'[empty]') }}</a>
                                            <br /> <i>{{$item->link->uri}}</i></td>
                                        <td>{!! $item->attr['_method']?$item->attr['_method']:$item->attr['method'] !!}</td>
                                        <td>{{ $item->attr['action'] }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <a href="{{ url('projects/'.$projectId.'/forms/' . $item->id) }}" title="View Form"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('projects/'.$projectId.'/forms/' . $item->id . '/edit') }}" title="Edit Form"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['projects/'.$projectId.'/forms', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Form',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                        <td><input type="checkbox" value="{{$item->id}}" class="delete-check" name="delete_check[]"></td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <?php $queryData = ['search' => Request::get('search')]?>
                            @include('partial/remove-all', ['_collection' => 'form', '_backLink' =>'projects/'.$projectId.'/forms?'.http_build_query($queryData)])
                            <div class="pagination-wrapper"> {!! $forms->appends($queryData)->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
@endsection
