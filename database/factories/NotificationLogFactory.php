<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NotificationLog>
 */
class NotificationLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'channel' => fake()->randomElement(['mail', 'sms']),
            'type' => fake()->randomElement([
                'question_assigned',
                'question_answered',
                'followup_message',
                'order_confirmed',
                'payment_received',
            ]),
            'status' => fake()->randomElement(['sent', 'failed']),
            'response' => fake()->optional()->randomElement([
                ['success' => true, 'message_id' => fake()->uuid()],
                ['success' => false, 'error' => 'Failed to send'],
            ]),
        ];
    }
}
