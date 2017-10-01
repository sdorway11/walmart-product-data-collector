@extends('layouts.head')
@section('body')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="chart-div"></div>
            </div>
            <?= $lava->render('LineChart', 'sales', 'chart-div') ?>
        </div>
    </div>
@endsection