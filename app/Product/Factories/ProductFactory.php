<?php

namespace App\Product\Factories;

use App\Brand\Models\Brand;
use App\Category\Models\Category;
use App\Measurement\Models\Measurement;
use App\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Product>
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stock = $this->faker->numberBetween(0, 100);

        return [
            'name' => $this->faker->unique()->word(),
            'sale_price' => $this->faker->randomFloat(2, 10, 500),
            'purchase_price' => $this->faker->randomFloat(2, 5, 400),
            'stock' => $stock,
            'status' => $this->getStatusBasedOnStock($stock),
            'category_id' => Category::inRandomOrder()->value('id'),
            'brand_id' => Brand::inRandomOrder()->value('id'),
            'measurement_id' => Measurement::inRandomOrder()->value('id'),
        ];
    }

    private function getStatusBasedOnStock(int $stock): string
    {
        return match (true) {
            $stock === 0 => 'OUT_OF_STOCK',
            $stock <= 10 => 'LIMITED_STOCK',
            default => 'AVAILABLE',
        };
    }
}
