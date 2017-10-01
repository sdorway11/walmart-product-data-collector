<?php

namespace App\Console\Commands;

use App\Classes\ApiTools;
use Illuminate\Console\Command;

class UploadUpcs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uploadUpcs';

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

        $upcs = [
            '854689001397',
            '848953000766',
            '888830007914',
            '020424201159',
            '071203833051',
            '602401806498',
            '646437014793',
            '700053289123',
            '700053335349',
            '702811627802',
            '702811627819',
            '712038330584',
            '859877002040',
            '859877002071',
            '868408000240',
            '868408000257',
            '868408000264',
            '868408000264',
            '886954261991',
            '888753752625',
        ];

        $apiTools->insertUpcs($upcs);
    }
}
