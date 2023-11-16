<?php

namespace Database\Factories;

use App\Enums\BorrowStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrow>
 */
class BorrowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => $this->faker->numberBetween(1, 5),
            'member_id' => $this->faker->numberBetween(1, 3),
            'borrow_date' => $this->faker->dateTimeBetween('-7 week', '-5 week'),
            'return_date' => $this->faker->dateTimeBetween('-2 week', 'now'),
            'status' => BorrowStatus::Returned,
        ];
    }
}
