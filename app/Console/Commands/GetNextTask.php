<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use RestCord\DiscordClient;
use Illuminate\Support\Facades\Http;

class GetNextTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:NextTask';

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
     * @return int
     */
    public function handle()
    {
        $schedule = app(Schedule::class);

        $tasks = collect($schedule->events());

        $matches = $tasks->filter(function ($item) {
            return Str::contains($item->command, 'get:beacon');
        });

        // assuming you get something back in that collection

        $date = $matches->first()->nextRunDate();

        // $date = Mon May  9 13:28:28 GMT 2022
        // parse the date into a usable format
        $date = date('Y-m-d H:i:s', strtotime($date));

        $this->info($date);
        
    }
}
