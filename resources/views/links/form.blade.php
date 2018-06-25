<div class="form-group {{ $errors->has('uri') ? 'has-error' : ''}}">
    {!! Form::label('uri', 'Uri', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('uri', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('uri', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    {!! Form::label('type', 'Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('type', ['internal', 'external', 'other'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('scraped') ? 'has-error' : ''}}">
    {!! Form::label('scraped', 'Scraped', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('scraped', null, ['class' => 'form-control']) !!}
        {!! $errors->first('scraped', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
