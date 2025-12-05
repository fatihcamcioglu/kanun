<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Temel Paket',
            'Standart Paket',
            'Premium Paket',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'question_quota' => fake()->numberBetween(5, 50),
            'voice_quota' => fake()->numberBetween(0, 10),
            'validity_days' => fake()->numberBetween(30, 365),
            'price' => fake()->randomFloat(2, 100, 5000),
            'currency' => 'TRY',
            'is_active' => true,
        ];
    }
}
