<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Stock;

class StockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stock::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'symbol' => $this->faker->word(),
            'open' => $this->faker->randomFloat(2, 0, 999999.99),
            'high' => $this->faker->randomFloat(2, 0, 999999.99),
            'low' => $this->faker->randomFloat(2, 0, 999999.99),
            'close' => $this->faker->randomFloat(2, 0, 999999.99),
        ];
    }
}
