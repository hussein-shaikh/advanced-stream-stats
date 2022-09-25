<?php

namespace Database\Seeders;

use App\Models\packages as ModelsPackages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Packages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsPackages::insert(
            [
                'name' => "start",
                'description' => "<ul>
            <li>Twitch Statistics</li>
             <li>Weekly Refresh</li>
             <li>Analytics</li>
     </ul>",
                'amount' => 20,
                'days_validity' => 30
            ]);
            ModelsPackages::insert([
                'name' => "expert",
                'description' => "<ul>
                <li>Twitch Statistics</li>
                 <li>Weekly Refresh</li>
                 <li>Analytics</li>
         </ul>",
                'amount' => 200,
                'days_validity' => 60
            ]);
            ModelsPackages::insert([
                'name' => "failure txn",
                'description' => "<ul>
                <li>to fail transaction use this package</li>
                 <li>New Stats every 2 days</li>
                 <li>Analyzing improvments</li>
         </ul>",
                'amount' => 3000,
                'days_validity' => 60
            ]);

    }
}
