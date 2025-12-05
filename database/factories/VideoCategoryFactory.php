<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VideoCategory>
 */
class VideoCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(2, true);
        return [
            'name' => ucfirst($name),
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->optional()->paragraph(),
            'is_active' => fake()->boolean(80),
        ];
    }
}
