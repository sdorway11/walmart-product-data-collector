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
            'upc' => 'UPC',
            'item_id' => 'ITEM ID',
            'parent_item_id' => 'PARENT ITEM ID',
            'name' => 'NAME',
            'msrp' => 'MSRP',
            'sale_price' => 'SALE PRICE',
            'stock' => 'STOCK',
            'customer_rating' => 'CUSTOMER RATING',
            'updated_at' => 'LAST UPDATED'
        ];

        $products =  DB::table('products')->paginate(10);;

        return view('home', ['products' => $products, 'columns' => $columns]);
    }

    public function searchData(SearchRequest $request) {

        $columns = [
            'upc' => 'UPC',
            'item_id' => 'ITEM ID',
            'parent_item_id' => 'PARENT ITEM ID',
            'name' => 'NAME',
            'msrp' => 'MSRP',
            'sale_price' => 'SALE PRICE',
            'stock' => 'STOCK',
            'customer_rating' => 'CUSTOMER RATING',
            'updated_at' => 'LAST UPDATED'
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
