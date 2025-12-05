<?php

namespace Database\Factories;

use App\Models\LegalQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LegalMessage>
 */
class LegalMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'legal_question_id' => LegalQuestion::factory(),
            'sender_id' => User::factory(),
            'sender_role' => fake()->randomElement(['CUSTOMER', 'LAWYER', 'ADMIN']),
            'message_body' => fake()->paragraph(),
            'voice_path' => fake()->optional()->filePath(),
            'attachment_path' => fake()->optional()->filePath(),
        ];
    }
}
