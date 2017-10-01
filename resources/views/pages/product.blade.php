@extends('layouts.head')
@section('body')
    <div class="container">
        <div class="row">
            <h2>{{ $products[0]->name }}</h2>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <img class="img-responsive img-rounded" src="{{$products[0]->large_image}}" alt="No Product Image" width="300" height="auto">
                </div>
                <div class="col-sm-6">
                    <div id="chart-div" style="width: 500px; height: 300px;"></div>
                </div>
                <?= $lava->render('PieChart', 'Ratings', 'chart-div',  ['width' => 10]) ?>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <a href="/graph/{{$products[0]->item_id}}">
            <div class="btn btn-primary col-lg-12 img-rounded text-center" >
                Show Product Graph
            </div>
        </a>
    </div>
    @include("partials/_products", ['products'=> $products, 'columns' => $columns])
@endsection