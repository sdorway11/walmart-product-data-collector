@extends('layouts.head')
@section('body')
    @include("partials/_search")
    @include("partials/_products", ['products'=> $products, 'columns' => $columns])
@endsection
@section('scripts')
    @include("partials/_scripts")
@endsection