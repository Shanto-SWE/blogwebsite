<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use\App\Models\Catregory;
use App\Models\Tag;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      
       

        $this->call(settingTableSeeder::class);
    }
}
