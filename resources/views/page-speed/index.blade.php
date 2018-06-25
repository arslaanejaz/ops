@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">Links
                {!! $total?'<span class="label label-default">Total: '.$total.'</span>':'' !!}
            </div>
            <div class="panel-body">
                <a href="{{ url('projects/'.$projectId.'/links/create') }}" class="btn btn-success btn-sm" title="Add New Link">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                </a>

                {!! Form::open(['method' => 'GET', 'url' => 'projects/'.$projectId.'/links', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                <div class="input-group">
                    <input type="text" value="{{isset($_GET['search'])?$_GET['search']:''}}" class="form-control" name="search" placeholder="Search...">
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
                            <th>#</th>
                            <th>Uri</th>
                            <th>Title</th>
                            <th>responseCode</th>
                            <th>Google Speed</th>
                            {{--<th>loadingExperience</th>--}}

                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                        (isset($_GET['page']) && $_GET['page']>1)?$i=($_GET['page']-1)*config('view.page_limit'):$i=1;
                        @endphp
                        @foreach($links as $item)
                            @php
                                $data = [];
                                if($item->pageSpeed){
                                 $data = $item->pageSpeed->data;
                                }

                                    $uri = trim($item->uri);
                                    //$a = parse_url($uri);
                                    //$title = isset($a['query'])?$a['query']:'NO QUERY';
                                    //$path = isset($a['path'])?$a['path']:'NO PATH';
                                    //$herf = '<a title="'.$title.'" target="_blank" href="'.trim($item->uri).'">'.$path.'</a>'
                            @endphp
                            @if(isset($data['responseCode']))
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $uri }}</td>
                                <td>{{ $data['title'] }}</td>
                                <td>{{ $data['responseCode'] }}</td>
                                <td>{{ $data['ruleGroups']['SPEED']['score'] }}</td>
{{--                                <td>{{ $data['loadingExperience']['overall_category'] }}</td>--}}
                                {{--<td>{{ json_encode($data['pageStats']) }}</td>--}}
                                <td>
                                    <a href="{{ url('projects/'.$projectId.'/page-speed/' . $item->id) }}" title="View Link"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                    <a href="{{ url('projects/'.$projectId.'/page-speed/' . $item->id.'?json') }}" target="_blank" title="View Link"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Json</button></a>
                                    <a href="{{ url('projects/'.$projectId.'/page-speed/' . $item->id.'?generateAgain') }}" target="_blank" title="View Link"><button class="btn btn-danger btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Generate Again</button></a>
                                    {{--<a href="{{ url('projects/'.$projectId.'/links/' . $item->id . '/edit') }}" title="Edit Link"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>--}}

                                </td>
                                {{--<td><input type="checkbox" value="{{$item->id}}" class="delete-check" name="delete_check[]"></td>--}}
                            </tr>
                            @else
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $uri }}</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>
                                        <a href="{{ url('projects/'.$projectId.'/page-speed/' . $item->id) }}" title="View Link"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                        <a href="{{ url('projects/'.$projectId.'/page-speed/' . $item->id.'?generateAgain') }}" target="_blank" title="View Link"><button class="btn btn-danger btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Generate Again</button></a>

                                        {{--<a href="{{ url('projects/'.$projectId.'/links/' . $item->id . '/edit') }}" title="Edit Link"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>--}}

                                    </td>
                                    {{--<td><input type="checkbox" value="{{$item->id}}" class="delete-check" name="delete_check[]"></td>--}}
                                </tr>
                                @endif
                        @endforeach
                        </tbody>
                    </table>
                    <?php $queryData = ['search' => Request::get('search')]?>

                    {{--@include('partial/remove-all', ['_collection' => 'form', '_backLink' =>'projects/'.$projectId.'/links?'.http_build_query($queryData)])--}}

                    <div class="pagination-wrapper"> {!! $links->appends($queryData)->render() !!} </div>
                </div>

            </div>
        </div>
    </div>
@endsection
