
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">Links
                {{ $links->count() }}
            </div>
            <div class="panel-body">

                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Uri</th>
                            <th>Title</th>
                            <th>responseCode</th>
                            <th>Google Speed</th>
                            <th>loadingExperience</th>

                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                        $i=1;
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
                                    <td>{!! isset($data['loadingExperience']['metrics'])?$data['loadingExperience']['metrics']['FIRST_CONTENTFUL_PAINT_MS']['category']:'--' !!}</td>
                                    <td>
                                        {{--<a href="{{ url('projects/'.$projectId.'/page-speed/' . $item->id) }}" title="View Link"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>--}}
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
                                        {{--<a href="{{ url('projects/'.$projectId.'/page-speed/' . $item->id) }}" title="View Link"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>--}}
                                        {{--<a href="{{ url('projects/'.$projectId.'/links/' . $item->id . '/edit') }}" title="Edit Link"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>--}}

                                    </td>
                                    {{--<td><input type="checkbox" value="{{$item->id}}" class="delete-check" name="delete_check[]"></td>--}}
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <?php $queryData = ['search' => Request::get('search')]?>

                </div>

            </div>
        </div>
    </div>

