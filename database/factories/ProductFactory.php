<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomElement([86, 126, 256]),
            'price' => fake()->randomElement([10000, 20000, 100000]),
            'game_id' => fake()->randomElement([1, 2, 3]),
            'img_url' => fake()->imageUrl()
        ];
    }
}
