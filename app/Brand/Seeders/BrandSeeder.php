<?php

namespace App\Brand\Seeders;

use App\Brand\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create(['description'=>'Gloria']);
        Brand::create(['description'=>'GN']);
        Brand::create(['description'=>'Don Vitorio']);
        Brand::create(['description'=>'Molitalia']);
        Brand::create(['description'=>'Donofrio']);
        Brand::create(['description'=>'Pepsi']);
        Brand::create(['description'=>'Coca Cola']);
        Brand::create(['description'=>'Inca Kola']);
        Brand::create(['description'=>'Sprite']);
        Brand::create(['description'=>'Fanta']);
    }
}
