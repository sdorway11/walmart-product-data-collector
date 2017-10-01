<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    //
    public function index() {
        $columns = [
            'upc',
            'item_id',
            'parent_item_id',
            'name',
            'msrp',
            'sale_price',
            'stock',
            'customer_rating',
            'updated_at'

        ];
        $products =  DB::table('products')->paginate(10);;

        return view('home', ['products' => $products, 'columns' => $columns]);
    }

    public function searchData(SearchRequest $request) {

        $columns = [
            'upc',
            'item_id',
            'parent_item_id',
            'name',
            'msrp',
            'sale_price',
            'stock',
            'customer_rating',
            'updated_at'

        ];

        $search = $request->search;

        $results = DB::table('products')
            ->where('item_id', $search)
            ->orWhere('upc', $search)
            ->orWhere('parent_item_id', $search)
            ->paginate(10);

        return view('home', ['products' => $results, 'columns' => $columns]);
    }
}
