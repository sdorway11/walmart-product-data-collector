<!doctype html>
<html lang="{{ config('app.locale') }}">
    @include("partials._head")
    <body>
        @include("partials/_header")
        @yield('body')
        @yield('scripts')
    </body>
</html>