<?php

namespace App\Http\Controllers;

use App\Classes\ApiTools;
use App\Http\Requests\UpcRequest;
use App\Models\ProductHistory;
use Illuminate\Support\Facades\DB;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class ProductDataController extends Controller
{
    //

    public function index() {
        return view('pages.add');
    }

    public function storeUpcs(UpcRequest $request) {

        $upcList = preg_split("/\\r\\n|\\r|\\n/", $request->upcs);

        $apiTools = new ApiTools();

        $apiTools->insertUpcs($upcList);

        return \Redirect::route('add')
            ->with('message', 'Upcs entered and refresh will start shortly!');
    }

    public function product($id) {

        $columns = [
            'upc',
            'parent_item_id',
            'name',
            'msrp',
            'sale_price',
            'number_of_reviews',
            'average_rating',
            'stock',
            'updated_at'
        ];

        $productData = ProductHistory::where('item_id', $id)->orderBy('id', 'desc') ->get();
        $productHistoryData = DB::table('product_history')->where('item_id', $id)->orderBy('id', 'desc')->paginate(10);

        $lava = new Lavacharts; // See note below for Laravel

        $ratings = $lava->DataTable();

        $rating1 = !is_null($productData[0]['rating_value_1']) ? $productData[0]['rating_value_1'] : 0;
        $rating2 = !is_null($productData[0]['rating_value_2']) ? $productData[0]['rating_value_2'] : 0;
        $rating3 = !is_null($productData[0]['rating_value_3']) ? $productData[0]['rating_value_3'] : 0;
        $rating4 = !is_null($productData[0]['rating_value_4']) ? $productData[0]['rating_value_4'] : 0;
        $rating5 = !is_null($productData[0]['rating_value_5']) ? $productData[0]['rating_value_5'] : 0;

        $ratings->addStringColumn('Ratings')
            ->addNumberColumn('Percent')
            ->addRow(['1 Star Ratings', $rating1])
            ->addRow(['2 Star Ratings', $rating2])
            ->addRow(['3 Star Ratings', $rating3])
            ->addRow(['4 Star Ratings', $rating4])
            ->addRow(['5 Star Ratings', $rating5]);

        $lava->PieChart('Ratings', $ratings, [
            'title'  => 'Most Recent Rating Distribution',
            'is3D'   => true,
            'chartArea' => [5 , 5],
            'animation' => [
                'startup' => true,
                'easing' => 'inAndOut'
            ],
            'colors' => ['#7bd9e1', '#ec6116', '#323232', '#b25e6b', '#399dbe'],
            'backgroundColor' => '#f5f8fa'
        ]);


        return view('pages.product', ['products' => $productHistoryData, 'columns' => $columns, 'lava' => $lava]);
    }

    public function graphData($id) {


        $productData = ProductHistory::where('item_id', $id)->orderBy('id', 'desc') ->get();

        $lava = new Lavacharts; // See note below for Laravel

        $data = $lava->DataTable();

        $data->addDateColumn('Date')
            ->addNumberColumn('Number Of Reveiws')
            ->addNumberColumn('Average Rating');

        foreach ($productData as $product) {

            $data->addRow([$product->created_at->format('Y-m-d H:i:s'), $product->number_of_reviews, $product->average_rating]);
        }


        $lava->LineChart('sales', $data, [
            'title' => 'Review and Rating Data',
            'colors' => ['#7bd9e1', '#ec6116'],
            'pointSize' => 2,
            'backgroundColor' => '#f5f8fa'
        ]);

        return view('pages.graph', ['lava' => $lava]);
    }
}
