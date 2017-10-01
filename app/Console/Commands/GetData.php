<?php

namespace App\Console\Commands;

use App\Classes\ApiTools;
use App\Models\Product;
use Illuminate\Console\Command;

class GetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getData';

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

        $upcs = $apiTools->getUpcs();

        foreach($upcs as $upc) {

            $data = $apiTools->getDataFromUpc($upc);

            if($data == "No Data") {
                continue;
            }

            $apiTools->parseItemData($data);
        }

        $apiTools->deleteUpcs($upcs);

    }
}
