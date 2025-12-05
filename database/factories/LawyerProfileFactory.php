<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LawyerProfile>
 */
class LawyerProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->lawyer(),
            'specializations' => fake()->randomElements([
                'Ceza Hukuku',
                'İş Hukuku',
                'Aile Hukuku',
                'Gayrimenkul Hukuku',
                'Ticaret Hukuku',
                'Vergi Hukuku',
            ], fake()->numberBetween(1, 3)),
            'bio' => fake()->paragraph(),
            'bar_number' => fake()->unique()->numerify('BAR####'),
            'is_active' => true,
        ];
    }
}
