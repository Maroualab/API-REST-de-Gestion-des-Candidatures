<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobOffer>
 */
class JobOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'title' => fake()->jobTitle,
        'recruiter_id' => User::factory(), // Add recruiter_id field
        'description' => fake()->text(300),
        'location' => fake()->city,
        'contract_type' => fake()->randomElement(['full-time', 'part-time','internship', 'freelance']),
        'category' => fake()->randomElement(['IT', 'Finance', 'Marketing', 'HR', 'Sales']), 
        'salary' => fake()->numberBetween(30000, 120000), 
        ];
    }
}
