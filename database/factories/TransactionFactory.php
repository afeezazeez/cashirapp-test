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

        $amount =  $this->faker->randomFloat(2, 0, 1000);

        $transaction_type = $this->faker->randomElement(['transfer', 'withdrawal', 'deposit']);

        $description = ucfirst($transaction_type) . ' of $' . $amount . ' was initialized';

        return [
            'uuid' => $this->faker->uuid(),
            'reference' => $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'type' =>  $transaction_type,
            'description' => $description,
            'status' => $this->faker->randomElement(['pending', 'successful', 'failed']),
            'amount' => $amount,
            'date' => $this->faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),

        ];
    }
}
