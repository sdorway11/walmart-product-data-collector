<div class="container">
    <table class="table table-hover">
        <thead>
            @foreach($columns as $column)
                <th>{{$column}}</th>
            @endforeach
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr class='clickable-row' data-href='/product/{{$product->item_id}}'>
                    @foreach($columns as $key)

                        <td>
                            {{$product->$key? $product->$key : 'No Data'}}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
</div>