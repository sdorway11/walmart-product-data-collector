@extends('layouts.head')
@section('body')
    @if(Session::has('message'))
        <div class="alert alert-info">
            {{Session::get('message')}}
        </div>
    @endif
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <div class="container">
        {!! Form::open(array('route' => 'upcs_store', 'class' => 'form')) !!}

        <div class="form-group">
            {!! Form::textarea('upcs', null,
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Enter Upcs')) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Enter Upcs',
              array('class'=>'btn btn-primary')) !!}
        </div>
        {{ Form::close() }}
    </div>
@endsection