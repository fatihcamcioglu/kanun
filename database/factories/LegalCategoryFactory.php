<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LegalCategory>
 */
class LegalCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Ceza Hukuku',
            'İş Hukuku',
            'Aile Hukuku',
            'Gayrimenkul Hukuku',
            'Ticaret Hukuku',
            'Vergi Hukuku',
            'İdare Hukuku',
            'Borçlar Hukuku',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'is_active' => true,
        ];
    }
}
