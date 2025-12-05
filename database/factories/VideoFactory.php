<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'video_category_id' => \App\Models\VideoCategory::factory(),
            'title' => fake()->sentence(),
            'short_description' => fake()->optional()->paragraph(),
            'cover_image_path' => fake()->optional()->imageUrl(640, 360, 'business'),
            'vimeo_link' => 'https://vimeo.com/' . fake()->numberBetween(100000000, 999999999),
            'order' => fake()->numberBetween(0, 100),
            'is_active' => fake()->boolean(80),
        ];
    }
}
