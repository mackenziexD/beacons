<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DateTime;
use App\Models\beacon;
use Illuminate\Support\Facades\Http;

class FuelCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'get:fuel';

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

    public function DiscordWebhook($message){
        // use http client to send discord webhook
        // testing
        //$url = 'https://discord.com/api/webhooks/969383055825453077/cC9iUaq8rD8BWI9z9VrlQ1UjmlcHQ9vc2L9gao5_ZAnjj1NtU8RxuuwSqrfB98s5oN4T';

        // prod
        $url = 'https://discord.com/api/webhooks/974804116842893412/0cWbeFIeSj5tKND8vwxAW2XuZkiSJKRz5Z86dqEQBno9ogU-DY1jgrN5Oqb9mAS4VN09';

        $dd = Http::post($url, [
            'content' => ''.$message.'',
            'username' => "BUSA Beacons",
            'avatar_url' => "http://games.chruker.dk/eve_online/graphics/ids/512/22262.jpg"
        ]);

        $this->info("Discord Webhook Sent");
    }

    public function handle()
    {
        
        $this->info("Running Fuel Cron");

        $beacons = beacon::all();

        $tableDataTitle = "**Structure Data**". PHP_EOL;
        $tableData = "";
        $OfflineData = "";

        // sort by $beacon->expires_in
        $beacons = $beacons->sortBy('expires_in');

        foreach($beacons as $beacon){
            // 43 Days Left
            $expires_in = str_replace(" Days Left", "", $beacon->expires_in);
            if(strpos($beacon->expires_in, 'OFFLINE') !== false){
                $OfflineData .= '`'. $beacon->system . ' '. $beacon->name . ': '. $beacon->expires_in .'`'. PHP_EOL;
            }
            elseif(strpos($beacon->expires_in, '[INCURSION]') !== false){
                $OfflineData .= '`'. $beacon->system . ' '. $beacon->name . ': '. $beacon->expires_in .'`'. PHP_EOL;
            }
            if($expires_in <= '07'){
                $tableData .= '`'. $beacon->system . ' '. $beacon->name . ': '. $beacon->expires_in .'`'. PHP_EOL;
            }
        }

        $tableData = $OfflineData . $tableData;

        # check if $tableData is empty
        if(!$tableData == ""){  
            $deets = $tableDataTitle . $tableData;
    
            $this->info($deets);
            $this->DiscordWebhook($deets);

            $tableData = "Nothing to report."; 
        } else {
            $this->info("Nothing to report.");
        }

    }
}
