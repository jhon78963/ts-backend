<?php

namespace App\Category\Seeders;

use App\Category\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(["description"=>"SIN CATEGORIA"]);
        Category::create(['description'=>'Verduras']);
        Category::create(['description'=>'Lacteos']);
        Category::create(['description'=>'Tuberculos']);
        Category::create(['description'=>'Frutas']);
        Category::create(['description'=>'Cereales']);
        Category::create(['description'=>'Aceites']);
        Category::create(['description'=>'Producto de Limpieza']);
        Category::create(['description'=>'Alimentos enlatados']);
        Category::create(['description'=>'Panaderia']);
        Category::create(['description'=>'Cremas y quesos']);
    }
}
