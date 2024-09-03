<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomImages =[
            'vendor/adminlte/dist/img/user1-128x128.jpg',
            'vendor/adminlte/dist/img/user2-160x160.jpg',
            'vendor/adminlte/dist/img/user-woman.jpg',
            'vendor/adminlte/dist/img/w22.jpg',
            'vendor/adminlte/dist/img/w33.jpg',
            //'vendor/adminlte/dist/img/no-usericon.svg',
       ];

       $positions = [
            'Brand Manager',
            'Marketing Specialist',
            'Public Relations Manager',
            'Communications Strategist',
            'Regulatory Affairs Analyst',
            'Reputation Manager',
            'Crisis Communications Specialist',
            'Media Relations Coordinator',
            'Content Strategist',
            'ESG Consultant',
            'Government Relations Specialist',
            'Corporate Communications Manager',
            'Digital Marketing Manager',
            'Repositioning Strategist',
            'Social Media Manager',
            'Event Coordinator',
            'Copywriter',
            'Research Analyst',
            'Strategic Planner',
        ];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => fake()->phoneNumber,
            'address' => fake()->streetAddress(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement(['worker','worker','worker','client']),
            'image' => $randomImages[rand(0,count($randomImages)-1)],
            'position' => $positions[rand(0,count($positions)-1)],
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
