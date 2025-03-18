<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cvs>
 */
class CvsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'candidate_id' => \App\Models\User::inRandomOrder()->first()->id,
            'file_path' => $this->faker->filePath(),
            'file_type' => $this->faker->randomElement(['pdf', 'docx']),
            'file_size' => $this->faker->numberBetween(100, 5000),
            'summary' => $this->faker->sentence(),
            'uploaded_at' => $this->faker->dateTime(),
        ];
    }
}
