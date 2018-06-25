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

<div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
    {!! Form::label('url', 'Url', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('url', null, ['class' => 'form-control']) !!}
        {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('request') ? 'has-error' : ''}}">
    {!! Form::label('request', 'Request', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('request', null, ['class' => 'form-control']) !!}
        {!! $errors->first('request', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('method') ? 'has-error' : ''}}">
    {!! Form::label('method', 'Method', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('method', null, ['class' => 'form-control']) !!}
        {!! $errors->first('method', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('response') ? 'has-error' : ''}}">
    {!! Form::label('response', 'Response', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('response', null, ['class' => 'form-control']) !!}
        {!! $errors->first('response', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
