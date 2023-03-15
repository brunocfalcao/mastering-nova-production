<?php

namespace App\Console\Commands;

use App\PaddleLog;
use Illuminate\Console\Command;

class FillIps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mastering-nova:fill-ips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills ips on paddle_log accordingly to the payload';

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
        $this->info('Processing ip addresses ...');

        PaddleLog::all()
                    ->each(function ($log) {
                        try {
                            $log->update([
                            'ip' => json_decode($log->payload['passthrough'])->price->request->ip,
                            ]);
                        } catch (\Exception $e) {
                        }
                    });
    }
}
