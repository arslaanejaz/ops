@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            {!! $total?'<span class="label label-default">Total Links: '.$total.'</span>':'' !!}
        </div>
        <div class="panel-body">
            <a href="{{ url('projects/'.$projectId.'/links/create') }}" class="btn btn-success btn-sm" title="Add New Link">
                <i class="fa fa-plus" aria-hidden="true"></i> Add New
            </a>

            {!! Form::open(['method' => 'GET', 'url' => 'projects/'.$projectId.'/links', 'class' => 'navbar-form navbar-right', 'role' => 'search']) !!}
            <label>External Links:</label> <input type="checkbox" value="1" name="external" {{(isset($_GET['external']) && $_GET['external']==1)?'checked':''}}>
            <label>Internal Links:</label> <input type="checkbox" value="1" name="internal" {{(isset($_GET['internal']) && $_GET['internal']==1)?'checked':''}}>
            <div class="input-group">
                <input type="text" value="{{isset($_GET['search'])?$_GET['search']:''}}" class="form-control" name="search" placeholder="Search...">
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
                            <th>Uri</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Forms</th>
                            <th>Scraped</th>
                            <th>Scraped Time</th>
                            <th>Score</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        (isset($_GET['page']) && $_GET['page']>1)?$i=($_GET['page']-1)*config('view.page_limit'):$i=1;
                        @endphp
                        @foreach($links as $item)
                        @php
                        $uri = trim($item->uri);
                        $a = parse_url($uri);
                        $title = isset($a['query'])?$a['query']:'NO QUERY';
                        $path = isset($a['path'])?$a['path']:'NO PATH';
                        $herf = '<a title="'.$title.'" target="_blank" href="'.trim($item->uri).'">'.$path.'</a>'
                        @endphp
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{!! $herf !!}
                                <br />
                                {{ $uri }}
                                <br />
                                <b>Parent link:</b>
                                {{ $item->parent_link?$item->parent_link:'' }}
                            </td>
                            <td>{{ str_replace(['{', '}'], ['', ''], trim($item->title)) }}</td>
                            <td>{!! $item->type==0?'Internal':'External' !!}</td>
                            <td>{{ $item->forms->count() }}</td>
                            <td>{{ $item->scraped }}</td>
                            <td>{{ $item->scraped_time?($item->scraped_time/1000):0 }}</td>
                            <td>{{ $item->page_speed_score?$item->page_speed_score:'Not Calculated' }}</td>
                            <td>
                                <a href="{{ url('projects/'.$projectId.'/links/' . $item->id) }}" title="View Link"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                <a href="{{ url('projects/'.$projectId.'/links/' . $item->id . '/edit') }}" title="Edit Link"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                {!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['projects/'.$projectId.'/links', $item->id],
                                'style' => 'display:inline'
                                ]) !!}
                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'title' => 'Delete Link',
                                'onclick'=>'return confirm("Confirm delete?")'
                                )) !!}
                                {!! Form::close() !!}
                                <br />
                                <br />
                                @if($item->page_speed_score)
                                <a href="{{ url('projects/'.$projectId.'/page-speed/' . $item->id.'?json') }}" target="_blank" title="View Link"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Json</button></a>
                                @endif
                                <a href="{{ url('projects/'.$projectId.'/page-speed/' . $item->id.'?generateAgain') }}" target="_blank" title="View Link"><button class="btn btn-danger btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Generate Again</button></a>

                            </td>
                            <td><input type="checkbox" value="{{$item->id}}" class="delete-check" name="delete_check[]"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <?php $queryData = ['search' => Request::get('search'), 'external' => Request::get('external'), 'internal' => Request::get('internal')] ?>

                @include('partial/remove-all', ['_collection' => 'form', '_backLink' =>'projects/'.$projectId.'/links?'.http_build_query($queryData)])

                <div class="pagination-wrapper"> {!! $links->appends($queryData)->render() !!} </div>
            </div>

        </div>
    </div>
</div>
@endsection