<?php

namespace Database\Seeders;

use App\Brand\Seeders\BrandSeeder;
use App\Category\Seeders\CategorySeeder;
use App\Customer\Seeders\CustomerSeeder;
use App\Measurement\Seeders\MeasurementSeeder;
use App\Product\Seeders\ProductSeeder;
use App\Role\Seeders\RoleSeeder;
use App\Supplier\Seeders\SupplierSeeder;
use App\User\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            MeasurementSeeder::class,
            BrandSeeder::class,
            CustomerSeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
