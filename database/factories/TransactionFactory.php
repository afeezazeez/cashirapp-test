<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
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
        $startDate = now()->subYears(2);
        $endDate = now();

        return [
            'uuid' => $this->faker->uuid(),
            'reference' => $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'type' => $this->faker->randomElement(['transfer', 'withdrawal', 'deposit']),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'successful', 'failed']),
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'date' => $this->faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),

        ];
    }
}
