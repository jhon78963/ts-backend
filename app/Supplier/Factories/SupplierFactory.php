<?php

namespace App\Supplier\Factories;

use App\Supplier\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Supplier>
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ruc' => $this->faker->unique()->numerify('2##########'),
            'business_name' => $this->faker->company() . ' ' . $this->faker->companySuffix(),
            'manager' => $this->faker->name(),
            'address' => $this->faker->address(),
        ];
    }
}
