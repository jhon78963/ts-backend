<?php

namespace App\Store\Seeders;

use App\Store\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::create(['address'=>'Dirección principal']);
    }
}
