@extends('layouts.app')

@section('content')


<section class="inner-content">
	
    <div class="container">


         
          
            @if(Auth::user()->role==0)
            <div class="col-md-6">	
                <a href="{{ url('/scrape') }}">
                    <button type="button" class="btn btn-default navbar-btn">Scrape</button>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ url('/projects') }}">
                    <button type="button" class="btn btn-default navbar-btn">Projects</button>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ url('/links') }}">
                    <button type="button" class="btn btn-default navbar-btn">2</button>
                </a>
            </div>
        @endif


    </div>

</section>

@endsection
