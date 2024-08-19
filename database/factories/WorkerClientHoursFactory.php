<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkerClientHours>
 */
class WorkerClientHoursFactory extends Factory
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

        $workers_id = User::where('role','worker')->pluck('id')->toArray();

        $clients_id = User::where('role','client')->pluck('id')->toArray();

        $hours = [
            0.5,
            1,
            1.5,
            2,
            2.5,
            3,
            3.5,
            4,
            4.5,
            5,
            5.5,
            6,
            6.5,
            7,
            7.5,
            8,
            8.5,
            9,
            9.5,
            10,
            10.5,
            11,
            11.5,
            12,
            12.5,
            13,
            13.5,
            14,
            14.5,
            15,
            15.5,
            16,
        ];

        $created_at = fake()->dateTimeBetween('-65 days', '+30 days');

        return [
            'worker_id' => $workers_id[rand(0,count($workers_id)-1)],
            'client_id' => $clients_id[rand(0,count($clients_id)-1)],
            'hours' => $hours[rand(0,10)],
            'created_at' => $created_at,
            'updated_at' => $created_at,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        //
    }
}
