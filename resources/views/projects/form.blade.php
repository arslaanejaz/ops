<script>
    $(document).on('click', '.remove-action', function(){
        $(this).parent().parent().parent().remove();
    })
    $(document).on('click', '.append-action', function(){
        var name = $(this).attr('data-name');
        var val = $('#'+name+'_key').val();
        if(val){
            $(this).parent().parent().parent().prepend(
                    '<div class="form-group ">' +
                    '<label class="col-md-2 control-label">'+val+' => </label>' +
                    '<div class="input-group col-md-6">' +
                    '<input required="required" name="'+name+'['+val+'][]" type="text" placeholder="(.*)blog\\/p\\/(.*)" class="form-control"><span class="input-group-btn">' +
                    '<button type="button" class="btn btn-danger remove-action"><i class="fa fa-minus-circle"></i></button></span>' +
                    '</div>' +
                    '</div>'
            );
            $('#'+name+'_key').val('');
        }else{
            alert('Key Is Required.');
        }
    });
</script>

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name of project', 'required' => 'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('uri') ? 'has-error' : ''}}">
    {!! Form::label('uri', 'Uri', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('uri', null, ['class' => 'form-control',  'placeholder' => 'http://xxx.example.com:8080/', 'required' => 'required']) !!}
        {!! $errors->first('uri', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('login') ? 'has-error' : ''}}">
    {!! Form::label('login', 'Login', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                @if(isset($project) && isset($project->login))
            @foreach($project->login as $key=>$val)
            @foreach($val as $v)
                <div class="form-group ">
                    <label class="col-md-2 control-label">{{$key}} => </label>
                    <div class="input-group col-md-6">
                    <input required="required" name="login[{{$key}}][]" value="{{$v}}" type="text" class="form-control"><span class="input-group-btn">
                    <button type="button" class="btn btn-danger remove-action"><i class="fa fa-minus-circle"></i></button></span>
                    </div>
                </div>
            @endforeach
            @endforeach
        @endif
        <div class="input-group col-md-8">
            <input type="text" id="login_key" placeholder="Key" class="form-control">
            <span class="input-group-btn"><button type="button" data-name="login" class="btn btn-default append-action"><i class="fa fa-plus-circle"></i></button></span>
        </div>

        {!! $errors->first('login', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('host') ? 'has-error' : ''}}">
    {!! Form::label('host', 'Host', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('host', null, ['class' => 'form-control', 'placeholder' => 'xxx.example.com', 'required' => 'required']) !!}
        {!! $errors->first('host', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('skip_uri') ? 'has-error' : ''}}">
    {!! Form::label('skip_uri', 'Skip Uri', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                @if(isset($project) && isset($project->skip_uri))
            @foreach($project->skip_uri as $key=>$val)
            @foreach($val as $v)
                <div class="form-group ">
                    <label class="col-md-2 control-label">{{$key}} => </label>
                    <div class="input-group col-md-6">
                    <input required="required" name="skip_uri[{{$key}}][]" value="{{$v}}" type="text" class="form-control"><span class="input-group-btn">
                    <button type="button" class="btn btn-danger remove-action"><i class="fa fa-minus-circle"></i></button></span>
                    </div>
                </div>
            @endforeach
            @endforeach
        @endif
        <div class="input-group col-md-8">
            <input type="text" id="skip_uri_key" placeholder="Key" class="form-control">
            <span class="input-group-btn"><button type="button" data-name="skip_uri" class="btn btn-default append-action"><i class="fa fa-plus-circle"></i></button></span>
        </div>
<i>Skip by query, regex url</i>
        {!! $errors->first('skip_uri', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skip_repeat') ? 'has-error' : ''}}">
    {!! Form::label('skip_repeat', 'Skip Repeat', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                @if(isset($project) && isset($project->skip_repeat))
            @foreach($project->skip_repeat as $key=>$val)
            @foreach($val as $v)
                <div class="form-group ">
                    <label class="col-md-2 control-label">{{$key}} => </label>
                    <div class="input-group col-md-6">
                    <input required="required" name="skip_repeat[{{$key}}][]" value="{{$v}}" type="text" class="form-control"><span class="input-group-btn">
                    <button type="button" class="btn btn-danger remove-action"><i class="fa fa-minus-circle"></i></button></span>
                    </div>
                </div>
            @endforeach
            @endforeach
        @endif
        <div class="input-group col-md-8">
            <input type="text" id="skip_repeat_key" placeholder="Key" class="form-control">
            <span class="input-group-btn"><button type="button" data-name="skip_repeat" class="btn btn-default append-action"><i class="fa fa-plus-circle"></i></button></span>
        </div>
                    <i>Skip repeat by query, regex url</i>
        {!! $errors->first('skip_repeat', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skip_repeat_form') ? 'has-error' : ''}}">
    {!! Form::label('skip_repeat_form', 'Skip Repeat Form', ['class' => 'col-md-4 control-label']) !!}

    <div class="col-md-6">
                @if(isset($project) && isset($project->skip_repeat_form))
            @foreach($project->skip_repeat_form as $key=>$val)
            @foreach($val as $v)
                <div class="form-group ">
                    <label class="col-md-2 control-label">{{$key}} => </label>
                    <div class="input-group col-md-6">
                    <input required="required" name="skip_repeat_form[{{$key}}][]" value="{{$v}}" type="text" class="form-control"><span class="input-group-btn">
                    <button type="button" class="btn btn-danger remove-action"><i class="fa fa-minus-circle"></i></button></span>
                    </div>
                </div>
            @endforeach
            @endforeach
        @endif
        <div class="input-group col-md-8">
            <input type="text" id="skip_repeat_form_key" placeholder="Key" class="form-control">
            <span class="input-group-btn"><button type="button" data-name="skip_repeat_form" class="btn btn-default append-action"><i class="fa fa-plus-circle"></i></button></span>
        </div>
        <i>regex on form action</i>
        {!! $errors->first('skip_repeat_form', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('x_headers') ? 'has-error' : ''}}">
    {!! Form::label('x_headers', 'X Headers', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                @if(isset($project) && isset($project->x_headers))
            @foreach($project->x_headers as $key=>$val)
            @foreach($val as $v)
                <div class="form-group ">
                    <label class="col-md-2 control-label">{{$key}} => </label>
                    <div class="input-group col-md-6">
                    <input required="required" name="x_headers[{{$key}}][]" value="{{$v}}" type="text" class="form-control"><span class="input-group-btn">
                    <button type="button" class="btn btn-danger remove-action"><i class="fa fa-minus-circle"></i></button></span>
                    </div>
                </div>
            @endforeach
            @endforeach
        @endif
        <div class="input-group col-md-8">
            <input type="text" id="x_headers_key" placeholder="Key" class="form-control">
            <span class="input-group-btn"><button type="button" data-name="x_headers" class="btn btn-default append-action"><i class="fa fa-plus-circle"></i></button></span>
        </div>

        {!! $errors->first('x_headers', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('testing') ? 'has-error' : ''}}">
    {!! Form::label('testing', 'Testing', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('testing', ['', 'On', 'Off'], null, ['class' => 'form-control']) !!}
        {!! $errors->first('testing', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
