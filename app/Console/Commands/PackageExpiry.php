<?php

namespace App\Console\Commands;

use App\Models\Subscriptions;
use Illuminate\Console\Command;

class PackageExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:expire_packages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire all the packages which are due';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $getSubscriptions = Subscriptions::where("valid_until", "<", date("Y-m-d"))->get();
        foreach ($getSubscriptions as $subscriptions) {
            Subscriptions::where("id", $subscriptions->id)->update(["is_active" => 0, "deleted_at" => date("Y-m-d H:i:s")]);
        }
    }
}
