<?php

namespace App\Console\Commands;

use App\PaddleLog;
use Illuminate\Console\Command;

class FillPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mastering-nova:fill-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills prices on paddle_log accordingly to the payload';

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
     * @return int
     */
    public function handle()
    {
        $this->info('Processing prices ...');

        PaddleLog::all()
                    ->each(function ($log) {
                        $log->update([
                            'earnings' => $log->payload['earnings'],
                            'payment_tax' => $log->payload['payment_tax'],
                            'sale_gross' => $log->payload['sale_gross'],
                            'fee' => $log->payload['fee'],
                            'coupon' => $log->payload['coupon'],
                        ]);
                    });
    }
}
