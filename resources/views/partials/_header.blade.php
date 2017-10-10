<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">{{ env('APP_NAME') }}</a>
        </div>
        <ul class="nav navbar-nav">
            <li {{ (Request::is('/') ? 'class=active' : '') }}><a href="/">Home</a></li>
            <li {{ (Request::is('add') ? 'class=active' : '') }}><a href={{route('add')}}>Add Products <span class="glyphicon-plus"></span></a></li>
            <li {{ (Request::is('images') ? 'class=active' : '') }}><a href={{route('images')}}>Product Images</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            {{--<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>--}}
            {{--<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>--}}
        </ul>
    </div>
</nav>
