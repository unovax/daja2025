<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i=1; $i < 1000; $i++) {
            Client::create([
                'name' => Str::random(10),
                'lastname' => Str::random(10),
                'email' => Str::random(10)."@gmail.com",
                'phone' => random_int(1000000000, 9999999999),
                'tenant_id' => 1
            ]);
        }
    }
}
