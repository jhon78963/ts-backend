<?php

namespace App\Supplier\Seeders;

use App\Supplier\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::factory()->count(100)->create();
    }
}
