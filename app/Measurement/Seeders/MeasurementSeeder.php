<?php

namespace App\Measurement\Seeders;

use App\Measurement\Models\Measurement;
use Illuminate\Database\Seeder;

class MeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Measurement::create(['description'=>'KG']);
        Measurement::create(['description'=>'Sacos']);
        Measurement::create(['description'=>'Gr']);
        Measurement::create(['description'=>'L']);
        Measurement::create(['description'=>'g']);
        Measurement::create(['description'=>'paquetes']);
        Measurement::create(['description'=>'cajas']);
        Measurement::create(['description'=>'unidad']);
    }
}
