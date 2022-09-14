<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Network;
use App\Models\Server;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *≥
     * @return void
     */
    public function run()
    {
        User::factory(3000)->create();
        Server::factory(8000)->create();
        Network::factory(48000)->create();
    }
}
