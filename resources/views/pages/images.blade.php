@extends('layouts.head')
@section('body')
    <div class="container">
        <table class="table table-hover">
            <thead>
            @foreach($columns as $key => $value)
                <th>{{$value}}</th>
            @endforeach
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr class='clickable-row' data-href='/product/{{$product->item_id}}'>
                    @foreach($columns as $key => $value)
                        <td>
                            {{$product->$key? $product->$key : 'No Data'}}
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection