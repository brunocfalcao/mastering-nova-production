<?php

namespace App\Console\Commands;

use App\Mail\LaunchDateAnnouncement;
use App\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendLaunchDateEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mastering-nova:send-launch-date-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the Launch Date email to all pre-subscribers';

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
        foreach (Subscriber::all() as $subscriber) {
            $this->info('sending email to '.$subscriber->email);
            Mail::to($subscriber->email)
            ->send(new LaunchDateAnnouncement());
        }

        $this->info('done. Your life hopefully will change after this!');
    }
}
