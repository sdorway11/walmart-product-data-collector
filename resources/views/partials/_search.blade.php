<div class="container">
    <div class="row">
        {!! Form::open(array('route' => 'search', 'class' => 'form')) !!}

        <div class="form-group col-lg-11">
            {!! Form::text('search', null,
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Search...')) !!}
        </div>

        <div class="form-group col-lg-1">
            {!! Form::submit('Search',
              array('class'=>'btn btn-primary')) !!}
        </div>

        {{ Form::close() }}
    </div>
</div>