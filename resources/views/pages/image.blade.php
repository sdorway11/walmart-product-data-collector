@extends('layouts.head')
@section('body')
    <div class="container">
        <div class="row">
            <h2>{{ $product->name }}</h2>
            <h3>{{ $product->upc }}</h3>
        </div>
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <th>Thumbnail</th>
            </thead>
            <tr>
                <td>{{ $product->thumbnail }}</td>
            </tr>
        </table>
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
            <th>Medium</th>
            </thead>
            <tr>
                <td>{{ $product->medium }}</td>
            </tr>
        </table>
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
            <th>Large</th>
            </thead>
            <tr>
                <td>{{ $product->large }}</td>
            </tr>
        </table>
    </div>
@endsection