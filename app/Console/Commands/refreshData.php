<?php

namespace App\Console\Commands;

use App\Classes\ApiTools;
use Carbon\Carbon;
use Illuminate\Console\Command;

class refreshData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refreshData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $apiTools = new ApiTools();

        $ids = $apiTools->getItemIds();

        $chunks = array_chunk($ids, 20);

        foreach ($chunks as $itemIds) {

            $results = $apiTools->getProductData($itemIds);

            if($results == "No Data") {

                continue;

            } else {

                $history = $apiTools->parseItemData($results);

            }

            foreach ($itemIds as $id) {

                $results = $apiTools->getReviewData($id);

                if ($results != 'No Data') {

                    $apiTools->parseReviewData($results, $history);
                }

            }
        }

    }
}
