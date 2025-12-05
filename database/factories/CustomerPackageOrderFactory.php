<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerPackageOrder>
 */
class CustomerPackageOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $package = Package::factory()->create();
        $startsAt = now();
        $expiresAt = $startsAt->copy()->addDays($package->validity_days);

        return [
            'user_id' => User::factory()->customer(),
            'package_id' => $package->id,
            'status' => fake()->randomElement(['pending_payment', 'paid', 'cancelled', 'expired']),
            'payment_method' => fake()->randomElement(['card', 'bank_transfer']),
            'payment_status' => fake()->randomElement(['waiting', 'success', 'failed']),
            'paid_at' => fake()->optional()->dateTime(),
            'starts_at' => $startsAt,
            'expires_at' => $expiresAt,
            'remaining_question_count' => $package->question_quota,
            'remaining_voice_count' => $package->voice_quota,
            'bank_transfer_receipt_path' => fake()->optional()->filePath(),
        ];
    }
}
