@extends('layouts.app')

@section('content')

    	<div class="login-form">
        
        	    {!! Form::open(['method'=>'POST', 'url' => 'login']) !!}

           <div class="form-head"> 
        	<h2>Welcome To OPS</h2>
           </div> 
		   
		   
             <div class="form-inner">
                    <div class="form-group">
                        {!! Form::label('email', 'User Name: ')!!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('password', 'Password: ') !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                </div>
                           {!! Form::submit('Login', ['class' => 'btn pull-right']) !!}

             
            	<a href="#">Forgot your password?</a>
				
				  {!! Form::token() !!}
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
			
				
     </div>
 

	
	
	
	  
 
  

@endsection
