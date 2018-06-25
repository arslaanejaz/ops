@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">Links
                {!! $total?'<span class="label label-default">Total: '.$total.'</span>':'' !!}
            </div>
            {!! Form::open(['method' => 'GET', 'url' => 'projects/'.$projectId.'/reports', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
            <div class="panel-body">


                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th>#</th><th>URL</th><th>Preview</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                        $i = 1;
                        @endphp

                        @foreach($reports as $item)
                        <tr>
                            <td>{{$i++}}</td>
                            <td><a href="{{$item->uri}}" target="_blank">{{$item->uri}}</a></td>
                            <td> @if(isset($_GET['iframe']))<iframe  width="100%" height="500px" frameBorder="0" srcdoc="{{ $item->response }}"></iframe>@else -- @endif  </td>
                        </tr>
                        @endforeach


                        </tbody>
                    </table>
                    <?php $queryData = ['search' => Request::get('search'), 'external' => Request::get('external'),'internal' => Request::get('internal')]?>

                    <div class="pagination-wrapper"> {!! $reports->appends($queryData)->render() !!} </div>
                </div>

            </div>
        </div>
    </div>
@endsection
