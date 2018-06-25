@extends('layouts.app')

@section('content')
    <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">Testcases
                    {!! $total?'<span class="label label-default">Total: '.$total.'</span>':'' !!}
                    </div>
                    <div class="panel-body">
                        <a href="{{ url('projects/'.$projectId.'/test-cases/create') }}" class="btn btn-success btn-sm" title="Add New TestCase">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => 'projects/'.$projectId.'/test-cases', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
                                        <th>#</th><th>Obj</th><th>Action</th><th>Method</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                (isset($_GET['page']) && $_GET['page']>1)?$i=($_GET['page']-1)*config('view.page_limit'):$i=1;
                                @endphp
                                @foreach($testcases as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td><code>{{ json_encode($item->obj, JSON_PRETTY_PRINT) }}</code></td><td>{{ $item->action }}</td>
                                        <td><td>{!! $item->__method?$item->__method:$item->method !!}</td></td>
                                        <td>
                                            <a href="{{ url('projects/'.$projectId.'/test-cases/' . $item->id) }}" title="View TestCase"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('projects/'.$projectId.'/test-cases/' . $item->id . '/edit') }}" title="Edit TestCase"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['projects/'.$projectId.'/test-cases', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete TestCase',
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
                            @include('partial/remove-all', ['_collection' => 'test_cases', '_backLink' =>'projects/'.$projectId.'/test-cases?'.http_build_query($queryData)])
                            <div class="pagination-wrapper"> {!! $testcases->appends($queryData)->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
@endsection
