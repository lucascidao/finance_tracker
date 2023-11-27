<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween( 1, 4500),
            'category' => fake()->text(),
            'type' => fake()->randomElement(['income','expense']),
            'description' => fake()->text(),
            'transaction_date' => fake()->date()
        ];
    }
}
