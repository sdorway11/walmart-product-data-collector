<?php


namespace App\Classes;



use App\Models\Product;
use App\Models\ProductHistory;
use App\Models\Upc;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use WalmartApiClient\Exception\Handler\ApiExceptionHandler;
use WalmartApiClient\Factory\CollectionFactory;
use WalmartApiClient\Factory\EntityFactory;
use WalmartApiClient\Http\TransportService;
use WalmartApiClient\Service\OfferService;
use WalmartApiClient\Service\ProductService;
use WalmartApiClient\Service\ReviewService;
use WalmartApiClient\Service\TaxonomyService;

class ApiTools
{

    /**
     * @param $ids
     * @return mixed|string
     */
    public function getProductData($ids) {
        $base_url = "http://api.walmartlabs.com/v1/items";
        $apiKey = env('API_KEY');

        $idArray = implode(',',$ids);

        $data = [
            'ids' => $idArray,
            'apiKey' => $apiKey,
            'format' => 'json'
        ];

        $client = new Client();

        try {
            $res = $client->get($base_url, ['query' => $data]);

            $result = json_decode($res->getBody()->getContents());
        } catch(\Exception $e) {
            echo $e->getMessage();

            $result = "No Data";
            file_put_contents('/srv/projects/walmartClient/storage/logs/response.log', print_r($res,true));
        }

        return $result;

    }

    /**
     * @return array
     */
    public function getItemIds() {

        $ids = Product::all()->pluck('item_id')->toArray();

        return $ids;
    }

    /**
     * @param $upc
     * @return mixed|string
     */
    public function getDataFromUpc($upc) {

        $base_url = "http://api.walmartlabs.com/v1/items";

        $apiKey = env('API_KEY');

        $data = [
            'upc' => $upc,
            'apiKey' => $apiKey,
            'format' => 'json'
        ];

        $client = new Client();

        try {
            $res = $client->get($base_url, ['query' => $data]);

            $result = json_decode($res->getBody()->getContents());

        } catch (\Exception $e) {
            echo $e->getMessage();

            $result = "No Data";
        }

        return $result;
    }

    /**
     * @param $id
     * @return mixed|string
     */
    public function getReviewData($id) {

        $base_url = "http://api.walmartlabs.com/v1/reviews/".$id;

        $apiKey = env('API_KEY');

        $data = [
            'apiKey' => $apiKey,
            'format' => 'json'
        ];

        $client = new Client();

        $attempts = 0;
        $reattempt = true;

        do {

            try {
                $res = $client->get($base_url, ['query' => $data]);

                $result = json_decode($res->getBody()->getContents());

                $reattempt = false;

            } catch (\Exception $e) {
                echo $e->getMessage();

                $result = "No Data";

                $attempts ++;

                echo "\nThrottled ". $attempts. "\n";

                if ($attempts > 5) {
                    $reattempt = false;
                }
            }

        } while ($reattempt == true);

        return $result;
    }

    /**
     * @param $reviewData
     * @param $history
     */
    public function parseReviewData($reviewData, $history) {

        $productData = [];

        if(isset($reviewData->itemId)) {

            $productData['item_id'] = $reviewData->itemId;

        }

        if(isset($reviewData->brandName)) {

            $productData['brand_name'] = $reviewData->brandName;

        }

        if(isset($reviewData->reviewStatistics->averageOverallRating)) {

            $productData['average_rating'] = $reviewData->reviewStatistics->averageOverallRating;

        }

        if(isset($reviewData->reviewStatistics->ratingDistributions)) {

            foreach($reviewData->reviewStatistics->ratingDistributions as $rating) {
                $value = $rating->ratingValue;

                $productData['rating_value_'.$value] = $rating->count;

            }
        }

        if(isset($reviewData->reviewStatistics->totalReviewCount)) {

            $productData['number_of_reviews'] = $reviewData->reviewStatistics->totalReviewCount;

        }

        $this->saveReviewData($productData, $history);
    }

    /**
     * @param $productData
     * @param $history
     */
    public function saveReviewData($productData, $history) {

        $columns = Schema::getColumnListing('products');

        $product = Product::firstOrNew(['item_id' => $productData['item_id']]);

        $historyId = $history[$productData['item_id']];

        unset($productData['item_id']);
        foreach ($productData as $key => $value) {

            if (in_array($key, $columns)) {

                $product->$key = $value;
            }
        }

        $product->save();

        $productHistory = ProductHistory::firstOrNew(['id' => $historyId]);
        foreach ($productData as $key => $value) {

            if (in_array($key, $columns)) {

                $productHistory->$key = $value;
            }
        }

        $productHistory->save();

    }

    /**
     * @param $data
     * @return array
     */
    public function parseItemData($data) {

        $productData = [];

        $history = [];

        foreach ($data->items as $item) {

            foreach ($item as $key => $value) {

                $keyColumn = strtolower(preg_replace('/(?<!\ )[A-Z]/', '_$0', $key));
                $productData[$keyColumn] = $value;
            }

            $this->saveProductData($productData);

            $ids = $this->archiveProductData($productData);

            foreach($ids as $key => $value) {
                $history[$key] = $value;
            }
        }

        return $history;

    }

    /**
     * @param $productData
     */
    public function saveProductData($productData) {

        $columns = Schema::getColumnListing('products');

        $product = Product::firstOrNew(['item_id' => $productData['item_id']]);

        unset($productData['item_id']);
        foreach ($productData as $key => $value) {

            if (in_array($key, $columns)) {

                $product->$key = $value;
            }
        }

        $product->save();

    }

    /**
     * @param $productData
     * @return mixed
     */
    public function archiveProductData($productData) {

        $columns = Schema::getColumnListing('product_history');


        $productHistory = new ProductHistory;

        foreach ($productData as $key => $value) {

            if (in_array($key, $columns)) {

                $productHistory->$key = $value;
            }
        }

        $productHistory->save();

        $dataArray[$productHistory->item_id] = $productHistory->id;

        return $dataArray;

    }

    /**
     * @return array
     */
    public function getUpcs() {
        $upcs = Upc::all()->pluck('upc')->toArray();

        return $upcs;
    }

    public function insertUpcs($upcs) {


        foreach ($upcs as $upc) {

            DB::table('upcs')->insert(['upc' => $upc]);
        }

    }

    /**
     * @param $upcs
     */
    public function deleteUpcs($upcs) {

        foreach($upcs as $upc) {
            Upc::where('upc', $upc)->delete();
        }
    }
}