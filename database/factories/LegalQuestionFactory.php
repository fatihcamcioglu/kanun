<?php

namespace Database\Factories;

use App\Models\CustomerPackageOrder;
use App\Models\LegalCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LegalQuestion>
 */
class LegalQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->customer(),
            'order_id' => CustomerPackageOrder::factory(),
            'category_id' => LegalCategory::factory(),
            'assigned_lawyer_id' => null,
            'title' => fake()->sentence(),
            'question_body' => fake()->paragraphs(3, true),
            'status' => 'waiting_assignment',
            'asked_at' => now(),
            'answered_at' => null,
        ];
    }
}
