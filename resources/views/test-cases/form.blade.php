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
                    '<input required="required" name="'+name+'['+val+'][]" type="text" class="form-control"><span class="input-group-btn">' +
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
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('action') ? 'has-error' : ''}}">
    {!! Form::label('action', 'Action', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('action', null, ['class' => 'form-control']) !!}
        {!! $errors->first('action', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('method') ? 'has-error' : ''}}">
    {!! Form::label('method', 'Method', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('method', null, ['class' => 'form-control']) !!}
        {!! $errors->first('method', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('__method') ? 'has-error' : ''}}">
    {!! Form::label('__method', '  Method', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('__method', null, ['class' => 'form-control']) !!}
        {!! $errors->first('__method', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    {!! Form::label('type', 'Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('type', ['form-data', 'x-www-from-urlencoded', 'raw', 'binary', 'Dusk', 'UnitTest', 'API','other'], null, ['class' => 'form-control']) !!}
        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('obj') ? 'has-error' : ''}}">
    {!! Form::label('obj', 'Obj', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <pre>
        {!! Form::textarea('obj', null, ['class' => 'form-control']) !!}
        </pre>
        {!! $errors->first('obj', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('options') ? 'has-error' : ''}}">
    {!! Form::label('options', 'Options', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                @if(isset($testcase) && isset($testcase->options))
            @foreach($testcase->options as $key=>$val)
            @foreach($val as $v)
                <div class="form-group ">
                    <label class="col-md-2 control-label">{{$key}} => </label>
                    <div class="input-group col-md-6">
                    <input required="required" name="options[{{$key}}][]" value="{{$v}}" type="text" class="form-control"><span class="input-group-btn">
                    <button type="button" class="btn btn-danger remove-action"><i class="fa fa-minus-circle"></i></button></span>
                    </div>
                </div>
            @endforeach
            @endforeach
        @endif
        <div class="input-group col-md-8">
            <input type="text" id="options_key" placeholder="Key" class="form-control">
            <span class="input-group-btn"><button type="button" data-name="options" class="btn btn-default append-action"><i class="fa fa-plus-circle"></i></button></span>
        </div>

        {!! $errors->first('options', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
